<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResellerController extends Controller
{

    public function create()
    {
        return view('reseller.register');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),

            // IMPORTANT
            'role'=>'shopkeeper',
            'status'=>'pending'
        ]);

        return redirect('/login')->with('message','Account created. Await admin approval.');

    }
}