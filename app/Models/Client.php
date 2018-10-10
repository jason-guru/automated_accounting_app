<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Client extends Model
{
    protected $fillable = [
        'company_number', 'company_name', 'company_type_id', 'accounts_next_due', 'accounts_overdue', 'address_line_1', 'address_line_2', 'postcode', 'city', 'county', 'country_id', 'phone', 'website', 'email', 'is_active', 'remind'
    ];

    protected $dates = ['deleted_at'];

    public function contact_person()
    {
        return $this->hasMany(ContactPerson::class);
    }

    public function business_info()
    {
        return $this->hasOne(BusinessInfo::class);
    }

    public function reminder()
    {
        return $this->hasOne(Reminder::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($client){
            $client->contact_person()->delete();
            $client->business_info()->delete();
            $client->reminder()->delete();
        });
    }
}
