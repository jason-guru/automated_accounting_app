<?php

namespace App\Repositories\Backend\Traits\Deadline;

use Carbon\Carbon;

/**
 * returns the aa and cs due and overdue clients
 */
trait AaCs
{
    public function fetchAaCs($filterValue = null)
    {
        $csDueClients = $this->calculateDue(config('deadline.code.1'), $filterValue);
        $csOverDueClients = $this->calculateOverDue(config('deadline.code.1'));
        $aaDueClients = $this->calculateDue(config('deadline.code.0'), $filterValue);
        $aaOverDueClients = $this->calculateOverDue(config('deadline.code.0'));
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
