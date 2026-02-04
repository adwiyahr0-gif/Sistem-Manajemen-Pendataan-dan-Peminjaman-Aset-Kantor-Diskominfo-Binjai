<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\AssetCatalogController;

// Semua route di dalam grup ini wajib login
Route::middleware('auth')->group(function () {
    
    // Dashboard (Bisa diakses Admin & User)
    // TAMBAHAN: Memberi nama 'user.dashboard' agar redirect dari BorrowingController sukses
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    // --- FITUR KHUSUS ADMIN & MANAJEMEN PINJAMAN ---
    Route::middleware(['auth'])->group(function () {
        
        // Aset & Inventaris
        Route::resource('assets', AssetController::class);
        
        // Transaksi Peminjaman
        Route::get('borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
        Route::get('borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
        Route::post('borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
        
        // Tombol Persetujuan Admin
        Route::put('borrowings/{id}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
        Route::put('borrowings/{id}/reject', [BorrowingController::class, 'reject'])->name('borrowings.reject');
        Route::put('borrowings/{id}/kembalikan', [BorrowingController::class, 'kembalikan'])->name('borrowings.kembalikan');

        // --- LAPORAN ---
        Route::get('/reports', function () {
            return view('reports.index');
        })->name('reports.index');

        // --- KELOLA USER/ADMIN ---
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // --- FITUR USER (PEGAWAI) ---
    // Katalog Aset untuk Pegawai
    Route::get('/user/assets', [AssetCatalogController::class, 'index'])->name('user.assets.index');

    // --- PROFILE MANAGEMENT ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';