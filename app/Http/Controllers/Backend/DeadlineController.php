<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests\Backend\DeadlineRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\DeadlineRepository;
use App\Repositories\Backend\MessageFormatRepository;

class DeadlineController extends Controller
{
    protected $deadline_repository;
    protected $message_format_repository;

    public function __construct(DeadlineRepository $deadline_repository, MessageFormatRepository $message_format_repository)
    {
        $this->deadline_repository = $deadline_repository;
        $this->message_format_repository = $message_format_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deadlines = $this->deadline_repository->where('is_active', 1)->get();
        return view('backend.deadlines.index', compact('deadlines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $message_formats = $this->message_format_repository->where('is_active', 1)->get();
        return view('backend.deadlines.create', compact('message_formats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeadlineRequest $request)
    {
        if(config('settings.enable_demo')){
            return back()->withFlashDanger('Not allowed in Demo mode');
        }
        $this->deadline_repository->create($request->except('_token'));
        return redirect()->route('admin.deadlines.index')->withFlashSuccess('Deadline Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deadline = $this->deadline_repository->where('is_active', 1)->getById($id);
        return view('backend.deadlines.show', compact('deadline'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $message_formats = $this->message_format_repository->where('is_active', 1)->get();
        $deadline = $this->deadline_repository->where('is_active', 1)->getById($id);
        return view('backend.deadlines.edit', compact('deadline', 'message_formats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeadlineRequest $request, $id)
    {
        try {
            if(config('settings.enable_demo')){
                return back()->withFlashDanger('Not allowed in Demo mode');
            }
            $this->deadline_repository->updateById($id, $request->except('_token'));
            
            return redirect()->route('admin.deadlines.index')->withFlashSuccess('Deadline Edited Successfully.');
        } catch (\Exception $ex) {
            return $ex->getMessage();
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
        if(config('settings.enable_demo')){
            return back()->withFlashDanger('Not allowed in Demo mode');
        }
        $this->deadline_repository->deleteById($id);
        return redirect()->route('admin.deadlines.index')->withFlashSuccess('Deadline Deleted Successfully.');
    }
}
