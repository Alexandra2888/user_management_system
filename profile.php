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
    <title>User Management System - Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <h1>User Profile</h1>
    <p><strong>Full Name:</strong>
        <?php echo $username; ?>
    </p>
    <p><strong>Email:</strong>
        <?php echo $email; ?>
    </p>
    <p><strong>Age:</strong>
        <?php echo $age; ?>
    </p>
    <p><strong>Bio:</strong>
        <?php echo $bio; ?>
    </p>
    <br>
    <button onclick="confirmEdit()">Edit Profile</button>
    <br>
    <button onclick="confirmDelete()">Delete Account</button>
    <br>
    <a href="logout.php">Logout</a>

    <script>
        function confirmEdit() {
            Swal.fire({
                title: 'Do you want to edit your profile?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'edit_profile.php';
                }
            });
        }

        function confirmDelete() {
            Swal.fire({
                title: 'Are you sure you want to delete your account?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete my account',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Account Deleted',
                        text: 'Your account has been deleted.',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'delete.php';
                    });
                }
            });
        }
    </script>
</body>

</html>