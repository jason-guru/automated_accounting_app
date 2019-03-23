<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\ClientDeadline;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\ClientRepository;
use App\Http\Requests\Backend\ClientDeadlineRequest;
use App\Repositories\Backend\FilingFrequencyRepository;

class ClientDeadlineController extends Controller
{
    protected $clientRepository;
    protected $filingFrequencyRepository;
    public function __construct(ClientRepository $clientRepository, FilingFrequencyRepository $filingFrequencyRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->filingFrequencyRepository = $filingFrequencyRepository;
    }
    public function index()
    {
        $clients = $this->clientRepository->with(['deadlines', 'company_type'])->all();
        return view('backend.client-deadline.index', compact('clients'));
    }

    public function fetchClients()
    {
        $clients = $this->clientRepository->with(['deadlines', 'company_type'])->all();
        return response()->json([
            'clients' => $clients
        ]);
    }

    public function store(ClientDeadlineRequest $request)
    {
        $this->clientRepository->getById($request->client_id)->deadlines()->updateExistingPivot($request->deadline_id, [
            'from' => $request->from,
            'to' => $request->to,
            'due_on' => $request->due_on
        ]);

        $clientDeadline =  $this->clientRepository->getById($request->client_id)->deadlines()->where('deadline_id', $request->deadline_id)->first();
        if(isset($request->frequency)){
            $this->filingFrequencyRepository->create([
                'client_deadline_id' => $clientDeadline->id,
                'frequency' => $request->frequency
            ]);
        }
        return response()->json([
            'message' => 'Client Deadline saved successfully'
        ],200);
    }
}
