<?php
//session_start();
require_once('connect.php');
//include 'header.php';

// Function to sanitize user input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $playerId = isset($_POST['player_id']) ? (int)$_POST['player_id'] : 0;
    $commenterName = isset($_POST['commenter_name']) ? sanitizeInput($_POST['commenter_name']) : '';
    $commentText = isset($_POST['comment_text']) ? sanitizeInput($_POST['comment_text']) : '';
    $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;

    if ($playerId <= 0 || empty($commentText) || $categoryId <= 0) {
        echo '<p class="text-danger">Invalid input. Please provide valid data.</p>';
        exit;
    }

    // If commenter name is not provided, use the logged-in user's name
    if (empty($commenterName) && isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $stmt = $db->prepare("SELECT name FROM user WHERE user_id = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userDetails && isset($userDetails['name'])) {
            $commenterName = $userDetails['name'];
        }
    }

    // Insert the sanitized and validated comment into the comments table
    $stmt = $db->prepare("INSERT INTO comments (player_id, commenter_name, comment_text, category_id) VALUES (:playerId, :commenterName, :commentText, :categoryId)");
    $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
    $stmt->bindParam(':commenterName', $commenterName, PDO::PARAM_STR);
    $stmt->bindParam(':commentText', $commentText, PDO::PARAM_STR);
    $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo '<p class="text-success">Comment submitted successfully.</p>';
    } else {
        echo '<p class="text-danger">Error submitting comment.</p>';
    }
} else {
    echo '<p class="text-danger">Invalid request.</p>';
}
?>
