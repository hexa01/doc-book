<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.4/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <x-admin-nav></x-admin-nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6">All Admins</h1>

        <!-- Create Admin Button -->
        <div class="mb-4 text-left">
            <a href="{{ route('admins.create') }}" class="inline-block bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-700">
                Add New Admin
            </a>
        </div>

        <!-- Admins Table -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-blue-600 text-white text-left">
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 border">{{ $admin->name }}</td>
                        <td class="py-3 px-4 border">{{ $admin->email }}</td>
                        <td class="py-3 px-4 border">
                            <!-- Edit Admin -->
                            <!-- <a href="{{ route('admins.edit', $admin->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a> -->
                            <!-- Delete Admin -->
                            <form method="POST" action="{{ route('admins.destroy', $admin->id) }}" class="inline">
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
