<?php

include "connect.php";

session_start();

// Function to check if the user is logged in
function checkLoggedIn()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

// Function to update the user's profile data
function updateProfile($conn)
{
    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    // Get the updated profile data from the form submission
    $username = $_POST['username'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $bio = $_POST['bio'];

    // Update the user's profile data in the database
    $updateProfileQuery = "UPDATE profiles SET username = ?, email = ?, age = ?, bio = ? WHERE user_id = ?";
    $stmt = $conn->prepare($updateProfileQuery);
    $stmt->bind_param("sssii", $username, $email, $age, $bio, $userId);
    $stmt->execute();
    $stmt->close();
}

// Check if the user is logged in
checkLoggedIn();

// Update the user's profile
updateProfile($conn);

$conn->close();

// Redirect to the profile page after saving the changes
header("Location: ../pages/profile.html");
exit;
?>