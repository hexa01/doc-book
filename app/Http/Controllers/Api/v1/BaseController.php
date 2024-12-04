<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function successResponse($message, $result, $code = 200){
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $result,
        ], $code);
    }
    public function errorResponse($error, $code = 400){
        return response()->json([
            'success' => false,
            'error' => $error,
        ], $code);
    }

    public function generateAvailableSlots($doctor, $appointment_date)
{

    $appointment_date = Carbon::parse($appointment_date);
    $appointment_day = $appointment_date->englishDayOfWeek;
    $schedule = $doctor->schedules->where('day', $appointment_day)->first();
    $slots = $schedule->slots;
    $start_time = Carbon::parse($schedule->start_time);
    $available_slots = [];
    for ($i = 0; $i < $slots; $i++) {
        $available_slots[] = $start_time->format('H:i');
        $start_time->addMinutes(30);
    }
    $booked_slots = Appointment::where('doctor_id', $doctor->id)->whereDate('appointment_date', $appointment_date)
    ->pluck('start_time')->toArray();
    $available_slots = array_filter($available_slots, function($slot) use ($booked_slots) {
        return !in_array($slot, $booked_slots);
    });

    $booked_slots = Appointment::where('doctor_id', $doctor->id)->whereDate('appointment_date', $appointment_date)
    ->pluck('start_time')->toArray();
    $available_slots = array_filter($available_slots, function($slot) use ($booked_slots) {
        return !in_array($slot, $booked_slots);
    });
    return $available_slots;
}




}
