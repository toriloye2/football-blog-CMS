<?php
session_start();
require('connect.php');
include 'header.php';

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $welcomeMessage = "Welcome, " . $_SESSION["name"] . "!";
} else {
    // If not logged in, redirect to the login page
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Create Category</h2>

    <!-- ✅ Display Session Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']); // Remove message after displaying
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']); // Remove message after displaying
            ?>
        </div>
    <?php endif; ?>

    <div class="form-outline mb-4">
        <form method="post" action="create_category.php">
            <label for="categoryName">Category Name:</label>
            <input class="form-control" type="text" name="position" required>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</div>

</body>
</html>
