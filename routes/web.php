<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentSettingController;
use App\Http\Controllers\CartController;
use Spatie\Sitemap\SitemapGenerator;

// 🔹 Halaman utama (home/landing)
Route::get('/', function () {
    $produkList     = \App\Models\Product::where('is_active', true)->with('images')->latest()->take(8)->get();
    $paymentSetting = \App\Models\PaymentSetting::current();

    return view('welcome', compact('produkList', 'paymentSetting'));
})->name('welcome');

Route::get('/servis', function () {
    return view('servis');
})->name('servis');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:10,1')->name('login.process');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:5,1');
});

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');
Route::redirect('/home', '/dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard/setting-pembayaran', [PaymentSettingController::class, 'edit'])->name('settings.payment.edit');
    Route::post('/dashboard/setting-pembayaran', [PaymentSettingController::class, 'update'])->name('settings.payment.update');
});

Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/produk-create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/produk', [ProductController::class, 'store'])->name('products.store');
    Route::get('/produk/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/produk/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/produk/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// ─────────────────────────────────────────────────────────────
// 🛒 KERANJANG & PESANAN PRODUK (wajib login)
// ─────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/keranjang/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/keranjang/checkout', [CartController::class, 'checkout'])->middleware('throttle:5,1')->name('cart.checkout');
    Route::get('/pesanan-produk', [CartController::class, 'orders'])->name('cart.orders');
    Route::patch('/pesanan-produk/{productOrder}/bukti', [CartController::class, 'uploadProof'])->middleware('throttle:10,1')->name('cart.upload-proof');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard/pesanan-produk', [CartController::class, 'adminOrders'])->name('cart.admin-orders');
    Route::patch('/dashboard/pesanan-produk/{productOrder}/status', [CartController::class, 'adminUpdateStatus'])->name('cart.admin-update-status');
});
// ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'admin'])->get('/generate-sitemap', function () {
    SitemapGenerator::create(config('app.url'))->writeToFile(public_path('sitemap.xml'));
    return response('Sitemap berhasil dibuat.')->header('Content-Type', 'text/plain');
})->name('sitemap.generate');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
