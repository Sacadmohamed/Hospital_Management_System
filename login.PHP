<?php
// Start the session to track the user login
session_start();
include('config.php');

// If the user is already logged in, redirect to the dashboard
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Handle form submission for login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL query to fetch the user from the database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // Bind the username parameter
    $stmt->execute();

    // Get the result of the query
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if the user exists and password matches
    if ($user && $password == $user['password']) {
        // Valid credentials, store session data
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role']; // Store user role in session

        // Redirect to the dashboard
        header("Location: index.php");
        exit;
    } else {
        // Invalid credentials, show an error message
        $error_message = "Invalid username or password. Please try again.";
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}

// If the user has clicked the logout link, it will destroy the session
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session to log out
    header("Location: login.php"); // Redirect back to login page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KASHI HOSPITAL MANAGEMENT SYSTEM - Login</title>
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

        .login-container {
            max-width: 400px;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            color: #009688;
        }

        .login-container label {
            font-size: 1.1rem;
            margin-bottom: 10px;
            display: block;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            background-color: #009688;
            color: white;
            font-size: 1.1rem;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .login-container input[type="submit"]:hover {
            background-color: #00796b;
        }

        .error-message {
            background-color: #ffcdd2;
            color: #d32f2f;
            padding: 10px;
            text-align: center;
            font-size: 1rem;
            margin-top: 20px;
            border-radius: 5px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #009688;
            color: white;
            position: absolute;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

    <h1>KASHI HOSPITAL MANAGEMENT SYSTEM</h1>

    <!-- Login Form -->
    <div class="login-container">
        <h2>Login</h2>

        <!-- Display error message if login fails -->
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Login">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Kashi Hospital Management System. All Rights Reserved (Muhida).</p>
    </footer>
</body>
</html>
