<?php
session_start();
include '../config/db.php';

// Get the task ID from the URL
if (isset($_GET['id'])) {
    $taskId = $_GET['id'];

    // Retrieve the current status of the task
    $query = "SELECT completed FROM tasks WHERE id = $taskId";
    $result = mysqli_query($conn, $query);
    $task = mysqli_fetch_assoc($result);

    if ($task) {
        // Toggle the completed status
        $newStatus = $task['completed'] ? 0 : 1; // If completed, set to 0 (uncompleted), otherwise set to 1
        $updateQuery = "UPDATE tasks SET completed = $newStatus WHERE id = $taskId";
        mysqli_query($conn, $updateQuery);
        
        $_SESSION['message'] = 'Task status updated successfully!';
    } else {
        $_SESSION['message'] = 'Task not found.';
    }
} else {
    $_SESSION['message'] = 'Invalid task ID.';
}

// Redirect back to the main page
header('Location: ../views/index.php');
exit();
