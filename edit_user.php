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

// Check if user ID is provided in the URL
if (isset($_GET['id'])) {
    $user_id = sanitizeInput($_GET['id']);

    // Fetch user data from the database
    $sql = "SELECT * FROM user WHERE user_id = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // // Check if user exists
    // if (!$user) {
    //     $_SESSION['error'] = 'User not found.';
    //     header('Location: index.php'); // Redirect to the user listing page
    //     exit();
    // }
}
// else {
//     $_SESSION['error'] = 'User ID not provided.';
//     header('Location: index.php'); // Redirect to the user listing page
//     exit();
// }

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = sanitizeInput($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? $_POST['email'] : '';
    $role = in_array($_POST['role'], [1, 2]) ? $_POST['role'] : 2; // Assuming role can be 1 (Admin) or 2 (User)

    // Validate input further if needed

    // Update user data in the database
    $updateSql = "UPDATE user SET name = :name, email = :email, role = :role WHERE user_id = :user_id";
    $updateStmt = $db->prepare($updateSql);
    $updateStmt->bindParam(':name', $name, PDO::PARAM_STR);
    $updateStmt->bindParam(':email', $email, PDO::PARAM_STR);
    $updateStmt->bindParam(':role', $role, PDO::PARAM_INT);
    $updateStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        $_SESSION['success'] = 'User Profile updated successfully.';
        header('Location: dashboard.php'); // Redirect to the user listing page
        exit();
    } else {
        $_SESSION['error'] = 'Error updating user.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <title>Edit User</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="post" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="1" <?php echo ($user['role'] == 1) ? 'selected' : ''; ?>>Admin</option>
                    <option value="2" <?php echo ($user['role'] == 0) ? 'selected' : ''; ?>>User</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" onclick="validateUserForm()">Update User</button>
        </form>
        <script>
            function validateUserForm() {
                var name = document.getElementById('name').value;
                var email = document.getElementById('email').value;

                // Validate name and email
                if (!isValidName(name) || !isValidEmail(email)) {
                    alert('Please enter valid values for Name and Email.');
                    return;
                }

                // If validation passes, submit the form
                document.getElementById('editUserForm').submit();
            }

            function isValidName(value) {
                // Check if the value is not empty
                return value.trim() !== '';
            }

            function isValidEmail(value) {
                // Check if the value is a valid email address
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            }
        </script>

    </div>

    
</body>
<footer style="background-color: #f8f9fa; padding: 20px; text-align: center;">
    <p>© 2023 T-Soccer Blog. All rights reserved.</p>
    <p><a href="aboutus.php">About Us</a> | <a href="contactus.php">Contact Us</a></p>
</footer>
</html>
