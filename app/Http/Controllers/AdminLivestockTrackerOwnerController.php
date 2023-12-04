<?php

namespace App\Http\Controllers;

use App\Models\Livestock;
use App\Models\PersonalInformation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLivestockTrackerOwnerController extends Controller
{
    //
    public function index(Request $request): View {
        $livestock = Livestock::where(function($query) use ($request) {
            $query->where('Livestock_Name', 'LIKE', '%' . $request->search . '%');
        });

        return view('admin.farmer.livestock.ownertracker', ['farmers' => $livestock->latest()->paginate(25), 'Farmers' => PersonalInformation::get(), 'search' => $request->search]);
    }

    public function livestockChangeOwner(Request $request): RedirectResponse {
        /* The code `Livestock::where('personal_information_id',
        ->id)->update(['personal_information_id' => ->personal_information_id])` is
        updating the `personal_information_id` field of the `Livestock` model in the database. */
        if($request->Mode_Of_Changing == 'Mass') {
            $personalinformation = Livestock::find($request->id)->personalinformation;
            $personalinformation->livestock()->update([
                'personal_information_id' => $request->personal_information_id,
            ]);
        } else {
            Livestock::find($request->id)->update([
                'personal_information_id' => $request->personal_information_id,
            ]);
        }

        activity('Activity Logs')->causedBy(Auth::user())->createdAt(now())->log('- Livestock Owner Successfully Changed.');
        return redirect()->route('adminLivestockOwnerTracker.index')->with('success', 'Livestock Owner Successfully Changed');
    }
}
