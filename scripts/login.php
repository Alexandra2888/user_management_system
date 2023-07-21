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

    // Perform additional validation and sanitization as per your requirements

    // Authenticate user
    $error = authenticateUser($conn, $username, $password);

    if (!$error) {
        // Redirect to profile.html if authentication is successful
        header("Location: ../pages/profile.html");
        exit;
    }
}

function authenticateUser($conn, $username, $password)
{
    // Prepare the SQL statement with placeholders
    $checkUserQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Username exists, verify the password
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            // Password is correct, set the session and return null for no error
            $_SESSION['user_id'] = $row['id'];
            return null;
        } else {
            // Invalid password, return error message
            return "Invalid password. Please try again.";
        }
    } else {
        // Invalid username, return error message
        return "Invalid username. Please try again.";
    }

    $stmt->close();
    return null;
}

$conn->close();
?>
