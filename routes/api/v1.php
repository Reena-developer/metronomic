<?php

use App\Http\Controllers\Api\V1\PatientMealPlanningController;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->as('v1.')->group(function () {
    Route::prefix('meal-plan')->as('meal-plan.')->group(function () {
        Route::post('/list', [PatientMealPlanningController::class, 'getRecordsByDateRange'])->name('list');
    });
});