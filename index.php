<?php
// File-based storage for simplicity
$file = 'tasks.txt';

// Handle new task submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['task'])) {
    $task = trim($_POST['task']);
    file_put_contents($file, $task . PHP_EOL, FILE_APPEND);
}

// Handle delete action
if (isset($_GET['del'])) {
    $tasks = file($file, FILE_IGNORE_NEW_LINES);
    unset($tasks[$_GET['del']]);
    file_put_contents($file, implode(PHP_EOL, $tasks) . PHP_EOL);
}

// Get current list
$tasks = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>PHP Mini To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>PHP Mini To-Do List</h1>
    <form method="post">
        <input type="text" name="task" placeholder="Add new task" required>
        <button type="submit">Add</button>
    </form>
    <ul>
        <?php foreach($tasks as $i => $t): ?>
        <li>
            <?php echo htmlspecialchars($t); ?>
            <a href="?del=<?php echo $i; ?>" class="del">Delete</a>
        </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
