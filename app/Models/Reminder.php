<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Attribute\ReminderAttribute;

class Reminder extends Model
{
    use ReminderAttribute;
    protected $fillable = [
        'client_id', 'is_active', 'has_reminded', 'deadline_id', 'reminder_date_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function frequency()
    {
        return $this->belongsTo(Frequency::class);
    }
}
