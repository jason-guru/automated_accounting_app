<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Attribute\ClientAttribute;
use SoftDeletes;

class Client extends Model
{
    use ClientAttribute;
    
    protected $fillable = [
        'company_number', 'company_name', 'company_type_id', 'accounts_next_due', 'accounts_overdue', 'address_line_1', 'address_line_2', 'postcode', 'city', 'county', 'country_id', 'phone', 'website', 'email', 'is_active', 'remind'
    ];

    protected $dates = ['deleted_at'];

    public function contact_people()
    {
        return $this->hasMany(ContactPerson::class);
    }

    public function company_type()
    {
        return $this->belongsTo(CompanyType::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function business_info()
    {
        return $this->hasOne(BusinessInfo::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($client){
            $client->contact_people()->delete();
            $client->business_info()->delete();
            $client->reminder()->delete();
        });
    }
}
