<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recurring extends Model
{
    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }
}
