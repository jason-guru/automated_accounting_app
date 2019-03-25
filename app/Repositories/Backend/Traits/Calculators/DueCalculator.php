<?php

namespace App\Repositories\Backend\Traits\Calculators;

use Carbon\Carbon;
use App\Business\LocalCompanyProfile;

/**
 * 
 */
trait DueCalculator
{
    private function getLocalClients()
    {
        return $this->all();
    }
    
    private function getDueClientIds($code, $filterValue)
    {
        try {
        $clientIds = [];
        $clients = $this->getLocalClients();
        if(count($clients) > 0){
            //this is date range filter
            if(is_json($filterValue)){
                $filterValue = json_decode($filterValue, true);
                foreach($clients as $client){
                    $clientDealineDueDate = carbon_parse($client->deadlines->where('code', $code)->first()->pivot->due_on);
                    if(!is_null($clientDealineDueDate)):
                        if($clientDealineDueDate >= Carbon::parse($filterValue['from'])->toDateString() && $clientDealineDueDate <= Carbon::parse($filterValue['to'])->toDateString()):
                            array_push($clientIds, $client->id);
                        endif;
                    endif;
                };
            }else{
                $whenAndFormat = $this->getWhenAndFormat($filterValue);
                    foreach($clients as $client){
                        $nextDue = $this->getDueOn($client, $code, $whenAndFormat, $filterValue);
                        if(!is_null($nextDue)){
                            if(!is_null($whenAndFormat['parentYear'])){
                                if(!is_null($whenAndFormat['parentMonth'])){
                                    //This Week Filter
                                    if($whenAndFormat['when'] == $nextDue && $whenAndFormat['parentYear'] == $this->getDueYear($client, $code) && $whenAndFormat['parentMonth'] == $this->getDueMonth($client, $code)){
                                        array_push($clientIds, $client->id);
                                    }
                                }else{
                                    //This Month filter
                                    if($whenAndFormat['when'] >= $nextDue && $whenAndFormat['parentYear'] == $this->getDueYear($client, $code)){
                                        array_push($clientIds, $client->id);
                                    }
                                }
                            }else{
                                if($whenAndFormat['when'] >= $nextDue){
                                    array_push($clientIds, $client->id);
                                }
                            }
                        }
                    }
                }
            }
            return $clientIds;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    private function getOverDueClientIds($code)
    {
        $localOverDue = new LocalCompanyProfile();
        $clientIds = [];
        $clients = $this->getLocalClients();
        if(count($clients) > 0){
            foreach($clients as $client){
                $isOverdue = $localOverDue->calculateOverDue($client, $code);
                if($isOverdue == true){
                    array_push($clientIds, $client->id);
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
            }elseif($filterValue == config('filter.value.1')){
                return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->due_on)->monthOfYear;
            }elseif($filterValue == config('filter.value.2')){
                return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->due_on)->weekOfYear;
            }
        }else{
            return null;
        }
    }

    private function getDueYear($client, $code)
    {
        if(!is_null($client->deadlines->where('code', $code)->first()->pivot->due_on))
        {
            return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->due_on)->format('Y');
        }else{
            return null;
        }
    }

    private function getDueMonth($client, $code)
    {
        if(!is_null($client->deadlines->where('code', $code)->first()->pivot->due_on))
        {
            return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->due_on)->format('M');
        }else{
            return null;
        }
    }
}
