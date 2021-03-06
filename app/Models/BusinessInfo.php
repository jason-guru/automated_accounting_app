<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
use Carbon\Carbon;

class BusinessInfo extends Model
{
    protected $fillable = [
        'client_id', 'business_start_date', 'book_start_date', 'year_end_date', 'company_reg_number', 'utr_number', 'vat_scheme_id', 'vat_submit_type_id', 'vat_reg_number', 'vat_reg_date', 'social_media', 'last_bookkeeping_done', 'utr', 'is_active', 'company_type_id'
    ];
    protected $dates = ['deleted_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function vat_scheme()
    {
        return $this->belongsTo(VatScheme::class);
    }

    public function vat_submit_type()
    {
        return $this->belongsTo(VatSubmitType::class);
    }

    public function get_date($date){
        return !is_null($date) ? Carbon::parse($date)->format('d-m-Y') : null;
    }
}
