<?php
// Start the session
session_start();

require('connect.php');
include 'header.php';

$error = ""; // Initialize an error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Basic validation for password length
    if (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } else {
        try {
            // Prepare a select statement
            $sql = "SELECT user_id, name, password, role FROM user WHERE name = :name";
            $stmt = $db->prepare($sql);

            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':name', $name);

            // Execute the prepared statement
            $stmt->execute();

            // Check if username exists
            if ($stmt->rowCount() == 1) {
                // Fetch the user data
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verify the password
                $hashed_password = $row['password'];
                if (password_verify($password, $hashed_password)) {
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["name"] = $row['name'];
                    $_SESSION["role"] = $row['role'];
                    $_SESSION["user_id"] = $row['user_id']; // Correctly set user_id

                    // Redirect based on the role
                    if ($_SESSION["role"] == 1) {
                        header("location: dashboard.php");
                        exit(); // Ensure no further code execution after redirection
                    } elseif ($_SESSION["role"] == 0) {
                        header("location: index.php");
                        exit(); // Ensure no further code execution after redirection
                    } else {
                        $error = "Unknown role!";
                    }
                } else {
                    $error = "Incorrect password. Please try again.";
                }
            } else {
                $error = "Invalid username. Please try again.";
            }
        } catch (PDOException $e) {
            // Log the error
            error_log("PDO Exception: " . $e->getMessage());
            $error = "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>

<body>

    <section class="vh-100 bg-image" style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">

                                <form method="post" id="loginForm">
                                    <div id="login">
                                        <h1 class="text-uppercase text-center mb-5">Login</h1>

                                        <!-- Display error message -->
                                        <?php if (!empty($error)): ?>
                                            <div class="alert alert-danger text-center">
                                                <?php echo htmlspecialchars($error); ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="form-outline mb-4">
                                            <label for="name" class="form-label">Name:</label>
                                            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Enter your name" required>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label for="password" class="form-label">Password:</label>
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password" required>
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <button type="submit" value="Login" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Login</button>
                                        </div>
                                        <p class="text-center text-muted mt-5 mb-0"> New User? <a href="signup.php" class="fw-bold text-body"><u>Register here</u></a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
<?php include 'footer.php'; ?>
</html>
