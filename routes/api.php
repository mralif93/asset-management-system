<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AssetController as ApiAssetController;
use App\Http\Controllers\Api\InspectionController as ApiInspectionController;
use App\Http\Controllers\Api\DisposalController as ApiDisposalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API routes for mobile app integration and external access.
| All routes are prefixed with /api/v1
|
*/

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {

    // Assets API
    Route::get('/assets', [ApiAssetController::class, 'index']);
    Route::get('/assets/summary', [ApiAssetController::class, 'summary']);
    Route::get('/assets/{asset}', [ApiAssetController::class, 'show']);

    // Inspections API
    Route::get('/inspections', [ApiInspectionController::class, 'index']);
    Route::get('/inspections/upcoming', [ApiInspectionController::class, 'upcoming']);
    Route::get('/inspections/overdue', [ApiInspectionController::class, 'overdue']);
    Route::get('/inspections/{inspection}', [ApiInspectionController::class, 'show']);

    // Disposals API
    Route::get('/disposals', [ApiDisposalController::class, 'index']);
    Route::get('/disposals/pending', [ApiDisposalController::class, 'pending']);
    Route::get('/disposals/summary', [ApiDisposalController::class, 'summary']);
    Route::get('/disposals/{disposal}', [ApiDisposalController::class, 'show']);
});

// Public API routes (if needed)
Route::prefix('v1')->group(function () {
    // Add public routes here if needed
});
