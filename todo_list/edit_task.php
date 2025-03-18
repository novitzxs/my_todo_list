<?php
include 'db.php';

// Check if task ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid task ID.");
}

$id = $_GET['id'];

// Fetch task details from the database
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = :id");
$stmt->execute(['id' => $id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    die("Task not found.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_task_name = trim($_POST['task_name']);
    if (!empty($new_task_name)) {
        $update_stmt = $conn->prepare("UPDATE tasks SET task_name = :task_name WHERE id = :id");
        $update_stmt->execute(['task_name' => $new_task_name, 'id' => $id]);

        // Redirect back to index.php after updating
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h2>Edit Task</h2>
        <form action="" method="POST">
            <input type="text" name="task_name" value="<?= htmlspecialchars($task['task_name']); ?>" required>
            <button type="submit">Update Task</button>
        </form>
        <a href="index.php">Cancel</a>
    </div>

</body>
</html>
