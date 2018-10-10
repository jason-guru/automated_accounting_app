<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = [
        'client_id', 'frequency_id','first_remind', 'second_remind', 'third_remind', 'is_active'
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
