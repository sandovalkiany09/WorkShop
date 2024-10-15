<?php
session_start();
include('utils/functions.php');

$conn = getConnection();
$user_id = $_GET['id'];

// Obtener los datos actuales del usuario
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_POST) {
    // Actualizar los datos del usuario
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $province_id = $_POST['province'];

    $update_sql = "UPDATE users SET name = ?, lastname = ?, username = ?, province_id = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssii", $firstName, $lastName, $email, $province_id, $user_id);
    
    if ($stmt->execute()) {
        header("Location: /WorkShop5/users.php?success=edit");
        exit();
    } else {
        echo "Error updating user.";
    }
}

// Obtener la lista de provincias
$provinces = getProvinces();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Edit User</h1>
    <form method="post">
      <div class="form-group">
        <label for="first-name">First Name</label>
        <input id="first-name" class="form-control" type="text" name="firstName" value="<?php echo $user['name']; ?>">
      </div>
      <div class="form-group">
        <label for="last-name">Last Name</label>
        <input id="last-name" class="form-control" type="text" name="lastName" value="<?php echo $user['lastname']; ?>">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" class="form-control" type="text" name="email" value="<?php echo $user['username']; ?>">
      </div>
      <div class="form-group">
        <label for="province">Province</label>
        <select id="province" class="form-control" name="province">
          <?php
          foreach ($provinces as $id => $province) {
              $selected = $user['province_id'] == $id ? 'selected' : '';
              echo "<option value=\"$id\" $selected>$province</option>";
          }
          ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</body>
</html>
