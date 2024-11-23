@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8 mt-8">
    <h2 class="text-2xl font-semibold text-center text-green-600 mb-6">Update Appointment</h2>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Specialization:</label>
        <input type="text" value="{{ $appointment->doctor->specialization->name }}" readonly
            class="mt-1 block w-full bg-gray-100 py-3 px-4 rounded-md cursor-not-allowed">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Doctor:</label>
        <input type="text" value="{{ $appointment->doctor->user->name }}" readonly
            class="mt-1 block w-full bg-gray-100 py-3 px-4 rounded-md cursor-not-allowed">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Appointment Date:</label>
        <input type="text" value="{{ $appointment_date->format('d-m-Y') }}" readonly
            class="mt-1 block w-full bg-gray-100 py-3 px-4 rounded-md cursor-not-allowed">
    </div>

    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Select a Slot:</label>
            <select name="start_time" required class="mt-1 block w-full border-gray-300 rounded-md py-3 px-4">
                <option value="" disabled selected>Select a Slot</option>
                @foreach ($available_slots as $slot)
                    <option value="{{ $slot }}" {{ $appointment->start_time == $slot ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::parse($slot)->format('h:i A') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit" class="w-full py-3 bg-green-500 text-white rounded-md hover:bg-green-600">
                Update Appointment
            </button>
        </div>
    </form>
</div>
@endsection
