<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.4/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <x-admin-nav> </x-admin-nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6">All Doctors</h1>

        <!-- Create Doctor Button -->
        <div class="mb-1 text-left">
            <a href="{{route('doctors.create')}}" class="inline-block bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-700">
                Add New Doctor
            </a>
        </div>

        <!-- Doctors Table -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-blue-600 text-white text-left">
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Specialization</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Phone</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doctor)
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 border">{{ $doctor->name }}</td>
                        <td class="py-3 px-4 border">{{ $doctor->doctor->specialization->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4 border">{{ $doctor->email }}</td>
                        <td class="py-3 px-4 border">{{ $doctor->phone }}</td>
                        <td class="py-3 px-4 border">
                            <!-- <a href="{{ route('doctors.show', $doctor->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">View</a> -->
                            <a href="{{ route('doctors.edit', $doctor->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
                            <form method="POST" action="{{ route('doctors.destroy', $doctor->id) }}" class="inline">
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