<?php

namespace App\Http\Controllers\Backend\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\ClientRepository;
use App\Business\Api\CompanyHouse\CompanyProfile;

class DeadlineController extends Controller
{
    public function __construct(ClientRepository $clientRepository, CompanyProfile $profile)
    {
        $this->clientRepository = $clientRepository;
        $this->profile = $profile;
    }
    
    public function aaCs()
    {
        $csDueCounter = $this->clientRepository->getCsDueCounter($this->profile);
        $csOverDueCounter = $this->clientRepository->getCsOverdueCounter($this->profile);
        $aaDueCounter = $this->clientRepository->getAaDueCounter($this->profile);
        $aaOverDueCounter = $this->clientRepository->getAaOverDueCounter($this->profile);

        return response()->json(
            [
                'chartdata' => [
                    'labels' => ['AA', 'CS'],
                    'datasets' => [
                        [
                            'label' => 'Due',
                            'backgroundColor' => '#f87979',
                            'data' => [$aaDueCounter, $csDueCounter]
                        ],
                        [
                            'label' => 'Overdue',
                            'backgroundColor' => 'red',
                            'data' => [$aaOverDueCounter, $csOverDueCounter]
                        ]
                    ]
                ]
            ]
        );
    }

    public function vat()
    {
        $csDueCounter = $this->clientRepository->getCsDueCounter($this->profile);
        $csOverDueCounter = $this->clientRepository->getCsOverdueCounter($this->profile);
        return response()->json(
            [
                'chartdata' => [
                    'labels' => ['VAT'],
                    'datasets' => [
                        [
                            'label' => 'Due',
                            'backgroundColor' => '#f87979',
                            'data' => [$csDueCounter]
                        ],
                        [
                            'label' => 'Overdue',
                            'backgroundColor' => 'red',
                            'data' => [$csOverDueCounter]
                        ]
                    ]
                ]
            ]
        );
    }

    public function payeCis()
    {
        $csDueCounter = $this->clientRepository->getCsDueCounter($this->profile);
        $csOverDueCounter = $this->clientRepository->getCsOverdueCounter($this->profile);
        $aaDueCounter = $this->clientRepository->getAaDueCounter($this->profile);
        $aaOverDueCounter = $this->clientRepository->getAaOverDueCounter($this->profile);

        return response()->json(
            [
                'chartdata' => [
                    'labels' => ['PAYE', 'CIS'],
                    'datasets' => [
                        [
                            'label' => 'Due',
                            'backgroundColor' => '#f87979',
                            'data' => [$aaDueCounter, $csDueCounter]
                        ],
                        [
                            'label' => 'Overdue',
                            'backgroundColor' => 'red',
                            'data' => [$aaOverDueCounter, $csOverDueCounter]
                        ]
                    ]
                ]
            ]
        );
    }
}
