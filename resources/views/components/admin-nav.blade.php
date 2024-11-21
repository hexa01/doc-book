

    <!-- Navigation Bar -->
    <nav class="bg-blue-600 p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('admins.index') }}" class="text-white text-xl font-bold">Admin Dashboard</a>
            <div class="space-x-4">
                <a href="{{ route('patients.index') }}" class="text-white">Patients</a>
                <a href="{{ route('doctors.index') }}" class="text-white">Doctors</a>
                <a href="{{ route('specializations.index') }}" class="text-white">Specializations</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="text-white" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>
