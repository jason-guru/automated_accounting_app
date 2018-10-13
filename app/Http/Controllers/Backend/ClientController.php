<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Repositories\Backend\ClientRepository;
use App\Repositories\Backend\ReminderRepository;
use App\Repositories\Backend\FrequencyRepository;
use App\Repositories\Backend\ContactPersonRepository;
use App\Repositories\Backend\BusinessInfoRepository;
use App\Models\Country;
use App\Models\CompanyType;
use Carbon\Carbon;
use Validator;
use App\Models\VatScheme;
use App\Models\VatSubmitType;

class ClientController extends Controller
{

    protected $client_repository;
    protected $countries;
    protected $company_types;
    protected $reminder_repository;
    protected $frequency_repository;
    protected $contact_person_repository;
    protected $business_info_repository;
    protected $vat_schemes;
    protected $vat_submit_types;

    public function __construct(ClientRepository $client_repository, ReminderRepository $reminder_repository, FrequencyRepository $frequency_repository, ContactPersonRepository $contact_person_repository, BusinessInfoRepository $business_info_repository)
    {
        $this->client_repository = $client_repository;
        $this->countries = Country::all();
        $this->company_types = CompanyType::all();
        $this->vat_schemes = VatScheme::all();
        $this->vat_submit_types = VatSubmitType::all();
        $this->reminder_repository = $reminder_repository;
        $this->frequency_repository = $frequency_repository;
        $this->contact_person_repository = $contact_person_repository;
        $this->business_info_repository = $business_info_repository;
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = $this->client_repository->paginate(10);
        return view('backend.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = $this->client_repository->create($request->except('_token', 'designation_id', 'initial_id', 'first_name', 'middle_name', 'last_name', 'contact_email', 'contact_phone', 'contact_address_line_1', 'contact_address_line_2', 'contact_city', 'contact_postcode', 'contact_county', 'contact_country_id'));

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
                $this->contact_person_repository->create($client_contact_people);
            }
        }
        endif;
        
        $this->business_info_repository->create([
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
            'last_bookkeeping_done' => Carbon::parse($request->last_bookkeeping_done)->format('Y-m-d'),
            'utr' => $request->utr
        ]);

        //set the reminder table data
        $active_frequency = $this->frequency_repository->where('is_active', 1)->first();
        $this->reminder_repository->set_reminders($client->id, $client->accounts_next_due, $active_frequency);
        return redirect()->route('admin.clients.index')->withFlashSuccess('Client created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->client_repository->getById($id);
        return view('backend.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vat_schemes = $this->vat_schemes;
        $vat_submit_types = $this->vat_submit_types;
        $company_types = $this->company_types;
        $countries = $this->countries;
        $client = $this->client_repository->getById($id);
        $business_info = $this->business_info_repository->where('client_id', $id)->first();
        return view('backend.clients.edit', compact('client', 'countries', 'company_types', 'business_info', 'vat_schemes', 'vat_submit_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = $this->client_repository->updateById($id, $request->except('_token','business_start_date', 'book_start_date' , 'year_end_date', 'company_reg_number', 'utr_number', 'utr', 'vat_submit_type_id', 'vat_reg_number', 'vat_reg_date', 'social_media', 'last_bookkeeping_done', 'vat_scheme_id'));
        $this->business_info_repository->updateById($client->business_info->id, $request->only('business_start_date', 'book_start_date' , 'year_end_date', 'company_reg_number', 'utr_number', 'utr', 'vat_submit_type_id', 'vat_reg_number', 'vat_reg_date', 'social_media', 'last_bookkeeping_done', 'vat_scheme_id'));
        if($request->remind_update){
            $this->reminder_repository->updateById($client->reminder->id, ['is_active' => $request->remind]);
            return response()->json([
                'success' => true
            ]);
        }else{
            return redirect()->route('admin.clients.index')->withFlashSuccess('Client updated Successfully');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->client_repository->deleteById($id);
        return back()->withFlashSuccess('Client successfully deleted');
    }
}
