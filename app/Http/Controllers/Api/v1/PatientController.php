<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Requests\Api\v1\UpdateUserRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\v1\BaseController;


class PatientController extends BaseController
{
    /**
     * View all Patients
     */
    public function index()
    {
        if(Auth::user()->role !== 'admin'){
            return $this->errorResponse('Forbidden Access',403);
        }
        $patients = Patient::with('user')->get();

        if ($patients->isEmpty()) {
            return $this->errorResponse('No patients found',404);
        }
        return $this->successResponse('Patients retrieved successfully', $patients);
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
     * Update Patient.
     */
    public function update(UpdateUserRequest $request, string $id)
    {

        if(!($user = User::find($id))){
            return $this->errorResponse('User not found', 404);
        };
        if((Auth::user()->id != $id) && Auth::user()->role !== 'admin'){
            return $this->errorResponse('Forbidden Access', 403);
        };

        if ($request->filled('current_password') && Auth::user()->role !== 'admin') {
            if (!Hash::check($request->current_password, $user->password)) {
                return $this->errorResponse('The current password is incorrect.',400);
            }
        }

        // Prepare the data to update
        $input = $request->only(['name', 'email', 'phone', 'address']);

        // Update the password only if provided
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->input('password'));
        }

        $user->update($input);
        return $this->successResponse('User updated successfully!', $user);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

        /**
     * View my Profile
     */
    public function view(){
        $patient = Patient::with('user')->where('user_id', Auth::user()->id)->first();
        return $this->successResponse('Your information retrieved successfully', $patient);
    }
}
