<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointments</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f4f7fc;
    }
    .container {
      max-width: 1000px;
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
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 12px;
      text-align: center;
    }
    th {
      background-color: #4CAF50;
      color: white;
    }
    td {
      background-color: #f9f9f9;
    }
    button {
      background-color: #FF5722;
      color: white;
      border: none;
      padding: 6px 12px;
      cursor: pointer;
      border-radius: 4px;
    }
    button:hover {
      background-color: #e64a19;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Appointments List</h2>
    <table>
      <thead>
        <tr>
          <th>Appointment Date</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($appointments as $appointment)
          <tr>
            <td>{{ $appointment->appointment_date }}</td>
            <td>{{ $appointment->start_time }}</td>
            <td>{{ $appointment->end_time }}</td>
            <td>
              <button>Edit</button>
              <button>Delete</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</body>
</html>
