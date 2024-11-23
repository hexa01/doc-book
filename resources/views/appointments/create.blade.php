@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8 mt-8">
    <h2 class="text-2xl font-semibold text-center text-green-600 mb-6">Book an Appointment</h2>


    <div class="space-y-4 mb-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Specialization:</label>
            <input type="text" value="{{ $doctor->specialization->name }}" readonly
                class="mt-1 block w-full border-gray-300 rounded-md py-3 px-4 bg-gray-100 cursor-not-allowed">
        </div>


        <div>
            <label class="block text-sm font-medium text-gray-700">Doctor:</label>
            <input type="text" value="{{ $doctor->user->name }}" readonly
                class="mt-1 block w-full border-gray-300 rounded-md py-3 px-4 bg-gray-100 cursor-not-allowed">
        </div>


        <div>
            <label class="block text-sm font-medium text-gray-700">Appointment Date:</label>
            <input type="text" value="{{ $appointment_date->format('d-m-Y') }}" readonly
                class="mt-1 block w-full border-gray-300 rounded-md py-3 px-4 bg-gray-100 cursor-not-allowed">
        </div>
    </div>


    <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
        @csrf


        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
        <input type="hidden" name="appointment_date" value="{{ $appointment_date->format('Y-m-d') }}">


        <div class="form-group">
            <label for="start_time" class="block text-sm font-medium text-gray-700">Available Slots:</label>
            <select name="start_time" id="start_time" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4">
                <option value="" disabled selected>Select a slot</option>
                @foreach($available_slots as $slot)
                    <option value="{{ $slot }}">{{ date('h:i A', strtotime($slot)) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit" class="w-full py-3 bg-green-500 text-white rounded-md hover:bg-green-600">
                Confirm Appointment
            </button>
        </div>
    </form>
</div>
@endsection
