<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseController;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Payment;
use App\Services\Api\v1\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends BaseController
{
    //appointment controller route sabaile access garna milxa aile fix it

    protected $appointmentService;
    // Inject the service via the constructor
    public function __construct(AppointmentService $appointmentService,)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * View Appointments
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


        //for admin
$data['appointments'] = $appointments->map(function ($appointment) {
                    return [
                        'id' => $appointment->id,
                        'date' => $appointment->appointment_date,
                        'slot' => $appointment->start_time,
                        'status' => $appointment->status,
                        'doctor_id' => $appointment->doctor_id,
                        'doctor_name' => $appointment->doctor->user->name,
                        'doctor_specialization' => $appointment->doctor->specialization->name,
                        'patient_id' => $appointment->patient_id,
                        'patient_name' => $appointment->patient->user->name,
                        'patient_email' => $appointment->patient->user->email,
                    ];
                });

        return $this->successResponse('Your appointments retrieved successfully', $data, 200);
    }

    /**
     * Create Appointment
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
        if(!$doctor = Doctor::find($request->doctor_id)){
            $this->errorResponse('The selected doctor id doesnt exist', 404);
        }
        $appointment_date = Carbon::parse($request->appointment_date);
        $available_slots = $this->appointmentService->generateAvailableSlots($doctor, $appointment_date);
        if (empty($available_slots)) {
            $this->errorResponse('There is no slots available for this day,Please choose another day', 404);
        }
        $slot = Carbon::parse($request->slot)->format('H:i');
        if (!in_array($slot, $available_slots)) {
            return $this->errorResponse('This slot is not available', 404);
        }

        $patientId = (Patient::where('user_id', Auth::id())->first())->id;
        if(Auth::user()->role)
        $appointment = Appointment::create([
            'patient_id' => $patientId,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $appointment_date,
            'start_time' => $slot,
            'status' => 'booked',
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
     * Update Appointment
     */
    public function update(Request $request, string $id)
    {
        if(!($appointment = Appointment::find($id))){
            return $this->errorResponse('Appointment not found', 404);
        }

        $payment = Payment::where('appointment_id',$appointment->id)->first();
        if ($payment->status == 'paid') {
            return $this->errorResponse('Cannot update already booked appointment', 403);
        }
        elseif ($appointment->status == 'completed') {
            return $this->errorResponse('Cannot update already completed appointment', 403);
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
        $appointment_date = Carbon::parse($request->appointment_date);
        $available_slots = $this->appointmentService->generateAvailableSlots($doctor, $appointment_date);

        if (empty($available_slots)) {
            return $this->errorResponse('There is no slot available for this day,Please choose another day', 404);
        }

        if (!in_array($slot, $available_slots)) {
            return $this->errorResponse('This slot is not available', 404);
        }

            $appointment->update([
                'appointment_date' => $appointment_date,
                'start_time' => $slot,
            ]);
            return $this->successResponse('Appointment updated successfully.', $appointment);

    }

    /**
     * Delete Appointment
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

        /**
     * Update Appointment Status
     */
    public function updateAppointmentStatus(Request $request, string $id)
    {
        $doctor = Auth::user()->doctor;
        if(!($appointment = Appointment::where('doctor_id', $doctor->id)->where('id', $id)->first())){
            return $this->errorResponse("Your appointment not found by this id", 404);
        }

        $this->appointmentService->validateAppointmentStatus($appointment, $request);

        $appointment->update([
            'status'=> $request->status,
        ]);

        return $this->successResponse('Patients information retrieved successfully', $appointment);
    }

        /**
     * Update History of Completed Appointments
     */
    public function updateHistory(Request $request, string $id)
    {
        $doctor = Auth::user()->doctor;
        if(!($appointment = Appointment::where('doctor_id', $doctor->id)->where('id', $id)->first())){
            return $this->errorResponse("Your appointment not found by this id", 404);
        }
        $request->validate([
            'history' => 'required|string|max:1000',
        ]);
        $appointment->update([
            'history' => $request->history,
        ]);
        return $this->successResponse('Patient History updated successfully.', $appointment);
    }
}
