<?php
session_start();
require('connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if ($user_id !== false) {
        // Perform the delete operation
        $delete_sql = "DELETE FROM user WHERE user_id = :user_id";
        $delete_stmt = $db->prepare($delete_sql);
        $delete_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($delete_stmt->execute()) {
            $_SESSION['success'] = "User deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting user";
        }
    } else {
        $_SESSION['error'] = "Invalid user ID";
    }
} else {
    $_SESSION['error'] = "Invalid request";
}

header("Location: dashboard.php");
exit();
?>
