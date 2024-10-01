<?php
include('utils/functions.php');

$conn = getConnection();
$sql = "SELECT users.name, users.lastname, users.username, provinces.name as province FROM users INNER JOIN provinces ON users.province_id = provinces.id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1 class="display-4">Users</h1>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Province</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>{$row['name']}</td>";
          echo "<td>{$row['lastname']}</td>";
          echo "<td>{$row['username']}</td>";
          echo "<td>{$row['province']}</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary mt-3">Back to Signup</a>
  </div>
</body>
</html>
