<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";  // user
$password = "";      // password
$dbname = "bdworshop2";  // db name

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
