<?php
require('functions.php');
session_start();

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Obtener conexión a la base de datos
    $conn = getConnection();

    // Buscar usuario por email
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verificar si el usuario está activo
        if ($user['status'] != 'active') {
            // Usuario inactivo, redirigir con un mensaje de error
            header("Location: /WorkShop5/login.php?error=inactive_account");
            exit();
        }

        // Si el usuario está activo, verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Credenciales correctas, iniciar sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            // Actualizar la columna last_login_datetime con la fecha y hora actual
            $update_sql = "UPDATE users SET last_login_datetime = NOW() WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $user['id']);
            $update_stmt->execute();

            // Redirigir a la página de usuarios
            header("Location: /WorkShop5/users.php");
            exit();
        } else {
            // Contraseña incorrecta, redirigir al login con mensaje de error
            header("Location: /WorkShop5/login.php?error=invalid_credentials");
            exit();
        }
    } else {
        // Usuario no existe, redirigir al formulario de registro con un mensaje
        header("Location: /WorkShop5/index.php?error=user_not_found");
        exit();
    }
}
?>
