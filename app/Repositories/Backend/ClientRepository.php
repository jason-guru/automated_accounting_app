<?php

namespace App\Repositories\Backend;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Business\Api\CompanyHouse\CompanyProfile;
use App\Repositories\Backend\Traits\Deadline\Vat;
use App\Repositories\Backend\Traits\Deadline\AaCs;
use App\Repositories\Backend\Traits\Deadline\PayeCis;
use App\Repositories\Backend\Traits\Methods\CommonDueCalculatorMethods;
use App\Repositories\Backend\Traits\Calculators\ApiBaseDueCalculator;
use App\Repositories\Backend\Traits\Calculators\DueCalculator;

/**
 * Class ClientRepository.
 */
class ClientRepository extends BaseRepository
{
    use CommonDueCalculatorMethods;
    //use ApiBaseDueCalculator;
    use DueCalculator;
    use AaCs;
    use Vat;
    use PayeCis;
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Client::class;
    }

    public function clientManager(Request $request, $deadlineRepository, $contactPersonRepository, $businessInfoRepository)
    {
        $client = $this->handleClient($request);
        $this->handleContactPerson($request, $contactPersonRepository, $client);
        $this->handleBusinessInfo($request, $businessInfoRepository, $client);
        $this->handleDeadline($request, $deadlineRepository, $client);

        if($request->is_api == 1){
            $this->insertClientDeadline($request, $client);
        }
        return redirect()->route('admin.clients.index')->withFlashSuccess('Client created successfully');
    }

    private function handleClient(Request $request)
    {
        $request->merge(['accounts_next_due' => carbon_parse($request->accounts_next_due)]);
        return $this->create($request->except('_token', 'designation_id', 'initial_id', 'first_name', 'middle_name', 'last_name', 'contact_email', 'contact_phone', 'contact_address_line_1', 'contact_address_line_2', 'contact_city', 'contact_postcode', 'contact_county', 'contact_country_id'));
    }

    private function handleContactPerson(Request $request, $contactPersonRepository, $client)
    {
        if(is_array($request->first_name)):
            for($i=0; $i< count($request->first_name); $i++){
                $client_contact_people = [
                    'client_id' => $client->id,
                    'designation_id' => $request->designation_id[$i],
                    'initial_id' => $request->initial_id[$i],
                    'first_name' => $request->first_name[$i],
                    'middle_name' => $request->middle_name[$i],
                    'last_name' => $request->last_name[$i],
                    'email' => $request->contact_email[$i],
                    'phone' => $request->contact_phone[$i],
                    'address_line_1' => $request->contact_address_line_1[$i],
                    'address_line_2' => $request->contact_address_line_2[$i],
                    'city' => $request->contact_city[$i],
                    'postcode' => $request->contact_postcode[$i],
                    'county' => $request->contact_county[$i],
                    'country_id' => $request->contact_country_id[$i]
                ];
                if(!is_null($request->first_name[$i])){
                    $contactPersonRepository->create($client_contact_people);
                }
            }
        endif;
    }

    private function handleBusinessInfo(Request $request, $businessInfoRepository, $client)
    {
        $businessInfoRepository->create([
            'client_id' => $client->id,
            'company_type_id' => $request->company_type_id,
            'business_start_date' => carbon_parse($request->business_start_date),
            'book_start_date' => carbon_parse($request->book_start_date),
            'year_end_date' => carbon_parse($request->year_end_date),
            'company_reg_number' => $request->company_reg_number,
            'utr_number' => $request->utr_number,
            'vat_scheme_id' => $request->vat_scheme_id,
            'vat_submit_type_id' => $request->vat_submit_type_id,
            'vat_reg_number' => $request->vat_reg_number,
            'vat_reg_date' => carbon_parse($request->vat_reg_date),
            'social_media' => $request->social_media,
            'last_bookkeeping_done' => carbon_parse($request->last_bookkeeping_done),
            'utr' => $request->utr
        ]);
    }
    
    private function handleDeadline(Request $request, $deadlineRepository, $client)
    {
        $deadlines = $deadlineRepository->all();
        foreach($deadlines as $deadline){
            $client->deadlines()->attach($deadline->id);
        }
    }

    private function insertClientDeadline(Request $request, $client)
    {
        foreach($client->deadlines as $deadline)
        {
            if($deadline->code == 'AA'){
                $client->deadlines()->updateExistingPivot(
                    $deadline->id,
                    [
                        'from' => $request->aa_from,
                        'to' => $request->aa_to,
                        'due_on' => $request->aa_due
                    ]
                );
            }elseif( $deadline->code == 'CS'){
                $client->deadlines()->updateExistingPivot(
                    $deadline->id,
                    [
                        'from' => $request->cs_from,
                        'to' => $request->cs_to,
                        'due_on' => $request->cs_due
                    ]
                );
            }
        }
    }

    public function getDialogClientData($apiData)
    {
        return [
            'company_name' => $apiData['company_name'],
            'from' => $apiData['vat']['from'],
            'to' => $apiData['vat']['to'],

            'aa_from' => $apiData['aa']['from'],
            'aa_to' => $apiData['aa']['to'],
            'aa_due' => $apiData['aa']['due'],
            'aa_overdue' => $apiData['aa']['overdue'] == 1 ? 'true': 'false',

            'cs_from' => $apiData['cs']['from'],
            'cs_to' => $apiData['cs']['to'],
            'cs_due' => $apiData['cs']['due'],
            'cs_overdue' => $apiData['cs']['overdue'] == 1 ? 'true': 'false',

            'vat_from' => $apiData['vat']['from'],
            'vat_to' => $apiData['vat']['to'],
            'vat_due' => $apiData['vat']['due'],
            'vat_overdue' => $apiData['vat']['overdue'] == 1 ? 'true': 'false',

            'paye_from' => $apiData['paye']['from'],
            'paye_to' => $apiData['paye']['to'],
            'paye_due' => $apiData['paye']['due'],
            'paye_overdue' => $apiData['paye']['overdue'] == 1 ? 'true': 'false',

            'cis_from' => $apiData['cis']['from'],
            'cis_to' => $apiData['cis']['to'],
            'cis_due' => $apiData['cis']['due'],
            'cis_overdue' => $apiData['cis']['overdue'] == 1 ? 'true': 'false',

            'client_id' => $apiData['client_id'],
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
}