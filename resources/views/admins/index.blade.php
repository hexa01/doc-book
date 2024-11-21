<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto mt-8 px-4">
        <!-- Dashboard Header -->
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Patients -->
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h2 class="text-xl font-semibold mb-2">Patients</h2>
                <p class="text-4xl font-bold text-blue-500 mb-4">123</p>
                <a href="{{route('patients.index')}}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Manage Patients
                </a>
            </div>
            <!-- Doctors -->
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h2 class="text-xl font-semibold mb-2">Doctors</h2>
                <p class="text-4xl font-bold text-green-500 mb-4">45</p>
                <a href="{{route('doctors.index')}}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    Manage Doctors
                </a>
            </div>
            <!-- Specializations -->
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h2 class="text-xl font-semibold mb-2">Specializations</h2>
                <p class="text-4xl font-bold text-purple-500 mb-4">12</p>
                <a href="{{route('specializations.index')}}" class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600">
                    Manage Specializations
                </a>
            </div>
            <!-- Admins -->
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h2 class="text-xl font-semibold mb-2">Admins</h2>
                <p class="text-4xl font-bold text-red-500 mb-4">5</p>
                <a href="#" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Manage Admins
                </a>
            </div>
        </div>

    </div>
</body>

</html>