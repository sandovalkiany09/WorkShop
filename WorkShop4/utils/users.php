<?php
include('../utils/functions.php');
require('../inc/header.php');

$users = getAllUsers(); /
?>

<div class="container-fluid">
    <div class="jumbotron">
        <h1 class="display-4">Users</h1>
        <p class="lead">List of users</p>
        <hr class="my-4">
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Province</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>{$user['name']}</td>";
                echo "<td>{$user['lastname']}</td>";
                echo "<td>{$user['username']}</td>";
                echo "<td>{$user['province']}</td>";
                echo "<td>
                        <a href='/edit_user.php?id={$user['id']}' class='btn btn-primary'>Edit</a>
                        <a href='/actions/delete_user.php?id={$user['id']}' class='btn btn-danger'>Delete</a>
                      </td>"; // Botones para editar y eliminar
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php require('../inc/footer.php'); ?>
