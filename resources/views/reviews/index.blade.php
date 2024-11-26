@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto mt-8 p-4 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold mb-6">Your Past Reviews</h1>

    @if($appointments->isEmpty())
        <div class="bg-yellow-100 p-4 rounded-md text-yellow-700">
            No appointments found with reviews.
        </div>
    @else
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Doctor's Name</th>
                    <th class="px-4 py-2">Specialization</th>
                    <th class="px-4 py-2">Appointment Date</th>
                    <th class="px-4 py-2">Review</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $appointment->doctor->user->name }}</td>
                        <td class="px-4 py-2">{{ $appointment->doctor->specialization->name }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d-m-Y') }}</td>
                        <td class="px-4 py-2">
                            @if($appointment->review)
                                {{ $appointment->review }}
                            @else
                                No review yet.
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
