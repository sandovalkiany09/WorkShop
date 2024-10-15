<?php
include('utils/functions.php');

$conn = getConnection();
$sql = "SELECT users.id, users.name, users.lastname, users.username, provinces.name as province FROM users INNER JOIN provinces ON users.province_id = provinces.id";
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
    <!-- Mensajes de confirmación -->
    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success">
        <?php if ($_GET['success'] == 'edit'): ?>
          User updated successfully!
        <?php elseif ($_GET['success'] == 'delete'): ?>
          User deleted successfully!
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Province</th>
          <th>Actions</th>
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
          // Botones de editar y eliminar
          echo "<td>";
          echo "<a href='edit_user.php?id={$row['id']}' class='btn btn-primary'>Edit</a> ";
          echo "<a href='delete_user.php?id={$row['id']}' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>";
          echo "</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
    <a href="utils/logout.php" class="btn btn-danger mt-3">Log Out</a>
  </div>
</body>
</html>
