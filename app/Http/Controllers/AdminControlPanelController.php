<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminControlPanelController extends Controller
{
    //
    public function index(string $currentRoute): View {
        if($currentRoute == 'All') {
            return view('admin.adminpanel.index', ['options' => Option::get(), 'currentRoute' => 'All']);
        } elseif($currentRoute == 'Religion') {
            return view('admin.adminpanel.index', ['options' => Option::where('Option_Name', 'Religion')->get(), 'currentRoute' => 'Religion']);
        } else {
            return view('admin.adminpanel.index', ['options' => Option::where('Option_Name', 'Livelihood')->get(), 'currentRoute' => 'Livelihood']);
        }
    }

    public function store(Request $request): RedirectResponse {
        $validation_rules = [
            'Option_Name' => 'required|string|max:24',
            'Name' => 'required|string|max:64|unique:options,Name',
        ];

        $validated_data = $request->validate($validation_rules);

        $capitalizedName = ucwords($validated_data['Name']);
        $capitalizedOptionName = ucwords($validated_data['Option_Name']);

        Option::create([
            'Option_Name' => $capitalizedOptionName,
            'Name' => $capitalizedName,
        ]);

        return redirect()->route('adminControlPanel.index', ['currentRoute' => 'All'])->with('success', 'Option Successfully Added');
    }

    public function destroy(Option $option): RedirectResponse {
        $option->delete();
        return redirect()->route('adminControlPanel.index', ['currentRoute' => 'All'])->with('success', 'Option Successfully Deleted');
    }
}
