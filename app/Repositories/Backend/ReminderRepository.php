<?php

namespace App\Repositories\Backend;

use App\Repositories\BaseRepository;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

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
    public function set_reminders($id, $due_date, $active_frequency, $reminder_id = null)
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
            'is_active' => true,
            'has_reminded' => 000
        ];
        if(is_null($reminder_id)):
            $this->model->create($prep_data);
        else:
            parent::updateById($reminder_id, $prep_data);
        endif;
    }

    public function get_reminders()
    {
        $reminders = $this->model->all();
        $reminder_data= collect([]);
        foreach($reminders as $reminder){
            $client_id = $reminder->client_id;
            $company_name = $reminder->company_name;
            $total_reminders = $this->model->where('client_id', $client_id)->get()->count();
            $total_reminded = $this->model->where('client_id', $client_id)->where('has_reminded')->get()->count();
            $reminder_data[$client_id] =[
                'client_id' => $client_id,
                'company_name' => $company_name,
                'total_reminders' => $total_reminders,
                'total_reminded' => $total_reminded,
                'actions' => $this->model->action_buttons
            ];
        }
        return $this->manual_paginate($reminder_data)->setPath('reminders');
    }

    /**
     * Create a length aware custom paginator instance.
     *
     * @param  Collection  $items
     * @param  int  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function manual_paginate($items, $perPage = 10)
    {
        //Get current page form url e.g. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Slice the collection to get the items to display in current page
        $currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage);

        //Create our paginator and pass it to the view
        return new LengthAwarePaginator($currentPageItems, count($items), $perPage);
    }

}