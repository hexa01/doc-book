@extends('layouts.patient-dashboard')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="w-full max-w-xl bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-semibold mb-6 text-center">Update Appointment</h1>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Appointment Update Form -->
        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Specialization (Disabled) -->
            <div class="mb-6">
                <label for="specialization" class="block text-sm font-medium text-gray-700">Specialization</label>
                <input type="text" id="specialization" name="specialization" 
                       class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md py-3 px-4 text-gray-500 cursor-not-allowed"
                       value="{{ $appointment->doctor->specialization->name }}" readonly>
            </div>

            <!-- Doctor's Name -->
            <div class="mb-6">
                <label for="doctor_id" class="block text-sm font-medium text-gray-700">Doctor's Name</label>
                <select id="doctor_id" name="doctor_id" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4">
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}" 
                            {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Appointment Date -->
            <div class="mb-6">
                <label for="appointment_date" class="block text-sm font-medium text-gray-700">Appointment Date</label>
                <input type="date" id="appointment_date" name="appointment_date" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4"
                       value="{{ $appointment->appointment_date }}">
            </div>

            <!-- Start Time -->
            <div class="mb-6">
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="time" id="start_time" name="start_time" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4"
                       value="{{ $appointment->start_time }}">
            </div>

            <!-- End Time -->
            <div class="mb-6">
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="time" id="end_time" name="end_time" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4"
                       value="{{ $appointment->end_time }}">
            </div>

            <!-- Submit Button -->
            <div class="mt-8 text-center">
                <button type="submit" 
                        class="px-6 py-3 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Update Appointment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
