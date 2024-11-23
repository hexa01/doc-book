@extends('layouts.dashboard')
@section('content')
<div class="container mt-8 p-4 bg-white shadow-md rounded-lg max-w-md mx-auto">
    <h1 class="text-2xl font-semibold mb-6 text-center">Edit Schedule</h1>
    <form action="{{ route('schedules.update', $schedule->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Day of the Week (Fixed and non-editable) -->
        <div>
            <label for="day" class="block text-sm font-medium text-gray-700">Day</label>
            <input type="text" id="day" name="day" value="{{ $schedule->day }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4 bg-gray-100 cursor-not-allowed" readonly>
        </div>

        <!-- Start Time -->
        <div>
            <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
            <input type="time" id="start_time" name="start_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4" value="{{ old('start_time', $schedule->start_time) }}" required>
            @error('start_time')
            <span class="text-red-500 text-md">{{ $message }}</span>
            @enderror
        </div>

        <!-- End Time -->
        <div>
            <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
            <input type="time" id="end_time" name="end_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4" value="{{ old('end_time', $schedule->end_time) }}" required>
            @error('end_time')
            <span class="text-red-500 text-md">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full py-3 bg-blue-500 text-white rounded hover:bg-blue-600">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection

