<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecializationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::Resource('patients',PatientController::class);
    Route::get('/specialization',[DoctorController::class, 'showSpecialization'])->name('doctor.specialization');
    Route::Resource('doctors',DoctorController::class);
    Route::Resource('appointments',AppointmentController::class);
    Route::Resource('admins',AdminController::class);
    Route::Resource('specializations',SpecializationController::class);
});

require __DIR__.'/auth.php';
