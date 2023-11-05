<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogsController extends Controller
{
    //
    public function index(): View {
        return view('admin.logs.index', ['logs' => Activity::latest()->get()]);
    }
}
