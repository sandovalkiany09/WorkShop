<?php
require '../utils/functions.php';

session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
    exit();
}

// Obtener el ID del usuario a eliminar
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    if (deleteUser($userId)) {
        header('Location: /users.php?success=UserDeleted');
    } else {
        header('Location: /users.php?error=DeleteFailed');
    }
} else {
    header('Location: /users.php?error=NoIdProvided');
}
