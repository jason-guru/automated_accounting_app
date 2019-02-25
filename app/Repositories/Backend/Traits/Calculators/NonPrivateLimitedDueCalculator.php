<?php

namespace App\Repositories\Backend\Traits\Calculators;

use Carbon\Carbon;
use App\Business\LocalCompanyProfile;

/**
 * 
 */
trait NonPrivateLimitedDueCalculator
{
    private function getLocalClients()
    {
        return $this->where('is_api', false)->get();
    }
    
    private function calculateNonPrivateLimitedDue($code)
    {
        $clientIds = [];
        $clients = $this->getLocalClients();
        if(count($clients) > 0){
            foreach($clients as $client){
                $nextDue = $this->getDueOnYear($client, $code);
                if(!is_null($nextDue)){
                    $currentYear = Carbon::now()->format('Y');
                    if($currentYear >= $nextDue){
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

    private function getDueOnYear($client, $code)
    {
        if(!is_null($client->deadlines->where('code', $code)->first()->pivot->due_on))
        {
            return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->due_on)->format('Y');
        }else{
            return null;
        }
    }
}
