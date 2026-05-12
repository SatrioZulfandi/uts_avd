<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Routing untuk halaman dashboard dan fitur export.
|--------------------------------------------------------------------------
*/

// Halaman utama redirect ke dashboard
Route::get('/', fn() => redirect()->route('dashboard'));

// Dashboard Analitik Penjualan
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Export Data
Route::get('/export/excel', [DashboardController::class, 'exportExcel'])->name('export.excel');
Route::get('/export/pdf', [DashboardController::class, 'exportPdf'])->name('export.pdf');
