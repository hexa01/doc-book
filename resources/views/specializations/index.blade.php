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
                            <!-- <a href="{{ route('specializations.show', $specialization->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">View</a> -->
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