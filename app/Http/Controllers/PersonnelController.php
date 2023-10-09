<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;

class PersonnelController extends Controller
{
    public function index(Request $request) :View {


        $users = User::where(function ($query) use ($request) {
            $query->where('email', 'LIKE', '%' . $request->search . '%')
                ->orWhere('name', 'LIKE', '%' . $request->search . '%');
        })
        ->where('role_as', 0);
        $count = $request->search ? $users->count()  : User::count();

        $search = $request->search;

        return view('admin.personnel',['users'=>$users
            ->skip($request->skip)
            ->take(10)
            ->get(),
            'userCount'=> $count,'search'=>$search]);
    }


    public function destroy(User $personnel): View{

        $personnel->delete();

        $count = User::count();


        return view('admin.personnel',['users'=>User::where('role_as', 0)
            ->take(10)
            ->get(),
            'userCount'=> $count,'search'=>'','msg'=>'Successfully deleted']);
    }


    public function edit(Request $request): View{

    }

    public function update(User $personnel):View{

        $personnel->update(['is_actived' => !$personnel->is_actived]);

        $count = User::count();

        return view('admin.personnel',['users'=>User::where('role_as', 0)
            ->take(10)
            ->get(),
            'userCount'=> $count,'search'=>'','msg'=>"Successfully updated"]);
    }


    public function store(Request $request): View{

        $validator = [
            'name' => 'required|string',
            'email'=>'required|email',
            'password' => 'required|string',
            'gender' => 'required|string',
            'role_as' => 'required|boolean',
            'is_actived' => 'required|boolean'
        ];

        $request['role_as'] = FALSE;
        $request['is_actived'] = TRUE;

        $user = User::where('role_as', 0);
        $count = User::count();


        $validate_request = Validator::make($request->all(), $validator);
        
        if($validate_request->fails()) {
            $errors = $validate_request->errors();
            return view('admin.personnel',['users'=>$user
            ->take(10)
            ->get(),
            'userCount'=> $count,'search'=>'','msg'=>$errors]);
        }

        
        $data = User::create($validate_request->validated());


        return view('admin.personnel',['users'=>$user
            ->take(10)
            ->get(),
            'userCount'=> $count,'search'=>'','msg'=>'Successfully Added']);
    }


}
