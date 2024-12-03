<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseController;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecializationController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specializations = Specialization::all();
        if ($specializations->isEmpty()) {
            return $this->errorResponse('No specializations found',404);
        }
        return $this->successResponse('Specializations retrieved successfully', $specializations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:specializations,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        $specialization = Specialization::create([
            'name' => $request->name,
        ]);
        return $this->successResponse('Specializations created successfully', $specialization, 201);
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
        if(!$specialization = Specialization::find($id)){
            return $this->errorResponse('Specializations not found',404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:specializations,name,' . $specialization->id,
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }
        $specialization->update([
            'name' => $request->name,
        ]);
        return $this->successResponse('Specialization updated successfully', $specialization, 201);



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!$specialization = Specialization::find($id)){
            return response()->json(
                [
                    'success'=>false,
                    'message'=>'Specialization not found',
                ],404
            );
        }
        $specialization->delete();
        return response()->json(
            [
                'success'=>true,
                'message'=>'Specialization Deleted Successfully',
            ],200
        );
    }
}
