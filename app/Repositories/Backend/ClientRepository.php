<?php

namespace App\Repositories\Backend;

use Carbon\Carbon;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Business\Api\CompanyHouse\CompanyProfile;
use App\Repositories\Backend\Traits\Deadline\Vat;
use App\Repositories\Backend\Traits\Deadline\AaCs;
use App\Repositories\Backend\Traits\Deadline\PayeCis;
use App\Repositories\Backend\Traits\Methods\CommonDueCalculatorMethods;
use App\Repositories\Backend\Traits\Calculators\PrivateLimitedDueCalculator;
use App\Repositories\Backend\Traits\Calculators\NonPrivateLimitedDueCalculator;

/**
 * Class ClientRepository.
 */
class ClientRepository extends BaseRepository
{
    use CommonDueCalculatorMethods;
    use PrivateLimitedDueCalculator;
    use NonPrivateLimitedDueCalculator;
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
            $this->handleClientDeadline($request, $client);
        }
        return redirect()->route('admin.clients.index')->withFlashSuccess('Client created successfully');
    }

    private function handleClient(Request $request)
    {
        $request->merge(['accounts_next_due' => Carbon::parse($request->accounts_next_due)->format('Y-m-d')]);
        return $this->create($request->except('_token', 'designation_id', 'initial_id', 'first_name', 'middle_name', 'last_name', 'contact_email', 'contact_phone', 'contact_address_line_1', 'contact_address_line_2', 'contact_city', 'contact_postcode', 'contact_county', 'contact_country_id'));
    }

    private function handleContactPerson(Request $request, $contactPersonRepository, $client)
    {
        if(is_array($request->first_name)):
        $counter = count($request->first_name);
        for($i=0; $i< $counter; $i++){
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
            'business_start_date' => !is_null($request->business_start_date) ? Carbon::parse($request->business_start_date)->format('Y-m-d'): null,
            'book_start_date' => !is_null($request->book_start_date) ?Carbon::parse($request->book_start_date)->format('Y-m-d'): null,
            'year_end_date' => !is_null($request->year_end_date) ? Carbon::parse($request->year_end_date)->format('Y-m-d') : null,
            'company_reg_number' => $request->company_reg_number,
            'utr_number' => $request->utr_number,
            'vat_scheme_id' => $request->vat_scheme_id,
            'vat_submit_type_id' => $request->vat_submit_type_id,
            'vat_reg_number' => $request->vat_reg_number,
            'vat_reg_date' => !is_null($request->vat_reg_date) ? Carbon::parse($request->vat_reg_date)->format('Y-m-d') : null,
            'social_media' => $request->social_media,
            'last_bookkeeping_done' => !is_null($request->last_bookkeeping_done) ? Carbon::parse($request->last_bookkeeping_done)->format('Y-m-d') : null,
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

    private function handleClientDeadline(Request $request, $client)
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
}