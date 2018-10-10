<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frequency extends Model
{
    protected $fillable = [
        'is_active'
    ];

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }
}
