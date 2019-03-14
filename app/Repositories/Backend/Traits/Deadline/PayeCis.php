<?php

namespace App\Repositories\Backend\Traits\Deadline;

use Carbon\Carbon;

/**
 * returns the aa and cs due and overdue clients
 */
trait PayeCis
{
    public function fetchPayeCis($filterValue =null)
    {
        $payeDueClients = $this->getDueClientIds(config('deadline.code.3'), $filterValue);
        $payeOverDueClients = $this->getOverDueClientIds(config('deadline.code.3'));

        $cisDueClients = $this->getDueClientIds(config('deadline.code.4'), $filterValue);
        $cisOverDueClients = $this->getOverDueClientIds(config('deadline.code.4'));

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
