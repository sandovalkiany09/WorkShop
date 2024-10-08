<?php

/**
 *  Gets the provinces from the database
 */
function getProvinces() {
  $conn = getConnection();
  $sql = "SELECT id, name FROM provinces";
  $result = mysqli_query($conn, $sql);

  $provinces = [];
  while($row = mysqli_fetch_assoc($result)) {
    $provinces[$row['id']] = $row['name'];
  }
  return $provinces;
}


function getConnection() {
  $connection = mysqli_connect('localhost', 'root', '', 'workshop3');
  return $connection;
}

/**
 * Saves an specific user into the database
 */
function saveUser($user) {
  $firstName = $user['firstName'];
  $lastName = $user['lastName'];
  $username = $user['email'];
  $province = $user['province_id'];
  $password = password_hash($user['password'], PASSWORD_DEFAULT);  // Encriptar la contraseña

  $sql = "INSERT INTO users (name, lastname, username, province_id, password) VALUES('$firstName', '$lastName', '$username', '$province', '$password')";

  $conn = getConnection();
  mysqli_query($conn, $sql);
  return true;
}

/**
 * Autentica a un usuario comparando el nombre de usuario y la contraseña
 */
function authenticate($username, $password) {
  $conn = getConnection();
  
  // Buscar al usuario por el correo electrónico
  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($result)) {
    // Verificar la contraseña ingresada contra la contraseña en la base de datos
    if (password_verify($password, $row['password'])) {
      return $row;  // Si coincide, devolver los datos del usuario
    }
  }
  return false;  // Si la autenticación falla
}
/**
 * Gets all users from the database with their associated provinces
 */
function getUsers() {
  $conn = getConnection();
  
  // Verifica si la conexión es exitosa
  if (!$conn) {
      die('Error en la conexión a la base de datos: ' . mysqli_connect_error());
  }

  $sql = "SELECT users.name, users.lastname, users.username, provinces.name as province
          FROM users
          JOIN provinces ON users.province_id = provinces.id";
  $result = mysqli_query($conn, $sql);

  // Verifica si la consulta fue exitosa
  if (!$result) {
      die('Error en la consulta SQL: ' . mysqli_error($conn));
  }

  $users = [];
  while ($row = mysqli_fetch_assoc($result)) {
      $users[] = $row; // Añadir cada fila de resultados al array de usuarios
  }

  return $users; // Devolver el array de usuarios
}
/**
 * Obtiene todos los usuarios de la base de datos
 */
function getAllUsers() {
  $conn = getConnection();
  $sql = "SELECT users.id, users.name, users.lastname, users.username, provinces.name AS province FROM users JOIN provinces ON users.province_id = provinces.id";
  $result = mysqli_query($conn, $sql);
  
  $users = [];
  while ($row = mysqli_fetch_assoc($result)) {
      $users[] = $row;
  }
  return $users;
}

/**
* Obtiene un usuario por su ID
*/
function getUserById($id) {
  $conn = getConnection();
  $sql = "SELECT * FROM users WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  
  return mysqli_fetch_assoc($result);
}

/**
* Actualiza la información de un usuario
*/
function updateUser($user) {
  $conn = getConnection();
  $sql = "UPDATE users SET name = ?, lastname = ?, username = ?, province_id = ? WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ssssi", $user['firstName'], $user['lastName'], $user['email'], $user['province_id'], $user['id']);
  mysqli_stmt_execute($stmt);
}

/**
* Elimina un usuario por su ID
*/
function deleteUser($id) {
  $conn = getConnection();
  $sql = "DELETE FROM users WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
}

?>
