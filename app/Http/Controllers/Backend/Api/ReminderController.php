<?php

namespace App\Http\Controllers\Backend\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\ReminderRepository;

class ReminderController extends Controller
{
    protected $reminderRepository;
    public function __construct(ReminderRepository $reminderRepository)
    {
        $this->reminderRepository = $reminderRepository;
    }

    public function store(Request $request)
    {
        $reminderArray = [];
        foreach($request->all() as $reminderData)
        {
            $this->reminderRepository->create(json_decode($reminderData, true));
        }
        return 'success';
    }
}
