<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointment System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Hero Section -->
    <header class="bg-gradient-to-br from-blue-500 to-teal-400 text-white">
        <div class="container mx-auto px-4 py-20 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to Doctor Appointment System</h1>
            <p class="text-lg md:text-xl mb-6">Book appointments with ease and manage your healthcare online.</p>
            <div class="flex justify-center gap-4">
                @auth
                    @if (auth()->user()->role === 'admin')
                        <!-- Admin Dashboard Link -->
                        <a href="{{ route('admins.index') }}" class="px-6 py-3 bg-white text-blue-500 font-semibold rounded shadow hover:bg-gray-200">
                            Admin Dashboard
                        </a>
                    @else
                        <!-- User Dashboard Link -->
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-white text-blue-500 font-semibold rounded shadow hover:bg-gray-200">
                            Dashboard
                        </a>
                    @endif
                @else
                    <!-- Show Login and Register links if user is not logged in -->
                    <a href="{{ route('login') }}" class="px-6 py-3 bg-white text-blue-500 font-semibold rounded shadow hover:bg-gray-200">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-teal-500 text-white font-semibold rounded shadow hover:bg-teal-600">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- How It Works Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">How It Works</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto bg-blue-500 text-white flex items-center justify-center rounded-full mb-4">
                        1
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Create an Account</h3>
                    <p class="text-gray-600">Sign up for free and create your personal account to get started.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto bg-blue-500 text-white flex items-center justify-center rounded-full mb-4">
                        2
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Find a Doctor</h3>
                    <p class="text-gray-600">Search for specialists and view their profiles and availability.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto bg-blue-500 text-white flex items-center justify-center rounded-full mb-4">
                        3
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Book an Appointment</h3>
                    <p class="text-gray-600">Select a date and time, then confirm your appointment instantly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">What Our Users Say</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 bg-white rounded shadow">
                    <p class="text-gray-600 italic mb-4">"Booking an appointment has never been easier. I love how seamless the process is!"</p>
                    <h4 class="font-bold">John Doe</h4>
                    <p class="text-sm text-gray-500">Patient</p>
                </div>
                <div class="p-6 bg-white rounded shadow">
                    <p class="text-gray-600 italic mb-4">"A great platform for managing appointments. Highly recommend it."</p>
                    <h4 class="font-bold">Dr. Jane Smith</h4>
                    <p class="text-sm text-gray-500">Doctor</p>
                </div>
                <div class="p-6 bg-white rounded shadow">
                    <p class="text-gray-600 italic mb-4">"Simple, fast, and reliable. A must-have for healthcare management."</p>
                    <h4 class="font-bold">Emily Johnson</h4>
                    <p class="text-sm text-gray-500">Patient</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-500 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Doctor Appointment System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
