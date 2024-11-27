@extends('layouts.dashboard')
@section('content')
<div class="container mx-auto mt-8 p-4 bg-white shadow-md rounded-lg">
    @if(session('message') || session('error'))
    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
        {{ session('message') }}
        {{ session('error') }}
    </div>
    @endif
    <h1 class="text-2xl font-semibold mb-6">My Schedule</h1>
    <a href="{{ route('schedules.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mb-4">Add New Slot</a>
    <table class="min-w-full table-auto" style="margin-top: 10px;">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Day</th>
                <th class="px-4 py-2">Start Time</th>
                <th class="px-4 py-2">End Time</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $schedule)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $schedule->day }}</td>
                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
                <td class="px-4 py-2 flex space-x-2">
                    <a href="{{ route('schedules.edit', $schedule->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                    <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection