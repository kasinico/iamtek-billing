<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\DashboardController;
// use App\Http\Controllers\VoucherController;
// use App\Http\Controllers\ResellerController;
// use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\Admin\UserController;

// /*
// |--------------------------------------------------------------------------
// | REDIRECT DASHBOARD
// |--------------------------------------------------------------------------
// */

// Route::get('/dashboard', [DashboardController::class, 'index'])
//     ->middleware(['auth', 'check.status'])
//     ->name('dashboard');

// /*
// |--------------------------------------------------------------------------
// | DASHBOARDS
// |--------------------------------------------------------------------------
// */

// Route::middleware(['auth', 'check.status'])->group(function () {

//     // Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
//     //     ->name('admin.dashboard');

//     // Route::get('/shopkeeper/dashboard', [DashboardController::class, 'shopkeeper'])
//     //     ->name('shopkeeper.dashboard');
// });

// /*
// |--------------------------------------------------------------------------
// | VOUCHERS
// |--------------------------------------------------------------------------
// */

// Route::middleware(['auth', 'check.status'])->group(function () {

//     Route::get('/vouchers', [VoucherController::class, 'index']);
//     Route::post('/vouchers/generate', [VoucherController::class, 'generate']);

//     Route::get('/voucher/print/{id}', [VoucherController::class, 'printVoucher']);
//     Route::get('/vouchers/print-batch/{id}', [VoucherController::class, 'printBatch']);
// });

// /*
// |--------------------------------------------------------------------------
// | USERS (ADMIN)
// |--------------------------------------------------------------------------
// */

// Route::middleware(['auth'])->group(function () {

//     Route::get('/admin/users', [UserController::class, 'index']);
//     Route::get('/admin/users/{id}/approve', [UserController::class, 'approve']);
//     Route::get('/admin/users/{id}/disable', [UserController::class, 'disable']);
//     Route::get('/admin/users/{id}/enable', [UserController::class, 'enable']);
// });

// /*
// |--------------------------------------------------------------------------
// | WIFI + HOTSPOT
// |--------------------------------------------------------------------------
// */

// Route::get('/wifi/login', [VoucherController::class, 'showWifiLogin']);
// Route::post('/wifi/login', [VoucherController::class, 'processWifiLogin']);

// Route::get('/hotspot/login', [VoucherController::class, 'hotspotLoginPage']);
// Route::post('/hotspot/login', [VoucherController::class, 'processHotspotLogin']);

// /*
// |--------------------------------------------------------------------------
// | RESSELLER
// |--------------------------------------------------------------------------
// */

// Route::get('/reseller/register', [ResellerController::class, 'create']);
// Route::post('/reseller/register', [ResellerController::class, 'store']);

// /*
// |--------------------------------------------------------------------------
// | PROFILE
// |--------------------------------------------------------------------------
// */

// Route::middleware(['auth'])->group(function () {

//     Route::get('/profile', [ProfileController::class, 'edit']);
//     Route::patch('/profile', [ProfileController::class, 'update']);
//     Route::delete('/profile', [ProfileController::class, 'destroy']);
// });

// require __DIR__.'/auth.php';




use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RouterController;
use App\Http\Controllers\PackageController;

use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pending', function () {
    return view('auth.pending');
})->name('pending');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','check.status'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD REDIRECT
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'shopkeeper') {
            return redirect()->route('shopkeeper.dashboard');
        }

        return redirect('/');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | DASHBOARDS
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/dashboard', [DashboardController::class,'admin'])
        ->name('admin.dashboard');

    Route::get('/shopkeeper/dashboard', [DashboardController::class,'shopkeeper'])
        ->name('shopkeeper.dashboard');


    /*
    |--------------------------------------------------------------------------
    | VOUCHERS
    |--------------------------------------------------------------------------
    */

    Route::get('/vouchers', [VoucherController::class,'index'])
        ->name('vouchers.index');

    Route::post('/vouchers/generate', [VoucherController::class,'generate'])
        ->name('vouchers.generate');

    Route::get('/voucher/print/{id}', [VoucherController::class,'printVoucher'])
        ->name('voucher.print');

    Route::get('/vouchers/print-batch/{id}', [VoucherController::class,'printBatch'])
        ->name('vouchers.printBatch');

    Route::delete('/voucher/{id}', [VoucherController::class, 'destroy'])->name('voucher.destroy');



    /*
    |--------------------------------------------------------------------------
    | ADMIN USERS MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/users', [UserController::class,'index'])
        ->name('admin.users');

    Route::get('/admin/users/{id}/approve', [UserController::class,'approve'])
        ->name('admin.users.approve');

    Route::get('/admin/users/{id}/disable', [UserController::class,'disable'])
        ->name('admin.users.disable');

    Route::get('/admin/users/{id}/enable', [UserController::class,'enable'])
        ->name('admin.users.enable');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class,'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class,'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class,'destroy'])
        ->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| WIFI LOGIN (END USERS)
|--------------------------------------------------------------------------
*/

Route::get('/wifi/login', [VoucherController::class,'showWifiLogin'])
    ->name('wifi.login');

Route::post('/wifi/login', [VoucherController::class,'processWifiLogin']);


/*
|--------------------------------------------------------------------------
| HOTSPOT LOGIN (CAPTIVE PORTAL)
|--------------------------------------------------------------------------
*/


Route::get('/hotspot', function () {
    return view('hotspot.index', [
        'packages' => \App\Models\Package::where('active', 1)->get()
    ]);
});

Route::post('/pay', [PaymentController::class, 'initiate']);
Route::post('/flutterwave/webhook', [PaymentController::class, 'webhook']);




Route::get('/hotspot/login', [VoucherController::class,'hotspotLoginPage'])
    ->name('hotspot.login');

Route::post('/hotspot/login', [VoucherController::class,'processHotspotLogin']);


/*
|--------------------------------------------------------------------------
| RESELLER REGISTRATION
|--------------------------------------------------------------------------
*/

Route::get('/reseller/register', [ResellerController::class,'create'])
    ->name('reseller.register');

Route::post('/reseller/register', [ResellerController::class,'store']);


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/routers', [RouterController::class, 'index'])->name('routers.index');
Route::get('/routers/create', [RouterController::class, 'create'])->name('routers.create');
Route::post('/routers', [RouterController::class, 'store'])->name('routers.store');
Route::get('/routers/{id}/edit', [RouterController::class, 'edit'])->name('routers.edit');
Route::put('/routers/{id}', [RouterController::class, 'update'])->name('routers.update');
Route::delete('/routers/{id}', [RouterController::class, 'destroy'])->name('routers.destroy');
Route::get('/routers/{id}/test', [RouterController::class, 'test'])->name('routers.test');


Route::get('/packages', [PackageController::class, 'index'])
    ->name('packages.index');

Route::get('/packages/create', [PackageController::class, 'create'])
    ->name('packages.create');

Route::post('/packages', [PackageController::class, 'store'])
    ->name('packages.store');

Route::get('/packages/{id}/edit', [PackageController::class, 'edit'])
    ->name('packages.edit');

Route::put('/packages/{id}', [PackageController::class, 'update'])
    ->name('packages.update');

Route::delete('/packages/{id}', [PackageController::class, 'destroy'])
    ->name('packages.destroy');


require __DIR__.'/auth.php';