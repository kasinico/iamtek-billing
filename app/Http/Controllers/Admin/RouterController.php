<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MikrotikDevice;
use Illuminate\Http\Request;
use RouterOS\Client;
use RouterOS\Query;

class RouterController extends Controller
{
    public function index()
    {
        $routers = MikrotikDevice::query()
            ->when(auth()->user()->role === 'shopkeeper', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->get();

        return view('routers.index', compact('routers'));
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

        return redirect()->route('routers.index')->with('success', 'Router added successfully.');
    }

    public function edit($id)
    {
        $router = $this->findAllowedRouter($id);

        return view('routers.edit', compact('router'));
    }

    public function update(Request $request, $id)
    {
        $router = $this->findAllowedRouter($id);

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

        return redirect()->route('routers.index')->with('success', 'Router updated successfully.');
    }

    public function destroy($id)
    {
        $router = $this->findAllowedRouter($id);

        $router->delete();

        return redirect()->route('routers.index')->with('success', 'Router deleted successfully.');
    }

    public function test($id)
    {
        $router = $this->findAllowedRouter($id);

        try {
            $client = new Client([
                'host' => $router->ip_address,
                'user' => $router->username,
                'pass' => $router->password,
                'port' => $router->port ?? 8728,
                'timeout' => 10,
            ]);

            $query = new Query('/system/identity/print');
            $response = $client->query($query)->read();

            $routerName = $response[0]['name'] ?? 'Unknown Router';

            return redirect()
                ->route('routers.index')
                ->with('success', "Router connected successfully: {$routerName}");

        } catch (\Throwable $e) {
            return redirect()
                ->route('routers.index')
                ->with('error', 'Router connection failed: ' . $e->getMessage());
        }
    }

    private function findAllowedRouter($id)
    {
        $router = MikrotikDevice::findOrFail($id);

        if (auth()->user()->role === 'shopkeeper' && $router->user_id !== auth()->id()) {
            abort(403, 'You are not allowed to access this router.');
        }

        return $router;
    }
}