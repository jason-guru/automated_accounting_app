<?php

namespace App\Listeners\Backend;

use Config;
use Carbon\Carbon;
use App\Mail\Backend\ReminderMail;
use Illuminate\Support\Facades\Mail;
use App\Events\Backend\ReminderEvent;
use App\Business\Api\BulletinMessenger;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\Backend\ReminderRepository;
use App\Repositories\Backend\MessageFormatRepository;

class SendDynamicReminderNotifications
{
    private $phone;
    private $email;
    private $emailDynamics;
    private $smsDynamics;
    private $emailTemplate;
    private $smsTemplate;
    private $messenger;
    protected $reminderRepository;
    protected $messageFormatRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ReminderRepository $reminderRepository, MessageFormatRepository $messageFormatRepository)
    {
        $this->reminderRepository = $reminderRepository;
        $this->messageFormatRepository = $messageFormatRepository;
        $this->messenger = new BulletinMessenger();
    }

    /**
     * Handle the event.
     *
     * @param  ReminderEvent  $event
     * @return void
     */
    public function handle(ReminderEvent $event)
    {
        try{
            $reminders = $this->reminderRepository->where('is_active', 1)->where('has_reminded', 0)->get();

            $today = Carbon::now()->toDateString();
            $now = Carbon::now()->toTimeString();

            if($reminders->count() > 0){
                foreach($reminders as $reminder){
                    $reminder_date = $reminder->remind_date;
                    $schedule_time = $reminder->schedule_time;
                    if($today >= $reminder_date && $now >= $schedule_time){
                        $this->setDestination($reminder);
                        $this->prepPackage($reminder);
                        $this->sendReminder($reminder->id);
                        $this->updateRecurringInfo($reminder, $reminder_date);
                        $this->updateCounter($reminder);
                        return "Success";
                    }
                }
            }
        }catch(\Exception $exception)
        {
            return $exception->getMessage();
        }
    }

    private function sendReminder($reminder_id)
    {
        try {
            $reminder = $this->reminderRepository->getById($reminder_id);
            $send_sms = $reminder->send_sms;
            $send_email = $reminder->send_email;
            $has_sent_sms = null;
            $mail_failures = null;
            if($send_sms && !$send_email){
                $has_sent_sms = $this->messenger->dispatch($this->phone, $this->smsTemplate, $this->smsDynamics);
                if($has_sent_sms){
                    $this->reminderRepository->updateById($reminder_id, ['has_reminded' => true]);
                }
            }elseif(!$send_sms && $send_email){
                $this->dispatchEmail();
            }elseif($send_sms && $send_email){
                $this->messenger->dispatch($this->phone, $this->smsTemplate, $this->smsDynamics);
                $this->dispatchEmail();
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        
    }

    private function setDestination($reminder)
    {
        $this->phone = $reminder->client->phone;
        $this->email = $reminder->client->email;
    }

    private function prepPackage($reminder)
    {
        $director_data = $reminder->client->contact_people->where('designation_id', 1)->first();
        $this->emailDynamics = [
            '%mail_to' => !is_null($director_data) ? $director_data->first_name : $reminder->client->company_name,
            '%reference_number' => count($reminder->reference_number) > 0 ? $reminder->reference_number->reference_number : "",
            '%amount' => count($reminder->reference_number) > 0 ? $reminder->reference_number->amount :"",
            '%period_from' => $this->getDeadlineDate($reminder, 'from'),
            '%period_to' => $this->getDeadlineDate($reminder, 'to'),
            '%due_on' => $this->getDeadlineDate($reminder, 'due_on')
        ];
        $this->smsDynamics = [
            '%mail_to' => !is_null($director_data) ? $director_data->first_name : $reminder->client->company_name,
            '%reference_number' => count($reminder->reference_number) > 0 ? $reminder->reference_number->reference_number : "",
            '%amount' => count($reminder->reference_number) > 0 ? $reminder->reference_number->amount :"",
            '%period_from' => $this->getDeadlineDate($reminder, 'from'),
            '%period_to' => $this->getDeadlineDate($reminder, 'to'),
            '%due_on' => $this->getDeadlineDate($reminder, 'due_on')
        ];
        $this->emailTemplate = [
            'format' => $reminder->deadline->message_format->email_format,
        ];
        $this->smsTemplate = [
            'format' => $reminder->deadline->message_format->sms_format,
        ];
    }

    private function getDeadlineDate($reminder, $dateType)
    {
        $deadline = $reminder->client->deadlines()->where('deadline_id', $reminder->deadline_id)->first()->pivot;
        if($reminder->deadline->code == config('deadline.code.2') && $dateType == 'due_on' && !is_null($deadline->$dateType)){
            return Carbon::parse($deadline->due_on)->subMonth()->subDays('7')->format(config('settings.date_format'));
        }
        return !is_null($deadline->$dateType) ?  carbon_parse($deadline->$dateType) : 'N/A';
        
    }

    private function dispatchEmail()
    {
        try {
            if(mail($this->email, 'Filing Reminder',  strtr($this->emailTemplate['format'], $this->emailDynamics), "From:".Config::get('mail.from.address'))){
                $this->reminderRepository->updateById($reminder_id, ['has_reminded' => true]);
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    private function updateRecurringInfo($reminder, $reminder_date)
    {
        try {
            
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
                $this->reminderRepository->updateById($reminder->id, ['remind_date' => $updated_date, 'has_reminded' => false]);
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        
    }

    private function updateCounter($reminder)
    {
        $counter = $this->reminderRepository->getById($reminder->id)->counter;
        $counter++;
        $this->reminderRepository->updateById($reminder->id, ['counter' => $counter]);
    }

    public function failed(ReminderEvent $event, $exception)
    {
        return $exception->getMessage();
    }
}
