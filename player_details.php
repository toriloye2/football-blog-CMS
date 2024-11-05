<?php
session_start();
require('connect.php');
include 'header.php';


// Check if the player ID is provided in the URL
if (isset($_GET['id'])) {
    $playerId = $_GET['id'];

    // Prepare the SQL statement to fetch details of the selected player
    $stmt = $db->prepare("SELECT fl.*, c.position
                        FROM football_legends fl
                        JOIN categories c ON fl.category_id = c.id
                        WHERE fl.player_id = :playerId");
    $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch player details
    $playerDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$playerDetails) {
        // Player not found, you can handle this case accordingly
        echo "Player not found";
    } else {
        // Display player details on the page
        echo '<h1>' . $playerDetails['first_name'] . ' ' . $playerDetails['last_name'] . '</h1>';
        echo '<p>Position: ' . $playerDetails['position'] . '</p>';
        echo '<p>Goals: ' . $playerDetails['goals'] . '</p>';
        echo '<p>Appearances: ' . $playerDetails['appearances'] . '</p>';





        // You can also display the player's image here using the image URL stored in the database
        $imageUrl = $playerDetails['images'] ?? 'https://placeimg.com/300/200/sports';
        echo '<img src="' . $imageUrl . '" alt="' . $playerDetails['first_name'] . '">';

        // Add more HTML structure and styling as needed
   // Display comments related to the player
$stmt = $db->prepare("SELECT * FROM comments WHERE player_id = :playerId");
$stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<h2>Comments</h2>';
foreach ($comments as $comment) {
    echo '<p>' . $comment['comment_text'] . '</p>';
}}
} else {
    // Player ID not provided in the URL, handle this case accordingly
    echo "Player ID not provided";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Legends Page</title>


</head>
<body>

<!-- Your existing PHP code goes here -->

<!-- HTML Form for Comment Section with Bootstrap Styling -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h2>Leave a Comment</h2>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Include the Comment Processing PHP File
                require('process_comment.php');
            }
            ?>

            <form action="" method="post">
                <input type="hidden" name="player_id" value="<?php echo $playerId; ?>">
                <input type="hidden" name="category_id" value="<?php echo $playerDetails['category_id']; ?>">

                <?php
                if (isset($_SESSION['user_id'])) {
                    $userId = $_SESSION['user_id'];
                    $stmt = $db->prepare("SELECT name FROM user WHERE user_id = :userId");
                    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                    $stmt->execute();
                    $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($userDetails && isset($userDetails['name'])) {
                        echo '<input type="hidden" name="commenter_name" value="' . htmlspecialchars($userDetails['name'], ENT_QUOTES, 'UTF-8') . '">';
                        echo '<p class="mb-2">Commenting as: ' . htmlspecialchars($userDetails['name'], ENT_QUOTES, 'UTF-8') . '</p>';
                    }
                }

                if (!isset($_SESSION['user_id']) || !isset($userDetails['name'])) {
                    echo '<label for="commenter_name" class="form-label">Your Name:</label>';
                    echo '<input type="text" name="commenter_name" id="commenter_name" class="form-control" required>';
                }
                ?>

                <br>

                <label for="comment_text" class="form-label">Your Comment:</label>
                <textarea name="comment_text" id="comment_text" class="form-control" rows="4" required></textarea>
                <br>

                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        </div>
    </div>
</div>


</body>
<footer style="background-color: #f8f9fa; padding: 20px; text-align: center;">
    <p>© 2023 T-Soccer Blog. All rights reserved.</p>
    <p><a href="aboutus.php">About Us</a> | <a href="contactus.php">Contact Us</a></p>


  </footer>
</html>
