@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">

    <!-- Title -->
    <h1 class="text-2xl font-bold text-center mb-6">Choose a Doctor</h1>

    <!-- Doctor Selection Form -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('appointments.slots') }}" method="GET">
            @csrf
            <div class="form-group mb-4">
                <!-- Display Specialization (Static) -->
                <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">Specialization</label>
                <input type="text" id="specialization" name="specialization" value="{{ $specialization->name }}" class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-700 cursor-not-allowed" readonly>
            </div>

            <div class="form-group mb-4">
                <!-- Doctor Dropdown -->
                <label for="doctor" class="block text-sm font-medium text-gray-700 mb-2">Select Doctor</label>
                <select name="doctor_id" id="doctor" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="" disabled selected>Select a doctor</option>
                    @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
                    @endforeach
                </select>
                @if(session('error'))
                <span class="text-red-500 text-md">{{ session('error') }}</span>
                @endif
            </div>



    </div>

    <!-- Submit Button -->
    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 w-full">
        Submit
    </button>
    </form>
</div>

</div>
@endsection