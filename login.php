<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Şifre düz metinle karşılaştırılıyor

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) { // Güvensiz doğrulama
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: tasks.php');
        exit;
    } else {
        echo "Invalid username or password.";
    }
}
// session_start();
// require 'db.php';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// $username = $_POST['username'];
// $password = $_POST['password'];

// $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
// $stmt->execute([$username]);
// $user = $stmt->fetch();

// if ($user && password_verify($password, $user['password'])) {
// // Set session variables
// $_SESSION['user_id'] = $user['id'];
// $_SESSION['role'] = $user['role'];

// // Redirect based on role
// if ($user['role'] === 'admin') {
// header('Location: admin_dashboard.php');
// } else {
// header('Location: tasks.php');
// }
// exit;
// } else {
// $error = "Invalid username or password.";
// }
// }


?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
</head>

<body class="bg-light">
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Login</h1>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" class="w-50 mx-auto">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>