<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseController;
use App\Http\Requests\Api\v1\UpdateUserRequest;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DoctorController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role !== 'admin'){
            return $this->errorResponse('Forbidden Access',403);
        }

        // $doctors = User::where('role', 'doctor')->get();
        $doctors = Doctor::with('user')->with('specialization')->get();
        if ($doctors->isEmpty()) {
            return $this->errorResponse('No doctors',404);
        }
        return $this->successResponse('Doctors retrieved successfully', $doctors);
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
    public function update(UpdateUserRequest $request, string $id)
    {
        if(!$user = User::find($id)){
            return $this->errorResponse('User not found', 404);
        };

        if((Auth::user()->id != $id) && Auth::user()->role !== 'admin'){
            return $this->errorResponse('Forbidden Access', 403);
        };

        $doctor = Doctor::where('user_id', $id)->first();
        if (!$doctor) {
            return $this->errorResponse('This user is not a doctor', 404);
        }


        if ($request->filled('current_password') && Auth::user()->role !== 'admin') {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'The current password is incorrect.'
                ], 400);
            }
        }

        // Prepare the data to update
        $input = $request->only(['name', 'email', 'phone', 'address', 'specialization_id']);


        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->input('password'));
        }

        $user->update($input);

        if ($request->filled('specialization_id')) {
            $doctor->update([
                'specialization_id' => $request('specialization_id')
            ]);
        }

        $doctor = Doctor::with('user')->where('user_id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'data' => $doctor
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function view(){
        $doctor = Doctor::with('user')->where('user_id', Auth::user()->id)->first();
        return $this->successResponse('Your information retrieved successfully', $doctor);
    }

    public function viewPatients()
    {
        $doctor = Auth::user()->doctor;
        $appointments = $doctor->appointments()->with('patient.user')->where('status', 'completed')->get();
        $patients = $appointments->map(function ($appointment) {
            return $appointment->patient->user;
        })->unique('id');
        $patientsInfo = $patients->map(function ($user) {
            return [
                'name' => $user->name,
                'address' => $user->address,
                'phone' => $user->phone,
            ];
        });

        return $this->successResponse('Patients information retrieved successfully', $patientsInfo);
    }
}
