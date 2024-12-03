<?php

use App\Http\Controllers\Api\v1\DoctorController;
use App\Http\Controllers\Api\v1\AdminController;
use App\Http\Controllers\Api\v1\AppointmentController;
use App\Http\Controllers\Api\v1\PatientController;
use App\Http\Controllers\Api\v1\ScheduleController;
use App\Http\Controllers\Api\v1\SpecializationController;
use App\Http\Controllers\Api\v1\UserAuthController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    Route::post('/login', [UserAuthController::class, 'login'])->name('api.login');
    Route::post('/register', [UserAuthController::class, 'register'])->name('api.register');

    Route::group(['middleware' => "auth:sanctum"], function () {
        Route::post('/logout', [UserAuthController::class, 'logout']);
        Route::get('/specializations', [SpecializationController::class, 'index'])->name('api.specializations.index');
        Route::apiResource('appointments',AppointmentController::class);

        Route::middleware('role:patient')->group( function () {
            Route::get('/patient-view', [PatientController::class, 'view'])->name('api.patients.view');
        });
        Route::middleware('role:doctor')->group( function () {
            Route::get('/doctor-view', [DoctorController::class, 'view'])->name('api.doctors.view');
            Route::get('/patients-view', [DoctorController::class, 'viewPatients'])->name('api.doctors.patients.view');
        });


        Route::middleware('role:admin')->group( function () {
            Route::post('/specializations', [SpecializationController::class, 'store'])->name('api.specializations.store');
            Route::put('/specializations/{specialization}', [SpecializationController::class, 'update'])->name('api.specializations.update');
            Route::delete('/specializations/{specialization}', [SpecializationController::class, 'destroy'])->name('api.specializations.delete');
            Route::apiResource('users',UserController::class);
            Route::apiResource('admins',AdminController::class);
        });

        Route::middleware('role:admin,doctor')->group( function () {
            Route::apiResource('doctors',DoctorController::class);
        });

        Route::middleware('role:admin,patient')->group( function () {
            Route::apiResource('patients',PatientController::class);
        });

        Route::apiResource('/schedules',ScheduleController::class)->middleware('role:doctor');

    });
});
