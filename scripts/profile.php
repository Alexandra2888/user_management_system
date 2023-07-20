<?php
session_start();

// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

include "../connect.php";

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
$conn->close();

// Return the profile data as JSON
echo json_encode([
    'username' => $username,
    'email' => $email,
    'age' => $age,
    'bio' => $bio,
]);
?>