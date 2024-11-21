<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = User::where('role', 'patient')->get();
        // dd($patients->toArray());
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
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
        // $patient = Patient::where('user_id', $id)->first();
        $user = User::findOrFail($id);
        return view('patients.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    $user = User::findOrFail($id);
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:patients,email,' . $id,
        'phone' => 'nullable|string|max:30',
        'address' => 'nullable|string|max:255',
        'password' => 'nullable|string|min:8|confirmed',
    ]);
        $input = $request->only(['name', 'email', 'phone', 'address']);
        if ($request->filled('password')) {
            $input['password'] = bcrypt($request->input('password'));
        }

        $input = array_filter($input, fn($value) => !is_null($value) && $value !== '');

        $user->update($input);
        return to_route('patients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user -> delete();
        return to_route('patients.index');
    }
}
