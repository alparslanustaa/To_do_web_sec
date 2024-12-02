<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="header">
    <link rel="stylesheet" href="Style.css">
    <a href="index.php"><h2>TaskHive</h2></a>
    <div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="tasks.php">My Tasks</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-primary">Login</a>
        <?php endif; ?>
    </div>
</div>
