<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RouterController;
use App\Http\Controllers\PackageController;

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CustomerController;

use App\Http\Controllers\ClientController;


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

Route::middleware(['auth','check.status','check.subscription'])->group(function () {

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
            return redirect()->route('dashboards.shopkeeper');
        }

        return redirect('/');
    })->name('dashboard');




    Route::get('/subscription', function () {
    return view('subscription.index');
    })->name('subscription.index');



    /*
    |--------------------------------------------------------------------------
    | DASHBOARDS
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/dashboard', function () {

    if (auth()->user()->role !== 'admin') {

        return redirect()->route('dashboard');

    }

    return app(DashboardController::class)->admin();

    })->name('admin.dashboard');


    Route::get('/shopkeeper/dashboard', function () {

        if (auth()->user()->role !== 'shopkeeper') {

            return redirect()->route('dashboard');

        }

        return app(DashboardController::class)->shopkeeper();

    })->name('dashboards.shopkeeper');


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

    Route::get('/admin/users', [UserController::class, 'index'])
    ->name('admin.users'); //admin controller for user page, client on sidebar

    Route::POST('/admin/users/store', [UserController::class, 'store'])
    ->name('admin.users.store'); //Add users/ customer on manage user sidebar

    Route::get('/admin/users/{id}/approve', [UserController::class,'approve'])
        ->name('admin.users.approve');

    Route::get('/admin/users/{id}/disable', [UserController::class,'disable'])
        ->name('admin.users.disable');

    Route::get('/admin/users/{id}/enable', [UserController::class,'enable'])
        ->name('admin.users.enable');



     /*
    |--------------------------------------------------------------------------
    | STAFF/ADMIN MANAGE STAFF PAGE
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/staff', [UserController::class, 'staff'])
        ->name('admin.staff');

// reports routes via controller
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

        //  COMMISSION REPORT
    Route::get( '/reports/commissions', [ReportController::class, 'commissions'] )
        ->name('reports.commissions');

        // client page details controller from manage isp table

    Route::get(
             '/clients/{user}',
             [ClientController::class, 'show']
        )->name('clients.show');
        


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

     /*
    |--------------------------------------------------------------------------
    | subscription routes
    |--------------------------------------------------------------------------
    */
    Route::get('/subscription', [SubscriptionController::class, 'index'])
        ->name('subscription.index');

    Route::post('/subscription/pay/manual/{id}', [SubscriptionController::class, 'manualActivate'])
        ->name('subscription.manual.activate');

    Route::post('/subscription/suspend/{id}', [SubscriptionController::class, 'suspend'])
        ->name('subscription.suspend');


/*
|--------------------------------------------------------------------------
| CUSTOMERS
|--------------------------------------------------------------------------
*/

Route::resource(
    'customers',
    CustomerController::class
)->only([

    'index',
    'show',
    'update',
    'destroy'

]);




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