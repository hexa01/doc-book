<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Doctor Specialty</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        select, button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Choose a Doctor's Specialty</h1>
    <form action="{{route('appointments.create')}}" method="GET">
        @csrf
        <div class="form-group">
    <label for="specialization">Specialty</label>
    <select name="specialization" id="specialization" required>
        <option value="" disabled selected>Select a specialization</option>
        @foreach($specializations as $specialization)
            <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
        @endforeach
    </select>
</div>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
