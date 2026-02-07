<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuruController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// Halaman utama (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/guru/dashboard', function () {
        return view('guru.dashboard');
    })->name('guru.dashboard');

    Route::get('/siswa/dashboard', function () {
        return view('siswa.dashboard');
    })->name('siswa.dashboard');
});
Route::get('/guru/generate-qr', [GuruController::class, 'generateQr'])->name('guru.generate-qr');
Route::get('/get-new-qr', [GuruController::class, 'getNewQr'])->name('get.new.qr');
Route::get('/proses-izin/{id}/{status}', [GuruController::class, 'prosesIzin'])->name('admin.proses-izin');
Route::get('/guru/data-siswa', [GuruController::class, 'dataSiswa'])->name('guru.data-siswa');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Baris penyelamat biar navigasi Breeze nggak error
Route::get('/dashboard', function () {
    return redirect()->route(Auth::user()->role == 'admin' ? 'admin.dashboard' : (Auth::user()->role == 'wali_kelas' ? 'guru.dashboard' : 'siswa.dashboard'));
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
