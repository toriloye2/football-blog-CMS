<?php
session_start();


// Include the database connection file (modify the path if needed)
require('connect.php');
include 'header.php';

// Function to sanitize user input
function sanitizeInput($input)
{
    return htmlspecialchars(strip_tags(trim($input)));
}

// Check if player ID is provided in the URL
if (isset($_GET['id'])) {
    $player_id = sanitizeInput($_GET['id']);

    // Fetch player data from the database
    $sql = "SELECT * FROM football_legends WHERE player_id = :player_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':player_id', $player_id, PDO::PARAM_INT);
    $stmt->execute();
    $legend = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if player exists
    if (!$legend) {
        $_SESSION['error'] = 'Football legend not found.';
        header('Location: dashboard.php'); // Redirect to the legends listing page
        exit();
    }
} else {
    $_SESSION['error'] = 'Player ID not provided.';
    header('Location: dashboard.php'); // Redirect to the legends listing page
    exit();
}
// ... (existing code)

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    // $category_id = sanitizeInput($_POST['category_id']); // Remove this line
    $position = sanitizeInput($_POST['position']);

    // Fetch category ID based on the selected position
    $categorySql = "SELECT id FROM categories WHERE position = :position";
    $categoryStmt = $db->prepare($categorySql);
    $categoryStmt->bindParam(':position', $position, PDO::PARAM_STR);
    $categoryStmt->execute();
    $categoryResult = $categoryStmt->fetch(PDO::FETCH_ASSOC);

    // Check if a valid category ID is obtained
    if ($categoryResult && isset($categoryResult['id'])) {
        $category_id = $categoryResult['id'];
    } else {
        $_SESSION['error'] = 'Invalid position selected.';
        // Handle the error as needed
        // You might want to redirect the user to the edit page again or display an error message.
        // header('Location: edit_legend.php?id=' . $player_id);
        // exit();
    }

    $goals = filter_var($_POST['goals'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $goals = ($goals !== false) ? $goals : 0;
    $appearances = filter_var($_POST['appearances'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $appearances = ($appearances !== false) ? $appearances : 0;

    // Validate input further if needed

    // Update player data in the database
    $updateSql = "UPDATE football_legends SET first_name = :first_name, last_name = :last_name, category_id = :category_id, goals = :goals, appearances = :appearances WHERE player_id = :player_id";
    $updateStmt = $db->prepare($updateSql);
    $updateStmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $updateStmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $updateStmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $updateStmt->bindParam(':goals', $goals, PDO::PARAM_INT);
    $updateStmt->bindParam(':appearances', $appearances, PDO::PARAM_INT);
    $updateStmt->bindParam(':player_id', $player_id, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        $_SESSION['success'] = 'Football legend updated successfully.';
        header('Location: dashboard.php'); // Redirect to the legends listing page
        exit();
    } else {
        $_SESSION['error'] = 'Error updating football legend.';
    }
}

// Check if the form is submitted
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Sanitize and validate input
//     $first_name = sanitizeInput($_POST['first_name']);
//     $last_name = sanitizeInput($_POST['last_name']);
//     $category_id = sanitizeInput($_POST['category_id']);
//     $position = sanitizeInput($_POST['position']);
//     // $goals = filter_var($_POST['goals'], FILTER_VALIDATE_INT) ? $_POST['goals'] : 0;
//     // $appearances = filter_var($_POST['appearances'], FILTER_VALIDATE_INT) ? $_POST['appearances'] : 0;

//     // Validate and sanitize numeric input for goals
//     $goals = filter_var($_POST['goals'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
//     $goals = ($goals !== false) ? $goals : 0;

//     // Validate and sanitize numeric input for appearances
//     $appearances = filter_var($_POST['appearances'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
//     $appearances = ($appearances !== false) ? $appearances : 0;


//     // Validate input further if needed

//     // Update player data in the database
// $updateSql = "UPDATE football_legends SET first_name = :first_name, last_name = :last_name, category_id = :category_id, goals = :goals, appearances = :appearances WHERE player_id = :player_id";
// $updateStmt = $db->prepare($updateSql);
// $updateStmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
// $updateStmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
// $updateStmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
// $updateStmt->bindParam(':goals', $goals, PDO::PARAM_INT);
// $updateStmt->bindParam(':appearances', $appearances, PDO::PARAM_INT);
// $updateStmt->bindParam(':player_id', $player_id, PDO::PARAM_INT);

//     if ($updateStmt->execute()) {
//         $_SESSION['success'] = 'Football legend updated successfully.';
//         header('Location: dashboard.php'); // Redirect to the legends listing page
//         exit();
//     } else {
//         $_SESSION['error'] = 'Error updating football legend.';
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Edit Football Legend</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Football Legend</h2>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form id="editForm" method="post" action="">
        <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $legend['first_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $legend['last_name']; ?>" required>
            </div>
            <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="deleteImage" name="deleteImage">
            <label class="form-check-label" for="deleteImage">Delete Image</label>
        </div>

            <div class="form-outline mb-4">
    <label for="position" class="form-label">Position:</label>
    <select class="form-control form-control-lg" id="position" name="position" required>
        <option value="">Select a position</option>
        <option value="goalkeeper">Goalkeeper</option>
        <option value="defender">Defender</option>
        <option value="midfielder">Midfielder</option>
        <option value="forward">Forward</option>
    </select>
</div>
            <div class="mb-3">
                <label for="goals" class="form-label">Goals</label>
                <input type="number" class="form-control" id="goals" name="goals" value="<?php echo $legend['goals']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="appearances" class="form-label">Appearances</label>
                <input type="number" class="form-control" id="appearances" name="appearances" value="<?php echo $legend['appearances']; ?>" required>
            </div>
            <!-- <button type="submit" class="btn btn-primary">Update Football Legend</button> -->
            <button type="button" class="btn btn-primary" onclick="validateForm()">Update Football Legend</button>
        </form>
        <script>
            function validateForm() {
                var goals = document.getElementById('goals').value;
                var appearances = document.getElementById('appearances').value;

                // Validate goals and appearances
                if (!isValidNumber(goals) || !isValidNumber(appearances)) {
                    alert('Please enter valid positive numbers for Goals and Appearances.');
                    return;
                }

                // If validation passes, submit the form
                document.getElementById('editForm').submit();
            }

            function isValidNumber(value) {
                // Check if the value is a positive integer greater than or equal to 1
                return /^\d+$/.test(value) && parseInt(value, 10) >= 1;
            }
        </script>
    </div>
</body>
<footer style="background-color: #f8f9fa; padding: 20px; text-align: center;">
    <p>© 2023 T-Soccer Blog. All rights reserved.</p>
    <p><a href="aboutus.php">About Us</a> | <a href="contactus.php">Contact Us</a></p>
</footer>
</html>
