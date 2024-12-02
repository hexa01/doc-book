<?php

use App\Http\Controllers\Api\v1\DoctorController;
use App\Http\Controllers\Api\v1\AdminController;
use App\Http\Controllers\Api\v1\PatientController;
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

        Route::middleware('role:admin')->group( function () {
            Route::apiResource('users',UserController::class);
            Route::apiResource('admins',AdminController::class);
        });

        Route::middleware('role:admin,doctor')->group( function () {
            Route::apiResource('doctors',DoctorController::class);
        });

        Route::middleware('role:admin,patient')->group( function () {
            Route::apiResource('patients',PatientController::class);
        });



        Route::apiResource('patients',PatientController::class);
        Route::apiResource('doctors',PatientController::class);
        Route::post('/logout', [UserAuthController::class, 'logout']);


    });
});
