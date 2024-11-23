@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    <!-- Title -->
    <h1 class="text-2xl font-bold text-center mb-6">Choose Specialization</h1>

    <!-- Specialty Selection Form -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('appointments.name-fetch') }}" method="GET">
            @csrf
            <div class="form-group mb-4">
                <!-- Specialization Dropdown -->
                <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">Select Specialization</label>
                <select name="specialization" id="specialization" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="" disabled selected>Select a specialization</option>
                    @foreach($specializations as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 w-full">
                Submit
            </button>
        </form>
    </div>

</div>
@endsection
