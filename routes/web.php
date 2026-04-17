<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoucherController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//nico - protecting Admin routes
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth']);



//VoucherController

// Route::middleware(['auth'])->group(function () {

//     // Voucher UI
//     Route::get('/vouchers', [VoucherController::class, 'index']);

//     // Generate vouchers (ONLY ONCE, SECURED)
//     Route::post('/vouchers/generate', [VoucherController::class, 'generate']);
//     Route::get('/vouchers/print/{id}', [VoucherController::class, 'print']);


//     //print vochers
// Route::get('/voucher/print/{id}', [VoucherController::class, 'printVoucher']); //single
// // Route::get('/vouchers/print-batch', [VoucherController::class, 'printBatch']); //batch
// // Route::get('/vouchers/print-batch/{id}', [VoucherController::class,'printBatch'])->name('vouchers.printBatch');
// Route::get('/vouchers/print-batch/{id}', [VoucherController::class,'printBatch']);
    

// });
Route::middleware(['auth'])->group(function () {

    // Voucher page
    Route::get('/vouchers', [VoucherController::class, 'index']);

    // Generate vouchers
    Route::post('/vouchers/generate', [VoucherController::class, 'generate']);

    // Print single voucher
    Route::get('/voucher/print/{id}', [VoucherController::class, 'printVoucher']);

    // Print batch vouchers
    // Route::get('/vouchers/print-batch/{id}', [VoucherController::class, 'printBatch']);
    Route::get('/vouchers/print-batch/{id}', [VoucherController::class, 'printBatch'])->name('vouchers.printBatch');

});


//Auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
