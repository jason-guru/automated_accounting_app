<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilingFrequency extends Model
{
    protected $fillable = [
        'frequency', 'client_deadline_id'
    ];

    public function clientDeadline()
    {
        return $this->belongsTo(clientDeadline::class);
    }
}
