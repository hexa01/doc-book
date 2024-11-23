@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl bg-white p-8 shadow-md rounded-lg mb-10">
    <!-- Header Section -->
    <h2 class="text-xl font-semibold mb-4 text-red-500">Are you sure you want to delete your account?</h2>
    <p class="mb-4 text-gray-600">This action is irreversible. Once deleted, your account cannot be restored. Please be certain that you want to proceed with deleting your account.</p>

    <!-- Confirmation Form -->
    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <div class="flex space-x-4">
            <!-- Confirm Deletion Button -->
            <button type="submit" class="w-full py-3 bg-red-500 text-white rounded hover:bg-red-600">
                Yes, Delete My Account
            </button>
            <!-- Cancel Button -->
            <a href="{{ route('profile.edit') }}" class="w-full py-3 bg-gray-300 text-black rounded hover:bg-gray-400 text-center block">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
