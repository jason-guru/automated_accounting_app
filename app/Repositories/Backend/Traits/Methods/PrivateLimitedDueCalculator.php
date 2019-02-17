<?php

namespace App\Repositories\Backend\Traits\Methods;

use Carbon\Carbon;

/**
 * 
 */
trait PrivateLimitedDueCalculator
{
    private function getPrivateLimitedClients()
    {
        return $this->where('company_type_id', 1)->get();
    }
    
    private function calculatePrivateLimitedDue($profile, $path)
    {
        $clientIds = [];
        $clients = $this->getPrivateLimitedClients();
        if(count($clients) > 0){
            foreach($clients as $client){
                $companyProfile = $profile->fetch($client->company_number);
                if($companyProfile['status'] == 200)
                {
                    foreach($this->prepPath($path) as $p){
                        $companyProfile = $companyProfile[$p];
                    }
                   //prepare dates
                   $currentYear = Carbon::now()->format('Y');
                   //Confirm Statement Due
                   $confirmStatementDue = Carbon::parse($companyProfile)->format('Y');
                   if($currentYear >= $confirmStatementDue){
                       array_push($clientIds, $client->id);
                   } 
                }else{
                    break;
                }
            }
        }
        return $clientIds;
    }

    private function calculatePrivateLimitedOverDue($profile, $path)
    {
        $clientIds = [];
        $clients = $this->getPrivateLimitedClients();
        if(count($clients) > 0){
            foreach($clients as $client){
                //fetch api
                $companyProfile = $profile->fetch($client->company_number);
                if($companyProfile['status']==200){
                    foreach($this->prepPath($path) as $p){
                        $companyProfile = $companyProfile[$p];
                    }
                    if($companyProfile){
                        array_push($clientIds, $client->id);
                    }
                }else{
                    break;
                }
            }
        }
        return $clientIds;
    }
}
