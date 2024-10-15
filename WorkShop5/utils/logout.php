<?php
session_start();
session_unset();  // Elimina todas las variables de sesión
session_destroy();  // Destruye la sesión actual
header("Location: /WorkShop5/login.php");  // Redirige al login
exit();
?>
