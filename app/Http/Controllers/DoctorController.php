<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('doctors.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
    public function showSpecialization()
    {
        // Specialization::query()->create([
        //     'name'=> 'Cardiology'
        // ]);
        // Specialization::query()->create([
        //     'name'=> 'Neurology'
        // ]);
        // Specialization::query()->create([
        //     'name'=> 'Surgery'
        // ]);

        $specializations = Specialization::all();
        return view('doctors.specialization', compact('specializations'));
        // $speciality = $request -> speciality;
    }
}
