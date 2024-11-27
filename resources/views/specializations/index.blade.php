<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specialization List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.4/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <x-admin-nav></x-admin-nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6">All Specializations</h1>

        <div class="mb-6 bg-white p-6 rounded-lg shadow-md">
            <form method="POST" action="{{ route('specializations.store') }}" class="flex justify-center items-center space-x-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 text-center mb-1">Specialization Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter Specialization" class="w-64 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Add
                    </button>
                </div>
            </form>
        </div>

        <!-- Specializations Table -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-blue-600 text-white text-left">
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4">Specialization Name</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($specializations as $specialization)
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 border">{{ $specialization->name }}</td>
                        <td class="py-3 px-4 border">
                            <a href="{{ route('specializations.edit', $specialization->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
                            <form method="POST" action="{{ route('specializations.destroy', $specialization->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
