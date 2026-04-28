<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Seller;
use App\Http\Controllers\Customer;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/',              [LandingController::class, 'index'])->name('landing');
Route::get('/produk/{slug}', [LandingController::class, 'show'])->name('produk.show');

// Auth
Route::get('/log-masuk',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/log-masuk', [AuthController::class, 'login'])->name('login.submit');
Route::get('/daftar',     [AuthController::class, 'showRegister'])->name('register');
Route::post('/daftar',    [AuthController::class, 'register'])->name('register.submit');
Route::post('/log-keluar',[AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Cart
    Route::get('/troli',                    [CartController::class, 'index'])->name('cart');
    Route::post('/troli',                   [CartController::class, 'add'])->name('cart.add');
    Route::put('/troli/{cartItem}',         [CartController::class, 'update'])->name('cart.update');
    Route::delete('/troli/{cartItem}',      [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/pembayaran',              [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/pembayaran',             [CheckoutController::class, 'placeOrder'])->name('checkout.place');

    /*
    |----------------------------------------------------------------------
    | Admin Routes
    |----------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/papan-pemuka',     [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/penjual',          [Admin\SellerController::class, 'index'])->name('sellers');
        Route::post('/penjual',         [Admin\SellerController::class, 'store'])->name('sellers.store');
        Route::patch('/penjual/{user}/toggle', [Admin\SellerController::class, 'toggleStatus'])->name('sellers.toggle');
        Route::delete('/penjual/{user}',[Admin\SellerController::class, 'destroy'])->name('sellers.destroy');

        Route::get('/pelanggan',        [Admin\CustomerController::class, 'index'])->name('customers');
        Route::delete('/pelanggan/{user}', [Admin\CustomerController::class, 'destroy'])->name('customers.destroy');

        Route::get('/penghantaran',     [Admin\ShippingController::class, 'index'])->name('shipping');
        Route::post('/penghantaran',    [Admin\ShippingController::class, 'store'])->name('shipping.store');
        Route::delete('/penghantaran/{shippingType}', [Admin\ShippingController::class, 'destroy'])->name('shipping.destroy');

        Route::get('/laporan',          [Admin\ReportController::class, 'index'])->name('reports');

        Route::get('/kategori',         [Admin\CategoryController::class, 'index'])->name('categories');
        Route::post('/kategori',        [Admin\CategoryController::class, 'store'])->name('categories.store');
        Route::delete('/kategori/{category}', [Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    /*
    |----------------------------------------------------------------------
    | Seller Routes
    |----------------------------------------------------------------------
    */
    Route::prefix('penjual')->name('seller.')->middleware('role:seller')->group(function () {
        Route::get('/papan-pemuka',     [Seller\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/produk',           [Seller\ProductController::class, 'index'])->name('products');
        Route::post('/produk',          [Seller\ProductController::class, 'store'])->name('products.store');
        Route::delete('/produk/{product}', [Seller\ProductController::class, 'destroy'])->name('products.destroy');

        Route::get('/transaksi',        [Seller\TransactionController::class, 'index'])->name('transactions');
        Route::patch('/transaksi/{order}/status', [Seller\TransactionController::class, 'updateStatus'])->name('transactions.status');
    });

    /*
    |----------------------------------------------------------------------
    | Customer Routes
    |----------------------------------------------------------------------
    */
    Route::prefix('pelanggan')->name('customer.')->middleware('role:customer')->group(function () {
        Route::get('/papan-pemuka',     [Customer\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/pesanan',          [Customer\OrderController::class, 'index'])->name('orders');
        Route::get('/pesanan/{order}',  [Customer\OrderController::class, 'show'])->name('order-detail');

        Route::get('/alamat',           [Customer\AddressController::class, 'index'])->name('addresses');
        Route::post('/alamat',          [Customer\AddressController::class, 'store'])->name('addresses.store');
        Route::patch('/alamat/{address}/utama', [Customer\AddressController::class, 'setDefault'])->name('addresses.default');
        Route::delete('/alamat/{address}', [Customer\AddressController::class, 'destroy'])->name('addresses.destroy');

        Route::get('/profil',           [Customer\ProfileController::class, 'edit'])->name('profile');
        Route::put('/profil',           [Customer\ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profil/kata-laluan', [Customer\ProfileController::class, 'changePassword'])->name('profile.password');
    });
});
