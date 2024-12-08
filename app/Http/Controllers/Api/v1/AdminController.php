<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Show all admins
     */
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        if ($admins->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No admins found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Admins retrieved successfully',
            'data' => $admins,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update admins information
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
        $input = $request->only(['name', 'email', 'phone', 'address']);

        // Update the password only if provided
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->input('password')); // Use Hash::make() for consistency
        }

        // Update the user profile with the validated input
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
