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
    $username = htmlspecialchars($profileData['username']);
    $email = htmlspecialchars($profileData['email']);
    $age = htmlspecialchars($profileData['age']);
    $bio = htmlspecialchars($profileData['bio']);
} else {
    // User profile data not found
    $username = "N/A";
    $email = "N/A";
    $age = "N/A";
    $bio = "N/A";
}

$stmt->close();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the form data
    $newEmail = $_POST['email'];
    $newAge = $_POST['age'];
    $newBio = $_POST['bio'];

    // Update the user's profile information in the database
    $updateProfileQuery = "UPDATE profiles SET email = ?, age = ?, bio = ? WHERE user_id = ?";
    $stmtUpdate = $conn->prepare($updateProfileQuery);
    $stmtUpdate->bind_param("sssi", $newEmail, $newAge, $newBio, $userId);
    $stmtUpdate->execute();

    // Redirect to the profile page after successful update
    header("Location: profile.php");
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Management System - Edit Profile</title>
</head>

<body>
    <h1>Edit Profile</h1>
    <form method="POST" action="edit_profile.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" disabled>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        <br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo $age; ?>" required>
        <br>
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio" rows="10" required><?php echo $bio; ?></textarea>
        <br>
        <input type="submit" value="Save">
    </form>
    <br>
    <a href="profile.php">Cancel</a>
</body>

</html>