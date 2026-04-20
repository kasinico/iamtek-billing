<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Admin\UserController;






Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


//nico - protecting Admin routes
// Route::get('/admin', function () {
//     return view('admin.dashboard');
// })->middleware(['auth']);

Route::get('/pending', function () {
    return view('pending');
});


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
Route::middleware(['auth','approved'])->group(function () {

    // Voucher page
    Route::get('/vouchers', [VoucherController::class, 'index']);

    // Generate vouchers
    Route::post('/vouchers/generate', [VoucherController::class, 'generate']);

    // Print single voucher
    Route::get('/voucher/print/{id}', [VoucherController::class, 'printVoucher']);

    // Print batch vouchers
    Route::get('/vouchers/print-batch/{id}', [VoucherController::class,'printBatch'])
        ->name('vouchers.printBatch');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth'])
        ->name('dashboard');

    Route::get('/admin/users',[AdminUserController::class,'index']);

    Route::post('/admin/users/{id}/approve',[AdminUserController::class,'approve']);

    /*
|--------------------------------------------------------------------------
| WIFI HOTSPOT LOGIN (END USERS)
|--------------------------------------------------------------------------
*/

Route::get('/wifi/login', [VoucherController::class, 'showWifiLogin']);

Route::post('/wifi/login', [VoucherController::class, 'processWifiLogin']);
});



//HOTSPOT LOGIN ROUTE
Route::get('/hotspot/login', [VoucherController::class, 'hotspotLogin']);
Route::get('/hotspot/login', [VoucherController::class, 'hotspotLoginPage']);
Route::post('/hotspot/login', [VoucherController::class, 'processHotspotLogin']);

//Auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/users', [UserController::class,'index']);

    Route::get('/admin/users/{id}/approve', [UserController::class,'approve']);

    Route::get('/admin/users/{id}/disable', [UserController::class,'disable']);
    Route::get('/admin/users/{id}/enable', [UserController::class,'enable']);

});

Route::get('/reseller/register', [ResellerController::class,'create']);
Route::post('/reseller/register', [ResellerController::class,'store']);

require __DIR__.'/auth.php';
