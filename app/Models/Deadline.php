<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Attribute\DeadlineAttribute;

class Deadline extends Model
{
    use DeadlineAttribute;
    protected $fillable = [
        'name', 'is_active', 'message_format_id', 'send_sms', 'send_email'
    ];

    public function message_format()
    {
        return $this->belongsTo(MessageFormat::class);
    }
}
