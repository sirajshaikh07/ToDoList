<?php
session_start(); // Start the session
include '../config/db.php'; // Include the database connection file

if (isset($_POST['task'])) {
    $task = trim($_POST['task']); // Get the task from the form

    // Prepare the SQL statement to prevent SQL injection
    $sql = "INSERT INTO tasks (task, completed) VALUES (?, 0)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $task);

    // Execute the statement and check for errors
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Task added successfully!"; // Set a success message
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($conn); // Set an error message
    }

    mysqli_stmt_close($stmt); // Close the statement
}

// Redirect back to the main page
header('Location: ../views/index.php');
exit();
?>
