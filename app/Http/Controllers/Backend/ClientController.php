<?php

namespace App\Http\Controllers\Backend;

use Validator;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\Initial;
use App\Models\VatScheme;
use App\Models\CompanyType;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\VatSubmitType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ClientRequest;
use App\Repositories\Backend\ClientRepository;
use App\Repositories\Backend\DeadlineRepository;
use App\Repositories\Backend\ReminderRepository;
use App\Repositories\Backend\FrequencyRepository;
use App\Repositories\Backend\BusinessInfoRepository;
use App\Repositories\Backend\ContactPersonRepository;

class ClientController extends Controller
{

    protected $clientRepository;
    protected $countries;
    protected $company_types;
    protected $reminder_repository;
    protected $frequency_repository;
    protected $contactPersonRepository;
    protected $businessInfoRepository;
    protected $vat_schemes;
    protected $vat_submit_types;
    protected $designations;
    protected $initials;
    protected $deadlineRepository;

    public function __construct(ClientRepository $clientRepository, ReminderRepository $reminder_repository, FrequencyRepository $frequency_repository, ContactPersonRepository $contactPersonRepository, BusinessInfoRepository $businessInfoRepository, DeadlineRepository $deadlineRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->countries = Country::all();
        $this->company_types = CompanyType::all();
        $this->vat_schemes = VatScheme::all();
        $this->vat_submit_types = VatSubmitType::all();
        $this->designations = Designation::all();
        $this->initials = Initial::all();
        $this->reminder_repository = $reminder_repository;
        $this->frequency_repository = $frequency_repository;
        $this->contactPersonRepository = $contactPersonRepository;
        $this->businessInfoRepository = $businessInfoRepository;
        $this->deadlineRepository = $deadlineRepository;
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = $this->clientRepository->paginate(10);
        return view('backend.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        try{
            $countries = $this->countries;
            $company_types = $this->company_types;
            $designations = $this->designations;
            $initials = $this->initials;
            $vat_schemes = $this->vat_schemes;
            $vat_submit_types = $this->vat_submit_types;
            return view('backend.clients.create', compact('countries', 'company_types', 'designations', 'initials', 'vat_schemes', 'vat_submit_types'));
        }catch(\Exception $exception)
        {
            return $exception->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        if(config('settings.enable_demo')){
            return back()->withFlashDanger('Not allowed in Demo mode');
        }
        return $this->clientRepository->clientManager($request, $this->deadlineRepository, $this->contactPersonRepository, $this->businessInfoRepository);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->clientRepository->getById($id);
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
        $client = $this->clientRepository->getById($id);
        $business_info = $this->businessInfoRepository->where('client_id', $id)->first();
        return view('backend.clients.edit', compact('client', 'countries', 'company_types', 'business_info', 'vat_schemes', 'vat_submit_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id)
    {
        if(config('settings.enable_demo')){
            return back()->withFlashDanger('Not allowed in Demo mode');
        }
        try{

            $request->merge(['accounts_next_due' => Carbon::parse($request->accounts_next_due)->format('Y-m-d')]);
            $request->merge(['business_start_date' => !is_null($request->business_start_date) ? Carbon::parse($request->business_start_date)->format('Y-m-d'): null]);
            $request->merge(['book_start_date' => !is_null($request->book_start_date) ? Carbon::parse($request->book_start_date)->format('Y-m-d'): null]);
            $request->merge(['year_end_date' => !is_null($request->year_end_date) ? Carbon::parse($request->year_end_date)->format('Y-m-d'): null]);
            $request->merge(['vat_reg_date' => !is_null($request->vat_reg_date) ? Carbon::parse($request->vat_reg_date)->format('Y-m-d'): null]);
            $request->merge(['last_bookkeeping_done' => !is_null($request->last_bookkeeping_done) ? Carbon::parse($request->last_bookkeeping_done)->format('Y-m-d'): null]);

            $client = $this->clientRepository->updateById($id, $request->except('_token','business_start_date', 'book_start_date' , 'year_end_date', 'company_reg_number', 'utr_number', 'utr', 'vat_submit_type_id', 'vat_reg_number', 'vat_reg_date', 'social_media', 'last_bookkeeping_done', 'vat_scheme_id'));
            $this->businessInfoRepository->updateById($client->business_info->id, $request->only('business_start_date', 'book_start_date' , 'year_end_date', 'company_reg_number', 'utr_number', 'utr', 'vat_submit_type_id', 'vat_reg_number', 'vat_reg_date', 'social_media', 'last_bookkeeping_done', 'vat_scheme_id'));
            return redirect()->route('admin.clients.index')->withFlashSuccess('Client updated Successfully');
        }catch(\Exception $exception)
        {
            return $exception->getMessage();
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
        
        if(config('settings.enable_demo')){
            return back()->withFlashDanger('Not allowed in Demo mode');
        }
        $this->clientRepository->deleteById($id);
        return back()->withFlashSuccess('Client successfully deleted');
    }

    public function switchToggle(Request $request, $id)
    {
        $client = $this->clientRepository->updateById($id,['remind' => $request->switch_value]);
        foreach($client->reminders as $reminder){
            $this->reminder_repository->updateById($reminder->id, ['is_active' => $request->switch_value]);
        };
        return response()->json([
            'success' => true
        ]);
    }

}
