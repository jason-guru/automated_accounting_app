<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\FrequencyRepository;
use App\Repositories\Backend\ReminderRepository;

class DeadlineController extends Controller
{
    protected $frequency_repository;
    protected $reminder_repository;

    public function __construct(FrequencyRepository $frequency_repository, ReminderRepository $reminder_repository)
    {
        $this->frequency_repository = $frequency_repository;
        $this->reminder_repository = $reminder_repository;
    }
    public function information()
    {
        return view('backend.deadlines.information');
    }

    public function reminders()
    {
        $reminders = $this->reminder_repository->paginate(10);
        return view('backend.deadlines.reminders', compact('reminders'));
    }

    public function frequency()
    {
        $frequencies = $this->frequency_repository->all();
        return view('backend.deadlines.frequency', compact('frequencies'));
    }

    public function frequency_store(Request $request)
    {
        $frequency_id = $request->frequency_id;
        $frequencies = $this->frequency_repository->all();
        foreach($frequencies as $frequency):
            $this->frequency_repository->updateById($frequency->id, ['is_active' => 0]);
        endforeach;
        $this->frequency_repository->updateById($frequency_id, ['is_active' => 1]);
        return back()->withFlashSuccess('Frequency updated successfully');
    }
}
