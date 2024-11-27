<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Specialization;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'patient') {
            $id = Auth::user()->patient->id;
            $appointments = Appointment::where('patient_id', $id)->orderBy('appointment_date', 'desc')->orderBy('start_time', 'asc')->paginate(5);
        } elseif (Auth::user()->role == 'doctor') {
            $id = Auth::user()->doctor->id;
            $appointments = Appointment::where('doctor_id', $id)->orderBy('appointment_date', 'desc')->orderBy('start_time', 'asc')->paginate(5);
        } else {
            abort(403, 'Unauthorized access');
        }

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {   
        abort_if((Auth::user()->role != 'patient'), 404);

        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:' . Carbon::tomorrow()->toDateString(),
            'doctor_id' => 'required|exists:doctors,id',
        ]);
        

        $doctor = Doctor::findOrFail($request->doctor_id);
        $appointment_date = Carbon::parse($request->appointment_date);
        $appointment_day = $appointment_date->englishDayOfWeek;
        $schedule = $doctor->schedules->where('day', $appointment_day)->first();

        if (!$schedule) {
            return redirect()->back()->with('error', 'No schedule found for this doctor on the selected day.');
        }

            $startTime = Carbon::parse($schedule->start_time);
            $endTime = Carbon::parse($schedule->end_time);
            $total_duration = $startTime->diffInMinutes($endTime);
            $slots = $total_duration / 30;
            $available_slots = [];
            for ($i = 0; $i < $slots; $i++) {
                $available_slots[] = $startTime->format('H:i');  
                $startTime->addMinutes(30);
            }
            
            $booked_slots = Appointment::where('doctor_id', $doctor->id)->whereDate('appointment_date', $appointment_date)
            ->pluck('start_time')->toArray();

            $available_slots = array_filter($available_slots, function($slot) use ($booked_slots) {
                return !in_array($slot, $booked_slots);
            });


            return view('appointments.create', compact('doctor', 'available_slots', 'appointment_date'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!(Auth::user()), 404);
        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:' . Carbon::tomorrow()->toDateString(),
            'start_time' => 'required|date_format:H:i',
        ]);
        
        $patient = Patient::where('user_id', Auth::id())->first();
        $patientId = $patient->id;
        
        $appointment = Appointment::create([
            'patient_id' => $patientId,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
        ]);

        $price = 500;

        Payment::create([
            'appointment_id' => $appointment->id,
            'amount' => $price,
            'status' => 'unpaid',
        ]);

        return to_route('appointments.index')->with('message',"Appointment has been booked successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(!(Auth::user()), 403);
        $appointment = Appointment::findOrFail($id);
        if ($appointment->status == 'completed' && $appointment->status == 'paid') {
            abort(403, 'Cannot update a completed appointment.');
        }
        abort_if(($appointment->patient->user_id !== Auth::id()),404);

        $doctor = $appointment->doctor;
        $appointment_date = Carbon::parse($appointment->appointment_date);
        $appointment_day = $appointment_date->englishDayOfWeek;
        $schedule = $doctor->schedules->where('day', $appointment_day)->first();

        $appointment_time = Carbon::parse($appointment->start_time);
        $startTime = Carbon::parse($schedule->start_time);
        $endTime = Carbon::parse($schedule->end_time);
        $total_duration = $startTime->diffInMinutes($endTime);
        $slots = $total_duration / 30;
        $available_slots = [];
        for ($i = 0; $i < $slots; $i++) {
            $available_slots[] = $startTime->format('H:i');  
            $startTime->addMinutes(30);
        }

        $booked_slots = Appointment::where('doctor_id', $doctor->id)->whereDate('appointment_date', $appointment_date)
        ->pluck('start_time')->toArray();

        $available_slots = array_filter($available_slots, function($slot) use ($booked_slots) {
            return !in_array($slot, $booked_slots);
        });
        $available_slots[] = $appointment_time->format('H:i');

        sort($available_slots);
        return view('appointments.edit', compact('available_slots', 'appointment','appointment_date'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(!(Auth::user()), 404);
        $appointment = Appointment::findOrFail($id);
        if ($appointment->status == 'completed') {
            abort(403, 'Cannot update a completed appointment.');
        }
        
        abort_if(($appointment->patient->user_id !== Auth::id()),404);
        $request->validate([
            'start_time' => 'required|date_format:H:i',
        ]);

        $appointment->update([
            'start_time' => $request->start_time,
        ]);
        session()->flash('message', 'Appointment updated successfully!');
        return to_route('appointments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        session()->flash('message', 'Appointment deleted successfully!');
        return redirect()->route('appointments.index');
    }

    public function appointmentsManage()
    {
        abort_if((Auth::User()->role == 'admin'),404);
        //update appointments status to completed if the time is in the past
        Appointment::where(function ($query) {
            $query->where('appointment_date', '<', Carbon::today())
                ->orWhere(function ($subQuery) {
                    $subQuery->where('appointment_date', Carbon::today())
                        ->where('end_time', '<', Carbon::now()->format('H:i:s'));
                });
        })->update(['status' => 'completed']);

        //delete appointments which are more than 4 year old
        Appointment::where('appointment_date', '<', Carbon::now()->subYears(4))->delete();

        if (Auth::user()->role == 'doctor') {
            $id = Auth::user()->doctor->id;
            $appointments = Appointment::where('doctor_id', $id)->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'desc')->orderBy('start_time', 'desc')->get();
            $count = $appointments->count();
            $patientCount = Appointment::where('doctor_id', $id)->distinct('patient_id')->count('patient_id');

        } elseif (Auth::user()->role == 'patient') {
            $id = Auth::user()->patient->id;
            $patientCount = 0;
            $appointments = Appointment::where('patient_id', $id)->orderBy('appointment_date', 'desc')->orderBy('start_time', 'desc')->get();
            $count = $appointments->filter(function ($appointment) {
                return Carbon::parse($appointment->appointment_date)->isFuture() ||
                    (Carbon::parse($appointment->appointment_date)->isToday() && Carbon::parse($appointment->start_time)->isAfter(Carbon::now()));
            })->count();
        }

        return view('dashboard', compact('appointments', 'count','patientCount'));
    }
    public function showSpecializations()
    {

        $specializations = Specialization::all();
        return view('appointments.specialization', compact('specializations'));
        // $speciality = $request -> speciality;
    }
    public function showDoctors(Request $request)
    {
        $specialization_id = $request->specialization;
        $specialization = Specialization::findOrFail($specialization_id);
        $doctors = Doctor::where('specialization_id', $specialization_id)->get();
        return view('appointments.name-fetch', compact('doctors', 'specialization'));
    }
    public function showDate(Request $request)
    {
        $doctor = Doctor::findOrFail($request->doctor_id);
        return view('appointments.slots', compact('doctor'));
    }

    public function editReview(Appointment $appointment)
    {
        abort_if(!((Auth::user()->id == $appointment->doctor->user->id)), 404);
        
        return view('reviews.edit', compact('appointment'));
    }

    public function updateReview(Request $request, Appointment $appointment)
    {
        abort_if(!((Auth::user()->id == $appointment->doctor->user->id)), 404);
        
        $request->validate([
            'review' => 'required|string|max:1000',  
        ]);

        
        $appointment->update([
            'review' => $request->review,
        ]);

        
        return redirect()->route('doctor.patients', $appointment)->with('message', 'Review updated successfully!');
    }

    public function patientReviews()
    {
        abort_if(!(Auth::user()), 404);
        $appointments = Appointment::where('patient_id', Auth::id())->whereNotNull('review')->get();
        return view('reviews.index', compact('appointments'));
    }

}

