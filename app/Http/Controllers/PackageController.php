<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::query()
            ->when(auth()->user()->role === 'shopkeeper', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->paginate(10);

        return view('packages.index', compact('packages'));
    }
     /**
     * Show create package form.
     */

    public function create()
    {
        return view('packages.create');
    }


    // Save new package.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'price'            => 'required|numeric|min:0',
            'duration'         => 'required|integer|min:1',
            'duration_unit'    => 'required|in:hour,day,week,month',
            'bandwidth'        => 'nullable|string|max:255',
            'mikrotik_profile' => 'required|string|max:255',
        ]);

        Package::create([
            'user_id'          => auth()->id(),
            'name'             => $validated['name'],
            'price'            => $validated['price'],
            'duration'         => $validated['duration'],
            'duration_unit'    => $validated['duration_unit'],
            'bandwidth'        => $validated['bandwidth'] ?? null,
            'mikrotik_profile' => $validated['mikrotik_profile'],
            'active'           => $request->has('active') ? 1 : 0,
        ]);

        return redirect()->route('packages.index')
            ->with('success', 'Package created successfully.');
    }

    // Edit the form
    public function edit($id)
    {
        $package = $this->findAllowedPackage($id);

        return view('packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = $this->findAllowedPackage($id);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'price'            => 'required|numeric|min:0',
            'duration'         => 'required|integer|min:1',
            'duration_unit'    => 'required|in:hour,day,week,month',
            'bandwidth'        => 'nullable|string|max:255',
            'mikrotik_profile' => 'required|string|max:255',
        ]);

        $package->update([
            'name'             => $validated['name'],
            'price'            => $validated['price'],
            'duration'         => $validated['duration'],
            'duration_unit'    => $validated['duration_unit'],
            'bandwidth'        => $validated['bandwidth'] ?? null,
            'mikrotik_profile' => $validated['mikrotik_profile'],
            'active'           => $request->has('active') ? 1 : 0,
        ]);

        return redirect()
            ->route('packages.index')
            ->with('success', 'Package updated successfully.');
    }

    /**
     * Delete package.
     */
    public function destroy($id)
    {
        $package = $this->findAllowedPackage($id);

        $package->delete();

        return redirect()
            ->route('packages.index')
            ->with('success', 'Package deleted successfully.');
    }

     /**
     * Prevent shopkeepers from editing/deleting other users' packages.
     */
    private function findAllowedPackage($id)
    {
        $package = Package::findOrFail($id);

        if (auth()->user()->role === 'shopkeeper' && $package->user_id !== auth()->id()) {
            abort(403, 'You are not allowed to access this package.');
        }

        return $package;
    }
}