<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;

class Personnel extends Controller
{
    public function getAllPersonnel(Request $request) :View {


        $users = User::where('email', 'LIKE', '%' . $request->search . '%')
        ->orWhere('name', 'LIKE', '%' . $request->search . '%');

        $count = $request->search ? $users->count()  : User::count();

        $search = $request->search;

        return view('admin.personnel',['users'=>$users
        ->skip($request->skip)
        ->take(10)
        ->get(),
        'userCount'=> $count,'search'=>$search]);
    }
}
