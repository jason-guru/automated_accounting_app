<?php

namespace App\Helpers\General;

use Carbon\Carbon;

class DateHelper
{
    public function carbonParse($date)
    {
        if(!is_null($date)){
            return Carbon::parse($date)->format(config('settings.date_format'));
        }else{
            return null;
        }
    }
}