@extends('layouts.dashboard')
@section('content')
<div class="container mx-auto mt-8 p-4 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold mb-6">Create Schedule</h1>
    <form action="{{ route('schedules.store') }}" method="POST" class="space-y-6">
        @csrf
        <!-- Day of the Week -->
        <div>
            <label for="day" class="block text-sm font-medium text-gray-700">Day</label>
            <select name="day" id="day" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4">
            <option value="" disabled selected>Select Day</option>
                <option value="Sunday">Sunday</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
            </select>
            @error('day')
            <span class="text-red-500 text-md">{{ $message }}</span>
        @enderror
        </div>

        <!-- Start Time -->
        <div>
            <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
            <input type="time" id="start_time" name="start_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4" value="{{ old('start_time')}}" required>
        </div>

        <!-- End Time -->
        <div>
            <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
            <input type="time" id="end_time" name="end_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4" value="{{ old('end_time')}}" required>
            @error('end_time')
            <span class="text-red-500 text-md">{{ $message }}</span>
        @enderror
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full py-3 bg-blue-500 text-white rounded hover:bg-blue-600">
                Save Schedule
            </button>
        </div>
    </form>
</div>
@endsection