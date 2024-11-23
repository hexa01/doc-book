@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-700">Welcome, John Doe</h1>
        <a href="{{ route('appointments.create') }}" 
           class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
            Book Appointment
        </a>
    </div>

    <!-- Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Upcoming Appointments Card -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold text-gray-800">Upcoming Appointments</h2>
            <p class="text-gray-600 mt-2">You have 2 upcoming appointments.</p>
            <a href="{{ route('appointments.index') }}" 
               class="text-blue-500 hover:underline mt-3 block">
                View All Appointments
            </a>
        </div>

        <!-- Medical History Card -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold text-gray-800">Medical History</h2>
            <p class="text-gray-600 mt-2">View your past consultations and medical history.</p>
            <a href="" 
               class="text-blue-500 hover:underline mt-3 block">
                View History
            </a>
        </div>

        <!-- Profile Card -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold text-gray-800">Your Profile</h2>
            <p class="text-gray-600 mt-2">Keep your contact information and medical details up to date.</p>
            <a href="{{ route('profile.edit') }}" 
               class="text-blue-500 hover:underline mt-3 block">
                Edit Profile
            </a>
        </div>
    </div>

    <!-- Recent Appointments Table -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Recent Appointments</h2>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-600">Date</th>
                        <th class="px-4 py-2 text-left text-gray-600">Doctor</th>
                        <th class="px-4 py-2 text-left text-gray-600">Specialization</th>
                        <th class="px-4 py-2 text-left text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Static Data for Recent Appointments -->
                    <tr>
                        <td class="px-4 py-2 border-t text-gray-800">2024-11-25</td>
                        <td class="px-4 py-2 border-t text-gray-800">Dr. Jane Smith</td>
                        <td class="px-4 py-2 border-t text-gray-800">Cardiologist</td>
                        <td class="px-4 py-2 border-t text-gray-800">
                            <span class="text-green-600">Confirmed</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border-t text-gray-800">2024-12-01</td>
                        <td class="px-4 py-2 border-t text-gray-800">Dr. Mark Brown</td>
                        <td class="px-4 py-2 border-t text-gray-800">Dermatologist</td>
                        <td class="px-4 py-2 border-t text-gray-800">
                            <span class="text-yellow-600">Pending</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border-t text-gray-800">2024-12-10</td>
                        <td class="px-4 py-2 border-t text-gray-800">Dr. Lisa White</td>
                        <td class="px-4 py-2 border-t text-gray-800">Neurologist</td>
                        <td class="px-4 py-2 border-t text-gray-800">
                            <span class="text-yellow-600">Pending</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
