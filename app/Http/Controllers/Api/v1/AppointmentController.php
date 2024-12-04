<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseController;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (Auth::user()->role == 'patient') {
            $id = Auth::user()->patient->id;
            $appointments = Appointment::where('patient_id', $id)->orderBy('appointment_date', 'desc')->orderBy('start_time', 'asc')->get();
        } elseif (Auth::user()->role == 'doctor') {
            $id = Auth::user()->doctor->id;
            $appointments = Appointment::where('doctor_id', $id)->orderBy('appointment_date', 'desc')->orderBy('start_time', 'asc')->get();
        } else {
            //for admins code coming in future right now forbidden access
            return $this->errorResponse('Forbidden Access', 403);
        }

        if ($appointments->isEmpty()) {
            return $this->errorResponse('No appointments found',404);
        }
        return $this->successResponse('Your appointments retrieved successfully', $appointments, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:' . Carbon::tomorrow()->toDateString(),
            'slot' => 'required|date_format:H:i',
            'patient_id' => ['nullable', 'exists:patients,id', function ($attribute,$value, $fail){
                if (Auth::user()->role === 'admin' && empty($value)){
                    return $this->errorResponse('Please input patient id.');
                }
            }]
        ]);
        $slot = Carbon::parse($request->slot)->format('H:i');
        if(!($doctor = Doctor::find($request->doctor_id))){
            $this->errorResponse('The selected doctor id doesnt exist', 404);
        }
        $available_slots = $this->generateAvailableSlots($doctor, $request->appointment_date);
        if (empty($available_slots)) {
            $this->errorResponse('There is no slots available for this day,Please choose another day', 404);
        }
        if (!in_array($slot, $available_slots)) {
            $this->errorResponse('This slot is not available', 404);
        }

        $patientId = (Patient::where('user_id', Auth::id())->first())->id;
        if(Auth::user()->role)
        $appointment = Appointment::create([
            'patient_id' => $patientId,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'start_time' => $slot,
        ]);
        $price = 500;
        Payment::create([
            'appointment_id' => $appointment->id,
            'amount' => $price,
            'status' => 'unpaid',
        ]);
        return $this->successResponse('Appointment Created Successfully',$appointment);

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
        if(!($appointment = Appointment::find($id))){
            return $this->errorResponse('Appointment not found', 404);
        }
        if ($appointment->status == 'completed' && $appointment->status == 'paid') {
            return $this->errorResponse('Cannot update a completed appointment', 403);
        }

        $doctor = $appointment->doctor;
        $request->validate([
            'appointment_date' => 'nullable|date|after_or_equal:' . Carbon::tomorrow()->toDateString(),
            'slot' => 'required|date_format:H:i',
            'patient_id' => ['nullable', 'exists:patients,id', function ($attribute,$value, $fail){
                if (Auth::user()->role === 'admin' && empty($value)){
                    return $this->errorResponse('Please input patient id.');
                }
            }]
        ]);
        $slot = Carbon::parse($request->slot)->format('H:i');
        $available_slots = $this->generateAvailableSlots($doctor, $request->appointment_date);

        if (empty($available_slots)) {
            return $this->errorResponse('There is no slot available for this day,Please choose another day', 404);
        }

        if (!in_array($slot, $available_slots)) {
            return $this->errorResponse('This slot is not available', 404);
        }

            $appointment->update([
                'appointment_date' => $request->appointment_date,
                'start_time' => $slot,
            ]);
            return $this->successResponse('Appointment updated successfully.', $appointment);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!($appointment = Appointment::find($id))){
            return $this->errorResponse('Appointment not found', 404);
        }
        if($appointment->delete()){
            return $this->successResponse('Appointment deleted successfully', null);
        }
    }
}
