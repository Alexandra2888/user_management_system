<?php

require_once "../connect.php";

session_start();

// Check if the user is already logged in, if yes, redirect to profile.html
if (isset($_SESSION['user_id'])) {
    header("Location: ../pages/profile.html");
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform additional validation and sanitization 

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
            // Password is correct, set the session and redirect to profile.html
            $_SESSION['user_id'] = $row['id'];
            header("Location: ../pages/profile.html");
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