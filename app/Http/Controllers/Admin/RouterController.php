<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MikrotikDevice;
use Illuminate\Http\Request;

class RouterController extends Controller
{
    public function index()
    {
        $query = MikrotikDevice::latest();

        if (auth()->user()->role === 'shopkeeper') {
            $query->where('user_id', auth()->id());
        }

        return view('routers.index', [
            'routers' => $query->get()
        ]);
    }

    public function create()
    {
        return view('routers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'port' => 'required|integer',
        ]);

        MikrotikDevice::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'ip_address' => $request->ip_address,
            'username' => $request->username,
            'password' => $request->password,
            'port' => $request->port,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()
            ->route('routers.index')
            ->with('success', 'Router added successfully.');
    }

    public function edit($id)
    {
        $router = MikrotikDevice::findOrFail($id);

        if (auth()->user()->role === 'shopkeeper' && $router->user_id !== auth()->id()) {
            abort(403);
        }

        return view('routers.edit', compact('router'));
    }

    public function update(Request $request, $id)
    {
        $router = MikrotikDevice::findOrFail($id);

        if (auth()->user()->role === 'shopkeeper' && $router->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
            'port' => 'required|integer',
        ]);

        $data = [
            'name' => $request->name,
            'ip_address' => $request->ip_address,
            'username' => $request->username,
            'port' => $request->port,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $router->update($data);

        return redirect()
            ->route('routers.index')
            ->with('success', 'Router updated successfully.');
    }

    public function destroy($id)
    {
        $router = MikrotikDevice::findOrFail($id);

        if (auth()->user()->role === 'shopkeeper' && $router->user_id !== auth()->id()) {
            abort(403);
        }

        $router->delete();

        return redirect()
            ->route('routers.index')
            ->with('success', 'Router deleted successfully.');
    }
}