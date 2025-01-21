<?php
session_start();
require_once('connect.php');

// Function to sanitize user input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo '<p class="text-danger">You need to log in to comment.</p>';
        exit;
    }

    // Sanitize and validate inputs
    $playerId = isset($_POST['player_id']) ? (int)$_POST['player_id'] : 0;
    $commentText = isset($_POST['comment_text']) ? sanitizeInput($_POST['comment_text']) : '';
    $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;

    // Fetch the logged-in user's name from the database
    $userId = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT name FROM user WHERE user_id = :userId");
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userDetails && isset($userDetails['name'])) {
        $commenterName = $userDetails['name'];
    } else {
        echo '<p class="text-danger">Error: Unable to retrieve user details. Please log in again.</p>';
        exit;
    }

    // Validate input
    if ($playerId <= 0 || empty($commentText) || $categoryId <= 0) {
        echo '<p class="text-danger">Invalid input. Please provide valid data.</p>';
        exit;
    }

    // Insert the comment into the database
    $stmt = $db->prepare("
        INSERT INTO comments (player_id, commenter_name, comment_text, category_id)
        VALUES (:playerId, :commenterName, :commentText, :categoryId)
    ");
    $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
    $stmt->bindParam(':commenterName', $commenterName, PDO::PARAM_STR);
    $stmt->bindParam(':commentText', $commentText, PDO::PARAM_STR);
    $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: player_details.php?id=$playerId");
        exit;
    } else {
        echo '<p class="text-danger">Error submitting comment. Please try again later.</p>';
    }
} else {
    echo '<p class="text-danger">Invalid request. Please submit the form correctly.</p>';
}
