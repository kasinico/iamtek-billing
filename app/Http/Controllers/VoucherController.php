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
        return view('vouchers.index', [
            'packages' => Package::all(),
            'routers'  => MikrotikDevice::all(),
            // 'vouchers' => Voucher::latest()->take(20)->get()
            'vouchers' => Voucher::with(['package','router'])
                     ->latest()
                     ->take(20)
                     ->get()
        ]);
    }

    /**
     * Generate + optionally push
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'router_id'  => 'nullable|exists:mikrotik_devices,id',
            'quantity'   => 'required|integer|min:1|max:1000',
            'duration'   => 'required|integer|min:1'
        ]);

        try {

            $results = [];

            for ($i = 0; $i < $validated['quantity']; $i++) {

                $voucher = Voucher::create([
                    'code'     => $this->voucherService->generateCode(),
                    'username' => $this->voucherService->generateUsername(),
                    'password' => $this->voucherService->generatePassword(),

                    'package_id' => $validated['package_id'],
                    'router_id'  => $validated['router_id'] ?? null,
                    'user_id'    => auth()->id(),

                    'status'   => 'unused',
                    'duration' => $validated['duration'],

                    'is_pushed' => 0
                ]);

                // ONLY PUSH IF ROUTER EXISTS
                if ($voucher->router_id) {

                    try {

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

                        Log::error('Mikrotik push failed', [
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
    public function printBatch() //printing A4 bantch vouchers
    {
        $vouchers = Voucher::with('package')
            ->latest()
            ->take(100)
            ->get();

        $pdf = Pdf::loadView('vouchers.batch-print', [
            'vouchers' => $vouchers
        ]);

        return $pdf->download('voucher-batch.pdf');
    }
}