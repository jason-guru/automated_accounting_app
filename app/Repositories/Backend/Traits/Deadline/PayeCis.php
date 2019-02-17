<?php

namespace App\Repositories\Backend\Traits\Deadline;

use Carbon\Carbon;

/**
 * returns the aa and cs due and overdue clients
 */
trait PayeCis
{
    private function getPayeDueClients()
    {
        return $this->calculateNonPrivateLimitedDue();
    }

    private function getPayeOverDueClients()
    {
        return $this->calculateNonPrivateLimitedOverDue();
    }

    private function getCisDueClients()
    {
        return $this->calculateNonPrivateLimitedDue();
    }

    private function getCisOverDueClients()
    {
        return $this->calculateNonPrivateLimitedOverDue();
    }

    public function fetchPayeCis()
    {
        $payeDueClients = $this->getPayeDueClients();
        $payeOverDueClients = $this->getPayeOverDueClients();

        $cisDueClients = $this->getCisDueClients();
        $cisOverDueClients = $this->getCisOverDueClients();

        return response()->json(
            [
                'chartdata' => [
                    'labels' => ['PAYE', 'CIS'],
                    'datasets' => [
                        [
                            'label' => 'Due',
                            'backgroundColor' => config('settings.due_color'),
                            'data' => [count($payeDueClients), count($cisDueClients)]
                        ],
                        [
                            'label' => 'Overdue',
                            'backgroundColor' => config('settings.overdue_color'),
                            'data' => [count($payeOverDueClients), count($cisOverDueClients)]
                        ]
                    ],
                    'clientIds' => [
                        'payeDue' => $payeDueClients,
                        'payeOverDue' => $payeOverDueClients,
                        'cisDue' => $cisDueClients,
                        'cisOverDue' => $cisOverDueClients
                    ]
                ]
            ]
        );
    }
}
