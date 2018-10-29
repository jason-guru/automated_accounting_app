<?php

namespace App\Listeners\Backend;

use App\Events\Backend\ReminderEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Repositories\Backend\ReminderRepository;
use App\Repositories\Backend\MessageFormatRepository;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Mail\Backend\ReminderMail;
use Illuminate\Support\Facades\Mail;
use Config;

class SendDynamicReminderNotifications
{
    protected $sms_client;
    protected $sms_api_key;
    protected $reminder_repository;
    protected $message_format_repository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ReminderRepository $reminder_repository, MessageFormatRepository $message_format_repository)
    {
        $this->sms_api_key = Config::get('services.bulletin_sms.secret');
        $this->sms_client =  new Client();
        $this->reminder_repository = $reminder_repository;
        $this->message_format_repository = $message_format_repository;
    }

    /**
     * Handle the event.
     *
     * @param  ReminderEvent  $event
     * @return void
     */
    public function handle(ReminderEvent $event)
    {
        $this->reminder_manager();
    }

    /**
     * Use to sent reminder to the clients according the reminding dates present in the reminders table
    */
    private function reminder_manager()
    {
        try{
            $reminders = $this->reminder_repository->where('is_active', 1)->where('has_reminded', 0)->get();
            $today = Carbon::now()->toDateString();
            $now = Carbon::now()->toTimeString();
            if($reminders->count() > 0){
                foreach($reminders as $reminder){
                    $reminder_date = $reminder->remind_date;
                    $schedule_time = $reminder->schedule_time;
                    if($today >= $reminder_date && $now >= $schedule_time){
                        $client_phone = $reminder->client->phone;
                        $client_email = $reminder->client->email;
                        $director_data = $reminder->client->contact_people->where('designation_id', 1)->first();
                        $email_body = [
                            'format' => $reminder->deadline->message_format->email_format,
                        ];
                        $email_data = [
                            '%mail_to' => !is_null($director_data) ? $director_data->first_name : $reminder->client->company_name,
                            '%reference_number' => count($reminder->reference_number) > 0 ? $reminder->reference_number->reference_number : "",
                            '%amount' => count($reminder->reference_number) > 0 ? $reminder->reference_number->amount :""
                        ];

                        $sms_body = [
                            'format' => $reminder->deadline->message_format->sms_format,
                        ];
                        $sms_data = [
                            '%mail_to' => !is_null($director_data) ? $director_data->first_name : $reminder->client->company_name,
                            '%reference_number' => count($reminder->reference_number) > 0 ? $reminder->reference_number->reference_number : "",
                            '%amount' => count($reminder->reference_number) > 0 ? $reminder->reference_number->amount :""
                        ];

                        $this->send_reminder($reminder->id, $client_phone, $client_email, $email_body, $sms_body, $sms_data, $email_data);
                        //update the reinder date if recurring is set
                        if(!is_null($reminder->recurring_id)){
                            $updated_date = $reminder_date;
                            if($reminder->recurring_id == 1){
                                $updated_date = Carbon::parse($reminder_date)->addDay()->format('Y-m-d');
                            }elseif($reminder->recurring_id == 2){
                                $updated_date = Carbon::parse($reminder_date)->addWeek()->format('Y-m-d');
                            }elseif($reminder->recurring_id == 3){
                                $updated_date = Carbon::parse($reminder_date)->addMonth()->format('Y-m-d');
                            }elseif($reminder->recurring_id == 4){
                                $updated_date = Carbon::parse($reminder_date)->addMonths(6)->format('Y-m-d');
                            }elseif($reminder->recurring_id == 5){
                                $updated_date = Carbon::parse($reminder_date)->addYear()->format('Y-m-d');
                            }
                            $this->reminder_repository->updateById($reminder->id, ['remind_date' => $updated_date]);
                        }
                        $counter = $this->reminder_repository->getById($reminder->id)->counter;
                        $counter++;
                        $this->reminder_repository->updateById($reminder->id, ['counter' => $counter]);
                        return "Success";
                    }
                }
            }
        }catch(\Exception $exception)
        {
            return $exception->getMessage();
        }
    }

    private function send_reminder($reminder_id, $client_phone, $client_email, $email_body, $sms_body, $sms_data, $email_data)
    {
        $reminder = $this->reminder_repository->getById($reminder_id);
        $send_sms = $reminder->send_sms;
        $send_email = $reminder->send_email;
        $has_sent_sms = null;
        $mail_failures = null;
        // if($send_sms){
        //     $has_sent_sms = $this->sms_manager($client_phone, $sms_body);
        // }
        // if($send_email){
        //     Mail::to($client_email)->send(new ReminderMail($email_body));
        //     return Mail::failures();
        // }
        //If mail is sent and has no mail failure
        if($send_sms && !$send_email){
            $has_sent_sms = $this->sms_manager($client_phone, $sms_body, $sms_data);
            if($has_sent_sms){
                $this->reminder_repository->updateById($reminder_id, ['has_reminded' => true]);
            }
        }elseif(!$send_sms && $send_email){
            if(mail($client_email, 'Filing Reminder',  strtr($email_body['format'], $email_data), "From:".Config::get('mail.from.address'))){
                $this->reminder_repository->updateById($reminder_id, ['has_reminded' => true]);
            }
        }elseif($send_sms && $send_email){
            $has_sent_sms = $this->sms_manager($client_phone, $sms_body, $sms_data);
            if(mail($client_email, 'Filing Reminder',  strtr($email_body['format'], $email_data), "From:".Config::get('mail.from.address')) && $has_sent_sms){
                $this->reminder_repository->updateById($reminder_id, ['has_reminded' => true]);
            }
        }elseif(!$send_sms && !$send_email){
            //do nothing
        }
    }

    // SMS
    private function sms_manager($to, $sms_body, $sms_data)
    {
        $response = $this->sms_client->request('GET', 'https://www.bulletinmessenger.net/api/3/sms/out', [
            'query' => ['to' => $to,'body' => strtr($sms_body['format'], $sms_data)],
            'headers' => ['Authorization' => "Bearer {$this->sms_api_key}"]
        ]);
        if($response->getStatusCode() == 200){
            return true;
        }else{
            return false;
        }
        //return true;
    }
}
