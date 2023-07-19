<?php

require_once "connect.php";

session_start();

// Check if the user is already logged in, if yes, redirect to profile.php
if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform additional validation and sanitization as per your requirements

    // Prepare the SQL statement with placeholders
    $checkUserQuery = "SELECT * FROM users WHERE username = ?";

    // Check if the username exists
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Username exists, verify the password
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            // Password is correct, set the session and redirect to profile.php
            $_SESSION['user_id'] = $row['id'];
            header("Location: profile.php");
            exit;
        } else {
            // Invalid password, display an error message
            $error = "Invalid password. Please try again.";
        }
    } else {
        // Invalid username, display an error message
        $error = "Invalid username. Please try again.";
    }

    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>User Management System - Login</title>
</head>

<body>
    <h1>User Login</h1>
    <?php if (isset($error)) { ?>
        <p style="color: red;">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php } ?>
    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
    <br>
    <a href="index.php">Back to Home</a>
    <a href="register.php">Go to Register</a>
</body>

</html>
