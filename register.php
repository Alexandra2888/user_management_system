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
    $password = $_POST['password'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $bio = $_POST['bio'];

    // Perform additional validation as per your requirements

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $checkUsernameQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkUsernameQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Username already exists, display an error message
        $error = "Username already exists. Please choose a different username.";
    } else {
        // Username is available, save the new user in the database
        $insertUserQuery = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmtUser = $conn->prepare($insertUserQuery);
        $stmtUser->bind_param("ss", $username, $hashedPassword);
        $stmtUser->execute();
        $userId = $stmtUser->insert_id;
        $stmtUser->close();

        // Save the profile associated with the new user
        $insertProfileQuery = "INSERT INTO profiles (user_id, username, email, age, bio) VALUES (?, ?, ?, ?, ?)";
        $stmtProfile = $conn->prepare($insertProfileQuery);
        $stmtProfile->bind_param("issss", $userId, $username, $email, $age, $bio);
        $stmtProfile->execute();
        $stmtProfile->close();

        // Redirect to the login page after successful registration
        header("Location: login.php");
        exit;
    }

    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>User Management System - Register</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <h1>User Registration</h1>
    <?php if (isset($error)) { ?>
        <p style="color: red;">
            <?php echo $error; ?>
        </p>
    <?php } ?>
    <form method="POST" action="register.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
        <br>
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio" rows="10" required></textarea>
        <br>
        <input type="submit" value="Register">
    </form>
    <br>
    <a href="login.php">Go to Login</a>
    <a href="index.php">Back to Home</a>
</body>

</html>
