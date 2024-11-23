<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        abort_if(!((Auth::user()->role == 'doctor' )), 404);
        $schedules = Schedule::where('doctor_id', Auth::user()->doctor->id)->get()
        ->sortBy(function($schedule) {
            $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            return array_search($schedule->day, $days);
        });

        return view('schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!((Auth::user()->role == 'doctor' )), 404);
        return view('schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        abort_if(!((Auth::user()->role == 'doctor' )), 404);
        $schedule = Schedule::where('doctor_id', Auth::user()->doctor->id)->where('day',$request->day)->get();
        if ($schedule->isNotEmpty()) {
            return redirect()->route('schedules.index')->with('error', 'Schedule already exists for this day.');
        }

        $request->validate([
            'day' => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);
        $duration = $startTime->diffInMinutes($endTime);
        $slots = $duration / 30;




        Schedule::create([
            'doctor_id' => Auth::user()->doctor->id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'slots' => $slots,
        ]);

        return redirect()->route('schedules.index')->with('message', 'Schedule created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(!((Auth::user()->role == 'doctor' )), 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        abort_if(!((Auth::user()->id == $schedule->doctor->user->id)), 404);
        return view('schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        $schedule = Schedule::findOrFail($id);
        abort_if(!((Auth::user()->id == $schedule->doctor->user->id)), 404);
        $request->validate([
            'day' => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);
        $duration = $startTime->diffInMinutes($endTime);
        $slots = $duration / 30;

        $schedule->update([
            'doctor_id' => Auth::user()->doctor->id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'slots' => $slots,
        ]);

        return redirect()->route('schedules.index')->with('message', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        abort_if(!((Auth::user()->id == $schedule->doctor->user->id)), 404);
        $schedule->delete();
        return redirect()->route('schedules.index')->with('message', 'Schedule deleted successfully.');

    }
}
