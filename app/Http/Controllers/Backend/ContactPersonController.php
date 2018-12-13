<?php

namespace App\Http\Controllers\Backend;

use App\Models\Country;
use App\Models\Designation;
use App\Models\Initial;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\ContactPersonRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\ContactPersonRepository;

class ContactPersonController extends Controller
{
    protected $companies;
    protected $designations;
    protected $initials;
    protected $contact_person_repository;

    public function __construct(ContactPersonRepository $contact_person_repository)
    {   
        $this->countries = Country::all();
        $this->designations = Designation::all();
        $this->initials = Initial::all();
        $this->contact_person_repository = $contact_person_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->countries;
        $designations = $this->designations;
        $initials = $this->initials;
        return view('backend.clients.contact-people.create', compact('countries', 'designations', 'initials'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_by_client($client_id)
    {
        $countries = $this->countries;
        $designations = $this->designations;
        $initials = $this->initials;
        return view('backend.clients.contact-people.create', compact('countries', 'designations', 'initials', 'client_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactPersonRequest $request)
    {
        if(config('settings.enable_demo')){
            return back()->withFlashDanger('Not allowed in Demo mode');
        }
        $this->contact_person_repository->create($request->except('_token'));
        return redirect()->route('admin.clients.show', ['id' => $request->client_id])->withFlashSuccess('Contact Person Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact_person = $this->contact_person_repository->getById($id);
        return view('backend.clients.contact-people.show', compact('contact_person'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countries = $this->countries;
        $designations = $this->designations;
        $initials = $this->initials;
        $contact_person = $this->contact_person_repository->getById($id);
        return view('backend.clients.contact-people.edit', compact('contact_person', 'countries', 'designations', 'initials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactPersonRequest $request, $id)
    {
        if(config('settings.enable_demo')){
            return back()->withFlashDanger('Not allowed in Demo mode');
        }
        $this->contact_person_repository->updateById($id, $request->except('_token'));
        return redirect()->route('admin.clients.show', ['id' => $request->client_id])->withFlashSuccess('Contact Person Updated Successfully');
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
        $client_id = $this->contact_person_repository->getById($id)->client_id;
        $this->contact_person_repository->deleteById($id);
        return redirect()->route('admin.clients.show', ['id' => $client_id])->withFlashSuccess('Contact Person Deleted Successfully');
    }
}
