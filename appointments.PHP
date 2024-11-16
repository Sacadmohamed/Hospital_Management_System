<?php
include('config.php');

// Fetch appointments
$result = $conn->query("SELECT a.id, p.fullname AS patient_name, d.fullname AS doctor_name, a.appointment_date, a.appointment_time 
                       FROM appointments a 
                       JOIN patients p ON a.patient_id = p.id
                       JOIN doctors d ON a.doctor_id = d.id");

// Handle appointment deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM appointments WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<p class='success-message'>Appointment deleted successfully.</p>";
    } else {
        echo "<p class='error-message'>Error deleting appointment: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Navbar Styles */
        nav {
            background-color: #2e7d32;
            overflow: hidden;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            display: block;
            font-size: 1.1rem;
        }

        nav ul li a:hover {
            background-color: #1b5e20;
            border-radius: 4px;
        }

        /* Header Styles */
        h1 {
            background-color: #43a047;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin: 0;
            font-size: 2.5rem;
        }

        /* Container for Appointments */
        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Appointment Item Styles */
        .appointment-item {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .appointment-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .appointment-item h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #1976d2;
        }

        .appointment-item p {
            font-size: 1.1rem;
            margin: 8px 0;
            color: #555;
        }

        .appointment-item .appointment-date-time {
            font-weight: bold;
            color: #388e3c;
        }

        .appointment-item .appointment-info {
            color: #333;
            font-size: 1rem;
            margin: 4px 0;
        }

        .appointment-actions {
            margin-top: 10px;
        }

        .appointment-actions a {
            color: #fff;
            background-color: #1976d2;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 10px;
        }

        .appointment-actions a:hover {
            background-color: #1565c0;
        }

        .no-appointments {
            text-align: center;
            font-size: 1.2rem;
            color: #d32f2f;
            padding: 20px;
            border-radius: 5px;
            background-color: #ffe0e0;
        }

        /* Success and Error Messages */
        .success-message {
            background-color: #e8f5e9;
            color: #388e3c;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            font-size: 1.1rem;
        }

        .error-message {
            background-color: #ffcdd2;
            color: #d32f2f;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Responsive Styling */
        @media screen and (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .container {
                padding: 20px;
                margin: 20px;
            }

            .appointment-item {
                padding: 15px;
            }

            .appointment-item h2 {
                font-size: 1.3rem;
            }

            .appointment-item p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar Section -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="patient_registration.php">Patient Registration</a></li>
            <li><a href="doctor_management.php">Doctor Management</a></li>
            <li><a href="appointment_booking.php">Book Appointment</a></li>
            <li><a href="appointments.php">View Appointments</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <h1>View Appointments</h1>

    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                echo "<div class='appointment-item'>";
                echo "<h2>Appointment ID: " . $row['id'] . "</h2>";
                echo "<p class='appointment-info'>Patient Name: " . $row['patient_name'] . "</p>";
                echo "<p class='appointment-info'>Doctor Name: " . $row['doctor_name'] . "</p>";
                echo "<p class='appointment-info appointment-date-time'>Appointment Date: " . $row['appointment_date'] . "</p>";
                echo "<p class='appointment-info appointment-date-time'>Appointment Time: " . $row['appointment_time'] . "</p>";
                echo "<div class='appointment-actions'>";
                echo "<a href='appointments.php?delete_id=" . $row['id'] . "'>Delete</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-appointments'>No appointments found.</p>";
        }

        $conn->close();
        ?>
    </div>

</body>
</html>
