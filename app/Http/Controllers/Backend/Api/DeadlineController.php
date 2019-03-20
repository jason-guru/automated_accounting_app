<?php

namespace App\Http\Controllers\Backend\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\ClientRepository;
use App\Business\Services\CompanyHouse\CompanyProfile;
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

    private function determineMethod(Request $request, $methodName)
    {
        if(isset($request->dateRange)){
            return $this->clientRepository->$methodName($request->dateRange);
        }else{
            return $this->clientRepository->$methodName($request->q);
        }
    }
    
    public function aaCs(Request $request)
    {
        return $this->determineMethod($request, 'fetchAaCs');
        
    }

    public function vat(Request $request)
    {
        return $this->determineMethod($request, 'fetchVat');
    }

    public function payeCis(Request $request)
    {
        return $this->determineMethod($request, 'fetchPayeCis');
    }

    
    public function fetchClients(Request $request)
    {
        $clientData = [];
        foreach($request->all() as $key => $clientId){
            $client = $this->clientRepository->getById($clientId);
            $clientData[$key] = $this->localCompanyProfile->fetch($client)['body'];
            $clientData[$key]['is_api'] = $client->is_api;
        }
        return $clientData;
    }

    public function prepareClients(Request $request)
    {
        $clientData = [];
        foreach($request->all() as $apiData)
        {
            $clientData[] = $this->clientRepository->getDialogClientData($apiData);
        }
        return $clientData;
    }
}
