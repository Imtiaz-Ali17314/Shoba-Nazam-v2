<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DisciplineRecordController;
use App\Http\Controllers\Api\IncidentTypeController;
use App\Http\Controllers\Api\SetupController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Support\Facades\Route;

// Setup routes
Route::get('/setup/status', [SetupController::class, 'status']);
Route::post('/setup', [SetupController::class, 'store']);

// Auth routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (Sanctum)
Route::middleware(['auth:sanctum', 'madrasa'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); // Logout
    Route::get('/user', [AuthController::class, 'user']);       // Current logged-in user info

    Route::apiResource('students', StudentController::class);              // CRUD students
    Route::apiResource('discipline-records', DisciplineRecordController::class); // CRUD discipline records
    Route::apiResource('incident-types', IncidentTypeController::class);   // CRUD incident types

    Route::get('/dashboard', [DashboardController::class, 'index']);      // Dashboard data

    // User Management (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Api\UserManagementController::class, 'index']);
        Route::post('/users', [\App\Http\Controllers\Api\UserManagementController::class, 'store']);
        Route::get('/users/{id}', [\App\Http\Controllers\Api\UserManagementController::class, 'show']);
        Route::put('/users/{id}', [\App\Http\Controllers\Api\UserManagementController::class, 'update']);
        Route::delete('/users/{id}', [\App\Http\Controllers\Api\UserManagementController::class, 'destroy']);
        Route::post('/users/{id}/toggle-status', [\App\Http\Controllers\Api\UserManagementController::class, 'toggleStatus']);
    });
});

//  Student routes
// GET /api/students?search=ali&page=1  --> List with pagination

// DisciplineRecord routes
// GET /api/discipline-records?from_date=2026-01-01&to_date=2026-01-31  --> Date Range
// GET /api/discipline-records?date=2026-01-15   --->   Single Date
// GET /api/discipline-records?student_id=5  ---> Student Filter
// GET /api/discipline-records?incident_type_id=2  --->  Incident Type Filter
// GET /api/discipline-records?student_id=5&incident_type_id=2&from_date=2026-01-01&to_date=2026-01-31    ---> Combined filters

// IncidentType routes
// GET /api/incident-types?search=later&page=1  --> List with pagination
