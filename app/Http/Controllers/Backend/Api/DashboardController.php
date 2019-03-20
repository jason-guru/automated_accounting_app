<?php

namespace App\Http\Controllers\Backend\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\ClientRepository;
use App\Business\Services\DueDateUpdate\Processor;

class DashboardController extends Controller
{
    protected $processor;
    protected $clientRepository;
    public function __construct(Processor $processor, ClientRepository $clientRepository)
    {
        $this->processor = $processor;
        $this->clientRepository = $clientRepository;
    }

    public function autoUpdate()
    {
        $companyHouseClients = $this->clientRepository->where('is_api', true)->get();
        if(count($companyHouseClients)>0){
            $companyHouseClients->each(function($companyHouseClient){
                $this->processor->apiBased($companyHouseClient->company_number);
            });
        }
        return;
    }
}
