<?php
/**************
 * Name: oriooooooooooooooooooo 
 * Date: 20th Sep. 2023 
 * Description: The project is a simple blogging application 
 **************/

require('connect.php');
include 'header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="row">
        <?php
        try {
            // Prepare the SQL statement without sorting
            $stmt = $db->prepare("SELECT * FROM football_legends");

            // Execute the statement
            $stmt->execute();

            // Fetch all the players' data
            $players = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Loop through each player and display their data
            foreach ($players as $player) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card">';

                // Use a placeholder image or a default image URL
                $imageUrl = 'https://placeimg.com/300/200/sports';

                echo '<img src="' . $imageUrl . '" class="card-img-top" alt="' . $player['first_name'] . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $player['first_name'] . ' ' . $player['last_name'] . '</h5>';
                echo '<p class="card-text">' . $player['position'] . '</p>';
                echo '<p class="card-text">Goals: ' . $player['goals'] . '</p>';
                echo '<p class="card-text">Appearances: ' . $player['appearances'] . '</p>';
                echo '<a href="players.php" class="btn btn-success">Read more</a>';
                echo '<br>';
                echo '<hr>';

                // // Add delete and edit buttons
                // if ($_SESSION['role'] == 1) {
                //     echo '<div class="edit-delete-buttons">';
                //     echo '<a href="delete.php?name=' . urlencode($player['first_name']) . '" class="btn btn-danger">Delete</a>';
                //     echo '<a href="edit_lege.php?player_id=' . urlencode($player['player_id']) . '" class="btn btn-secondary">Edit</a>';
                //     echo '</div>';
                // }

                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>
</body>
<footer style="background-color: #f8f9fa; padding: 20px; text-align: center;">
    <p>© 2023 T-Soccer Blog. All rights reserved.</p>
    <p><a href="aboutus.php">About Us</a> | <a href="contactus.php">Contact Us</a></p>
</footer>
</html>
