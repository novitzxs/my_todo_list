<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = trim($_POST['task_name']);
    if (!empty($task_name)) {
        $stmt = $conn->prepare("INSERT INTO tasks (task_name) VALUES (:task_name)");
        $stmt->execute(['task_name' => $task_name]);
    }
}
header("Location: index.php");
exit();
?>
