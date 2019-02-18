<?php

namespace App\Repositories\Backend\Traits\Calculators;

use Carbon\Carbon;

/**
 * 
 */
trait NonPrivateLimitedDueCalculator
{
    private function getNonPrivateLimitedClients()
    {
        return $this->where('company_type_id', 1, '!=')->get();
    }
    
    private function calculateNonPrivateLimitedDue()
    {
        $clientIds = [];
        $clients = $this->getNonPrivateLimitedClients();
        if(count($clients) > 0){
            foreach($clients as $client){
                $currentYear = Carbon::now()->format('Y');
                $nextDue = Carbon::parse($client->accounts_next_due)->format('Y');
                if($currentYear >= $nextDue){
                    array_push($clientIds, $client->id);
                }else{
                    break;
                }
            }
        }
        return $clientIds;
    }

    private function calculateNonPrivateLimitedOverDue()
    {
        $clientIds = [];
        $clients = $this->getNonPrivateLimitedClients();
        if(count($clients) > 0){
            foreach($clients as $client){
                $isOverdue = $client->accounts_overdue;
                if($isOverdue == true){
                    array_push($clientIds, $client->id);
                }else{
                    break;
                }
            }
        }
        return $clientIds;
    }
}
