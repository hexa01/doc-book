<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(!(Auth::user()->role == 'admin'),404);
        $patients_count = Patient::count();
        $doctors_count = Doctor::count();
        $specializations_count = Specialization::count();
        $admins_count = User::where('role','admin')->get()->count();
        // $admin_count remaining to fetch
        $count_arr = [$patients_count,$doctors_count,$specializations_count,$admins_count];
        return view('admins.index', compact('count_arr'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!(Auth::user()->role == 'admin'), 404);
        return view('admins.create');
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
        abort_if(!(Auth::user()->role == 'admin'),404);
        $admin = User::findOrFail($id);
        $admin->delete();
        return to_route('admins.view')->with('message',"Admin has been deleted successfully");
    }

    public function view()
{
    abort_if(!(Auth::user()->role == 'admin'),404);
    $admins =  User::where('role','admin')->get(); // Fetch all admins from the database
    return view('admins.view', compact('admins'));
}

}
