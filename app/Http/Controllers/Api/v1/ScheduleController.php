<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseController;
use App\Models\Appointment;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends BaseController
{
    /**
     * Display logged in doctors schedule.
     */
    public function index()
    {
        $schedules = Schedule::where('doctor_id', Auth::user()->doctor->id)->select('day', 'start_time', 'end_time')->get()
            ->sortBy(function ($schedule) {
                $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                return array_search($schedule->day, $days);
            });
        return $this->successResponse('Your schedules retrieved successfully', $schedules, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update Schedule.
     */
    public function update(Request $request, string $id)
    {
        $day = ucfirst(strtolower($id));
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        if (!in_array($day, $days)) {
            return $this->errorResponse('This is not a valid day', 404);
        }

        $doctor = Auth::user()->doctor;
        $doctor_id = Auth::user()->doctor->id;

        $appointment_dates = Appointment::where('doctor_id', $doctor_id)->distinct()->pluck('appointment_date')->toArray();
        $appointment_days = array_map(function ($date) {
            return Carbon::parse($date)->englishDayOfWeek;
        }, $appointment_dates);
        if (in_array($day, $appointment_days)) {
            return $this->errorResponse('Appointment exists in this day. You cant update a schedule on this day.', 403);
        }

        $schedule = Schedule::where('doctor_id', $doctor_id)->where('day', $day)->first();

        $start_time = Carbon::parse($request->start_time);
        $end_time = Carbon::parse($request->end_time);
        $duration = $start_time->diffInMinutes($end_time);

        // $slots = $duration / 30;
        $slots = intdiv($duration, 30);

        if ($schedule) {
            $start_time = Carbon::parse($request->start_time)->format('H:i');
            $end_time = Carbon::parse($request->end_time)->format('H:i');
            $schedule->update([
                'start_time' => $start_time,
                'end_time' => $end_time,
                'slots' => $slots,
            ]);
            return $this->successResponse('Your schedule updated successfully', $schedule, 200);
        } else {
            return $this->errorResponse('Schedule not found', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
