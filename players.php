<?php
/**************
 * Name: oriooooooooooooooooooo
 * Date: 20th Sep. 2023
 * Description: The project is a simple blogging application
 **************/
// Start the session
session_start();
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
             // Prepare the SQL statement with a JOIN to fetch category (position) information
            $stmt = $db->prepare("SELECT fl.*, c.position
            FROM football_legends fl
            JOIN categories c ON fl.category_id = c.id");


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
    <p><a href="aboutus.php">About Us</a> |
</footer>
</html>
