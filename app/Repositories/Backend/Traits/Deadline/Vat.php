<?php

namespace App\Repositories\Backend\Traits\Deadline;

use Carbon\Carbon;

/**
 * returns the aa and cs due and overdue clients
 */
trait Vat
{
    private function getVatDueClients($code, $filterValue)
    {
        return $this->calculateNonPrivateLimitedDue($code, $filterValue);
    }

    private function getVatOverDueClients($code)
    {
        return $this->calculateNonPrivateLimitedOverDue($code);
    }

    public function fetchVat($filterValue=null)
    {
        $code = config('deadline.code.2');
        $vatDueClients = $this->getVatDueClients($code, $filterValue);
        $vatOverDueClients = $this->getVatOverDueClients($code);

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
