<?php
  require_once('../utils/functions.php');

  if($_POST) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    $user = authenticate($username, $password);

    if($user) {
      session_start();
      $_SESSION['user'] = $user;
      header('Location: /users.php');
    } else {
      header('Location: /index.php?error=login');
    }
  }

  /**
   * Autenticar usuario
   */
  function authenticate($username, $password) {
    $conn = getConnection();  // Conectar a la base de datos

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
      // Verifica si la contraseña es correcta
      if (password_verify($password, $row['password'])) {
        return $row;  // Devuelve los datos del usuario si la contraseña es correcta
      }
    }
    return false;  // Si la autenticación falla
  }
?>
