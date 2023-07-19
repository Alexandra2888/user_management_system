<!DOCTYPE html>
<html lang="en">
<head>
  <title>User Management System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Welcome to User Management System</h1>
    <a href="register.php">Register</a>
    <br>
    <a href="login.php">Login</a>
</body>
</html>


<?php
session_start();

// Check if the user is already logged in, if yes, redirect to profile.php
if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit;
}

?>