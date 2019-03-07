<?php

namespace App\Repositories\Backend\Traits\Deadline;

use Carbon\Carbon;

/**
 * returns the aa and cs due and overdue clients
 */
trait Vat
{
    public function fetchVat($filterValue=null)
    {
        $vatDueClients = $this->calculateNonPrivateLimitedDue(config('deadline.code.2'), $filterValue);
        $vatOverDueClients = $this->calculateNonPrivateLimitedOverDue(config('deadline.code.2'));

        return response()->json(
            [
                'chartdata' => [
                    'labels' => ['VAT'],
                    'datasets' => [
                        [
                            'label' => 'Due',
                            'backgroundColor' => config('settings.due_color'),
                            'data' => [count($vatDueClients)]
                        ],
                        [
                            'label' => 'Overdue',
                            'backgroundColor' => config('settings.overdue_color'),
                            'data' => [count($vatOverDueClients)]
                        ]
                    ],
                    'clientIds' => [
                        'vatDue' => $vatDueClients,
                        'vatOverDue' => $vatOverDueClients,
                    ]
                ]
            ]
        );
    }
}
