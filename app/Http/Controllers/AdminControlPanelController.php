<?php

namespace App\Http\Controllers;

use App\Models\Religion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminControlPanelController extends Controller
{
    //
    public function index(): View {
        return view('admin.adminpanel.index', ['religions' => Religion::get()]);
    }

    public function store(Request $request): RedirectResponse {
        $validation_rules = [
            'religion' => 'required|string|max:64|unique:religions,religion',
        ];
        $validated_data = $request->validate($validation_rules);

        $capitalizedString = ucwords($validated_data['religion']);

        Religion::create([
            'religion' => $capitalizedString,
        ]);

        return redirect()->route('adminControlPanel.index')->with('success', 'Religion Successfully Added');
    }

    public function destroy(Religion $religion): RedirectResponse {
        $religion->delete();
        return redirect()->route('adminControlPanel.index')->with('success', 'Religion Successfully Deleted');
    }
}
