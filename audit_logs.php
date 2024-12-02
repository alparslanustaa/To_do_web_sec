
        <?php
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: login.php');
            exit;
        }
        require 'db.php';

        $stmt = $pdo->query('SELECT * FROM audit_logs');
        $logs = $stmt->fetchAll();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Audit Logs</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container">
                <h1 class="my-4">Audit Logs</h1>
                <a href="tasks.php" class="btn btn-primary">Back to Tasks</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Task ID</th>
                            <th>User ID</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?= htmlspecialchars($log['action']) ?></td>
                                <td><?= htmlspecialchars($log['task_id']) ?></td>
                                <td><?= htmlspecialchars($log['user_id']) ?></td>
                                <td><?= htmlspecialchars($log['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </body>
        </html>
        