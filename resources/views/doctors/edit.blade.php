<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.4/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen">

    <x-admin-nav></x-admin-nav>

    <!-- Centering the form using Flexbox -->
    <div class="flex justify-center items-center h-full">
        <div class="w-full max-w-lg p-6 bg-white shadow-md rounded-lg">
            <h1 class="text-2xl font-bold mb-6 text-center">Edit Doctor</h1>

            <!-- Doctor Edit Form -->
            <form method="POST" action="{{ route('doctors.update', $doctor->id) }}">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $doctor->user->name) }}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $doctor->user->email) }}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $doctor->user->phone) }}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Specialization Dropdown -->
                <div class="mb-4">
                    <label for="specialization_id" class="block text-sm font-medium text-gray-700">Specialization</label>
                    <select name="specialization_id" id="specialization_id" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="" disabled {{ empty($doctor->specialization_id) ? 'selected' : '' }}>
                            Select Specialization
                        </option>
                        @foreach($specializations as $specialization)
                        <option value="{{ $specialization->id }}" {{ isset($doctor->specialization_id) && $doctor->specialization_id == $specialization->id ? 'selected' : '' }}>
                            {{ $specialization->name }}
                        </option>
                        @endforeach
                    </select>
                </div>



                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $doctor->user->address) }}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <small class="text-gray-500">Leave blank to keep the current password</small>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button type="submit" class="w-full bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Update Doctor
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>