<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\MessageFormatRequest;
use App\Repositories\Backend\MessageFormatRepository;

class MessageFormatController extends Controller
{
    protected $message_format_repository;

    public function __construct(MessageFormatRepository $message_format_repository)
    {
        $this->message_format_repository = $message_format_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $message_formats = $this->message_format_repository->paginate(10);
        return view('backend.formats.index', compact('message_formats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.formats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageFormatRequest $request)
    {
        $this->message_format_repository->create($request->except('_token'));
        return redirect()->route('admin.message-formats.index')->withFlashSuccess('Message Format created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message_format = $this->message_format_repository->getById($id);
        return view('backend.formats.show', compact('message_format'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $message_format = $this->message_format_repository->getById($id);
        return view('backend.formats.edit', compact('message_format'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MessageFormatRequest $request, $id)
    {
        $this->message_format_repository->updateById($id, $request->except('_token'));
        return redirect()->route('admin.message-formats.index')->withFlashSuccess('Message Format updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->message_format_repository->deleteById($id);
        return redirect()->route('admin.message-formats.index')->withFlashSuccess('Message Format deleted successfully!');
    }
}
