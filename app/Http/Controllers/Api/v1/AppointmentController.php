<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseController;
use App\Models\Appointment;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
