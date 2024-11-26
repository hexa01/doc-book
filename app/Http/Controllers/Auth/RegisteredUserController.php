<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'address' => ['string', 'max:255'],
            'phone' => ['string', 'max:30'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['in:patient,doctor,admin'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'role' => $request->role,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
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
            Doctor::create([
                'user_id' => $user->id,
                'specialization_id'  => $specialization_id,
            ]);
        } elseif ($user->role == 'admin') {

        }
        if (Auth::user()) {
            if ($user->role == 'patient') {
                return redirect(route('patients.index', absolute: false));
            } elseif ($user->role == 'doctor') {
                return redirect(route('doctors.index', absolute: false));
            }
            return redirect(route('admins.view', absolute: false));
        }

        event(new Registered($user));
        return redirect()->route('login')->with('status', 'Registration successful! Please log in.');
        // if ($user->role == 'patient') {
        //     return redirect(route('dashboard', absolute: false));
        // } elseif ($user->role == 'doctor') {
        //     return redirect(route('dashboard', absolute: false));
        // }
    }
}
