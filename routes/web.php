<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SpecializationController;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [AppointmentController::class, 'appointmentsManage'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile-delete', [ProfileController::class, 'deleteForm'])->name('profile.delete.form');
    Route::delete('/profile-delete', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::Resource('patients', PatientController::class);
    Route::get('/specialization', [AppointmentController::class, 'showSpecializations'])->name('appointments.specialization');
    Route::get('/name-fetch', [AppointmentController::class, 'showDoctors'])->name('appointments.name-fetch');
    Route::get('/slots', [AppointmentController::class, 'showDate'])->name('appointments.slots');
    Route::get('doctor/patients', [DoctorController::class, 'showPatients'])->name('doctor.patients');
    Route::Resource('doctors', DoctorController::class);
    Route::get('patient/reviews', [AppointmentController::class, 'patientReviews'])->name('appointments.patientReviews');
    Route::get('appointments/{appointment}/edit-review', [AppointmentController::class, 'editReview'])->name('appointments.editReview');
    Route::put('appointments/{appointment}/update-review', [AppointmentController::class, 'updateReview'])->name('appointments.updateReview');
    Route::Resource('appointments', AppointmentController::class);
    Route::Resource('admins', AdminController::class);
    Route::Resource('specializations', SpecializationController::class);
    Route::post('userregister', [RegisteredUserController::class, 'store'])->name('admin.user.store');
    Route::resource('schedules', ScheduleController::class);
});

require __DIR__ . '/auth.php';
