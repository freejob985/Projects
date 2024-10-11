<?php
/**
 * view_errors.php
 * 
 * This file displays the latest error messages from the WordPress creator log file.
 *
 * @author Your Name
 * @version 1.0
 */

// Include the function to get latest errors
require_once 'process.php';

// Get the latest 10 error messages
$errors = getLatestErrors(10);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WordPress Creator Error Log</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">WordPress Creator Error Log</h1>
        <div class="list-group">
            <?php foreach ($errors as $error): ?>
                <div class="list-group-item list-group-item-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (empty($errors)): ?>
            <p class="alert alert-success mt-3">No errors found in the log.</p>
        <?php endif; ?>
    </div>
</body>
</html>