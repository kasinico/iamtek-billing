<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{

    // Show all shopkeepers
    public function index()
    {
        $users = User::where('role','shopkeeper')->get();

        return view('admin.users', compact('users'));
    }


    // Approve shopkeeper
    public function approve($id)
    {
        $user = User::findOrFail($id);

        $user->status = 'active';
        $user->save();

        return redirect()->back()->with('success','User approved successfully');
    }


    // Disable shopkeeper
    public function disable($id)
    {
        $user = User::findOrFail($id);

        $user->status = 'disabled';
        $user->save();

        return redirect()->back()->with('success','User disabled');
    }


        // enable shopkeeper
    public function enable($id)
    {
        $user = User::findOrFail($id);

        $user->status = 'active';
        $user->save();

        return redirect()->back()->with('success','User enabled');
    }

}