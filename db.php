<?php
$pdo = new PDO('mysql:host=localhost;dbname=todo_app', 'root', 'mysql');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>