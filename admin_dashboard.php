<?php
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: login.php');
//     exit;
// }
require 'db.php';

// Handle Add User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
    $stmt->execute([$username, $password, $role]);
    header('Location: admin_dashboard.php');
    exit;
}

// Handle Edit User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $userId = $_POST['user_id'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    $stmt = $pdo->prepare('UPDATE users SET username = ?, role = ? WHERE id = ?');
    $stmt->execute([$username, $role, $userId]);

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->execute([$password, $userId]);
    }
    header('Location: admin_dashboard.php');
    exit;
}

// Handle Delete User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $userId = $_POST['delete_user'];
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$userId]);
    header('Location: admin_dashboard.php');
    exit;
}

// Fetch all users
$stmt = $pdo->query('SELECT * FROM users');
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
</head>

<body class="bg-light">
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Admin Dashboard</h1>
        <h2>Add User</h2>
        <form method="POST" class="mb-4">
            <input type="hidden" name="add_user" value="1">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <select name="role" class="form-control">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
        <h2>Manage Users</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <form method="POST">
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td>
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>"
                                    class="form-control">
                            </td>
                            <td>
                                <select name="role" class="form-control">
                                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                </select>
                            </td>
                            <td>
                                <button type="submit" name="edit_user" class="btn btn-warning btn-sm">Edit</button>
                                <button type="submit" name="delete_user" value="<?= $user['id'] ?>"
                                    class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>