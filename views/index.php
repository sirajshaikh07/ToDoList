<?php
session_start();
include '../config/db.php';

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

$sql = "SELECT * FROM tasks";
if ($filter == 'completed') {
    $sql .= " WHERE completed = 1";
} elseif ($filter == 'pending') {
    $sql .= " WHERE completed = 0";
}
$sql .= " ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">
    <title>To-Do List</title>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">To-Do List</h1>

    <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="mb-3 text-center">
        <a href="index.php?filter=all" class="btn btn-secondary">Show All</a>
        <a href="index.php?filter=pending" class="btn btn-warning">Show Pending</a>
        <a href="index.php?filter=completed" class="btn btn-success">Show Completed</a>
    </div>

    <form action="../controllers/add_task.php" method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" name="task" class="form-control" placeholder="Enter your task here" required>
            <button class="btn btn-primary" type="submit">Add Task</button>
        </div>
    </form>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <ul class="list-group" id="taskList">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($task = mysqli_fetch_assoc($result)) {
                        $completedClass = $task['completed'] ? 'text-decoration-line-through' : '';
                        $buttonText = $task['completed'] ? 'Undo' : 'Complete';
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center $completedClass'>" .
                             htmlspecialchars($task['task']) .
                             "<div>" .
                             "<a href='../controllers/complete_task.php?id=" . $task['id'] . "' class='btn btn-sm btn-warning me-2'>$buttonText</a>" .
                             "<a href='../controllers/edit_task.php?id=" . $task['id'] . "' class='btn btn-sm btn-warning me-2'>Edit</a>" .
                             "<a href='../controllers/delete_task.php?id=" . $task['id'] . "' class='btn btn-sm btn-danger'>Delete</a>" .
                             "</div></li>";
                    }
                } else {
                    echo "<li class='list-group-item text-center'>No tasks yet!</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
