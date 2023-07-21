<?php
include "../connect.php";

session_start();

// Function to update user's profile information in the database
function updateProfile($conn, $userId, $newEmail, $newAge, $newBio) {
    $updateProfileQuery = "UPDATE profiles SET email = ?, age = ?, bio = ? WHERE user_id = ?";
    $stmtUpdate = $conn->prepare($updateProfileQuery);
    $stmtUpdate->bind_param("sssi", $newEmail, $newAge, $newBio, $userId);

    $response = array(); // Prepare a response array

    if ($stmtUpdate->execute()) {
        $response['success'] = true;

        // Fetch updated profile data from the database
        $selectProfileQuery = "SELECT * FROM profiles WHERE user_id = ?";
        $stmt = $conn->prepare($selectProfileQuery);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // User profile data found, fetch and assign the information
            $profileData = $result->fetch_assoc();
            $response['username'] = htmlspecialchars($profileData['username']);
            $response['email'] = htmlspecialchars($profileData['email']);
            $response['age'] = htmlspecialchars($profileData['age']);
            $response['bio'] = htmlspecialchars($profileData['bio']);
        } else {
            // User profile data not found
            $response['username'] = "N/A";
            $response['email'] = "N/A";
            $response['age'] = "N/A";
            $response['bio'] = "N/A";
        }

        $stmt->close();
    } else {
        $response['success'] = false;
    }

    $stmtUpdate->close();

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

// Check if the form is submitted using AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Validate and sanitize the form data
    $newEmail = $_POST['email'];
    $newAge = $_POST['age'];
    $newBio = $_POST['bio'];

    // Update the user's profile information in the database
    updateProfile($conn, $_SESSION['user_id'], $newEmail, $newAge, $newBio);

    exit; // End the script, no further processing needed
}

$conn->close();
?>
