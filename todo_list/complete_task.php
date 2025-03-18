<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("UPDATE tasks SET is_completed = 1 WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
header("Location: index.php");
exit();
?>
