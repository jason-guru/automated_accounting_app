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
        try {
            $clients = $this->clientRepository->with(['deadlines', 'company_type'])->all();
            return response()->json([
                'clients' => $clients
            ]);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
        
    }

    public function store(ClientDeadlineRequest $request)
    {
        try {
            $this->clientRepository->getById($request->client_id)->deadlines()->updateExistingPivot($request->deadline_id, [
                'from' => $request->from,
                'to' => $request->to,
                'due_on' => $request->due_on
            ]);
            if(isset($request->frequency)){
                $this->clientRepository->getById($request->client_id)->deadlines()->updateExistingPivot($request->deadline_id, [
                    'frequency' => $request->frequency
                ]);
            }
            return response()->json([
                'message' => 'Client Deadline saved successfully'
            ],200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
        
    }
}
