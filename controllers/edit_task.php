<?php
session_start(); // Start the session
include '../config/db.php'; // Include the database connection file

// Check if the task ID is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the task ID from the query parameter

    // Fetch the task from the database
    $sql = "SELECT * FROM tasks WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $task = mysqli_fetch_assoc($result);

    if (!$task) {
        // Task not found, redirect to index
        $_SESSION['message'] = "Task not found!";
        header('Location: ../views/index.php');
        exit();
    }
} else {
    // No task ID provided, redirect to index
    $_SESSION['message'] = "No task ID provided!";
    header('Location: ../views/index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Edit Task</title>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Edit Task</h1>

    <form action="../controllers/update_task.php" method="POST" class="mb-4">
        <input type="hidden" name="id" value="<?= htmlspecialchars($task['id']) ?>"> <!-- Hidden input for task ID -->
        <div class="mb-3">
            <label for="task" class="form-label">Task Description</label>
            <input type="text" name="task" id="task" class="form-control" value="<?= htmlspecialchars($task['task']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Task</button>
        <a href="../views/index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
