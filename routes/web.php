<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\AssetMovementController;
use App\Http\Controllers\Admin\InspectionController;
use App\Http\Controllers\Admin\MaintenanceRecordController;
use App\Http\Controllers\Admin\DisposalController;
use App\Http\Controllers\Admin\LossWriteoffController;
use App\Http\Controllers\Admin\ImmovableAssetController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\MasjidSurauController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuditTrailController;
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
    
    // Legacy profile redirect - redirect to appropriate profile based on role
    Route::get('/profile', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.profile.edit');
        } else {
            return redirect()->route('user.profile.edit');
        }
    })->name('profile.edit');
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

    // Settings - Masjid/Surau Management
    Route::resource('masjid-surau', MasjidSurauController::class);
    Route::patch('masjid-surau/{masjidSurau}/toggle-status', [MasjidSurauController::class, 'toggleStatus'])->name('masjid-surau.toggle-status');
    Route::post('masjid-surau/bulk-delete', [MasjidSurauController::class, 'bulkDelete'])->name('masjid-surau.bulk-delete');
    
    // Settings - Audit Trails
    Route::prefix('audit-trails')->name('audit-trails.')->group(function () {
        Route::get('/', [AuditTrailController::class, 'index'])->name('index');
        Route::get('/export/csv', [AuditTrailController::class, 'export'])->name('export');
        Route::post('/cleanup', [AuditTrailController::class, 'cleanup'])->name('cleanup');
        Route::get('/user-activity/json', [AuditTrailController::class, 'userActivity'])->name('user-activity');
        Route::get('/{auditTrail}', [AuditTrailController::class, 'show'])->name('show');
    });
    
    // Admin Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [AdminProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [AdminProfileController::class, 'update'])->name('update');
        Route::put('/password', [AdminProfileController::class, 'updatePassword'])->name('password');
        Route::get('/settings', [AdminProfileController::class, 'settings'])->name('settings');
        Route::patch('/settings', [AdminProfileController::class, 'updateSettings'])->name('settings.update');
        Route::get('/activity', [AdminProfileController::class, 'activity'])->name('activity');
        Route::delete('/', [AdminProfileController::class, 'destroy'])->name('destroy');
    });
});

// User Routes - Only dashboard and profile
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // User Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [UserProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [UserProfileController::class, 'update'])->name('update');
        Route::put('/password', [UserProfileController::class, 'updatePassword'])->name('password');
        Route::get('/activity', [UserProfileController::class, 'activity'])->name('activity');
        Route::delete('/', [UserProfileController::class, 'destroy'])->name('destroy');
    });
});

// require __DIR__.'/auth.php'; // Commented out to use custom authentication

