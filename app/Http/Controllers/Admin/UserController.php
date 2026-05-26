<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    // Show all shopkeepers
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {

            return redirect()->route('dashboard');

        }

        $users = User::where('role','shopkeeper')
                        ->when($request->search, function ($query) use ($request) {

                            $query->where('name', 'like', '%' . $request->search . '%');

                        })

                        ->latest()

                        ->paginate(10);

        return view('admin.users', compact('users'));
    }


    // Approve shopkeeper
    public function approve($id)
    {
        $user = User::findOrFail($id);

        $user->status = 'active';

        $user->subscription_status = 'trial';

        $user->trial_ends_at = now()->addDays(15);

        $user->save();

        return redirect()->back()
            ->with('success', 'User approved with 15-day trial.');
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

// Add new user / Manage Customers 
    /*
|--------------------------------------------------------------------------
| CREATE CLIENT
|--------------------------------------------------------------------------
*/

public function store(Request $request)
    {
        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],

            'phone' => [
                'nullable',
                'string',
                'max:15',
                'min:10',
                'required',
                'regex:/^[0-9+]+$/'
            ],

            'country' => [
                'required',
                'in:UG,KE,PH'
            ],

            'password' => [
                'required',
                'min:6'
            ],
            'role' => 'required|in:admin,shopkeeper',

        ]);

        User::create([

            'name' => $request->name,

            'email' => $request->email,

            'phone' => $request->phone,

            'country' => $request->country,

            'role' => $request->role,

            'status' => 'active',
            'subscription_status' =>
                $request->role === 'admin'
                    ? 'active'
                    : 'trial',

            'trial_ends_at' =>
                $request->role === 'shopkeeper'
                    ? now()->addDays(15)
                    : null,

            // 'subscription_status' => 'trial',

            // 'trial_ends_at' => now()->addDays(15),

            'password' => Hash::make($request->password),

        ]);

        return back()->with(
            'success',
            'User has been created successfully.'
        );
    }
// Manage staff admin that will be assigned
    public function staff(Request $request)
    {
        $users = User::where('role', 'admin')
            ->latest()
            ->paginate(10);

        return view('admin.staff', compact('users'));
    }

}