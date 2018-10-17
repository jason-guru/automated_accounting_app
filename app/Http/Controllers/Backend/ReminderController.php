<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\ReminderRepository;
use App\Http\Requests\Backend\ReminderRequest;
use Carbon\Carbon;

class ReminderController extends Controller
{
    protected $reminder_repository;

    public function __construct(ReminderRepository $reminder_repository)
    {
        $this->reminder_repository = $reminder_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reminders = $this->reminder_repository->paginate(10);
        return view('backend.reminders.index', compact('reminders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
