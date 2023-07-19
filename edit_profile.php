<?php

include "connect.php";

session_start();

// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}



// Get the user ID from the session
$userId = $_SESSION['user_id'];

// Fetch user profile data from the database
$selectProfileQuery = "SELECT * FROM profiles WHERE user_id = ?";
$stmt = $conn->prepare($selectProfileQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // User profile data found, fetch and assign the information
    $profileData = $result->fetch_assoc();
    $username = $profileData['username'];
    $email = $profileData['email'];
    $age = $profileData['age'];
    $bio = $profileData['bio'];
} else {
    // User profile data not found
    $username = "N/A";
    $email = "N/A";
    $age = "N/A";
    $bio = "N/A";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Management System - Edit Profile</title>
</head>

<body>
    <h1>Edit Profile</h1>
    <form method="POST" action="save_profile.php">
        <label for="fullName">Full Name:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        <br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo $age; ?>" required>
        <br>
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio" required><?php echo $bio; ?></textarea>
        <br>
        <button type="submit">Save</button>
    </form>
    <br>
    <a href="profile.php">Cancel</a>
</body>

</html>