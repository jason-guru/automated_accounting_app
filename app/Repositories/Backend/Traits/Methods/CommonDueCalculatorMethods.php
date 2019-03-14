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
        $format = null;
        $when = null;
        $parentMonth = null;
        $parentYear = null;
        if($filterValue == config('filter.value.0') || $filterValue == null){
            $when = Carbon::now()->format('Y');
            $format = 'Y';
        }elseif($filterValue == config('filter.value.1')){
            $when = Carbon::now()->format('m');
            $format = 'm';
            $parentYear = Carbon::now()->format('Y');
        }elseif($filterValue == config('filter.value.2')){
            $when = Carbon::now()->weekOfYear;
            $parentMonth = Carbon::now()->format('M');
            $parentYear = Carbon::now()->format('Y');
        }
        return [
            'when' => $when,
            'format' =>$format,
            'parentMonth' => $parentMonth,
            'parentYear' => $parentYear
        ];
    }
}
