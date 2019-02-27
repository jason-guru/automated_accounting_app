<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\ClientDeadline;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\ClientRepository;
use App\Http\Requests\Backend\ClientDeadlineRequest;

class ClientDeadlineController extends Controller
{
    protected $clientRepository;
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
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

        return response()->json([
            'message' => 'Client Deadline saved successfully'
        ],200);
    }
}
