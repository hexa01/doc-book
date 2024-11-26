@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto mt-8 p-4 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold mb-6">Update Review for this Appointment</h1>

    <!-- Display Validation Errors -->
    @error('review')
        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
            <p>{{ $message }}</p>
        </div>
    @enderror

    <form action="{{ route('appointments.updateReview', $appointment) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="review" class="block text-gray-700">Review:</label>
            <textarea id="review" name="review" class="w-full p-3 border border-gray-300 rounded-md" rows="5">{{ old('review', $appointment->review) }}</textarea>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save Review</button>
    </form>
</div>
@endsection
