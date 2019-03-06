<?php
    
namespace App\Repositories\Backend\Traits\Methods;

use Carbon\Carbon;
 
/**
 * Common Due Calculator Methods
 */
trait CommonDueCalculatorMethods
{
    private function prepPath($path)
    {
        return explode(', ', $path);
    }

    private function getWhenAndFormat($filterValue)
    {
        $format = '';
        if($filterValue == config('filter.value.0') || $filterValue == null){
            $when = Carbon::now()->format('Y');
            $format = 'Y';
        }elseif($filterValue == config('filter.value.1')){
            $when = Carbon::now()->format('m');
            $format = 'm';
        }elseif($filterValue == config('filter.value.2')){
            $when = Carbon::now()->weekOfYear;
        }
        return [
            'when' => $when,
            'format' =>$format
        ];
    }
}
