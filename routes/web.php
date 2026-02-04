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
    
    // --- DASHBOARD ---
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    // --- FITUR KHUSUS ADMIN (Hanya bisa diakses jika role = admin) ---
    // Jika Anda punya middleware 'admin', bisa dipasang di sini. 
    // Sementara menggunakan auth agar fungsi tetap berjalan.
    Route::middleware(['auth'])->group(function () {
        
        // Aset & Inventaris
        Route::resource('assets', AssetController::class);
        
        // Transaksi Peminjaman (Admin View)
        Route::get('borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
        Route::get('borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
        Route::post('borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
        
        // Tombol Persetujuan & Pengembalian
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
    Route::get('/user/assets', [AssetCatalogController::class, 'index'])->name('user.assets.index');

    // --- PROFILE MANAGEMENT (Bisa diakses Admin & User) ---
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';