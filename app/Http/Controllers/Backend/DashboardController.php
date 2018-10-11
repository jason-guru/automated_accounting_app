<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\ClientRepository;
use App\Repositories\Backend\ReminderRepository;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    protected $client_repository;
    protected $reminder_repository;

    public function __construct(ClientRepository $client_repository, ReminderRepository $reminder_repository)
    {
        $this->reminder_repository = $reminder_repository;
        $this->client_repository = $client_repository;
    }
    
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $clients = $this->client_repository->all();
        $reminders = $this->reminder_repository->where('is_active', 1)->get();
        return view('backend.dashboard', compact('clients', 'reminders'));
    }
}
