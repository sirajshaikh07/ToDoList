<?php
session_start(); // Start the session
include '../config/db.php'; // Include the database connection file

if (isset($_POST['id']) && isset($_POST['task'])) {
    $id = intval($_POST['id']); // Get the task ID
    $task = trim($_POST['task']); // Get the updated task description

    // Prepare the SQL statement to update the task
    $sql = "UPDATE tasks SET task = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $task, $id);

    // Execute the statement and check for errors
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Task updated successfully!"; // Set a success message
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($conn); // Set an error message
    }

    mysqli_stmt_close($stmt); // Close the statement
}

// Redirect back to the main page
header('Location: ../views/index.php');
exit();
?>
