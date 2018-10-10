<?php

namespace App\Repositories\Backend;

use App\Repositories\BaseRepository;
use App\Models\Reminder;
use Carbon\Carbon;

/**
 * Class ReminderRepository.
 */
class ReminderRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Reminder::class;
    }

    /**
     * @param int $client_id
     * @return boolean
     * Set the value of the reminder table as per due date
     * 
    */
    public function set_reminders($id, $due_date, $active_frequency)
    {
        $first_date=$second_date=$third_date=null;
        $first_date = Carbon::parse($due_date)->subYear();
        if($active_frequency->id == 2){
            $second_date = Carbon::parse($first_date)->addMonths(6);
        }elseif($active_frequency->id == 3){
            $second_date = Carbon::parse($first_date)->addMonths(4);
            $third_date = Carbon::parse($second_date)->addMonths(4);
        }
        $prep_data = [
            'client_id' => $id,
            'frequency_id' => $active_frequency->id,
            'first_remind' => $first_date,
            'second_remind' => $second_date,
            'third_remind' => $third_date,
            'is_active' => true
        ];
        $this->model->create($prep_data);
    }
}