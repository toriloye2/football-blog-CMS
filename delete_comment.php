<?php
session_start();

// Include the database connection file
require('connect.php');

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}

// Check if the comment ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $commentId = $_GET['id'];

    try {
        // Perform the deletion of the comment
        $deleteStmt = $db->prepare("DELETE FROM comments WHERE comment_id = :comment_id");
        $deleteStmt->bindParam(':comment_id', $commentId);
        $deleteStmt->execute();

        $_SESSION['success'] = "Comment deleted successfully";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error deleting comment: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "Invalid comment ID";
}

// Redirect back to the dashboard
header("location: dashboard.php");
exit();
?>
