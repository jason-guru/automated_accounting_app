<?php

namespace App\Repositories\Backend\Traits\Deadline;

use Carbon\Carbon;

/**
 * returns the aa and cs due and overdue clients
 */
trait PayeCis
{
    private function getPayeDueClients($code)
    {
        return $this->calculateNonPrivateLimitedDue($code);
    }

    private function getPayeOverDueClients($code)
    {
        return $this->calculateNonPrivateLimitedOverDue($code);
    }

    private function getCisDueClients($code)
    {
        return $this->calculateNonPrivateLimitedDue($code);
    }

    private function getCisOverDueClients($code)
    {
        return $this->calculateNonPrivateLimitedOverDue($code);
    }

    public function fetchPayeCis()
    {
        $code = config('deadline.code.3');
        $payeDueClients = $this->getPayeDueClients($code);
        $payeOverDueClients = $this->getPayeOverDueClients($code);

        $code = config('deadline.code.4');
        $cisDueClients = $this->getCisDueClients($code);
        $cisOverDueClients = $this->getCisOverDueClients($code);

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
