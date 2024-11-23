@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">

    <!-- Title -->
    <h1 class="text-2xl font-bold text-center mb-6">Choose a Doctor</h1>

    <!-- Doctor Selection Form -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('appointments.create') }}" method="GET">
            @csrf
            <input type="hidden" name="doctor_id" value="{{$doctor->id}}">
            <div class="form-group mb-4">
                <!-- Display Specialization (Static) -->
                <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">Specialization</label>
                <input type="text" id="specialization" name="specialization" value="{{ $doctor->specialization->name }}" class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-700 cursor-not-allowed" readonly>
            </div>

            <div class="form-group mb-4">
                <!-- Display Doctor (Read-Only) -->
                <label for="doctor" class="block text-sm font-medium text-gray-700 mb-2">Doctor</label>
                <input type="text" id="doctor" name="doctor" value="{{ $doctor->user->name }}" class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-700 cursor-not-allowed" readonly>
            </div>

            <div class="form-group mb-4">
                <!-- Appointment Date -->
                <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">Appointment Date</label>
                <input type="date" id="appointment_date" name="appointment_date" required 
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    min="{{ \Carbon\Carbon::tomorrow()->toDateString() }}">
                @error('appointment_date')
                    <span class="text-red-500 text-md">{{ $message }}</span>
                @enderror
                @if(session('error'))
                <span class="text-red-500 text-md">{{ session('error') }}</span>
                @endif
                
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 w-full">
                Submit
            </button>
        </form>
    </div>

</div>
@endsection
