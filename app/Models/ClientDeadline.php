<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientDeadline extends Model
{
    protected $table = 'client_deadline';

    public function filingFrequency()
    {
        return $this->hasOne(FilingFrequency::class);
    }

    public function getFrequency($deadlineId, $clientId)
    {
        return $this->where(['deadline_id' => $deadlineId, 'client_id' => $clientId])->first()->filingFrequency->frequency;
    }
}
