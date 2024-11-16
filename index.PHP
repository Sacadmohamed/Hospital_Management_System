<?php
// Start the session to access session variables
session_start();

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle logout by destroying the session and redirecting to login page
if (isset($_GET['logout'])) {
    session_destroy();  // Destroy session data
    header("Location: login.php");  // Redirect to login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    
    <!-- Link to Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        h1 {
            background-color: #009688;
            color: white;
            text-align: center;
            padding: 20px;
            margin: 0;
            font-size: 2.5rem;
            letter-spacing: 1px;
        }

        nav {
            display: flex;
            justify-content: center;
            background-color: #00796b;
            padding: 10px 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            margin: 0 15px;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #ffeb3b;
        }

        nav a:active {
            color: #004d40;
        }

        /* Main dashboard container */
        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 40px auto;
            justify-content: center;
            padding: 20px;
        }

        /* Each dashboard feature block */
        .dashboard-item {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: #333;
        }

        /* Hover effects for each feature block */
        .dashboard-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .dashboard-item i {
            font-size: 3rem;
            margin-bottom: 10px;
            color: #009688;
        }

        .dashboard-item h3 {
            font-size: 1.5rem;
            margin: 10px 0;
        }

        .dashboard-item p {
            font-size: 1rem;
            color: #555;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #00796b;
            color: white;
            position: absolute;
            width: 100%;
            bottom: 0;
            margin: 0;
        }

        .logout-link {
            text-align: center;
            margin-top: 20px;
        }

        .logout-link a {
            font-size: 1.2rem;
            color: #00796b;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #ffffff;
            border: 2px solid #00796b;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .logout-link a:hover {
            background-color: #00796b;
            color: #ffffff;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .dashboard-container {
                grid-template-columns: 1fr 1fr;
            }

            .dashboard-item i {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <h1>Welcome to the KASHI Hospital Management System</h1>
    
    <nav>
        <a href="patient_registration.php">Patient Registration</a>
        <a href="doctor_management.php">Doctor Management</a>
        <a href="appointment_booking.php">Book Appointment</a>
        <a href="appointments.php">View Appointments</a>
    </nav>

    <div class="dashboard-container">
        <!-- Patient Registration Card -->
        <a href="patient_registration.php" class="dashboard-item">
            <i class="fas fa-user-plus"></i>
            <h3>Patient Registration</h3>
            <p>Add and manage patient details</p>
        </a>

        <!-- Doctor Management Card -->
        <a href="doctor_management.php" class="dashboard-item">
            <i class="fas fa-user-md"></i>
            <h3>Doctor Management</h3>
            <p>Manage doctor profiles and specialties</p>
        </a>

        <!-- Appointment Booking Card -->
        <a href="appointment_booking.php" class="dashboard-item">
            <i class="fas fa-calendar-check"></i>
            <h3>Book Appointment</h3>
            <p>Schedule appointments with doctors</p>
        </a>

        <!-- View Appointments Card -->
        <a href="appointments.php" class="dashboard-item">
            <i class="fas fa-calendar-alt"></i>
            <h3>View Appointments</h3>
            <p>View and manage scheduled appointments</p>
        </a>
    </div>

    <!-- Logout Link -->
    <div class="logout-link">
        <a href="index.php?logout=true">Logout</a>
    </div>

    <footer>
        <p>&copy; 2024 KASHI Hospital Management System. All Rights Reserved (Muhida).</p>
    </footer>
</body>
</html>
