<?php

namespace App\Repositories\Backend\Traits\Calculators;

use Carbon\Carbon;

trait ApiBaseDueCalculator
{
    private function getApiClients()
    {
        return $this->where('is_api', true)->get();
    }
    
    private function calculatePrivateLimitedDue($profile, $path, $filterValue)
    {
        
        $whenAndFormat = $this->getWhenAndFormat($filterValue);
        
        return $this->getClientIds($whenAndFormat, $path, $profile, $filterValue);
    }

    private function calculatePrivateLimitedOverDue($profile, $path)
    {
        $clientIds = [];
        $clients = $this->getApiClients();
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

    private function getClientIds($whenAndFormat, $path, $profile, $filterValue)
    {
        $clientIds = [];
        $clients = $this->getApiClients();
        if(count($clients) > 0){
            foreach($clients as $client){
                $companyProfile = $profile->fetch($client->company_number);
                if($companyProfile['status'] == 200)
                {
                    foreach($this->prepPath($path) as $p){
                        $companyProfile = $companyProfile[$p];
                    }
                    if($filterValue != config('filter.value.2')){
                        $fetchedDue = Carbon::parse($companyProfile)->format($whenAndFormat['format']);
                    }else{
                        $fetchedDue = Carbon::parse($companyProfile)->weekOfYear;
                    }
                    if($whenAndFormat['when'] == $fetchedDue){
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
