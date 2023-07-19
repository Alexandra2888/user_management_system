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


// Delete the user and profile data from the database
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
$conn->close();

// Clear the user session
session_destroy();

// Redirect to the register page
header("Location: register.php");
exit;
?>