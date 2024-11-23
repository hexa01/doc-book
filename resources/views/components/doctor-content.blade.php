<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Welcome, Dr. {{ Auth::user()->name }}</h1>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Appointments -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-gray-600 font-semibold">Total Appointments</h2>
            <p class="text-3xl font-bold text-blue-600">120</p>
        </div>

        <!-- Today's Appointments -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-gray-600 font-semibold">Today's Appointments</h2>
            <p class="text-3xl font-bold text-green-600">8</p>
        </div>

        <!-- Total Patients -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-gray-600 font-semibold">Total Patients</h2>
            <p class="text-3xl font-bold text-indigo-600">45</p>
        </div>

        <!-- Availability -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-gray-600 font-semibold">Weekly Availability</h2>
            <p class="text-3xl font-bold text-yellow-600">5 Days</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <a href="{{ route('appointments.index') }}" class="bg-blue-500 text-white p-4 rounded-lg shadow hover:bg-blue-600">
            <h3 class="text-lg font-bold">View Appointments</h3>
            <p>Check and manage your upcoming appointments.</p>
        </a>
        <a href="{{route('schedules.index')}}" class="bg-green-500 text-white p-4 rounded-lg shadow hover:bg-green-600">
            <h3 class="text-lg font-bold">Set Schedule</h3>
            <p>Update your availability for the week.</p>
        </a>
        <a href="{{route('doctor.patients')}}" class="bg-yellow-500 text-white p-4 rounded-lg shadow hover:bg-yellow-600">
            <h3 class="text-lg font-bold">View Patients</h3>
            <p>Access your patient list.</p>
        </a>
    </div>

    <!-- Upcoming Appointments -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Upcoming Appointments</h2>
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Patient</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Time</th>
                    <th class="px-4 py-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $appointment->patient->user->name }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}</td>
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
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-2 text-center text-gray-500">No upcoming appointments</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>