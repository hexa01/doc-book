<div class="container mx-auto mt-8 p-4 bg-white shadow-md rounded-lg">
    @if(session('message'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
            {{ session('message') }}
        </div>
    @elseif(session('error'))
        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('appointments.specialization') }}" 
           class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
            Book an Appointment
        </a>
    </div>

    <h1 class="text-2xl font-semibold mb-6">My Appointments</h1>

    <!-- Display all appointments in a table -->
    <table class="min-w-full table-auto">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Doctor's Name</th>
                <th class="px-4 py-2">Specialization</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Time</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appointments as $appointment)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $appointment->doctor->user->name }}</td>
                    <td class="px-4 py-2">{{ $appointment->doctor->specialization->name }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d-m-Y') }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</td>
                    <td class="px-4 py-2">
                        @if($appointment->status == 'booked')
                        <span class="text-green-600">Booked</span>
                        @elseif($appointment->status == 'completed')
                        <span class="text-yellow-600">Completed</span>
                        @elseif($appointment->status == 'missed')
                        <span class="text-red-600">Missed</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 flex space-x-2">
                        @if($appointment->status == 'completed')
                        <button class="px-4 py-2 bg-gray-300 text-gray-600 rounded cursor-not-allowed" disabled>Edit</button>
                        <button class="px-4 py-2 bg-gray-300 text-gray-600 rounded cursor-not-allowed" disabled>Delete</button>
                        @elseif($appointment->status == 'booked')
                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-2 text-center text-gray-500">No appointments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
