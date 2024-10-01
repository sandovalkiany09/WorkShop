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
