<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\UpdateUserRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $patients = User::where('role', 'patient')->get();
        $patients = Patient::with('user')->get();
        if ($patients->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No patients found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Patients retrieved successfully',
            'data' => $patients,
        ], 200);
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
        $user = User::findOrFail($id);

        if ($request->filled('current_password') && Auth::user()->role !== 'admin') {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'The current password is incorrect.'
                ], 400);
            }
        }

        // Prepare the data to update
        $input = $request->only(['name', 'email', 'phone', 'address']);

        // Update the password only if provided
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->input('password'));
        }

        $user->update($input);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'data' => $user
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
