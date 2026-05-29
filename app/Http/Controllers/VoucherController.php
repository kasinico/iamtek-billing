<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\Package;
use App\Models\MikrotikDevice;
use App\Services\VoucherService;
use App\Services\MikrotikPushService;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf; //print pdf vouchers
use App\Models\VoucherBatch;
use Illuminate\Support\Str;
use App\Models\VoucherSession;



class VoucherController extends Controller
{
    
    protected $voucherService;
    protected $mikrotikPush;

    public function __construct(
        VoucherService $voucherService,
        MikrotikPushService $mikrotikPush
    ) {
        $this->voucherService = $voucherService;
        $this->mikrotikPush = $mikrotikPush;
        
    }

    /**
     * Dashboard page
     */
    public function index()
    {
    $routerQuery = MikrotikDevice::where('is_active', 1);
    $packageQuery = Package::where('active', 1);
    $voucherQuery = Voucher::with(['package', 'router'])->latest(); //query contains ALL vouchers. before permission

    

    /**
     * Shopkeepers must only see their own routers, packages, and vouchers.
     * Admin can see everything.
     */
    if (auth()->user()->role === 'shopkeeper') {
        $routerQuery->where('user_id', auth()->id());
        $packageQuery->where('user_id', auth()->id());
        $voucherQuery->where('user_id', auth()->id());
    }

    return view('vouchers.index', [
        'packages' => $packageQuery->get(),
        'routers'  => $routerQuery->get(),
        'vouchers' => $voucherQuery->paginate(10),
    ]);
}
    
         //===================shopkeepers only see their own routers ========================
    

