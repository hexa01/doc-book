<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Appointment Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome for icons -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            width: 90%;
            margin: auto;
            padding-top: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .status {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
        }
        .status.pending {
            background-color: orange;
        }
        .status.completed {
            background-color: green;
        }
        .status.cancelled {
            background-color: red;
        }
        .action-btns {
            display: flex;
            gap: 10px;
        }
        .action-btns a {
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            color: white;
        }
        .action-btns .edit {
            background-color: #007bff;
        }
        .action-btns .delete {
            background-color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Doctor's Appointment Dashboard</h1>

    <table>
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>John Doe</td>
                <td>2024-11-22</td>
                <td><span class="status pending">Pending</span></td>
                <td class="action-btns">
                    <a href="#" class="edit"><i class="fas fa-edit"></i> Edit</a>
                    <a href="#" class="delete"><i class="fas fa-trash-alt"></i> Delete</a>
                </td>
            </tr>
            <tr>
                <td>Jane Smith</td>
                <td>2024-11-23</td>
                <td><span class="status completed">Completed</span></td>
                <td class="action-btns">
                    <a href="#" class="edit"><i class="fas fa-edit"></i> Edit</a>
                    <a href="#" class="delete"><i class="fas fa-trash-alt"></i> Delete</a>
                </td>
            </tr>
            <tr>
                <td>Mary Johnson</td>
                <td>2024-11-25</td>
                <td><span class="status cancelled">Cancelled</span></td>
                <td class="action-btns">
                    <a href="#" class="edit"><i class="fas fa-edit"></i> Edit</a>
                    <a href="#" class="delete"><i class="fas fa-trash-alt"></i> Delete</a>
                </td>
            </tr>
            <!-- More rows can be added here -->
        </tbody>
    </table>
</div>

</body>
</html>
