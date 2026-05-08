<?php



use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Payment;
use App\Models\Package;
use App\Models\Voucher;
use App\Models\MikrotikDevice;
use App\Services\MikrotikPushService;
use Flutterwave\MobileMoney;
use Flutterwave\Rave;



class PaymentController extends Controller
{
    public function initiate(Request $request)
    {
        $package = Package::findOrFail($request->package_id);

        $tx_ref = 'tx_' . Str::random(10);

        Payment::create([
            'tx_ref' => $tx_ref,
            'phone' => $request->phone,
            'network' => $request->network,
            'amount' => $package->price,
            'status' => 'pending',
            'package_id' => $package->id,
        ]);

        $flw = new \Flutterwave\Rave(env('FLW_SECRET_KEY'));
        $mobileMoney = new \Flutterwave\MobileMoney();

        $payload = [
            "type" => "mobile_money_uganda",
            "phone_number" => $request->phone,
            "network" => $request->network,
            "amount" => $package->price,
            "currency" => "UGX",
            "email" => "user@iamtek.com",
            "tx_ref" => $tx_ref,
        ];

        $mobileMoney->mobilemoney($payload);

        return back()->with('success', 'Payment prompt sent to your phone.');
    }

    public function webhook(Request $request)
    {
        if ($request->header('verif-hash') !== env('FLW_SECRET_HASH')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->data;

        if ($request->event === 'charge.completed' && $data['status'] === 'successful') {

            $payment = Payment::where('tx_ref', $data['tx_ref'])->first();

            if (!$payment || $payment->status === 'completed') {
                return response()->json(['status' => 'ignored']);
            }

            $payment->update(['status' => 'completed']);

            $package = Package::find($payment->package_id);

            // 🔥 CREATE VOUCHER
            $voucher = Voucher::create([
                'user_id' => $package->user_id,
                'package_id' => $package->id,
                'code' => strtoupper(Str::random(8)),
                'status' => 'unused',
            ]);

            // 🔥 PUSH TO MIKROTIK
            $routers = MikrotikDevice::where('is_active', 1)->get();
            $mikrotik = new MikrotikPushService();

            foreach ($routers as $router) {
                try {
                    $mikrotik->createUserFromVoucher($router, $voucher, $package);
                } catch (\Throwable $e) {
                    logger($e->getMessage());
                }
            }

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'ok']);
    }
}