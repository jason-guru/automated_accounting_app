<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Repositories\Backend\ClientRepository;
use App\Repositories\Backend\ReminderRepository;
use App\Repositories\Backend\FrequencyRepository;
use App\Models\Country;
use App\Models\CompanyType;
use Carbon\Carbon;
use Validator;

class ClientController extends Controller
{

    protected $client_repository;
    protected $countries;
    protected $company_types;
    protected $reminder_repository;
    protected $frequency_repository;

    public function __construct(ClientRepository $client_repository, ReminderRepository $reminder_repository, FrequencyRepository $frequency_repository)
    {
        $this->client_repository = $client_repository;
        $this->countries = Country::all();
        $this->company_types = CompanyType::all();
        $this->reminder_repository = $reminder_repository;
        $this->frequency_repository = $frequency_repository;
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
        $client = $this->client_repository->create($request->except('_token'));
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
        $company_types = $this->company_types;
        $countries = $this->countries;
        $client = $this->client_repository->getById($id);
        return view('backend.clients.edit', compact('client', 'countries', 'company_types'));
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
        $client = $this->client_repository->updateById($id, $request->except('_token'));
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
