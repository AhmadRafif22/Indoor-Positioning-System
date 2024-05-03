<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PerangkatController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenggunaHomeController;
use App\Http\Controllers\HomepageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomepageController::class, 'index']);

Route::get('/search', [HomepageController::class, 'search'])->name('search');

// Route Admin

// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware(['auth', 'verified', 'role:admin'])->name('dashboard');

// Route::get('/pengguna', function () {
//     return view('admin.kelolapengguna');
// })->middleware(['auth', 'verified', 'role:admin'])->name('pengguna');

// Route::get('/perangkat', function () {
//     return view('admin.kelolaperangkat');
// })->middleware(['auth', 'verified', 'role:admin'])->name('perangkat');

Route::group(['middleware' => ['auth', 'verified', 'role:admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::group(['middleware' => ['auth', 'verified', 'role:admin']], function () {
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::put('/pengguna/{pengguna}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
});

Route::group(['middleware' => ['auth', 'verified', 'role:admin']], function () {
    Route::get('/perangkat', [PerangkatController::class, 'index'])->name('perangkat.index');
    Route::post('/perangkat', [PerangkatController::class, 'store'])->name('perangkat.store');
    Route::put('/perangkat/{perangkat}', [PerangkatController::class, 'update'])->name('perangkat.update');
    Route::delete('/perangkat/{id}', [PerangkatController::class, 'destroy'])->name('perangkat.destroy');
});

// Route pengguna

// Route::group(['middleware' => ['auth', 'verified', 'role:pengguna']], function () {
//     Route::get('/pengguna-home', [PenggunaHomeController::class, 'index'])->name('pengguna-home');
// });

// Route::get('/pengguna-home', function () {
//     return view('pengguna.pengguna-home');
// })->middleware(['auth', 'verified', 'role:pengguna'])->name('pengguna-home');

Route::get('/pengguna-home', [PenggunaHomeController::class, 'index'])->name('pengguna-home')->middleware(['auth', 'verified', 'role:pengguna']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
