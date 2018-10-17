<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Attribute\ReminderAttribute;

class Reminder extends Model
{
    use ReminderAttribute;
    protected $fillable = [
        'client_id', 'frequency_id','first_remind', 'second_remind', 'third_remind', 'is_active', 'has_reminded'
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
