<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\RegisterRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * View all Users.
     */
    public function index()
    {
        $users = User::query()->with('doctor','patient')->get();
        if($users->isEmpty()){
            return response()->json(
                [
                    'success'=>false,
                    'message'=>'No users found',
                ],200
            );
        };
        return response()->json(
            [
                'message'=>'Fetched Successfully',
                'users'=>$users,
            ],200
        );

    }

    /**
     * Create new User.
     */
    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();
        // $input['password'] = bcrypt($input['password']);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'role' => $validated['role'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);
        if ($user->role == 'patient') {
            Patient::create([
                'user_id' => $user->id,
            ]);
        } elseif ($user->role == 'doctor') {
            $specialization_id = NULL;
            if ($request->has('specialization_id')) {
                $specialization_id = $request->specialization_id;
            }
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'specialization_id'  => $specialization_id,
            ]);

            $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            foreach ($days as $day) {
                Schedule::create([
                    'doctor_id' => $doctor->id,
                    'day' => $day,
                    'start_time' => '10:00',
                    'end_time' => '17:00',
                    'slots' => 14,
                ]);
            }

        }
        // $success['token'] = $user->createToken('doc-book')->plainTextToken;

        return response()->json([
            'success' => true,
            // 'result' => $success,
            'message' => 'User Registered Successfully',
            'data' => $user,
        ], 201);
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
     * Delete User.
     */
    public function destroy(string $id)
    {
        if(!$user = User::find($id)){
            return response()->json(
                [
                    'success'=>false,
                    'message'=>'User not found',
                ],200
            );
        };
        $user->delete();
        return response()->json(
            [
                'success'=>true,
                'message'=>'User Deleted Successfully',
            ],200
        );


    }
}
