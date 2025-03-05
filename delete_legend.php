<?php
session_start();
require('connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $player_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if ($player_id !== false) {
        // Perform the delete operation
        $delete_sql = "DELETE FROM football_legends WHERE player_id = :player_id";
        $delete_stmt = $db->prepare($delete_sql);
        $delete_stmt->bindParam(':player_id', $player_id, PDO::PARAM_INT);

        if ($delete_stmt->execute()) {
            $_SESSION['success'] = "Football legend deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting football legend";
        }
    } else {
        $_SESSION['error'] = "Invalid player ID";
    }
} else {
    $_SESSION['error'] = "Invalid request";
}

// Debugging: Check if session messages are being set
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

exit();
?>
