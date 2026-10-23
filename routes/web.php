<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Halaman Utama Redirect Otomatis Berdasarkan Role
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('siswa.dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware('auth')->name('dashboard');

// Route Khusus Siswa
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [PengaduanController::class, 'dashboardSiswa'])->name('siswa.dashboard');
    Route::get('/siswa/pengaduan', [PengaduanController::class, 'indexSiswa'])->name('siswa.pengaduan.index');
    Route::get('/siswa/pengaduan/create', [PengaduanController::class, 'createSiswa'])->name('siswa.pengaduan.create');
    Route::post('/siswa/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');

    // Edit & hapus pengaduan (hanya yang masih pending)
    Route::get('/siswa/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'edit'])->name('siswa.pengaduan.edit');
    Route::put('/siswa/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('siswa.pengaduan.update');
    Route::delete('/siswa/pengaduan/{pengaduan}', [PengaduanController::class, 'destroy'])->name('siswa.pengaduan.destroy');
});

// Route Khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [PengaduanController::class, 'dashboardAdmin'])->name('admin.dashboard');
    Route::get('/admin/pengaduan', [PengaduanController::class, 'indexAdmin'])->name('admin.pengaduan.index');
    Route::patch('/admin/pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])->name('admin.pengaduan.updateStatus');
    Route::get('/admin/pengaduan/cetak-pdf', [PengaduanController::class, 'cetakPdf'])->name('admin.pengaduan.cetakPdf');
});

// Route Pengaturan Profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';