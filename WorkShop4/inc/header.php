<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign up</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="navId">
    <li class="nav-item">
      <a href="/WorkShop4/utils/signup.php" class="nav-link active">Signup</a>
    </li>
    <li class="nav-item">
      <a href="/WorkShop4/index.php" class="nav-link active">Login</a>
    </li>
    <li class="nav-item">
      <a href="/WorkShop4/actions/logout.php" class="nav-link active">Logout</a>
    </li>

    <li class="nav-item">
      <a href="/WorkShop4/utils/users.php" class="nav-link">Users</a>
    </li>
    <li>
       Hola <?php echo $user ? htmlspecialchars($user['name']) : 'Invitado'; ?>
    </li>
  </ul>
