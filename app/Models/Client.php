<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Client extends Model
{
    protected $dates = ['deleted_at'];

    public function contact_person()
    {
        return $this->hasMany(ContactPerson::class);
    }

    public function business_info()
    {
        return $this->hasOne(BusinessInfo::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($client){
            $client->contact_person()->delete();
            $client->business_info()->delete();
        });
    }
}
