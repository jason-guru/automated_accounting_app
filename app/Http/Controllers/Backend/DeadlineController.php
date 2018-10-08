<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeadlineController extends Controller
{
    public function information()
    {
        return view('backend.deadlines.information');
    }

    public function reminders()
    {
        return view('backend.deadlines.reminders');
    }
}
