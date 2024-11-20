<!-- resources/views/patients/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.4/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Navigation Bar -->
    <nav class="bg-blue-600 p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="#" class="text-white text-xl font-bold">Healthcare App</a>
            <div class="space-x-4">
                <a href="#" class="text-white">Dashboard</a>
                <a href="#" class="text-white">Book Appointment</a>
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-white" type="submit">Logout</button>
                        </form>


            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6">Welcome, John Doe</h1>

        <!-- Patient Information -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">Your Information</h2>
            <p><strong>Email:</strong> johndoe@example.com</p>
            <p><strong>Phone:</strong> 123-456-7890</p>
            <p><strong>Address:</strong> 123 Main St, City, Country</p>
        </div>

        <!-- Button to Create Appointment -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Book an Appointment</h2>
            <p>To book an appointment with your doctor, click the button below.</p>
            
            <!-- Book Appointment Button -->
            <a href="{{route('appointments.create')}}" class="mt-4 inline-block bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-700">
                Book an Appointment
            </a>
        </div>
    </div>

</body>
</html>
