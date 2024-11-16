<?php
include('config.php');

// Add a new doctor
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fullname'])) {
    $fullname = $_POST['fullname'];
    $specialty = $_POST['specialty'];
    $contact = $_POST['contact'];
    $address_det = $_POST['address_det'];

    $sql = "INSERT INTO doctors (fullname, specialty, contact, address_det) VALUES ('$fullname', '$specialty', '$contact', '$address_det')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-message'>New doctor added successfully.</p>";
    } else {
        echo "<p class='error-message'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Delete doctor
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM doctors WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<p class='success-message'>Doctor deleted successfully.</p>";
    } else {
        echo "<p class='error-message'>Error deleting doctor: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Management</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
            color: #333;
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

        /* Container for the Form */
        .container {
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Form Fields */
        label {
            font-size: 1.1rem;
            margin-bottom: 5px;
            display: inline-block;
            color: #555;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #2e7d32;
            outline: none;
        }

        textarea {
            height: 150px;
            resize: vertical;
        }

        /* Submit Button */
        input[type="submit"] {
            background-color: #2e7d32;
            color: white;
            font-size: 1.1rem;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0d47a1;
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

        /* Table Styles */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #2e7d32;
            color: white;
        }

        button {
            background-color: #1976d2;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #1565c0;
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

            input[type="submit"] {
                font-size: 1rem;
            }

            nav ul {
                flex-direction: column;
            }

            nav ul li {
                margin: 10px 0;
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
    <h1>Manage Doctors</h1>

    <div class="container">
        <form method="POST">
            <label for="fullname">Doctor Name:</label>
            <input type="text" name="fullname" required>

            <label for="specialty">Specialty:</label>
            <input type="text" name="specialty" required>

            <label for="contact">Contact Number:</label>
            <input type="text" name="contact" required>

            <label for="address_det">Address:</label>
            <textarea name="address_det"></textarea>

            <input type="submit" value="Add Doctor">
        </form>
    </div>

    <!-- Display Doctors -->
    <div class="container">
        <h2>List of Doctors</h2>
        <?php
        $result = $conn->query("SELECT * FROM doctors");
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Specialty</th><th>Contact</th><th>Address</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['fullname'] . "</td>
                        <td>" . $row['specialty'] . "</td>
                        <td>" . $row['contact'] . "</td>
                        <td>" . $row['address_det'] . "</td>
                        <td>
                            <a href='?delete_id=" . $row['id'] . "'><button>Delete</button></a>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No doctors found.</p>";
        }
        ?>
    </div>

</body>
</html>
