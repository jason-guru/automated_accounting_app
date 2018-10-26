<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Attribute\ReminderAttribute;

class Reminder extends Model
{
    protected $fillable = [
        'client_id', 'is_active', 'has_reminded', 'deadline_id', 'remind_date', 'reference_number_id', 'schedule_time'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function deadline()
    {
        return $this->belongsTo(Deadline::class);
    }

    public function reference_number()
    {
        return $this->belongsTo(ReferenceNumber::class);
    }

     /**
     * @return string
     */
    public function getShowButton($id)
    {
        return '<a href="'.route('admin.reminders.show', $id).'" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.view').'" class="btn btn-info"><i class="fas fa-eye"></i></a>';
    }

    /**
     * @return string
     */
    public function getEditButton($id)
    {
        return '<a href="'.route('admin.reminders.edit', $id).'" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.edit').'" class="btn btn-primary"><i class="fas fa-edit"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButton($id)
    {
        return '<a href="'.route('admin.reminders.destroy', $id).'"
			 data-method="delete"
			 data-trans-button-cancel="'.__('buttons.general.cancel').'"
			 data-trans-button-confirm="'.__('buttons.general.crud.delete').'"
			 data-trans-title="'.__('strings.backend.general.are_you_sure').'"
			 class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.delete').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getActionButtons($id)
    {
        return '<div class="btn-group btn-group-sm" role="group" aria-label="'.__('labels.backend.access.users.user_actions').'">
                '.$this->getShowButton($id).'
                '.$this->getEditButton($id).'
                '.$this->getDeleteButton($id).'
			  
        </div>';
    }
}
