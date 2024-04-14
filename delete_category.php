<?php
session_start();

// Include the database connection file
require('connect.php');
include 'header.php';

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}

// Check if the category ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $categoryId = $_GET['id'];

    try {
        // Perform the deletion of the category
        $deleteStmt = $db->prepare("DELETE FROM categories WHERE id = :id");
        $deleteStmt->bindParam(':id', $categoryId);
        $deleteStmt->execute();

        $_SESSION['success'] = "Category deleted successfully";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error deleting category: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "Invalid category ID";
}

// Redirect back to the dashboard
header("location: dashboard.php");
exit();
?>
