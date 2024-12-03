<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseController;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends BaseController
{
    /**
     * Display a listing of the resource.
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $day = ucfirst(strtolower($id));
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        //in_array(strtolower($value), array_map('strtolower', $array))
        if (!in_array($day, $days)) {
            $this->errorResponse('This is not a valid day', 404);
        }
        $doctor_id = Auth::user()->doctor->id;
        $schedule = Schedule::where('doctor_id', $doctor_id)->where('day', $day)->first();

        if ($schedule) {
            $schedule->update([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);
            return $this->successResponse('Your schedule updated successfully', $schedule, 200);
        } else {
            $this->errorResponse($schedule, 404);
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
