<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
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
        $patient = Patient::where('user_id', Auth::id())->first();
        $patientId = $patient->id;
        $appointments = Appointment::where('patient_id', $patientId)->orderBy('appointment_date', 'desc')->orderBy('start_time', 'desc')->get();
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $specialization_id = $request -> specialization;
        $doctors = Doctor::where('specialization_id',$specialization_id)->get();
        return view('appointments.create',compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $patient = Patient::where('user_id', Auth::id())->first();
       $patientId = $patient->id;
        Appointment::create([
            'patient_id' => $patientId,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
        return to_route('appointments.index');

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
        $appointment = Appointment::findOrFail($id);
        $specialization_id = $appointment->doctor->specialization_id;
        $doctors = Doctor::where('specialization_id', $specialization_id)->get();
        return view('appointments.edit',compact('doctors','appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);
         $appointment->update([
             'doctor_id' => $request->doctor_id,
             'appointment_date' => $request->appointment_date,
             'start_time' => $request->start_time,
             'end_time' => $request->end_time,
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
}
