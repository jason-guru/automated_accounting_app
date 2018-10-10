<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class ContactPerson extends Model
{
    protected $fillable = [
        'client_id', 'designation_id', 'initial_id', 'first_name', 'middle_name', 'last_name', 'email', 'phone', 'address_line_1', 'address_line_2', 'city', 'postcode', 'county', 'country_id', 'is_active'
    ];
    protected $dates = ['deleted_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
