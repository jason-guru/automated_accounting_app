<?php

namespace App\Repositories\Backend\Traits\Deadline;

use Carbon\Carbon;

/**
 * returns the aa and cs due and overdue clients
 */
trait AaCs
{
    private function getCsDueClients($profile)
    {
        $path = "body, confirmation_statement, next_due";
        return $this->calculatePrivateLimitedDue($profile, $path);
    }

    private function getCsOverDueClients($profile)
    {
        $path = "body, confirmation_statement, overdue";
        return $this->calculatePrivateLimitedOverDue($profile, $path);
    }

    private function getAaDueClients($profile)
    {
        $path = "body, accounts, next_accounts, due_on";
        return $this->calculatePrivateLimitedDue($profile, $path);
    }

    private function getAaOverDueClients($profile)
    {
        $path = "body, accounts, next_accounts, overdue";
        return $this->calculatePrivateLimitedOverDue($profile, $path);
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
                            'backgroundColor' => config('settings.due_color'),
                            'data' => [count($aaDueClients), count($csDueClients)]
                        ],
                        [
                            'label' => 'Overdue',
                            'backgroundColor' => config('settings.overdue_color'),
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
