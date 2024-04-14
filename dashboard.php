<?php
session_start();
if(isset($_SESSION['success'])){
    echo $_SESSION['success'];
    unset($_SESSION['success']); // removes it after it has been displayed
}

require('connect.php');
include 'header.php';
// Check if the user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $welcomeMessage = "Welcome, " . $_SESSION["name"] . "!";
} else {
    // If not logged in, redirect to the login page
    header("location: login.php");
    exit();
}

// Fetch users from the database
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'user_id'; // Default sort column
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'ASC'; // Default sort order

// Make sure to validate and sanitize the input values here

// Define sort order: ASC or DESC
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

// If sort column is defined
if(isset($_GET['column']) && in_array($_GET['column'], array('user_id', 'name', 'email', 'role', 'date', 'password'))){
    $sort_column = $_GET['column'];
    $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
    $add_class = ' class="highlight"';
} else {
    $up_or_down = ''; 
    $asc_or_desc = 'desc';
    $add_class = '';
}

$sql = "SELECT * FROM user ORDER BY " . $sort_column . " " . $sort_order;
$result = $db->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    <title>Dashboard</title>
</head>
<body>


    
    <h1 class="text-center">Dashboard</h1>
    <!-- <div class="container mt-5">

    <div class="form-outline mb-4">
    <form method="post"  action="create_category.php" >
        <h5 class="text-center">Create category</h5>
    <label for="categoryName">Category Name:</label>
    <input class="form-control" type="text" name="position" required>
    <br>
    <button type="submit" class="btn btn-primary">Submit </button>
