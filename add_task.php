<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Girdi temizlenmeden kullanılıyor
    $description = $_POST['description'];
    $stmt = $pdo->prepare('INSERT INTO tasks (user_id, description) VALUES (?, ?)');
    $stmt->execute([$_SESSION['user_id'], $description]);

    // Eklenen görevi doğrudan çıktılıyoruz (güvensiz)
    echo "Task added: " . $description;
    exit;
}

?>
<!DOCTYPE html>
<html>

<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
</head>

<body>
    <form method="POST">
        <input type="text" name="description" placeholder="Add a task">
        <button type="submit">Submit</button>
    </form>
    <?php include 'footer.php'; ?>
</body>

</html>