    /**
     * Generate + optionally push
     */
    // public function generate(Request $request)
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'router_id'  => 'nullable|exists:mikrotik_devices,id',
            'quantity'   => 'required|integer|min:1|max:1000',
        ]);
        $package = Package::findOrFail($validated['package_id']);
        $router = MikrotikDevice::findOrFail($validated['router_id']);

            //=====================Also make sure shopkeepers cannot use another person’s router.
        if (auth()->user()->role === 'shopkeeper') {
            $routerAllowed = MikrotikDevice::where('id', $validated['router_id'])
                ->where('user_id', auth()->id())
                ->exists();

            if (!$routerAllowed) {
                return redirect()
                    ->back()
                    ->with('error', 'You are not allowed to use this router.');
            }
        }

        try {

            $results = [];

            // CREATE BATCH FIRST
            $batch = VoucherBatch::create([
                'batch_name' => 'Batch-'.date('YmdHis'),
                'quantity' => $validated['quantity']
            ]);

            for ($i = 0; $i < $validated['quantity']; $i++) {

                $commissionPercentage = 30;

                $commissionAmount =
                    ($package->price * $commissionPercentage) / 100;

                $shopkeeperAmount =
                    $package->price - $commissionAmount;

                    // dd($package->id, $package->price);

                $voucher = Voucher::create([
                    'code'     => $this->voucherService->generateCode(),
                    'username' => $this->voucherService->generateUsername(),
                    'password' => $this->voucherService->generatePassword(),

                    'package_id' => $validated['package_id'],
                    'router_id'  => $validated['router_id'] ?? null,
                    'user_id'    => auth()->id(), //That means vouchers belong to the logged-in user

                    'status'   => 'unused',
                    'duration' => $package->duration_in_hours,

                    'batch_id' => $batch->id,
                    'created_by' => auth()->id(),
                    'is_pushed' => 0,
                    'price' => $package->price,

                    'commission_percentage' => $commissionPercentage,

                    'commission_amount' => $commissionAmount,

                    'shopkeeper_amount' => $shopkeeperAmount,
                ]);

                //================= PUSH TO ROUTER IF SELECTED=============================
                // PUSH TO ROUTER
                if ($voucher->router_id) {

                    try {

                        // 🔥 THIS IS YOUR CORRECT PUSH LINE
                        $response = $this->mikrotikPush->pushVoucher($voucher);

                        $voucher->update([
                            'is_pushed' => 1,
                            'router_response' => json_encode($response),
                            'sync_error' => null
                        ]);

                    } catch (\Exception $e) {

                        $voucher->update([
                            'is_pushed' => 0,
                            'sync_error' => $e->getMessage()
                        ]);

                        \Log::error('Mikrotik push failed', [
                            'voucher_id' => $voucher->id,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                $results[] = $voucher;
            }

            return redirect()
                ->back()
                ->with('success', count($results).' vouchers generated successfully');

        } catch (\Exception $e) {

            Log::error('Voucher generation failed', [
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed: '.$e->getMessage());
        }
    }
    public function printVoucher($id) //printing 1 voucher on A4 page alone
    {
        $voucher = Voucher::with('package')->findOrFail($id);

        $pdf = Pdf::loadView('vouchers.print', [
            'voucher' => $voucher
        ]);

        return $pdf->download('voucher-'.$voucher->code.'.pdf');
    }
    // public function printBatch() //printing A4 bantch vouchers
    // {
    //     $vouchers = Voucher::with('package')
    //         ->latest()
    //         ->take(100)
    //         ->get();

    //     $pdf = Pdf::loadView('vouchers.batch-print', [
    //         'vouchers' => $vouchers
    //     ]);

    //     return $pdf->download('voucher-batch.pdf');
    // }
  public function printBatch($id)
    {

        $vouchers = Voucher::with('package')
                    ->where('batch_id', $id)
                    ->get();

        if($vouchers->isEmpty()){
            // return "No vouchers found for batch ".$id;
            return redirect()->back()->with('error', "No vouchers found for batch {$id}");
        }

        // $pdf = Pdf::loadView('vouchers.batch-print', [
        //     'vouchers' => $vouchers
        // ]);
        $pdf = Pdf::loadView('vouchers.batch-print', compact('vouchers'));


        return $pdf->download('batch-'.$id.'.pdf');

        if (!$voucher->batch_id) {
    Log::warning('Voucher missing batch_id', ['voucher' => $voucher->id]);
        }
    }


//     public function hotspotLogin(Request $request)
//     {
//     $voucher = Voucher::where('code', $request->code)->first();
    
// if (!$voucher->activated_at) {

//     $voucher->activated_at = now();

//     if ($voucher->package) {

//         $voucher->expires_at = now()->addHours(
//             $voucher->package->duration_in_hours
//         );

//     }

// }



//     if (!$voucher) {
//         return response()->json(['error' => 'Invalid voucher']);
//     }

//     if ($voucher->status == 'expired') {
//         return response()->json(['error' => 'Voucher expired']);
//     }

//     if ($voucher->expires_at && now()->gt($voucher->expires_at)) {
//         $voucher->update(['status' => 'expired']);
//         return response()->json(['error' => 'Voucher expired']);
//     }

//     // CREATE SESSION
//     VoucherSession::create([
//         'voucher_id' => $voucher->id,
//         'voucher_code' => $voucher->code,
//         'ip_address' => $request->ip(),
//         'mac_address' => $request->mac ?? null,
//         'router_id' => $voucher->router_id,
//         'login_at' => now(),
//         'status' => 'active'
//     ]);

//     // MARK VOUCHER AS USED
//     $voucher->update([
//             'status' => 'active',
//             'activated_at' =>
//                 $voucher->activated_at ?? now(),
//             'phone_number' =>
//                  $request->phone ?? null
//     ]);

//     return response()->json([
//         'success' => true,
//         'message' => 'Login successful'
//     ]);
//     }

    
public function hotspotLogin(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | FIND VOUCHER
    |--------------------------------------------------------------------------
    */

    $voucher = Voucher::where(
        'code',
        $request->code
    )->first();

    /*
    |--------------------------------------------------------------------------
    | INVALID
    |--------------------------------------------------------------------------
    */

    if (!$voucher) {

        return response()->json([

            'error' => 'Invalid voucher'

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | EXPIRED
    |--------------------------------------------------------------------------
    */

    if (

        $voucher->expires_at

        &&

        now()->gt($voucher->expires_at)

    ) {

        $voucher->update([

            'status' => 'used'

        ]);

        return response()->json([

            'error' => 'Voucher expired'

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | FIRST ACTIVATION
    |--------------------------------------------------------------------------
    */

    if (!$voucher->activated_at) {

        $voucher->activated_at = now();

        if ($voucher->package) {

            $voucher->expires_at = now()->addHours(

                $voucher->package->duration_in_hours

            );

        }

    }

    /*
    |--------------------------------------------------------------------------
    | CREATE SESSION
    |--------------------------------------------------------------------------
    */

    VoucherSession::create([

        'voucher_id' => $voucher->id,

        'voucher_code' => $voucher->code,

        'ip_address' => $request->ip(),

        'mac_address' =>
            $request->mac ?? null,

        'router_id' =>
            $voucher->router_id,

        'login_at' => now(),

        'status' => 'active'

    ]);

    /*
    |--------------------------------------------------------------------------
    | UPDATE VOUCHER
    |--------------------------------------------------------------------------
    */

    $voucher->update([

        'status' => 'active',

        'activated_at' =>
            $voucher->activated_at,

        'phone_number' =>
            $request->phone ?? null

    ]);

    /*
    |--------------------------------------------------------------------------
    | SUCCESS
    |--------------------------------------------------------------------------
    */

    return response()->json([

        'success' => true,

        'message' => 'Login successful'

    ]);
}



    public function hotspotLoginPage(Request $request)
        {
            return view('hotspot.login');
        }



    public function processHotspotLogin(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'phone' => 'required'
        ]);

        $voucher = Voucher::where('code', $request->code)->first();

        if (!$voucher) {
            return back()->with('error', 'Invalid voucher');
        }

        // if ($voucher->status !== 'unused') {
        // return back()->with('error', 'Voucher already used');
        // }

        
        /*
        |--------------------------------------------------------------------------
        | EXPIRED CHECK
        |--------------------------------------------------------------------------
        */

        if (
            $voucher->expires_at
            &&
            now()->gt($voucher->expires_at)
        ) {
            $voucher->update([
                'status' => 'used'
            ]);

            return back()->with(
                'error',
                'Voucher expired'
            );
        }
      
        // Create session tracking
        VoucherSession::create([
            'voucher_id' => $voucher->id,
            'voucher_code' => $voucher->code,
            'router_id' => $voucher->router_id,
            'ip_address' => $request->ip(),
            'login_at' => now(),
            'status' => 'active',
            'data_used' => 0
        ]);

        // mark voucher used
        $voucher->update([
            'status' => 'active',
            'activated_at' =>
                $voucher->activated_at ?? now(),
            'phone_number' =>
                 $request->phone ?? null
        ]);

        // 🔥 REDIRECT TO MIKROTIK AUTH
        return redirect()->away(
            "http://{$voucher->router->ip_address}/login?username={$voucher->username}&password={$voucher->password}"
        );
    }

    public function destroy($id)
    {
        $voucher = $this->findAllowedRouter($id);

        $voucher->delete();

        return redirect()->route('vouchers.index')->with('success', 'Voucher deleted successfully.');
    }

    private function findAllowedRouter($id)
    {
        $voucher = Voucher::findOrFail($id);

        if (auth()->user()->role === 'shopkeeper' && $voucher->user_id !== auth()->id()) {
            abort(403, 'You are not allowed to access this voucher.');
        }

        return $voucher;
    }
}