</form>
</div> -->
        <div class="row">
            <div class="sort mt-3 mb-4">
                <!-- Sorting Form Container -->
                <!-- <div class="col-md-6">
                    <form class="form-inline" method="get" action="">
                        <label class="mr-2" for="sort">Sort by:</label>
                        <select class="form-control mr-2" name="sort" id="sort">
                            <option value="user_id" <?php echo ($sort_column == 'user_id') ? 'selected' : ''; ?>>User ID</option>
                            <option value="name" <?php echo ($sort_column == 'name') ? 'selected' : ''; ?>>Name</option>
                            <option value="email" <?php echo ($sort_column == 'email') ? 'selected' : ''; ?>>Email</option>
                            <option value="role" <?php echo ($sort_column == 'role') ? 'selected' : ''; ?>>Role</option>
                            <option value="date" <?php echo ($sort_column == 'date') ? 'selected' : ''; ?>>Date</option>
                            <option value="password" <?php echo ($sort_column == 'password') ? 'selected' : ''; ?>>Password</option>
                        </select>
                        <label class="mr-2" for="order">Order:</label>
                        <select class="form-control mr-2" name="order" id="order">
                            <option value="ASC" <?php echo ($sort_order == 'ASC') ? 'selected' : ''; ?>>Ascending</option>
                            <option value="DESC" <?php echo ($sort_order == 'DESC') ? 'selected' : ''; ?>>Descending</option>
                        </select>
                        <button type="submit" class="btn btn-secondary mr-2">Sort</button>
                    </form>
                </div> -->
            </div>

            <div class="container mt-5">
                <h2 class="text-center">Users Table</h2>
                <table class="table table-bordered" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><a href="?column=user_id&order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="user_id" data-order="<?php echo $asc_or_desc; ?>">User ID</a></th>
                            <th><a href="?column=name&order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="name" data-order="<?php echo $asc_or_desc; ?>">Name</a></th>
                            <th><a href="?column=email&order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="email" data-order="<?php echo $asc_or_desc; ?>">Email</a></th>
                            <th><a href="?column=role&order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="role" data-order="<?php echo $asc_or_desc; ?>">Role</a></th>
                            <th><a href="?column=date&order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="date" data-order="<?php echo $asc_or_desc; ?>">Date</a></th>
                            <th><a href="?column=password&order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="password" data-order="<?php echo $asc_or_desc; ?>">Password</a></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->rowCount() > 0) {
                            $counter = 1; 
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>"; 
                                echo "<td>" . $counter . "</td>";
                                echo "<td>" . $row["user_id"] . "</td>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . ($row["role"] == 1 ? "Admin" : "User") . "</td>";
                                echo "<td>" . $row["date"] . "</td>";
                                // echo "<td>" . $row["password"] . "</td>"; // Display hashed password
                                echo "<td>
                                        <a href='edit_user.php?id=" . $row["user_id"] . "' class='btn btn-primary btn-sm'>Update</a>
                                        <a href='delete_user.php?id=" . $row["user_id"] . "' class='btn btn-danger btn-sm'>Delete</a>
                                      </td>";
                                echo "</tr>";
                                $counter++;
                            }
                        } else {
                            echo "<tr><td colspan='7'>No users found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
// Fetch football legends from the database
$legends_sort_column = isset($_GET['legends_sort']) ? $_GET['legends_sort'] : 'player_id'; // Default sort column for legends
$legends_sort_order = isset($_GET['legends_order']) ? $_GET['legends_order'] : 'ASC'; // Default sort order for legends

// Make sure to validate and sanitize the input values here

$legends_sql = "SELECT * FROM football_legends ORDER BY " . $legends_sort_column . " " . $legends_sort_order;
$legends_result = $db->query($legends_sql);
?>
    <div class="container mt-5">
    <h2 class="text-center">Football Legends Table</h2>
        <table  class="table table-bordered" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th><a href="?legends_sort=player_id&legends_order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="player_id" data-order="<?php echo $asc_or_desc; ?>">Player ID</a></th>
                    <th><a href="?legends_sort=first_name&legends_order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="first_name" data-order="<?php echo $asc_or_desc; ?>">First Name</a></th>
                    <th><a href="?legends_sort=last_name&legends_order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="last_name" data-order="<?php echo $asc_or_desc; ?>">Last Name</a></th>
                    <th><a href="?legends_sort=position&legends_order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="position" data-order="<?php echo $asc_or_desc; ?>">Position</a></th>
                    <th><a href="?legends_sort=goals&legends_order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="goals" data-order="<?php echo $asc_or_desc; ?>">Goals</a></th>
                    <th><a href="?legends_sort=appearances&legends_order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="appearances" data-order="<?php echo $asc_or_desc; ?>">Appearances</a></th>
                    <th><a href="?legends_sort=created_at&legends_order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="created_at" data-order="<?php echo $asc_or_desc; ?>">Created At</a></th>
                    <th><a href="?legends_sort=updated_at&legends_order=<?php echo $asc_or_desc; ?>" class="column_sort btn btn-link" id="updated_at" data-order="<?php echo $asc_or_desc; ?>">Updated At</a></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($legends_result->rowCount() > 0) {
                    $counter_legends = 1; 
                    while ($legend_row = $legends_result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>"; 
                        echo "<td>" . $counter_legends . "</td>";
                        echo "<td>" . $legend_row["player_id"] . "</td>";
                        echo "<td>" . $legend_row["first_name"] . "</td>";
                        echo "<td>" . $legend_row["last_name"] . "</td>";
                        echo "<td>" . $legend_row["category_id"] . "</td>";
                        echo "<td>" . $legend_row["goals"] . "</td>";
                        echo "<td>" . $legend_row["appearances"] . "</td>";
                        echo "<td>" . $legend_row["created_at"] . "</td>";
                        echo "<td>" . $legend_row["updated_at"] . "</td>";
                        echo "<td>
                                <a href='edit_legend.php?id=" . $legend_row["player_id"] . "' class='btn btn-primary btn-sm'>Update</a>
                                <a href='delete_legend.php?id=" . $legend_row["player_id"] . "' class='btn btn-danger btn-sm'>Delete</a>
                              </td>";
                        echo "</tr>";
                        $counter_legends++;
                    }
                } else {
                    echo "<tr><td colspan='10'>No football legends found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-5">
    <?php
    try {
        // Fetch all categories
        $categoriesStmt = $db->prepare("SELECT * FROM categories");
        $categoriesStmt->execute();
        $categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

        // Loop through each category
        foreach ($categories as $category) {

            $category_sort_order = isset($_GET['order_dir']) ? $_GET['order_dir'] : 'ASC';
            
            echo '<h2 class="text-center">' . $category['position'] . '</h2>';
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th><a href="?category_id=' . $category['id'] . '&order_by=first_name&order_dir=' . ($category_sort_order == 'ASC' ? 'DESC' : 'ASC') . '">Name</a></th>';
            echo '<th><a href="?category_id=' . $category['id'] . '&order_by=position&order_dir=' . ($category_sort_order == 'ASC' ? 'DESC' : 'ASC') . '">Position</a></th>';
            echo '<th><a href="?category_id=' . $category['id'] . '&order_by=goals&order_dir=' . ($category_sort_order == 'ASC' ? 'DESC' : 'ASC') . '">Goals</a></th>';
            echo '<th><a href="?category_id=' . $category['id'] . '&order_by=appearances&order_dir=' . ($category_sort_order == 'ASC' ? 'DESC' : 'ASC') . '">Appearances</a></th>';
            // echo '<th>Actions</th>';
            // echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Prepare the SQL statement to fetch players by category with sorting
            $order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'first_name';
            $order_dir = isset($_GET['order_dir']) ? $_GET['order_dir'] : 'ASC';
            
            $playersStmt = $db->prepare("SELECT fl.*, c.position 
                                         FROM football_legends fl
                                         JOIN categories c ON fl.category_id = c.id
                                         WHERE fl.category_id = :category_id
                                         ORDER BY $order_by $order_dir");
            $playersStmt->bindParam(':category_id', $category['id']);
            $playersStmt->execute();
            $players = $playersStmt->fetchAll(PDO::FETCH_ASSOC);

            // Loop through each player in the category and display their data in a table row
            foreach ($players as $player) {

                echo '<td>';
                echo '<a href="delete_category.php?id=' . urlencode($category['id']) . '" class="btn btn-danger">Delete</a>';
                echo '</td>';
                echo '<tr>';
                echo '<td>' . $player['first_name'] . ' ' . $player['last_name'] . '</td>';
                echo '<td>' . $player['category_id'] . '</td>';
                echo '<td>' . $player['goals'] . '</td>';
                echo '<td>' . $player['appearances'] . '</td>';
                echo '<td>';
                // echo '<a href="delete_legend.php?player_id=' . urlencode($player['player_id']) . '&category_id=' . urlencode($category['id']) . '" class="btn btn-danger">Delete</a>';
                // echo '<a href="edit_legend.php?player_id=' . urlencode($player['player_id']) . '&category_id=' . urlencode($category['id']) . '" class="btn btn-primary">Update</a>';
                // Inside the loop where you display categories
                

                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</div>
<div class="container mt-5">
    <?php
    try {
        // Fetch all comments
        $commentsStmt = $db->prepare("SELECT * FROM comments");
        $commentsStmt->execute();
        $comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<h2 class="text-center">Comments Table</h2>';
        echo '<table class="table table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>#</th>';
        echo '<th>Commenter Name</th>';
        echo '<th>Comment Text</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($comments as $comment) {
            echo '<tr>';
            echo '<td>' . $comment['comment_id'] . '</td>';
            echo '<td>' . $comment['commenter_name'] . '</td>';
            echo '<td>' . $comment['comment_text'] . '</td>';
            echo '<td>';
            echo '<a href="delete_comment.php?id=' . urlencode($comment['comment_id']) . '" class="btn btn-danger">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</div>




  </body>
 </html>



    <script>
        // JavaScript for handling column sorting
        document.addEventListener('DOMContentLoaded', function () {
            let headers = document.querySelectorAll('.column_sort');

            headers.forEach(header => {
                header.addEventListener('click', () => {
                    window.location.href = `?column=${header.id}&order=${header.dataset.order}`;
                });
            });
        });
    </script>
