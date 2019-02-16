<?php

namespace App\Repositories\Backend\Traits\Methods;

use Carbon\Carbon;

/**
 * returns the aa and cs due and overdue clients
 */
trait AaCs
{
    private function getCsDueClients($profile)
    {
        $path = "body, confirmation_statement, next_due";
        return $this->calculateDue($profile, $path);
    }

    private function getCsOverDueClients($profile)
    {
        $path = "body, confirmation_statement, overdue";
        return $this->calculateOverDue($profile, $path);
    }

    private function getAaDueClients($profile)
    {
        $path = "body, accounts, next_accounts, due_on";
        return $this->calculateDue($profile, $path);
    }

    private function getAaOverDueClients($profile)
    {
        $path = "body, accounts, next_accounts, overdue";
        return $this->calculateOverDue($profile, $path);
    }

    public function fetchAaCs($profile)
    {
        $csDueClients = $this->getCsDueClients($profile);
        $csOverDueClients = $this->getCsOverDueClients($profile);

        $aaDueClients = $this->getAaDueClients($profile);
        $aaOverDueClients = $this->getAaOverDueClients($profile);
        return response()->json(
            [
                'chartdata' => [
                    'labels' => ['AA', 'CS'],
                    'datasets' => [
                        [
                            'label' => 'Due',
                            'backgroundColor' => '#f87979',
                            'data' => [count($aaDueClients), count($csDueClients)]
                        ],
                        [
                            'label' => 'Overdue',
                            'backgroundColor' => 'red',
                            'data' => [count($aaOverDueClients), count($csOverDueClients)]
                        ]
                    ],
                    'clientIds' => [
                        'csDue' => $csDueClients,
                        'csOverDue' => $csOverDueClients,
                        'aaDue' => $aaDueClients,
                        'aaOverDue' => $aaOverDueClients
                    ]
                ]
            ]
        );
    }
}
