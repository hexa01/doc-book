<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialization;
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
        abort_if(!(Auth::user()->role == 'admin'), 404);
        $doctors = User::where('role','doctor')->get();

        // $doctors = User::where('role', 'doctor')->with('specialization')->get();
        // dd($doctors->toArray());

        return view('doctors.index',compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctors.create', compact('specializations'));
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
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(!(Auth::user()->role == 'admin'), 404);
        $user = User::findOrFail($id);
        $doctor = Doctor::where('user_id',$user->id)->first();
        $specializations = Specialization::all();
        return view('doctors.edit',compact('doctor','specializations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $user = User::findOrFail($id);
        $doctor = Doctor::findOrFail($id);
        if (($request->filled('password') && (Auth::user()->role != 'admin'))) {

            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
        } else {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:patients,email,' . $id,
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $doctor->user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }
        }
    }
            $input = $request->only(['name', 'email', 'phone', 'address']);
            if ($request->filled('password')) {
                $input['password'] = bcrypt($request->input('password'));
            }
    
            $input = array_filter($input, fn($value) => !is_null($value) && $value !== '');
    
            $doctor->user->update($input);
            if (Auth::user()->role == 'doctor') {
                session()->flash('message', 'Updated successfully!');
                return to_route('profile.edit');
            }
            $doctor->update([
            'specialization_id' => $request->specialization_id,
            ]);
            return to_route('doctors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if (Auth::user()->role == 'admin'){
            $user->delete();
            return to_route('patients.index');
        }
        elseif (Auth::user()->role == 'doctor'){
        }
    }

    public function showPatients()
    {
        abort_if(Auth::user()->role != 'doctor', 403);
        $doctor = Auth::user()->doctor;
        $appointments = $doctor->appointments()->with('patient')->where('status','completed')->get();
        $patients = $appointments->pluck('patient')->unique('id');
        return view('doctors.patients', compact('patients'));
    }

}
