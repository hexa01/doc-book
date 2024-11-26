@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto mt-8 p-4 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold mb-6">Your Patients</h1>

    @if($patients->isEmpty())
        <div class="bg-yellow-100 p-4 rounded-md text-yellow-700">
            No patients found.
        </div>
    @else
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Patient Name</th>
                    <th class="px-4 py-2">Last Appointment Date</th>
                    <th class="px-4 py-2">Review</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                    @php
                        // Find the last appointment for the patient with the current doctor
                        $lastAppointment = $patient->appointments->where('doctor_id', Auth::user()->doctor->id)
                            ->sortByDesc('appointment_date')
                            ->first();
                    @endphp

                    @if($lastAppointment)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $patient->user->name }}</td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($lastAppointment->appointment_date)->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-2">
                                @if($lastAppointment->review)
                                    <span class="text-green-600">Reviewed</span>
                                @else
                                    <span class="text-yellow-600">No Review</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">

                                @if($lastAppointment->review)
                                    <a href="{{ route('appointments.editReview', $lastAppointment) }}" 
                                       class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Edit Review</a>
                                @else
                                    <a href="{{ route('appointments.editReview', $lastAppointment) }}" 
                                       class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Add Review</a>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
