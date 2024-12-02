<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect username and password directly from the form
    $username = $_POST['username'];
    $password = $_POST['password']; // Password is stored as plain text
    $role = 'user'; // Default role is user

    try {
        // Insert user with plain text password into the database
        $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
        $stmt->execute([$username, $password, $role]);
        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// session_start();
// require 'db.php';
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// $username = $_POST['username'];
// $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// try {
// $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, "user")');
// $stmt->execute([$username, $password]);
// header('Location: login.php');
// exit;
// } catch (PDOException $e) {
// $error = "Error: " . $e->getMessage();
// }
// }

?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
</head>

<body class="bg-light">
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Register</h1>
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
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>