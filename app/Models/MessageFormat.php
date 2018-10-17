<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Attribute\MessageFormatAttribute;

class MessageFormat extends Model
{
    use MessageFormatAttribute;
    protected $fillable = ['sms_format', 'email_format', 'is_active', 'name'];
}
