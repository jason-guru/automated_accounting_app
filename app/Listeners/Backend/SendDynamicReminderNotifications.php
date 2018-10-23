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
        $this->sms_api_key = config('services.bulletin_sms.secret');
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
            if($reminders->count() > 0){
                foreach($reminders as $reminder){
                    $reminder_date = $reminder->remind_date;
                    if($today >= $reminder_date){
                        $client_phone = $reminder->client->phone;
                        $client_email = $reminder->client->email;
                        $email_body = [
                            'format' => $reminder->deadline->message_format->email_format,
                            'client_company_name' => $reminder->client->company_name,
                            'client_next_account' => Carbon::parse($reminder->client->account_next_due)->format('d-m-Y')
                        ];

                        $sms_body = [
                            'format' => $reminder->deadline->message_format->sms_format,
                            'client_company_name' => $reminder->client->company_name,
                            'client_next_account' => Carbon::parse($reminder->client->account_next_due)->format('d-m-Y')
                        ];

                        $this->send_reminder($reminder->id, $client_phone, $client_email, $email_body, $sms_body);
                        return "Success";
                    }
                }
            }
        }catch(\Exception $exception)
        {
            return $exception->getMessage();
        }
    }

    private function send_reminder($reminder_id, $client_phone, $client_email, $email_body, $sms_body)
    {
        $reminder = $this->reminder_repository->getById($reminder_id);
        $send_sms = $reminder->deadline->send_sms;
        $send_email = $reminder->deadline->send_email;
        $has_sent_sms = null;
        $mail_failures = null;
        if($send_sms){
            $has_sent_sms = $this->sms_manager($client_phone, $sms_body);
        }
        if($send_email){
            $mail_failures = $this->email_manager($client_email, $email_body);
        }
        //If mail is sent and has no mail failure
        if($has_sent_sms == true || $has_sent_sms == null && count($mail_failures) == 0 || $mail_failures == null){
            $this->reminder_repository->updateById($reminder_id, ['has_reminded' => true]);
        }
    }

    // SMS
    private function sms_manager($to, $sms_body)
    {
        $response = $this->sms_client->request('GET', 'https://www.bulletinmessenger.net/api/3/sms/out', [
            'query' => ['to' => $to,'body' => sprintf($sms_body['format'], $sms_body['client_company_name'], $sms_body['client_next_account'])],
            'headers' => ['Authorization' => "Bearer {$this->sms_api_key}"]
        ]);
        if($response->getStatusCode() == 200){
            return true;
        }else{
            return false;
        }
        //return true;
    }

    // Email
    private function email_manager($client_email, $email_body)
    {
        Mail::to($client_email)->send(new ReminderMail($email_body));
        return Mail::failures();
    }
}
