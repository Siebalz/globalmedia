<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentSettingController;

// 🔹 Halaman utama (home/landing) - ini yang tampil pertama saat web dibuka
Route::get('/', function () {
    $produkList     = \App\Models\Product::where('is_active', true)->with('images')->latest()->take(8)->get();
    $paymentSetting = \App\Models\PaymentSetting::current();

    return view('welcome', compact('produkList', 'paymentSetting'));
})->name('welcome');

// 🔹 Halaman servis perangkat jaringan (statis)
Route::get('/servis', function () {
    return view('servis');
})->name('servis');

// 🔹 Halaman login (guest = hanya bisa diakses kalau BELUM login)
// throttle:10,1 = maksimal 10 request per menit per IP, lapisan tambahan anti brute-force/bot
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:10,1')->name('login.process');

    // 🔹 Halaman register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:5,1');
});

// 🔹 Dashboard (halaman default setelah login)
Route::get('/dashboard', [HomeController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// 🔹 Alias lama, arahkan ke dashboard supaya tidak 404
Route::redirect('/home', '/dashboard');

// 🔹 Khusus admin: pengaturan pembayaran (QRIS statik)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard/setting-pembayaran', [PaymentSettingController::class, 'edit'])->name('settings.payment.edit');
    Route::post('/dashboard/setting-pembayaran', [PaymentSettingController::class, 'update'])->name('settings.payment.update');
});

// 🔹 Produk / perangkat jaringan second (marketplace publik, bisa diakses tanpa login)
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product}', [ProductController::class, 'show'])->name('products.show');

// 🔹 Khusus admin: kelola produk tanpa perlu sentuh code
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/produk-create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/produk', [ProductController::class, 'store'])->name('products.store');
    Route::get('/produk/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/produk/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/produk/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// 🔹 Logout
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
