<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;

class ActivityLogsController extends Controller
{
    //
    public function index(): View {
        return view('admin.logs.index', ['logs' => Activity::latest()->get()]);
    }

    public function filterLogs(Request $request): View {
        $validation_rules = [
            'Start_Date' => 'required|date',
            'End_Date' => 'required|date',
        ];
        
        $validated_data = Validator::make($request->all(), $validation_rules);

        if ($validated_data->fails()) {
            return view('admin.logs.index', ['logs' => Activity::latest()->get()]);
        }

        if($validated_data->validated()['Start_Date'] >= $validated_data->validated()['End_Date']) {
            return view('admin.logs.index', ['logs' => Activity::latest()->get()])->with('errorMessage', 'Invalid Date Range');
        } 

        $filteredLogs = Activity::whereBetween('created_at', [$validated_data->validated()['Start_Date'], $validated_data->validated()['End_Date']])->latest()->get();
            return view('admin.logs.index', ['logs' => $filteredLogs]);
    }
}
