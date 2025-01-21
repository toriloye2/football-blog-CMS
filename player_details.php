<?php
session_start();
require('connect.php'); // Database connection
include 'header.php';

// Check if the player ID is provided in the URL
if (isset($_GET['id'])) {
    $playerId = $_GET['id'];
} else {
    // If no ID is provided, fetch a random player's ID
    $stmt = $db->prepare("SELECT player_id FROM football_legends ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $randomPlayer = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($randomPlayer) {
        $playerId = $randomPlayer['player_id'];
    } else {
        echo "<div class='container mt-5'><h2 class='text-danger'>No players found in the database.</h2></div>";
        exit;
    }
}

// Fetch player details including bio
$stmt = $db->prepare("
    SELECT fl.*, c.position
    FROM football_legends fl
    JOIN categories c ON fl.category_id = c.id
    WHERE fl.player_id = :playerId
");
$stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
$stmt->execute();
$playerDetails = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$playerDetails) {
    echo "<div class='container mt-5'><h2 class='text-danger'>Player not found. Please try again later.</h2></div>";
    exit;
}

// Fetch the next player's ID
$nextStmt = $db->prepare("SELECT player_id FROM football_legends WHERE player_id > :currentId ORDER BY player_id ASC LIMIT 1");
$nextStmt->bindParam(':currentId', $playerId, PDO::PARAM_INT);
$nextStmt->execute();
$nextPlayer = $nextStmt->fetch(PDO::FETCH_ASSOC);

// Fetch the previous player's ID
$prevStmt = $db->prepare("SELECT player_id FROM football_legends WHERE player_id < :currentId ORDER BY player_id DESC LIMIT 1");
$prevStmt->bindParam(':currentId', $playerId, PDO::PARAM_INT);
$prevStmt->execute();
$prevPlayer = $prevStmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Player Details -->
        <div class="row">
            <div class="col-md-4 text-center">
                <?php
                $imageUrl = $playerDetails['images'] ?? 'https://placeimg.com/300/200/sports';
                echo "<img src='{$imageUrl}' alt='{$playerDetails['first_name']}' class='img-fluid rounded'>";
                ?>
            </div>
            <div class="col-md-8">
                <h1 class="mb-4"><?php echo "{$playerDetails['first_name']} {$playerDetails['last_name']}"; ?></h1>
                <p><strong>Position:</strong> <?php echo $playerDetails['position']; ?></p>
                <p><strong>Goals:</strong> <?php echo $playerDetails['goals']; ?></p>
                <p><strong>Appearances:</strong> <?php echo $playerDetails['appearances']; ?></p>
            </div>
        </div>

        <!-- Biography Section -->
        <div class="mt-5">
            <h2>Biography</h2>
            <?php
            if (!empty($playerDetails['bio'])) {
                echo "<div class='p-3 bg-light rounded'>";
                $bioContent = htmlspecialchars($playerDetails['bio']);
                $bioParagraphs = explode("\n", $bioContent);
                foreach ($bioParagraphs as $paragraph) {
                    if (trim($paragraph) !== '') {
                        echo "<p class='mb-3'>" . nl2br($paragraph) . "</p>";
                    }
                }
                echo "</div>";
            } else {
                echo "<p class='text-muted'>Biography not available for this player.</p>";
            }
            ?>
        </div>

        <!-- Next and Previous Buttons -->
        <div class="mt-5 d-flex justify-content-between">
            <?php
            if ($prevPlayer) {
                echo "<a href='player_details.php?id={$prevPlayer['player_id']}' class='btn btn-secondary'>&laquo; Previous</a>";
            } else {
                echo "<a class='btn btn-secondary disabled'>&laquo; Previous</a>";
            }

            if ($nextPlayer) {
                echo "<a href='player_details.php?id={$nextPlayer['player_id']}' class='btn btn-primary'>Next &raquo;</a>";
            } else {
                echo "<a class='btn btn-primary disabled'>Next &raquo;</a>";
            }
            ?>
        </div>

        <!-- Comments Section -->
        <div class="mt-5">
            <h2>Comments</h2>
            <?php
            $stmt = $db->prepare("SELECT * FROM comments WHERE player_id = :playerId ORDER BY comment_id DESC");
            $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($comments) > 0) {
                foreach ($comments as $comment) {
                    echo "<p class='border p-2 rounded bg-light mb-2'><strong>{$comment['commenter_name']}:</strong> {$comment['comment_text']}</p>";
                }
            } else {
                echo "<p>No comments yet. Be the first to comment!</p>";
            }
            ?>
        </div>

        <!-- Comment Form -->
        <div class="mt-5">
            <h2>Leave a Comment</h2>
            <form action="process_comment.php" method="post">
                <input type="hidden" name="player_id" value="<?php echo $playerId; ?>">
                <textarea name="comment_text" id="comment_text" class="form-control" rows="4" required></textarea>
                <br>
                <?php
                if (!isset($_SESSION['user_id'])) {
                    echo '<p class="text-danger">You need to log in to comment.</p>';
                    echo '<button type="button" class="btn btn-secondary" disabled>Submit Comment</button>';
                } else {
                    echo '<button type="submit" class="btn btn-primary">Submit Comment</button>';
                }
                ?>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
