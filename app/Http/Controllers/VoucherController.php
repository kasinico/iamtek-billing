<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\Package;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        $vouchers = Voucher::latest()->take(50)->get();

        return view('vouchers.index', compact('packages', 'vouchers'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'package_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        for ($i = 0; $i < $request->quantity; $i++) {
            Voucher::create([
                'code' => 'IAM-' . strtoupper(Str::random(5)),
                'package_id' => $request->package_id,
                'user_id' => auth()->id(),
                'status' => 'unused'
            ]);
        }

        return back()->with('success', 'Vouchers generated successfully!');
    }
}