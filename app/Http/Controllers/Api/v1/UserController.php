<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
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
