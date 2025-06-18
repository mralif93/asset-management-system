<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetMovementController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\MaintenanceRecordController;
use App\Http\Controllers\DisposalController;
use App\Http\Controllers\LossWriteoffController;
use App\Http\Controllers\ImmovableAssetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Asset Management (Modul Pengurusan Aset Alih)
    Route::resource('assets', AssetController::class);
    Route::get('assets/location/{lokasi}', [AssetController::class, 'byLocation'])->name('assets.by-location');
    Route::patch('assets/{asset}/location', [AssetController::class, 'updateLocation'])->name('assets.update-location');
    
    // Asset Movements (Modul Pengurusan Pergerakan/Pinjaman Aset)
    Route::resource('asset-movements', AssetMovementController::class);
    Route::patch('asset-movements/{assetMovement}/approve', [AssetMovementController::class, 'approve'])->name('asset-movements.approve');
    Route::patch('asset-movements/{assetMovement}/reject', [AssetMovementController::class, 'reject'])->name('asset-movements.reject');
    Route::patch('asset-movements/{assetMovement}/return', [AssetMovementController::class, 'recordReturn'])->name('asset-movements.return');
    
    // Asset Inspections (Modul Pengurusan Pemeriksaan Aset)
    Route::resource('inspections', InspectionController::class);
    
    // Maintenance Records (Modul Pengurusan Penyelenggaraan Aset)
    Route::resource('maintenance-records', MaintenanceRecordController::class);
    
    // Asset Disposal (Modul Pengurusan Pelupusan Aset)
    Route::resource('disposals', DisposalController::class);
    
    // Loss and Write-off (Modul Pengurusan Kehilangan dan Hapus Kira)
    Route::resource('loss-writeoffs', LossWriteoffController::class);
    
    // Immovable Assets (Modul Pengurusan Aset Tak Alih)
    Route::resource('immovable-assets', ImmovableAssetController::class);
    
    // Reports (Modul Laporan)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/assets-by-location/{lokasi}', [ReportController::class, 'assetsByLocation'])->name('assets-by-location');
        Route::get('/disposal/{id}', [ReportController::class, 'disposalReport'])->name('disposal');
        Route::get('/annual-summary/{year?}', [ReportController::class, 'annualSummary'])->name('annual-summary');
        Route::get('/movements-summary', [ReportController::class, 'movementsSummary'])->name('movements-summary');
    });
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
