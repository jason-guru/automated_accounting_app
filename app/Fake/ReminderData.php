<?php

namespace App\Fake;

class ReminderData
{
    public function fetch($client, $deadline)
    {
        $fakeReminderData=[];
        $fakeReminderData[0] = json_encode([
            'client_id' => $client->id,
            'deadline_id' => $deadline->id,
            'remind_date' => "2019-02-28",
            'has_reminded' => false,
            'is_active' => true,
            'schedule_time'=> "00:00:00",
            'recurring_id' => 1,
            "send_sms" => 1,
            'send_email' => 0
        ], true);

        return $fakeReminderData;
    }
}