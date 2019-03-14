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
    
    public function aaCs(Request $request)
    {
        return $this->clientRepository->fetchAaCs($request->q);
    }

    public function vat(Request $request)
    {
        return $this->clientRepository->fetchVat($request->q);
    }

    public function payeCis(Request $request)
    {
        return $this->clientRepository->fetchPayeCis($request->q);
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
