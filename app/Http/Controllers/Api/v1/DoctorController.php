<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $doctors = User::where('role', 'doctor')->get();
        $doctors = Doctor::with('user')->with('specialization')->get();
        // $doctors = User::where('role', 'doctor')->with('specialization')->get();
        if ($doctors->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No doctors found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Doctors retrieved successfully',
            'data' => $doctors,
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
    public function update(Request $request, string $id)
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
        $input = $request->only(['name', 'email', 'phone', 'address', 'specialization_id']);


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
