<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\AssetMovementController;
use App\Http\Controllers\Admin\InspectionController;
use App\Http\Controllers\Admin\MaintenanceRecordController;
use App\Http\Controllers\Admin\DisposalController;
use App\Http\Controllers\Admin\LossWriteoffController;
use App\Http\Controllers\Admin\ImmovableAssetController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\UserDashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Laravel expects this route name
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('forgot-password.submit');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Dashboard redirects
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('dashboard');
    
    // Profile Management (available to both admin and user)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes - ALL modules under admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard & System
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/system-overview', [AdminDashboardController::class, 'systemOverview'])->name('system-overview');
    
    // User Management CRUD
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::patch('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk-delete');
    
    // Assets Management
    Route::resource('assets', AssetController::class);
    Route::get('assets/location/{lokasi}', [AssetController::class, 'byLocation'])->name('assets.by-location');
    Route::patch('assets/{asset}/location', [AssetController::class, 'updateLocation'])->name('assets.update-location');
    Route::post('assets/bulk-delete', [AssetController::class, 'bulkDelete'])->name('assets.bulk-delete');
    
    // Asset Movements
    Route::resource('asset-movements', AssetMovementController::class);
    Route::patch('asset-movements/{assetMovement}/approve', [AssetMovementController::class, 'approve'])->name('asset-movements.approve');
    Route::patch('asset-movements/{assetMovement}/reject', [AssetMovementController::class, 'reject'])->name('asset-movements.reject');
    Route::patch('asset-movements/{assetMovement}/return', [AssetMovementController::class, 'recordReturn'])->name('asset-movements.return');
    
    // Inspections
    Route::resource('inspections', InspectionController::class);
    
    // Maintenance Records
    Route::resource('maintenance-records', MaintenanceRecordController::class);
    
    // Immovable Assets
    Route::resource('immovable-assets', ImmovableAssetController::class);
    
    // Disposals
    Route::resource('disposals', DisposalController::class);
    Route::patch('disposals/{disposal}/approve', [DisposalController::class, 'approve'])->name('disposals.approve');
    Route::patch('disposals/{disposal}/reject', [DisposalController::class, 'reject'])->name('disposals.reject');
    
    // Loss Write-offs
    Route::resource('loss-writeoffs', LossWriteoffController::class);
    Route::patch('loss-writeoffs/{lossWriteoff}/approve', [LossWriteoffController::class, 'approve'])->name('loss-writeoffs.approve');
    Route::patch('loss-writeoffs/{lossWriteoff}/reject', [LossWriteoffController::class, 'reject'])->name('loss-writeoffs.reject');
    
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/assets-by-location/{lokasi?}', [ReportController::class, 'assetsByLocation'])->name('assets-by-location');
        Route::get('/disposal/{id}', [ReportController::class, 'disposalReport'])->name('disposal');
        Route::get('/annual-summary/{year?}', [ReportController::class, 'annualSummary'])->name('annual-summary');
        Route::get('/movements-summary', [ReportController::class, 'movementsSummary'])->name('movements-summary');
        Route::get('/inspection-schedule', [ReportController::class, 'inspectionSchedule'])->name('inspection-schedule');
        Route::get('/maintenance-schedule', [ReportController::class, 'maintenanceSchedule'])->name('maintenance-schedule');
        Route::get('/asset-depreciation', [ReportController::class, 'assetDepreciation'])->name('asset-depreciation');
    });
});

// User Routes - Only dashboard and profile
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});

// require __DIR__.'/auth.php'; // Commented out to use custom authentication

