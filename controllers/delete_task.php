<?php
session_start(); // Start the session
include '../config/db.php'; // Include the database connection file

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the task ID from the query parameter

    // Prepare the SQL statement to delete the task
    $sql = "DELETE FROM tasks WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Execute the statement and check for errors
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Task deleted successfully!"; // Set a success message
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($conn); // Set an error message
    }

    mysqli_stmt_close($stmt); // Close the statement
}

// Redirect back to the main page
header('Location: ../views/index.php');
exit();
?>
