@extends('layouts.dashboard')
@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-6 py-6">
        <h1 class="text-3xl font-semibold mb-6">Manage Your Profile</h1>

        <!-- Display Success and Error Messages -->
        @if (session('message'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
            {{ session('message') }}
        </div>
        @elseif (session('error'))
        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
            {{ session('error') }}
        </div>
        @endif

        <!-- Update Personal Details Section -->
        <div class="max-w-4xl bg-white p-8 shadow-md rounded-lg mb-10">
            <h2 class="text-xl font-semibold mb-4">Update Personal Details</h2>

            @if(Auth::user()->role == 'patient')
            <form action="{{ route('patients.update', [Auth::user()->id]) }}" method="POST" class="space-y-6">
                @elseif(Auth::user()->role == 'doctor')
                <form action="{{ route('doctors.update', [Auth::user()->id]) }}" method="POST" class="space-y-6">
                    @endif
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4" required>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input
                            type="email" id="email" name="email" value="{{ old('email', $user->email)}}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4"
                            required>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <input
                            type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4">
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input
                            type="text" id="address" name="address" value="{{ old('address', $user->address) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4">
                    </div>

                    <!-- Doctor-Specific Specialization Field -->
                    @if(Auth::user()->role == 'doctor')
                    <div>
                        <label for="specialization" class="block text-sm font-medium text-gray-700">Specialization</label>
                        <input
                            type="text" id="specialization" name="specialization" value="{{ $user->doctor->specialization->name }}" readonly
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4 bg-gray-100">
                        <p class="text-sm text-gray-500 mt-1">To change specialization, please contact the administrator.</p>
                    </div>
                    @endif

                    <!-- Update Button -->
                    <div>
                        <button
                            type="submit"
                            class="w-full py-3 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Update Details
                        </button>
                    </div>

                </form>
        </div>


        <!-- Update Password Section -->
        <div class="max-w-4xl bg-white p-8 shadow-md rounded-lg mb-10">
            <h2 class="text-xl font-semibold mb-4">Update Password</h2>
            <form action="{{ route('patients.update',[Auth::user()->id]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" id="current_password" name="current_password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4" required>
                    @error('current_password')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" id="new_password" name="password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4" required>
                    @error('current_password')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                    @enderror

                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="password_confirmation"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-3 px-4" required>
                </div>

                <!-- Update Password Button -->
                <div>
                    <button type="submit"
                        class="w-full py-3 bg-green-500 text-white rounded hover:bg-green-600">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Account Section -->
        <div class="max-w-4xl bg-white p-8 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold mb-4 text-red-600">Danger Zone</h2>
            <form action="{{route('profile.delete.form')}}" method="GET">
                @csrf
                <p class="mb-4 text-gray-700">
                    Deleting your account is permanent and cannot be undone. All your data will be lost.
                </p>
                <button type="submit"
                    class="w-full py-3 bg-red-500 text-white rounded hover:bg-red-600">
                    Delete My Account
                </button>
            </form>
        </div>
    </div>
</div>
@endsection