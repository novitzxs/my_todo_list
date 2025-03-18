<?php
include 'db.php';

// Fetch pending tasks
$pending_stmt = $conn->prepare("SELECT * FROM tasks WHERE is_completed = 0 ORDER BY created_at DESC");
$pending_stmt->execute();
$pending_tasks = $pending_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch completed tasks
$completed_stmt = $conn->prepare("SELECT * FROM tasks WHERE is_completed = 1 ORDER BY created_at DESC");
$completed_stmt->execute();
$completed_tasks = $completed_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="prettier.css">
</head>
<body>

    <div class="container">
        <div class="left-box">TODO LIST</div>
        <div class="right-box">
            
            <!-- NEW TASK SECTION -->
            <div class="new-task">
                <h2>NEW TASK</h2>
                <form action="add_task.php" method="POST">
                    <input type="text" name="task_name" id="taskInput" required>
                    <button type="submit" id="addTaskButton">Add Task</button>
                </form>
            </div>

            <!-- TASK LIST SECTION -->
            <div class="task-list">
                <h2>TASK LIST</h2>
                <ul id="listTask">
                    <?php if (!empty($pending_tasks)): ?>
                        <?php foreach ($pending_tasks as $task): ?>
                            <li>
                                <span class="task-text"><?= htmlspecialchars($task['task_name']); ?></span>
                                <div class="task-buttons">
                                    <a href="edit_task.php?id=<?= urlencode($task['id']); ?>" class="edit-btn">✏ Edit</a>
                                    <a href="complete_task.php?id=<?= urlencode($task['id']); ?>" class="complete-btn">✔ Complete</a>
                                    <a href="delete_task.php?id=<?= urlencode($task['id']); ?>" class="delete-btn">❌ Delete</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No pending tasks.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- COMPLETED TASK SECTION -->
            <div class="completed-task">
                <h2>COMPLETED TASK</h2>
                <ul id="completedTasks">
                    <?php if (!empty($completed_tasks)): ?>
                        <?php foreach ($completed_tasks as $task): ?>
                            <li>
                                <span class="task-text"><?= htmlspecialchars($task['task_name']); ?></span>
                                <a href="delete_task.php?id=<?= urlencode($task['id']); ?>" class="delete-btn">❌ Delete</a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No completed tasks yet.</li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>

</body>
</html>
