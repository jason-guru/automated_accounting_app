<?php

namespace App\Listeners\Backend;

use App\Events\Backend\ReminderEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Repositories\Backend\FrequencyRepository;
use App\Repositories\Backend\ReminderRepository;
use App\Repositories\Backend\MessageFormatRepository;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Mail\Backend\ReminderMail;
use Illuminate\Support\Facades\Mail;

class SendReminderNotification implements ShouldQueue
{
    protected $sms_client;
    protected $sms_api_key;
    protected $frequency_repository;
    protected $reminder_repository;
    protected $message_format_repository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(FrequencyRepository $frequency_repository, ReminderRepository $reminder_repository, MessageFormatRepository $message_format_repository)
    {
        $this->sms_api_key = config('services.bulletin_sms.secret');
        $this->sms_client =  new Client();
        $this->frequency_repository = $frequency_repository;
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
        $first_date=$second_date=$third_date = null;
        $reminders = $this->reminder_repository->where('is_active', 1)->get();
        $today = Carbon::now()->toDateString();

        foreach($reminders as $reminder):
            // $first_date = $reminder->first_remind;
            // $second_date = $reminder->second_remind;
            // $third_date = $reminder->third_remind;
            $first_date = "2018-10-5";
            $second_date = "2018-10-8";
            $third_date = "2018-10-9";
            $client_phone = $reminder->client->phone;
            $client_email = $reminder->client->email;
            $email_body = [
                'format'=>$this->message_format_repository->where('is_active', 1)->get()->first()->email_format,
                'client_company_name'=> $reminder->client->company_name,
                'client_next_account' => Carbon::parse($reminder->client->accounts_next_due)->format('d-m-Y') 
            ];

            $sms_body = [
                'format' => $this->message_format_repository->where('is_active', 1)->get()->first()->sms_format,
                'client_company_name'=> $reminder->client->company_name,
                'client_next_account' => Carbon::parse($reminder->client->accounts_next_due)->format('d-m-Y') 
            ];
            //check if 
            if($today <= $first_date && $reminder->has_reminded == 000 ):
                $reminder_state = 100;
                $this->send_reminder($reminder->id, $client_phone, $client_email, $email_body, $sms_body, $reminder_state);
            endif;
            //check if second date is present or not
            if(!is_null($second_date)):
                if($today <= $second_date && $reminder->has_reminded == 100):
                    $reminder_state = 110;
                    $this->send_reminder($reminder->id, $client_phone, $client_email, $email_body, $sms_body, $reminder_state);
                endif;
            endif;

            //check if third date is present or not
            if(!is_null($third_date)):
                if($today <= $third_date && $reminder->has_reminded == 110):
                    $reminder_state = 111;
                    $this->send_reminder($reminder->id, $client_phone, $client_email, $email_body, $sms_body, $reminder_state);
                endif;
            endif;
        endforeach;
        }catch(\Exception $exception)
            {
                return $exception->getMessage();
            }
        }

        // SMS
        private function sms_manager($to, $sms_body)
        {
            // $response = $this->sms_client->request('GET', 'https://www.bulletinmessenger.net/api/3/sms/out', [
            //     'query' => ['to' => $to,'body' => sprintf($sms_body['format'], $sms_body['client_company_name'], $sms_body['client_next_account'])],
            //     'headers' => ['Authorization' => "Bearer {$this->sms_api_key}"]
            // ]);
            // if($response->getStatusCode() == 200){
            //     return true;
            // }else{
            //     return false;
            // }
            return true;
        }

        private function send_reminder($reminder_id, $client_phone, $client_email, $email_body, $sms_body, $reminder_state)
        {
            //SMS and mail reminder to the client
            $has_sent_sms = $this->sms_manager($client_phone, $sms_body);
            Mail::to($client_email)->send(new ReminderMail($email_body));
            $mail_failures = Mail::failures();
            //If mail is sent and has no mail failure
            if($has_sent_sms && count($mail_failures) == 0){
                $this->reminder_repository->updateById($reminder_id, ['has_reminded' => $reminder_state]);
            }
        }
}
