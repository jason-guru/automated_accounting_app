<?php

namespace App\Repositories\Backend\Traits\Deadline;

use Carbon\Carbon;

/**
 * returns the aa and cs due and overdue clients
 */
trait Vat
{
    private function getVatDueClients()
    {
        return $this->calculateNonPrivateLimitedDue();
    }

    private function getVatOverDueClients()
    {
        return $this->calculateNonPrivateLimitedOverDue();
    }

    public function fetchVat()
    {
        $vatDueClients = $this->getVatDueClients();
        $vatOverDueClients = $this->getVatOverDueClients();

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
