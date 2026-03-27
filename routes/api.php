<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DisciplineRecordController;
use App\Http\Controllers\Api\IncidentTypeController;
use App\Http\Controllers\Api\SetupController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UserManagementController;
use App\Http\Controllers\Api\MadrasaController;
use Illuminate\Support\Facades\Route;

// ------------------------
// Setup routes (public)
// ------------------------
Route::get('/setup/status', [SetupController::class, 'status']);
Route::post('/setup', [SetupController::class, 'store']);

// ------------------------
// Auth routes (public)
// ------------------------
Route::post('/login', [AuthController::class, 'login']);

// ------------------------
// Protected routes (Sanctum + Madrasa middleware)
// ------------------------
Route::middleware(['auth:sanctum', 'madrasa'])->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Students CRUD
    Route::apiResource('students', StudentController::class);

    // Discipline Records CRUD
    Route::apiResource('discipline-records', DisciplineRecordController::class);

    // Incident Types CRUD
    Route::apiResource('incident-types', IncidentTypeController::class);

    // Madrasa Settings
    Route::get('/madrasa-info', [MadrasaController::class, 'show']);
    Route::post('/madrasa-info', [MadrasaController::class, 'update']); // multipart/form-data for logo

    // ------------------------
    // User Management (Admin only)
    // ------------------------
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [UserManagementController::class, 'index']);
        Route::post('/users', [UserManagementController::class, 'store']);
        Route::get('/users/{id}', [UserManagementController::class, 'show']);
        Route::put('/users/{id}', [UserManagementController::class, 'update']);
        Route::patch('/users/{id}/toggle-status', [UserManagementController::class, 'toggleStatus']);
        Route::delete('/users/{id}', [UserManagementController::class, 'destroy']);
    });
});