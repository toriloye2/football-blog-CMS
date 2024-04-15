<?php
// Start the session
session_start();

require('connect.php');
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
    } else {
        echo "Password is valid.";
    }

    try {
        // Prepare a select statement
        $sql = "SELECT name, password, role FROM user WHERE name = :name";
        $stmt = $db->prepare($sql);

        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':name', $name);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Check if username exists, if yes then verify password
            if ($stmt->rowCount() == 1) {
                if ($row = $stmt->fetch()) {
                    $hashed_password = $row['password'];
                    if (password_verify($password, $hashed_password)) {
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["name"] = $name;
                        $_SESSION["role"] = $row['role'];  // Add the role to the session

                        // Redirect based on the role
                        if ($_SESSION["role"] == 1) {
                            header("location: dashboard.php");
                            exit(); // Ensure no further code execution after redirection
                        } elseif ($_SESSION["role"] == 0) {
                            header("location: index.php");
                            exit(); // Ensure no further code execution after redirection
                        } else {
                            // Handle other roles if needed
                            echo "Unknown role!";
                        }
                    } else {
                        // Display an error message if password is not valid
                        echo "Wrong Password lad.";
                    }
                }
            } else {
                // Display an error message if username doesn't exist
                echo "C'mon your Username's Wrong ";
            }
        } else {
            // Log the error
            error_log("Database error during login: " . implode(", ", $stmt->errorInfo()));
            echo "Oops! Something went wrong. Please try again later.";
        }
    } catch (PDOException $e) {
        // Log the error
        error_log("PDO Exception during login: " . $e->getMessage());
        echo "Oops! Something went wrong. Please try again later.";
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

                                        <div class="form-outline mb-4">
                                            <label for="name" class="form-label">Name:</label>
                                            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Enter your name" required>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label for="password" class="form-label">Password:</label>
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password" required>
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <button type="submit" value="Login" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" onclick="validateAndSubmit(event)">Login</button>
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

    <script>
        function validateAndSubmit(event) {
            var name = document.getElementById('name').value;
            var password = document.getElementById('password').value;

            // Your validation logic goes here
            if (name.trim() === '' || password.trim() === '') {
                alert('Please enter both name and password.');
            } else {
                // Prevent the default form submission behavior
                event.preventDefault();

                document.getElementById('loginForm').submit();
            }
        }
    </script>

</body>
<footer style="background-color: #f8f9fa; padding: 20px; text-align: center;">
    <p>© 2023 T-Soccer Blog. All rights reserved.</p>
    <p><a href="aboutus.php">About Us</a>
</footer>

</html>
