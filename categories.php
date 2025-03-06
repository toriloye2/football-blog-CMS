<?php
session_start();
require('connect.php');
include 'header.php';

// Redirect if not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Categories</h2>

    <!-- ✅ Display Session Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']); // Clear the message after displaying
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']); // Clear the message after displaying
            ?>
        </div>
    <?php endif; ?>

    <!-- ✅ Category Creation Form -->
    <div class="form-outline mb-4">
        <form method="post" action="create_category.php">
            <h5 class="text-center">Create Category</h5>
            <label for="categoryName">Category Name:</label>
            <input class="form-control" type="text" name="position" required>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- ✅ Fetch & Display Categories with Players -->
    <?php
    try {
        // Fetch all categories
        $categoriesStmt = $db->prepare("SELECT * FROM categories ORDER BY position ASC");
        $categoriesStmt->execute();
        $categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($categories)) {
            // Loop through each category
            foreach ($categories as $category) {
                echo '<h2 class="mt-4">' . htmlspecialchars($category['position']) . '</h2>';
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

                // Fetch players under the current category
                $playersStmt = $db->prepare("
                    SELECT fl.*, c.position
                    FROM football_legends fl
                    JOIN categories c ON fl.category_id = c.id
                    WHERE fl.category_id = :category_id
                ");
                $playersStmt->bindParam(':category_id', $category['id'], PDO::PARAM_INT);
                $playersStmt->execute();
                $players = $playersStmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($players)) {
                    // Loop through each player in the category and display their data
                    foreach ($players as $player) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($player['position']) . '</td>';
                        echo '<td>' . htmlspecialchars($player['goals']) . '</td>';
                        echo '<td>' . htmlspecialchars($player['appearances']) . '</td>';
                        echo "<td>
                                <a href='edit_legend.php?id=" . $player["player_id"] . "' class='btn btn-primary btn-sm'>Update</a>
                                <a href='delete_legend.php?id=" . $player["player_id"] . "' class='btn btn-danger btn-sm'>Delete</a>
                              </td>";
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5" class="text-center">No players in this category yet.</td></tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>'; // Close the table for each category
            }
        } else {
            echo '<p class="text-center">No categories found. Create a new category above.</p>';
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error fetching categories: " . $e->getMessage() . "</div>";
    }
    ?>

</div>

<?php include 'footer.php'; ?>

</body>
</html>
