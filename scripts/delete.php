<?php

include "../connect.php";

session_start();

// Function to delete user and profile data from the database
function deleteUserProfile($conn, $userId)
{
    $deleteUserQuery = "DELETE FROM users WHERE id = ?";
    $deleteProfileQuery = "DELETE FROM profiles WHERE user_id = ?";

    $stmtUser = $conn->prepare($deleteUserQuery);
    $stmtProfile = $conn->prepare($deleteProfileQuery);

    $stmtUser->bind_param("i", $userId);
    $stmtProfile->bind_param("i", $userId);

    $stmtProfile->execute();
    $stmtUser->execute();

    $stmtProfile->close();
    $stmtUser->close();
}

// Check if the user is not logged in, redirect to login.html
if (!isset($_SESSION['user_id'])) {
    header("Location: ../ages/login.html");
    exit;
}

// Get the user ID from the session
$userId = $_SESSION['user_id'];

// Delete the user and profile data from the database
deleteUserProfile($conn, $userId);

$conn->close();

// Clear the user session
session_destroy();

// Redirect to the register page
header("Location: ../pages/register.html");
exit;
?>