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
        return $this->clientRepository->fetchAaCs($this->profile);
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

    
    public function fetchClients(Request $request)
    {
        $clientData = [];
        foreach($request->all() as $clientId){
            $client = $this->clientRepository->getById($clientId);
            if($client->company_number != null){
                $clientData[] = $this->profile->fetch($client->company_number)['body'];
            }
        }
        return $clientData;
    }

    /**
     * Requiremnets from API: 
     *  1. company_name
     *  2. accounts.next_accounts.period_start_on
     *  3. accounts.next_accounts.period_end_on
     *  4. confirmation_statement.next_due
     *  5. confirmation_statement.overdue
     *  6. accounts.next_accounts.due_on
     *  7. accounts.next_accounts.overdue
     * 
     * Requirement for database
     */
    public function prepareClients(Request $request)
    {
        $clientData = [];
        foreach($request->all() as $apiData)
        {
            $client = $this->clientRepository->where('company_number', $apiData['company_number'])->first();
            $clientData[] = [
                'company_name' => $apiData['company_name'],
                'from' => $apiData['accounts']['next_accounts']['period_start_on'],
                'to' => $apiData['accounts']['next_accounts']['period_end_on'],
                'cs_due' => $apiData['confirmation_statement']['next_due'],
                'cs_overdue' => $apiData['confirmation_statement']['overdue'],
                'aa_due' => $apiData['accounts']['next_accounts']['due_on'],
                'aa_overdue' => $apiData['accounts']['next_accounts']['overdue'],
                //from database
                'client_id' => $client->id,
                'deadline_id' => null,
                'remind_date' => null,
                'has_reminded' => false,
                'is_active' => true,
                'reference_number_id' => null,
                'schedule_time' => null,
                'recurring_id' => 1,
                'counter' => null,
                'send_sms' => true,
                'send_email' => true
            ];
        }
        

        return $clientData;
    }
}
