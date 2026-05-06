<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\MikrotikPushService;
use App\Models\MikrotikDevice;



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
//SAVE PACKAGE INTO VARIABLE
        $package = Package::create([
            'user_id'          => auth()->id(),
            'name'             => $validated['name'],
            'price'            => $validated['price'],
            'duration'         => $validated['duration'],
            'duration_unit'    => $validated['duration_unit'],
            'bandwidth'        => $validated['bandwidth'] ?? null,
            'mikrotik_profile' => $validated['mikrotik_profile'],
            'active'           => $request->has('active') ? 1 : 0,
        ]);


        // sending packages to router------------------------------
        $routers = MikrotikDevice::where('is_active', 1)->get();
        logger('Routers found: ' . $routers->count());


        $mikrotik = new MikrotikPushService();

        foreach ($routers as $router) {

            try {

                logger("Creating profile on router: " . $router->ip_address);

                $mikrotik->createProfileFromPackage($router, $package);

            } catch (\Throwable $e) {

                logger("Profile create failed: " . $e->getMessage());
            }
        }

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

        //update to router ------------------------------------------------
        $routers = MikrotikDevice::where('is_active', 1)
            ->whereNotNull('ip_address')
            ->get();

        $mikrotik = new MikrotikPushService();

        foreach ($routers as $router) {
            try {
                $mikrotik->updateProfileOnRouter($router, $package);
            } catch (\Throwable $e) {
                logger("Update failed: " . $e->getMessage());
            }
        }

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

        // 🔥 Store profile BEFORE delete
        $profileName = $package->mikrotik_profile;

        // 🔥 Get active routers
        // $routers = MikrotikDevice::where('is_active', 1)->get();
        $routers = MikrotikDevice::where('is_active', 1)
            ->whereNotNull('ip_address')
            ->get();

        foreach ($routers as $router) {

            try {

                $client = new \RouterOS\Client([
                    'host' => $router->ip_address,
                    'user' => $router->username,
                    'pass' => $router->password,
                    'port' => $router->port ?? 8728,
                ]);

                $print = new \RouterOS\Query('/ip/hotspot/user/profile/print');
                $print->where('name', $profileName);

                $result = $client->query($print)->read();

                if (!empty($result)) {

                    $id = $result[0]['.id'];

                    $remove = new \RouterOS\Query('/ip/hotspot/user/profile/remove');
                    $remove->equal('.id', $id);

                    $client->query($remove)->read();

                    logger("Deleted profile {$profileName} on {$router->ip_address}");
                }

            } catch (\Throwable $e) {

                logger("Delete failed on {$router->ip_address}: " . $e->getMessage());
            }
        }

        // 🔥 Delete AFTER router cleanup
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