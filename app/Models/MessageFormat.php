<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageFormat extends Model
{
    protected $fillable = ['sms_format', 'email_format', 'is_active'];
}
