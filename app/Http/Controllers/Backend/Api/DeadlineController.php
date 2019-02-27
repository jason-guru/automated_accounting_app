<?php

namespace App\Http\Controllers\Backend\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\ClientRepository;
use App\Business\Api\CompanyHouse\CompanyProfile;
use App\Business\LocalCompanyProfile;

class DeadlineController extends Controller
{
    protected $clientRepository;
    protected $profile;
    protected $localCompanyProfile;
    public function __construct(ClientRepository $clientRepository, CompanyProfile $profile, LocalCompanyProfile $localCompanyProfile)
    {
        $this->clientRepository = $clientRepository;
        $this->profile = $profile;
        $this->localCompanyProfile = $localCompanyProfile;
    }
    
    public function aaCs()
    {
        return $this->clientRepository->fetchAaCs($this->profile);
    }

    public function vat()
    {
        return $this->clientRepository->fetchVat();
    }

    public function payeCis()
    {
        return $this->clientRepository->fetchPayeCis();
    }

    
    public function fetchClients(Request $request)
    {
        $clientData = [];
        foreach($request->all() as $key => $clientId){
            $client = $this->clientRepository->getById($clientId);
            if($client->is_api){
                $clientData[$key] = $this->profile->fetch($client->company_number)['body'];
                $clientData[$key]['is_api'] = $client->is_api;
            }else{
                $clientData[$key] = $this->localCompanyProfile->fetch($client)['body'];
                $clientData[$key]['is_api'] = $client->is_api;
            }
        }
        return $clientData;
    }

    public function prepareClients(Request $request)
    {
        $clientData = [];
        foreach($request->all() as $apiData)
        {
            if($apiData['is_api']){
                
                $clientData[] = $this->clientRepository->getAaCsDialogClientData($apiData);
                
            }else{
                $clientData[] = $this->clientRepository->getVatPayeCisClientData($apiData);
            }
        }
        return $clientData;
    }
}
