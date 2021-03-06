<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\ReminderRepository;
use App\Repositories\Backend\ClientRepository;
use App\Repositories\Backend\DeadlineRepository;
use App\Http\Requests\Backend\ReminderRequest;
use App\Http\Requests\Backend\CreateFromEditRequest;
use App\Repositories\Backend\ReminderDateRepository;
use App\Models\Recurring;
use Carbon\Carbon;


class ReminderController extends Controller
{
    protected $reminder_repository;
    protected $client_repository;
    protected $deadline_repository;
    protected $reminder_date_repository;
    protected $recurrings;

    public function __construct(ReminderRepository $reminder_repository, ClientRepository $client_repository, DeadlineRepository $deadline_repository, ReminderDateRepository $reminder_date_repository)
    {
        $this->reminder_repository = $reminder_repository;
        $this->client_repository = $client_repository;
        $this->deadline_repository = $deadline_repository;
        $this->reminder_date_repository = $reminder_date_repository;
        $this->recurrings = Recurring::where('is_active', 1)->get();

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
        $clients = $this->client_repository->where('is_active', 1)->with('reference_numbers')->get();
        
        $deadlines = $this->deadline_repository->where('is_active', 1)->get();
        $recurrings = $this->recurrings;
        return view('backend.reminders.create', compact('clients', 'deadlines', 'recurrings'));
    }

    public function create_from_edit(CreateFromEditRequest $request)
    {
        if(!array_key_exists('send_sms', $request->all())){
            $send_sms = false;
        }else{
            $send_sms = true;
        }
        if(!array_key_exists('send_email',$request->all())){
            $send_email = false;
        }else{
            $send_email = true;
        }
        $request->merge(['send_sms' => $send_sms]);
        $request->merge(['send_email' => $send_email]);
        $this->reminder_repository->create($request->except('_token'));
        return back()->withFlashSuccess('Reminder Added Successfully');
    }

    /**
     * ***** Code explanation *****
     * get the total reminder data, the reminder data consist of
     * Example $reminders_data,
     * $reminders_data = [
     *      0 => [
     *          'deadline_id' => 1,
     *          0 => 2018-10-19,
     *          1 => 2018-10-20
     *      ],
     *      1 => [
     *          'deadline_id' => 2,
     *          0 => 2018-10-21,
     *          1 => 2018-10-22
     *      ],
     * ];
     * 
     * 
     * So, by looping $reminders_data, we get the single deadline reminders. Then we remove the deadline_id via array_shift and loop through the dates and store the information in the reminders table.
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReminderRequest $request)
    {
        if(config('settings.enable_demo')){
            return back()->withFlashDanger('Not allowed in Demo mode');
        }
        try{
            $reminders_data = $request->reminders_data;
            $client_id = $request->client_id;
            foreach($reminders_data as $reminder_data){
                $deadline_id = $reminder_data['deadline_id'];
                array_shift($reminder_data);
                foreach($reminder_data as $key => $data){
                    if(!array_key_exists('send_sms', $data)){
                        $send_sms = false;
                    }else{
                        $send_sms = true;
                    }
                    if(!array_key_exists('send_email',$data)){
                        $send_email = false;
                    }else{
                        $send_email = true;
                    }
                    $prep_reminder_data = [
                        'client_id' => $client_id,
                        'deadline_id' =>$deadline_id,
                        'remind_date' => $data['date'],
                        'schedule_time' => $data['time'],
                        'recurring_id' => $data['recurring_id'],
                        'send_sms' => $send_sms,
                        'send_email' => $send_email,
                        'reference_number_id' => !is_null($request->reference_number_id) ? $request->reference_number_id : null
                    ];
                    $this->reminder_repository->create($prep_reminder_data);
                }
            }
            return redirect()->route('admin.reminders.index')->withFlashSuccess('Reminder Created Successfully!');
        }catch(\Exception $exception)
        {
            return $exception->getMessage();
        }
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
        return view('backend.reminders.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clients = $this->client_repository->where('is_active', 1)->get();
        $deadlines = $this->deadline_repository->where('is_active', 1)->get();
        $client = $this->client_repository->getById($id);
        $recurrings = $this->recurrings;
        return view('backend.reminders.edit', compact('client', 'clients', 'deadlines' ,'recurrings'));
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
        if(config('settings.enable_demo')){
            return back()->withFlashDanger('Not allowed in Demo mode');
        }
        $reminders = $this->reminder_repository->where('client_id', $id)->get();
        foreach($reminders as $key => $reminder){
            //check if updated
            if($reminder->has_reminded){
            $is_updated = $this->is_updated($reminder, $request, $key);
            if($is_updated){
                $this->reminder_repository->updateById($reminder->id, ['has_reminded' => false]);
            }
            }
            $date = Carbon::parse($request->reminder_dates[$key])->format('Y-m-d');
            $time = $request->reminder_time[$key];
            $recurrence_id = $request->recurring_id[$key];
            $reference_number_id = $request->reference_number_id[$key];
            $this->reminder_repository->updateById($reminder->id, ['remind_date' => $date, 'schedule_time' => $time, 'recurring_id' => $recurrence_id, 'reference_number_id' => $reference_number_id ]);
            
        }
        return back()->withFlashSuccess('Reminders updated successfully');
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
        $this->reminder_repository->where('client_id', $id)->delete();
        return back()->withFlashSuccess('Reminders Deleted Successfully');
    }

    /**
     * Remove a set reminder from reminder page
     * 
     */
    public function destroy_from_edit($id){
        if(config('settings.enable_demo')){
            return back()->withFlashDanger('Not allowed in Demo mode');
        }
        $this->reminder_repository->deleteById($id);
        return back()->withFlashSuccess('Reminder Deleted Successfully');
    }

    /**
     * Switch input update
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function switch_update(Request $request, $id){
        if($request->message_type == 'sms'){
            $this->reminder_repository->updateById($id,['send_sms' => $request->switch_value]);
            return response()->json([
                'success' => true,
                'message' => 'Send SMS state changed'
            ]);
        }elseif($request->message_type == 'email'){
            $this->reminder_repository->updateById($id,['send_email' => $request->switch_value]);
            return response()->json([
                'success' => true,
                'message' => 'Send Email state changed'
            ]);
        }
        
    }

    private function is_updated($reminder, $request, $key)
    {
        $existing_reminder = $this->reminder_repository->getById($reminder->id);
        $existing_date = $existing_reminder->remind_date;
        $existing_time = $existing_reminder->schedule_time;

        if(Carbon::parse($request->reminder_dates[$key])->format('Y-m-d') != $existing_date || $request->reminder_time[$key] != $existing_time){
            return true;
        }else{
            return false;
        }
    }
}
