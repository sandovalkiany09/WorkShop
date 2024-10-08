<?php
require '../utils/functions.php';

session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
    exit();
}

// Obtener el ID del usuario a editar
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $user = getUserById($userId); // Función para obtener datos del usuario por ID

    if (!$user) {
        header('Location: /users.php?error=UserNotFound');
        exit();
    }
} else {
    header('Location: /users.php?error=NoIdProvided');
    exit();
}

// Manejar el envío del formulario
if ($_POST) {
    $userData['id'] = $userId;
    $userData['firstName'] = $_POST['firstName'];
    $userData['lastName'] = $_POST['lastName'];
    $userData['email'] = $_POST['email'];
    $userData['province_id'] = $_POST['province'];

    if (updateUser($userData)) {
        header('Location: /users.php?success=UserUpdated');
    } else {
        header('Location: /users.php?error=UpdateFailed');
    }
}

// Obtener las provincias para el formulario
$provinces = getProvinces();
?>

<?php require '../inc/header.php'; ?>
<div class="container">
    <h1>Edit User</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" name="firstName" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" name="lastName" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="form-group">
            <label for="province">Province</label>
            <select class="form-control" name="province">
                <?php foreach ($provinces as $id => $name): ?>
                    <option value="<?php echo $id; ?>" <?php echo $id == $user['province_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
<?php require '../inc/footer.php'; ?>
