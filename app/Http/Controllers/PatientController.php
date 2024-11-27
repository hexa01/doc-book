<?php

namespace App\Http\Controllers;

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
        abort_if(!(Auth::user()->role == 'admin'), 404);
        $patients = User::where('role', 'patient')->paginate(7);
        // dd($patients->toArray());

        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        abort_if(!(Auth::user()->role == 'admin'), 404);
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
    public function show()
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(!(Auth::user()->role == 'admin'), 404);

        // $patient = Patient::where('user_id', $id)->first();
        if (Auth::user()->role == 'admin') {
            $user = User::findOrFail($id);
            return view('patients.edit', compact('user'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user = User::findOrFail($id);
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
        }

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }
        }


        $input = $request->only(['name', 'email', 'phone', 'address']);
        if ($request->filled('password')) {
            $input['password'] = bcrypt($request->input('password'));
        }

        $input = array_filter($input, fn($value) => !is_null($value) && $value !== '');

        $user->update($input);

        if (Auth::user()->role == 'patient') {
            session()->flash('message', 'Updated successfully!');
            return to_route('profile.edit');
        }
        return to_route('patients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        if (Auth::user()->role == 'admin'){
            return to_route('patients.index');
        }
        else{

        }
    }
}
