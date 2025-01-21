<?php
session_start();
require('connect.php');
include 'header.php';

// Check if the user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $welcomeMessage = "Welcome, " . htmlspecialchars($_SESSION["name"]) . "!";
} else {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

require 'vendor/autoload.php';
use Gumlet\ImageResize;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $first_name = htmlspecialchars($_POST["first_name"]);
        $last_name = htmlspecialchars($_POST["last_name"]);
        $category_id = htmlspecialchars($_POST["category_id"]);
        $goals = (int)$_POST["goals"];
        $appearances = (int)$_POST["appearances"];
        $image = $_FILES["image"]["name"];

        $target_dir = "images/";
        $target_file = $target_dir . basename($image);

        // Validate file type
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_extensions = ["jpg", "jpeg", "png", "gif", "webp"];

        if (!in_array($imageFileType, $allowed_extensions)) {
            throw new Exception("Invalid file type. Only JPG, JPEG, PNG, GIF, and WEBP are allowed.");
        }

        // Upload and resize the image
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $imageResizer = new ImageResize($target_file);
            $imageResizer->resizeToBestFit(300, 300); // Resize to a maximum of 300x300
            $imageResizer->save($target_file);

            // Insert data into the database
            $sql = "INSERT INTO football_legends (first_name, last_name, category_id, goals, appearances, images)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$first_name, $last_name, $category_id, $goals, $appearances, $target_file]);

            // Redirect to the index page on success
            header("Location: index.php");
            exit();
        } else {
            throw new Exception("Failed to upload the image.");
        }
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
    <title>Create Football Player</title>
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
                                <h1 class="text-uppercase text-center mb-5">Create a New Player</h1>

                                <div class="form-outline mb-4">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control form-control-lg" id="first_name" name="first_name" required>
                                </div>

                                <div class="form-outline mb-4">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control form-control-lg" id="last_name" name="last_name" required>
                                </div>

                                <div class="form-outline mb-4">
                                    <label for="category_id" class="form-label">Position</label>
                                    <select class="form-control form-control-lg" name="category_id" required>
                                        <?php
                                        try {
                                            $sql = "SELECT * FROM categories";
                                            $stmt = $db->query($sql);

                                            if ($stmt->rowCount() > 0) {
                                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($rows as $row) {
                                                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['position']) . "</option>";
                                                }
                                            } else {
                                                echo "<option disabled>No positions available</option>";
                                            }
                                        } catch (PDOException $e) {
                                            echo "<option disabled>Error loading positions</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-outline mb-4">
                                    <label for="goals" class="form-label">Goals</label>
                                    <input type="number" class="form-control form-control-lg" id="goals" name="goals" required>
                                </div>

                                <div class="form-outline mb-4">
                                    <label for="appearances" class="form-label">Appearances</label>
                                    <input type="number" class="form-control form-control-lg" id="appearances" name="appearances" required>
                                </div>

                                <div class="form-outline mb-4">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Submit</button>
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
