<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TamuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// --- GUEST ROUTES ---
Route::get('/', [TamuController::class, 'showForm'])->name('tamu.form');
Route::post('/', [TamuController::class, 'store'])->name('tamu.form.submit');
Route::get('/sukses', [TamuController::class, 'sukses'])->name('tamu.sukses');

// --- ADMIN AUTH ROUTES ---
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// --- PROTECTED ADMIN PANEL ROUTES ---
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Data Tamu
    Route::get('/admin/tamu', [AdminController::class, 'index'])->name('admin.tamu');
    Route::delete('/admin/tamu/{id}', [AdminController::class, 'destroy'])->name('admin.tamu.delete');
    
    // Laporan
    Route::get('/admin/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::get('/admin/laporan/export', [AdminController::class, 'exportExcel'])->name('admin.laporan.export');
    
    // Profil Admin
    Route::get('/admin/profil', [AdminController::class, 'showProfil'])->name('admin.profil');
    Route::put('/admin/profil', [AdminController::class, 'updateProfil'])->name('admin.profil.update');
    Route::put('/admin/profil/password', [AdminController::class, 'updatePassword'])->name('admin.profil.password');
});
