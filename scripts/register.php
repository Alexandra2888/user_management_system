<?php

require_once "../connect.php";

session_start();

// Function to check if the user is already logged in
function checkLoggedIn()
{
    if (isset($_SESSION['user_id'])) {
        header("Location: ../pages/login.html");
        exit;
    }
}

// Function to process the form data and register the new user
function registerUser($conn)
{
    // Validate and sanitize the form data
    $password = $_POST['password'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $bio = $_POST['bio'];

    // Perform additional validation and sanitization 

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statements with placeholders
    $checkUsernameQuery = "SELECT * FROM users WHERE username = ?";
    $insertUserQuery = "INSERT INTO users (username, password) VALUES (?, ?)";
    $insertProfileQuery = "INSERT INTO profiles (user_id, username, email, age, bio) VALUES (?, ?, ?, ?, ?)";

    // Check if the username already exists
    $stmt = $conn->prepare($checkUsernameQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists, display an error message
        $error = "Username already exists. Please choose a different username.";
    } else {
        // Username is available, save the new user in the database
        $stmtUser = $conn->prepare($insertUserQuery);
        $stmtUser->bind_param("ss", $username, $hashedPassword);
        $stmtUser->execute();
        $userId = $stmtUser->insert_id;
        $stmtUser->close();

        // Save the profile associated with the new user
        $stmtProfile = $conn->prepare($insertProfileQuery);
        $stmtProfile->bind_param("issss", $userId, $username, $email, $age, $bio);
        $stmtProfile->execute();
        $stmtProfile->close();

        // Redirect to the login page after successful registration
        header("Location: ../pages/login.html");
        exit;
    }

    $stmt->close();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkLoggedIn();
    registerUser($conn);
}

$conn->close();

?>