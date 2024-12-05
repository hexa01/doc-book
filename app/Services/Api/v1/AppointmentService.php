<?php

namespace App\Services\Api\v1;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentService
{

    public function validateAppointmentStatus(Appointment $appointment, Request $request)
    {
        $request->validate([
            'status' => 'required|in:completed,missed',
        ], [
            'status.in' => 'The status must be updated to either completed or missed.',
        ]);
        if (Carbon::parse($appointment->appointment_date)->isFuture()) {
            return response()->json([
                'success' => false,
                'error' => 'You cannot update the appointment status for a future date.',
            ], 401);
        }
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
        return $available_slots;

    }
}
