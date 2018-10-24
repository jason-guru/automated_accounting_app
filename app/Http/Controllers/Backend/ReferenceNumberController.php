<?php

namespace App\Http\Controllers\Backend;

use Storage;
use App\Models\ReferenceNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReferenceNumberRequest;
use App\Repositories\Backend\ClientRepository;
use App\Repositories\Backend\ReferenceNumberRepository;
use App\Repositories\Backend\ReminderRepository;
use App\Http\Requests\Backend\ReminderRequest;
use Intervention\Image\ImageManager;

class ReferenceNumberController extends Controller
{
    protected $reference_number_repository;
    protected $reminder_repository;

    public function __construct(ReminderRepository $reminder_repository, ReferenceNumberRepository $reference_number_repository, ClientRepository $client_repository)
    {
        $this->reminder_repository = $reminder_repository;
        $this->client_repository = $client_repository;
        $this->reference_number_repository = $reference_number_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reference_numbers = $this->reference_number_repository->paginate(10);
        return view('backend.reference-numbers.index', compact('reference_numbers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = $this->client_repository->where('is_active', 1)->get();
        return view('backend.reference-numbers.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReferenceNumberRequest $request)
    {
        $path = $request->file('invoice')->store('/invoices', 'public');
        $request->merge(['attachment_path' => $path]);
        $reference_numbers = $this->reference_number_repository->create($request->except('_token'));
        return redirect()->route('admin.reference-numbers.index')->withFlashSuccess('Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReferenceNumber  $referenceNumber
     * @return \Illuminate\Http\Response
     */
    public function show(ReferenceNumber $referenceNumber)
    {
        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $reference_number = $this->reference_number_repository->getById($referenceNumber->id);
        return view('backend.reference-numbers.show', compact('reference_number', 'storagePath'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReferenceNumber  $referenceNumber
     * @return \Illuminate\Http\Response
     */
    public function edit(ReferenceNumber $referenceNumber)
    {
        $clients = $this->client_repository->where('is_active', 1)->get();
        $reference_number = $this->reference_number_repository->getById($referenceNumber->id);
        return view('backend.reference-numbers.edit', compact('reference_number', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReferenceNumber  $referenceNumber
     * @return \Illuminate\Http\Response
     */
    public function update(ReferenceNumberRequest $request, ReferenceNumber $referenceNumber)
    {
        $reference_number = $this->reference_number_repository->updateById($referenceNumber->id, $request->except('_token'));
        $this->reminder_repository->updateById($referenceNumber->reminder->id, ['reference_number_id' => $request->reference_number_id]);
        return redirect()->route('admin.reference-numbers.index')->withFlashSuccess('Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReferenceNumber  $referenceNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReferenceNumber $referenceNumber)
    {
        try{
            $has_stored_in_reminder = $this->reminder_repository->where('reference_number_id', $referenceNumber->id)->get();
            if($has_stored_in_reminder->count() == 0){
                $path = public_path().'/storage/'.$referenceNumber->attachment_path;
                //unlink($path);
                $reference_number = $this->reference_number_repository->deleteById($referenceNumber->id);
                return redirect()->route('admin.reference-numbers.index')->withFlashSuccess('Deleted Successfully');
            }else{
                return redirect()->route('admin.reference-numbers.index')->withFlashDanger('Delete Prohibited as reference already in use');
            }
        }catch(\Exception $exception)
        {
            return $exception->getMessage();
        }
        
    }
}
