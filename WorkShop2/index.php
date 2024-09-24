<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Validar y sanitizar los campos
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$lastName = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
$number = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_STRING);
$gmail = filter_input(INPUT_POST, 'gmail', FILTER_SANITIZE_EMAIL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Comprobar si todos los campos están llenos
    if ($name && $lastName && $number && $gmail) {

        // Preparar la sentencia SQL para insertar los datos
        $sql = "INSERT INTO users (name, lastname, number, gmail) VALUES (?, ?, ?, ?)";

        // Preparar la declaración para evitar inyecciones SQL
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $lastName, $number, $gmail);

        // Ejecutar la declaración
        if ($stmt->execute()) {
            echo "Datos guardados correctamente";
        } else {
            echo "Error al guardar los datos: " . $conn->error;
        }

        // Cerrar la declaración
        $stmt->close();

    } else {
        echo "Por favor, completa todos los campos.";
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Print Name</title>
</head>
<body>
<form action="index.php" method="POST">
<div class="form-group">
    <label for="">Name:</label>
    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>"  placeholder="Your name">
    
    <label for="">Last Name:</label>
    <input type="text" class="form-control" name="lastname" value="<?php echo htmlspecialchars($lastName); ?>"  placeholder="Your last name">
    
    <label for="">Number:</label>
    <input type="text" class="form-control" name="number" value="<?php echo htmlspecialchars($number); ?>"  placeholder="Your number">
    
    <label for="">Gmail:</label>
    <input type="email" class="form-control" name="gmail" value="<?php echo htmlspecialchars($gmail); ?>"  placeholder="Your gmail">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</body>
</html>
