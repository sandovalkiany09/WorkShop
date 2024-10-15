<?php
require('functions.php');

// Verificar si el parámetro (cantidad de horas) fue proporcionado
if ($argc != 2) {
    echo "Usage: php validateActiveSessions.php <hours>\n";
    exit(1);
}

$hours = (int)$argv[1]; // Convertir el argumento en un número entero

if ($hours <= 0) {
    echo "Please provide a valid number of hours greater than 0.\n";
    exit(1);
}

// Obtener conexión a la base de datos
$conn = getConnection();

// Consulta para obtener usuarios activos que no han iniciado sesión en las últimas X horas
$sql = "SELECT id, username, TIMESTAMPDIFF(HOUR, last_login_datetime, NOW()) AS hours_since_last_login 
        FROM users 
        WHERE status = 'active' 
        HAVING hours_since_last_login > ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hours);
$stmt->execute();
$result = $stmt->get_result();

$users_to_deactivate = [];

while ($user = $result->fetch_assoc()) {
    $users_to_deactivate[] = $user;
}

// Si hay usuarios que cumplen la condición, se les marca como inactivos
if (count($users_to_deactivate) > 0) {
    foreach ($users_to_deactivate as $user) {
        // Actualizar el estado del usuario a "inactive"
        $update_sql = "UPDATE users SET status = 'inactive' WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $user['id']);
        $update_stmt->execute();

        echo "User with ID {$user['id']} (Username: {$user['username']}) has been marked as inactive.\n";
    }
} else {
    echo "No users found with last login greater than $hours hours.\n";
}

$stmt->close();
$conn->close();
?>
