<?php

namespace App\Repositories\Backend\Traits\Calculators;

use Carbon\Carbon;
use App\Business\LocalCompanyProfile;

/**
 * 
 */
trait NonApiBasedDueCalculator
{
    private function getLocalClients()
    {
        return $this->where('is_api', false)->get();
    }
    
    private function calculateNonPrivateLimitedDue($code, $filterValue)
    {
        $whenAndFormat = $this->getWhenAndFormat($filterValue);

        $clientIds = [];
        $clients = $this->getLocalClients();
        if(count($clients) > 0){
            foreach($clients as $client){
                $nextDue = $this->getDueOn($client, $code, $whenAndFormat, $filterValue);
                if(!is_null($nextDue)){
                    if($whenAndFormat['when'] >= $nextDue){
                        array_push($clientIds, $client->id);
                    }else{
                        break;
                    }
                }
            }
        }
        return $clientIds;
    }

    private function calculateNonPrivateLimitedOverDue($code)
    {
        $localOverDue = new LocalCompanyProfile();
        $clientIds = [];
        $clients = $this->getLocalClients();
        if(count($clients) > 0){
            foreach($clients as $client){
                $isOverdue = $localOverDue->calculateOverDue($client, $code);
                if($isOverdue == true){
                    array_push($clientIds, $client->id);
                }else{
                    break;
                }
            }
        }
        return $clientIds;
    }

    private function getDueOn($client, $code, $whenAndFormat, $filterValue)
    {
        if(!is_null($client->deadlines->where('code', $code)->first()->pivot->due_on))
        {
            if($filterValue != config('filter.value.2')){
                return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->due_on)->format($whenAndFormat['format']);
            }else{
                return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->due_on)->weekOfYear;
            }
        }else{
            return null;
        }
    }
}
