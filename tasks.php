<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}
require 'db.php';

// Handle form submission to add a task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['description']) && isset($_POST['action']) && $_POST['action'] === 'add') {
    $description = $_POST['description'];
    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare('INSERT INTO tasks (user_id, description) VALUES (?, ?)');
    $stmt->execute([$userId, $description]);
    header('Location: tasks.php');
    exit;
}

// Handle task updates (edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['description']) && isset($_POST['task_id']) && $_POST['action'] === 'edit') {
    $description = $_POST['description'];
    $taskId = $_POST['task_id'];
    $stmt = $pdo->prepare('UPDATE tasks SET description = ? WHERE id = ? AND user_id = ?');
    $stmt->execute([$description, $taskId, $_SESSION['user_id']]);
    header('Location: tasks.php');
    exit;
}

// Handle task deletions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id']) && $_POST['action'] === 'delete') {
    $taskId = $_POST['task_id'];
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ? AND user_id = ?');
    $stmt->execute([$taskId, $_SESSION['user_id']]);
    header('Location: tasks.php');
    exit;
}

// Fetch tasks for the logged-in user
$stmt = $pdo->prepare('SELECT * FROM tasks WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$tasks = $stmt->fetchAll(); // Fetch all tasks. If none exist, this will be an empty array.
?>
<!DOCTYPE html>
<html>
<head>
    <title>TaskHive - My Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1 class="mb-4">My Tasks</h1>
        <form method="POST" class="mb-3">
            <input type="hidden" name="action" value="add">
            <div class="input-group">
                <input type="text" name="description" class="form-control" placeholder="New Task" required>
                <button type="submit" class="add-task" class="btn btn-primary">Add Task</button>
            </div>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tasks)): ?>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <form method="POST" style="display:inline;">
                                <td>
                                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                    <input type="text" name="description" value="<?= htmlspecialchars($task['description']) ?>" class="form-control">
                                </td>
                                <td>
                                    <button type="submit" name="action" value="edit" class="btn btn-warning btn-sm">Edit</button>
                                    <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center">No tasks available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
