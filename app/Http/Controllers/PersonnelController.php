<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class PersonnelController extends Controller
{


    public function index(Request $request): View {
        $users = User::where(function ($query) use ($request) {
            $query->where('employee_id', 'LIKE', '%' . $request->search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $request->search . '%');
        })->get()->filter(function($user) {
            return $user->userdetails->user_role == 'User';
        });

        $count = $request->search ? $users->count()  : User::count();
        $search = $request->search;

        return view('admin.personnel', ['users' => $users->skip($request->skip)->take(10), 'userCount' => $count, 'search' => $search]);
    }


    public function destroy(User $personnel): RedirectResponse {
        $personnel->delete();
        return redirect()->route('personnel.index')->with('success', 'Successfully Deleted');
    }


    public function edit(Request $request): RedirectResponse {
        $validator = [
            'last_name' => 'required|string|max:50',
            'first_name'=>'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'gender' => 'required|string|max:24',
            'password' => 'required|string',
            /* 'employee_id' => Rule::unique('users')->ignore($request->id), */
        ];

        $validate_request = Validator::make($request->all(), $validator);

        if($validate_request->fails()) {
            return back()->withErrors($validate_request)->withInput();
        }
        
        $findUser = User::find($request->id);
        
        $findUser->update([
            /* 'employee_id' => $validate_request->validated()['employee_id'], */
            'last_name' => $validate_request->validated()['last_name'],
            'first_name' => $validate_request->validated()['first_name'],
            'middle_name' => $validate_request->validated()['middle_name'],
            'password' => $validate_request->validated()['password'],
        ]);

        $findUser->userdetails()->update([
            'gender' => $validate_request->validated()['gender'],
        ]);
    
        return redirect()->route('personnel.index')->with('success', 'Successfully Updated');
    }

    public function update(User $personnel): RedirectResponse {
        $personnel->userdetails()->update(['is_actived' => !$personnel->userdetails->is_actived]);
        return redirect()->route('personnel.index')->with('success', 'Successfully Updated');
    }


    public function store(Request $request): RedirectResponse {
        $validator = [
            'last_name' => 'required|string|max:50',
            'first_name'=>'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'gender' => 'required|string|max:24',
            'user_role' => 'required|string|max:24',
            'is_actived' => 'required|boolean',
            'password' => 'required|string',
            /* 'employee_id' => 'required|string|unique:users,employee_id', */
        ];

        $request['user_role'] = 'User';
        $request['is_actived'] = TRUE;

        $validate_request = Validator::make($request->all(), $validator);
    
        if($validate_request->fails()) {
            return back()->withErrors($validate_request)->withInput();
        }

        $createdUser = User::create([
            /* 'employee_id' => $validate_request->validated()['employee_id'], */
            'last_name' => $validate_request->validated()['last_name'],
            'first_name' => $validate_request->validated()['first_name'],
            'middle_name' => $validate_request->validated()['middle_name'],
            'password' => $validate_request->validated()['password'],
        ]);

        UserDetails::create([
            'user_id' => $createdUser->id,
            'user_role' => $validate_request->validated()['user_role'],
            'gender' => $validate_request->validated()['gender'],
        ]);

        return redirect()->route('personnel.index')->with('success', 'Successfully Added');
    }
}
