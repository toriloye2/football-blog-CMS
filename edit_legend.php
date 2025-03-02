<?php
session_start();

// Include the database connection file
require('connect.php');
include 'header.php';

// Function to sanitize user input
function sanitizeInput($input) {
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
        header('Location: players.php'); // Redirect to the legends listing page
        exit();
    }
} else {
    $_SESSION['error'] = 'Player ID not provided.';
    header('Location: players.php'); // Redirect to the legends listing page
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $position = sanitizeInput($_POST['position']);
    $bio = sanitizeInput($_POST['bio']); // Capture bio input

    // Fetch category ID based on the selected position
    $categorySql = "SELECT id FROM categories WHERE name = :position";
    $categoryStmt = $db->prepare($categorySql);
    $categoryStmt->bindParam(':position', $position, PDO::PARAM_STR);
    $categoryStmt->execute();
    $categoryResult = $categoryStmt->fetch(PDO::FETCH_ASSOC);

    if ($categoryResult && isset($categoryResult['id'])) {
        $category_id = $categoryResult['id'];
    } else {
        $_SESSION['error'] = 'Invalid position selected.';
        header('Location: edit_legend.php?id=' . $player_id);
        exit();
    }

    // Validate numerical inputs for goals and appearances
    $goals = filter_var($_POST['goals'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) ?: 0;
    $appearances = filter_var($_POST['appearances'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) ?: 0;

    // Update player data in the database
    $updateSql = "UPDATE football_legends
                  SET first_name = :first_name,
                      last_name = :last_name,
                      category_id = :category_id,
                      goals = :goals,
                      appearances = :appearances,
                      bio = :bio
                  WHERE player_id = :player_id";

    $updateStmt = $db->prepare($updateSql);
    $updateStmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $updateStmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $updateStmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $updateStmt->bindParam(':goals', $goals, PDO::PARAM_INT);
    $updateStmt->bindParam(':appearances', $appearances, PDO::PARAM_INT);
    $updateStmt->bindParam(':bio', $bio, PDO::PARAM_STR);
    $updateStmt->bindParam(':player_id', $player_id, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        $_SESSION['success'] = 'Football legend updated successfully.';
        header('Location: players.php'); // Redirect to the legends listing page
        exit();
    } else {
        $_SESSION['error'] = 'Error updating football legend.';
    }
}
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
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($legend['first_name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($legend['last_name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea class="form-control" id="bio" name="bio" rows="4"><?php echo htmlspecialchars($legend['bio'] ?? ''); ?></textarea>
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

            <button type="submit" class="btn btn-primary">Update Football Legend</button>
        </form>
    </div>
</body>
<?php include 'footer.php'; ?>
</html>
