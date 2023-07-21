<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Homepage.">
  <title>User Management System</title>
  <link rel="stylesheet" href="styles/main.css">
  <link rel="stylesheet" href="styles/home.css">
  <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"
    integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc"
    crossorigin="anonymous"></script>
</head>

<body>
  <nav class="navigation">
    <div class="navigation__container">
      <a href="pages/register.html" class="navigation__container--links">Register</a>
      <a href="pages/login.html" class="navigation__container--links">Login</a>
    </div>
  </nav>
  <main class="container">
    <h1 class="container__title">Welcome to User Management System</h1>
  </main>
</body>

</html>


<?php

session_start();

// Check if the user is already logged in, if yes, redirect to profile.php
if (isset($_SESSION['user_id'])) {
  header("Location: ./pages/profile.php");
  exit;
}

?>