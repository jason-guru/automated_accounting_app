<?php

namespace App\Repositories\Backend;

use Carbon\Carbon;
use App\Models\Client;
use App\Repositories\BaseRepository;
use App\Business\Api\CompanyHouse\CompanyProfile;

/**
 * Class ClientRepository.
 */
class ClientRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Client::class;
    }

    public function getCsDueCounter($profile)
    {
        $csDueCounter = 0;
        $clients = $this->where('company_type_id', 1)->get();
        if(count($clients)>0){
            foreach($clients as $client){
                //fetch api
                $companyProfile = $profile->fetch($client->company_number);
    
                if($companyProfile['status']==200){
                    //prepare dates
                    $currentYear = Carbon::now()->format('Y');
                    //Confirm Statement Due
                    $confirmStatementDue = Carbon::parse($companyProfile['body']['confirmation_statement']['next_due'])->format('Y');
                    if($currentYear == $confirmStatementDue){
                        $csDueCounter++;
                    }
                }else{
                    break;
                }
            }
        }
        return $csDueCounter;
    }

    public function getCsOverDueCounter($profile)
    {
        $csOverDueCounter = 0;
        $clients = $this->where('company_type_id', 1)->get();
        if(count($clients) > 0){
            foreach($clients as $client){
                //fetch api
                $companyProfile = $profile->fetch($client->company_number);
                // $companyProfile = $profile->fetch($client->company_number, "2017-08-21", "2019-08-21", "2019-04-21", "2019-04-21", false, false);
    
                if($companyProfile['status']==200){
                    //prepare dates
                    $csOverDue = $companyProfile['body']['confirmation_statement']['overdue'];
                    if($csOverDue){
                        $csOverDueCounter++;
                    }
                }else{
                    break;
                }
            }
        }
        return $csOverDueCounter;
    }

    public function getAaDueCounter($profile)
    {
        $aaDueCounter = 0;
        $clients = $this->where('company_type_id', 1)->get();
        if(count($clients) >0){
            foreach($clients as $client){
                //fetch api
                $companyProfile = $profile->fetch($client->company_number);
    
                if($companyProfile['status']==200){
                    //prepare dates
                    $currentYear = Carbon::now()->format('Y');
                    //Confirm Statement Due
                    $nextAccountDue = Carbon::parse($companyProfile['body']['accounts']['next_accounts']['due_on'])->format('Y');
                    if($currentYear == $nextAccountDue){
                        $aaDueCounter++;
                    }
                }else{
                    break;
                }
            }
        }
        
        return $aaDueCounter;
    }

    public function getAaOverDueCounter($profile)
    {
        $aaOverDueCounter = 0;
        $clients = $this->where('company_type_id', 1)->get();
        if(count($clients)>0){
            foreach($clients as $client){
                //fetch api
                $companyProfile = $profile->fetch($client->company_number);
                // $companyProfile = $profile->fetch($client->company_number, "2017-08-21", "2019-08-21", "2019-04-21", "2019-04-21", false, false);
    
                if($companyProfile['status']==200){
                    //prepare dates
                    $aaOverDue = $companyProfile['body']['accounts']['next_accounts']['overdue'];
                    if($aaOverDue){
                        $aaOverDueCounter++;
                    }
                }else{
                    break;
                }
            }
        }
        
        return $aaOverDueCounter;
    }
}