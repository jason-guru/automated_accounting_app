<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\ReminderRepository;
use App\Repositories\Backend\ClientRepository;
use App\Repositories\Backend\DeadlineRepository;
use App\Http\Requests\Backend\ReminderRequest;
use App\Repositories\Backend\ReminderDateRepository;
use Carbon\Carbon;

class ReminderController extends Controller
{
    protected $reminder_repository;
    protected $client_repository;
    protected $deadline_repository;
    protected $reminder_date_repository;

    public function __construct(ReminderRepository $reminder_repository, ClientRepository $client_repository, DeadlineRepository $deadline_repository, ReminderDateRepository $reminder_date_repository)
    {
        $this->reminder_repository = $reminder_repository;
        $this->client_repository = $client_repository;
        $this->deadline_repository = $deadline_repository;
        $this->reminder_date_repository = $reminder_date_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reminder_data = $this->reminder_repository->get_reminders();
        return view('backend.reminders.index', compact('reminder_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //collection of all clients
        $clients = $this->client_repository->where('is_active', 1)->get();
        
        $deadlines = $this->deadline_repository->where('is_active', 1)->get();
        
        return view('backend.reminders.create', compact('clients', 'deadlines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $remind_dates = $request->remind_date;
        foreach($remind_dates as $remind_date){
            $get_remind_date = $this->reminder_date_repository->create(['remind_date' => $remind_date]);
            $request->request->add(['reminder_date_id' => $get_remind_date->id]);
            $this->reminder_repository->create($request->except('_token', 'remind_date'));
        }
        // $request->merge(['remind_date' => Carbon::parse($request->remind_date)->format('Y-m-d')]);
        // $reminder_date = $this->reminder_date_repository->create($request->only('remind_date'));
        // $request->request->add(['reminder_date_id' => $reminder_date->id]);
        // $this->reminder_repository->create($request->except('_token', 'reminder_date'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $get_reminder = $this->reminder_repository->getById($id);
        $reminder = [
            'id' => $get_reminder->id,
            'first_remind' => !is_null($get_reminder->first_remind) ? Carbon::parse($get_reminder->first_remind)->format('d-m-Y') :"",
            'second_remind' => !is_null($get_reminder->second_remind) ? Carbon::parse($get_reminder->second_remind)->format('d-m-Y') :"",
            'third_remind' => !is_null($get_reminder->third_remind) ? Carbon::parse($get_reminder->third_remind)->format('d-m-Y') :"",
        ];

        return view('backend.reminders.edit', compact('reminder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReminderRequest $request, $id)
    {
        $request->merge(['first_remind' => !is_null($request->first_remind) ? Carbon::parse($request->first_remind)->format('Y-m-d') : null ]);
        $request->merge(['second_remind' => !is_null($request->second_remind) ? Carbon::parse($request->second_remind)->format('Y-m-d') : null ]);
        $request->merge(['third_remind' => !is_null($request->third_remind) ? Carbon::parse($request->third_remind)->format('Y-m-d') : null ]);
        
        $this->reminder_repository->updateById($id, $request->except("_token"));
        return redirect()->route('admin.reminders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
