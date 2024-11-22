<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">


    <!-- Navbar -->
    <nav class="bg-blue-600 p-4">
        @if(Auth::user()->role == 'patient')
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Dashboard Logo/Title -->
            <a href="" class="text-white text-xl font-bold">
                Patient Dashboard
            </a>
            <!-- Navigation Links -->
            <div class="space-x-4">
                <a href="{{ route('appointments.index') }}" class="text-white">Appointments</a>
                <a href="{{ route('profile.edit') }}" class="text-white">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="text-white" type="submit">Logout</button>
                </form>
            </div>
        </div>
        @elseif(Auth::user()->role == 'doctor')
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Dashboard Logo/Title -->
            <a href="" class="text-white text-xl font-bold">
                Doctor Dashboard
            </a>
            <!-- Navigation Links -->
            <div class="space-x-4">
                <a href="{{ route('appointments.index') }}" class="text-white">Appointments</a>
                <a href="{{ route('profile.edit') }}" class="text-white">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="text-white" type="submit">Logout</button>
                </form>
            </div>
        </div>
        @endif
    </nav>
    <!-- Main Content -->
    <main class="py-6">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>
</body>

</html>