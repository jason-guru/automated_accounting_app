<?php

namespace App\Helpers\General;

use Carbon\Carbon;

class DateHelper
{
    public function carbonParse($date, $format = null)
    {
        $getFormat = $format == null? config('settings.date_format') : $format;
        if(!is_null($date)){
            return Carbon::parse($date)->format($getFormat);
        }else{
            return null;
        }
    }
}