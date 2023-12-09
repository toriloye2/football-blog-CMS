<?php
session_start();
require('connect.php');
include 'header.php';

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $welcomeMessage = "Welcome, " . $_SESSION["name"] . "!";
} else {
    // If not logged in, redirect to the login page
    header("location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="form-outline mb-4">
    <form method="post"  action="create_category.php" >
        <h5 class="text-center">Create category</h5>
    <label for="categoryName">Category Name:</label>
    <input class="form-control" type="text" name="position" required>
    <br>
    <button type="submit" class="btn btn-primary">Submit </button>
</form>
</div>
    
    
</body>
</html>





<?php
try {
    // Fetch all categories
    $categoriesStmt = $db->prepare("SELECT * FROM categories");
    $categoriesStmt->execute();
    $categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through each category
    foreach ($categories as $category) {
        echo '<h2>' . $category['position'] . '</h2>';
        echo '<div class="table-responsive">';
        echo '<table class="table table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Name</th>';
        echo '<th>Position</th>';
        echo '<th>Goals</th>';
        echo '<th>Appearances</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Prepare the SQL statement to fetch players by category
        $playersStmt = $db->prepare("SELECT fl.*, c.position 
                                     FROM football_legends fl
                                     JOIN categories c ON fl.category_id = c.id
                                     WHERE fl.category_id = :category_id");
        $playersStmt->bindParam(':category_id', $category['id']);
        $playersStmt->execute();
        $players = $playersStmt->fetchAll(PDO::FETCH_ASSOC);

        // Loop through each player in the category and display their data in a table row
        foreach ($players as $player) {
            echo '<tr>';
            echo '<td>' . $player['first_name'] . ' ' . $player['last_name'] . '</td>';
            echo '<td>' . $player['position'] . '</td>';
            echo '<td>' . $player['goals'] . '</td>';
            echo '<td>' . $player['appearances'] . '</td>';
            echo "<td>
            <a href='edit_legend.php?id=" . $player["player_id"] . "' class='btn btn-primary btn-sm'>Update</a>
            <a href='delete_legend.php?id=" . $player["player_id"] . "' class='btn btn-danger btn-sm'>Delete</a>
            </td>";
           
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>'; // Close the table for each category
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}



?>

