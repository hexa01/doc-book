<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Creation Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f7fc;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="date"],
        input[type="time"],
        button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Create an Appointment</h2>
        <form action="{{route('appointments.store')}}" method="POST">
            @csrf
            <!-- Appointment Date -->
            <div class="form-group">
    <label for="doctor">Choose Doctor:</label>
    <select id="doctor" name="doctor_id" required>
        <option value="">Select a Doctor</option>
        @foreach ($doctors as $doctor)
            <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
        @endforeach
    </select>
</div>
            <div class="form-group">
                <label for="appointment-date">Appointment Date:</label>
                <input type="date" id="appointment-date" name="appointment_date" required>
            </div>

            <!-- Start Time -->
            <div class="form-group">
                <label for="start-time">Start Time:</label>
                <input type="time" id="start-time" name="start_time" required>
            </div>

            <!-- End Time -->
            <div class="form-group">
                <label for="end-time">End Time:</label>
                <input type="time" id="end-time" name="end_time" required>
            </div>

            <!-- Submit Button -->
            <button type="submit">Create Appointment</button>
        </form>
    </div>

</body>

</html>