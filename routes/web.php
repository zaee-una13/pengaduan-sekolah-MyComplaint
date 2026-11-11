<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\SiswaController;
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
    return view('login');
});

// Alias agar redirect bawaan Breeze ke route('dashboard') tidak error
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

    // Kelola akun siswa (hanya admin)
    Route::prefix('admin/siswa')->name('admin.siswa.')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('index');
        Route::get('/create', [SiswaController::class, 'create'])->name('create');
        Route::post('/', [SiswaController::class, 'store'])->name('store');
        Route::get('/{siswa}/edit', [SiswaController::class, 'edit'])->name('edit');
        Route::put('/{siswa}', [SiswaController::class, 'update'])->name('update');
        Route::delete('/{siswa}', [SiswaController::class, 'destroy'])->name('destroy');
    });
});

// Route Pengaturan Profil (tanpa hapus akun: akun hanya dihapus oleh admin lewat Kelola Siswa)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
