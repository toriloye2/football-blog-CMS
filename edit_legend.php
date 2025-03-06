<?php
session_start();
require('connect.php');
include 'header.php';

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

// Check if player ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $player_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    // Fetch player data from the database
    $sql = "SELECT * FROM football_legends WHERE player_id = :player_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':player_id', $player_id, PDO::PARAM_INT);
    $stmt->execute();
    $legend = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$legend) {
        $_SESSION['error'] = 'Football legend not found.';
        header('Location: players.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Player ID not provided.';
    header('Location: players.php');
    exit();
}

// Handle form submission for updating the player
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $first_name = htmlspecialchars($_POST["first_name"]);
        $last_name = htmlspecialchars($_POST["last_name"]);
        $category_id = htmlspecialchars($_POST["category_id"]);
        $goals = (int)$_POST["goals"];
        $appearances = (int)$_POST["appearances"];
        $bio = htmlspecialchars($_POST["bio"]); // New bio field
        $image = $_FILES["image"]["name"];
        $target_dir = "images/";

        if (!empty($image)) {
            $target_file = $target_dir . basename($image);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_extensions = ["jpg", "jpeg", "png", "gif", "webp"];

            if (!in_array($imageFileType, $allowed_extensions)) {
                throw new Exception("Invalid file type. Only JPG, JPEG, PNG, GIF, and WEBP are allowed.");
            }

            // Upload and resize the image
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                require 'vendor/autoload.php';
                use Gumlet\ImageResize;
                $imageResizer = new ImageResize($target_file);
                $imageResizer->resizeToBestFit(300, 300);
                $imageResizer->save($target_file);

                // Update player with image
                $sql = "UPDATE football_legends SET
                            first_name = ?, last_name = ?, category_id = ?, goals = ?, appearances = ?, bio = ?, images = ?
                        WHERE player_id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$first_name, $last_name, $category_id, $goals, $appearances, $bio, $target_file, $player_id]);
            } else {
                throw new Exception("Failed to upload the image.");
            }
        } else {
            // Update player without changing the image
            $sql = "UPDATE football_legends SET
                        first_name = ?, last_name = ?, category_id = ?, goals = ?, appearances = ?, bio = ?
                    WHERE player_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$first_name, $last_name, $category_id, $goals, $appearances, $bio, $player_id]);
        }

        $_SESSION['success'] = "Football legend updated successfully!";
        header("Location: players.php");
        exit();
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit Football Legend</title>
</head>

<body>
<section class="vh-100 bg-image" style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <?php if (isset($errorMessage)): ?>
                                <div class="alert alert-danger">
                                    <?php echo htmlspecialchars($errorMessage); ?>
                                </div>
                            <?php endif; ?>

                            <form method="post" enctype="multipart/form-data">
                                <h1 class="text-uppercase text-center mb-5">Edit Player</h1>

                                <div class="form-outline mb-4">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control form-control-lg" id="first_name" name="first_name" value="<?php echo htmlspecialchars($legend['first_name']); ?>" required>
                                </div>

                                <div class="form-outline mb-4">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control form-control-lg" id="last_name" name="last_name" value="<?php echo htmlspecialchars($legend['last_name']); ?>" required>
                                </div>

                                <div class="form-outline mb-4">
                                    <label for="category_id" class="form-label">Position</label>
                                    <select class="form-control form-control-lg" name="category_id" required>
                                        <?php
                                        try {
                                            $sql = "SELECT * FROM categories";
                                            $stmt = $db->query($sql);
                                            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($categories as $row) {
                                                $selected = ($legend['category_id'] == $row['id']) ? "selected" : "";
                                                echo "<option value='" . htmlspecialchars($row['id']) . "' $selected>" . htmlspecialchars($row['position']) . "</option>";
                                            }
                                        } catch (PDOException $e) {
                                            echo "<option disabled>Error loading positions</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-outline mb-4">
                                    <label for="goals" class="form-label">Goals</label>
                                    <input type="number" class="form-control form-control-lg" id="goals" name="goals" value="<?php echo htmlspecialchars($legend['goals']); ?>" required>
                                </div>

                                <div class="form-outline mb-4">
                                    <label for="appearances" class="form-label">Appearances</label>
                                    <input type="number" class="form-control form-control-lg" id="appearances" name="appearances" value="<?php echo htmlspecialchars($legend['appearances']); ?>" required>
                                </div>

                                <div class="form-outline mb-4">
                                    <label for="bio" class="form-label">Player Bio</label>
                                    <textarea class="form-control form-control-lg" id="bio" name="bio" rows="4" required><?php echo htmlspecialchars($legend['bio']); ?></textarea>
                                </div>

                                <div class="form-outline mb-4">
                                    <label for="image" class="form-label">Upload New Image (optional)</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
</body>
</html>
