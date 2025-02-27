<?php

require('connect.php');
include 'header.php';
function filtered_name() {
    return filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

function valid_name() {
    $name_length = strlen(filtered_name());
    return $name_length > 0 && $name_length <= 140;
}

function filtered_email() {
    return filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
}

function valid_email() {
    return filter_var(filtered_email(), FILTER_VALIDATE_EMAIL);
}

function filtered_password() {
    return filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

function valid_password() {
    $password_length = strlen(filtered_password());
    return $password_length > 0 && $password_length <= 140;
}

// Function to sanitize and validate user input
function filter_input_data($input)
{
    return filter_input(INPUT_POST, $input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    // die($confirm_password);
     // Validate confirm password
     if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
       } else if ($password !== $confirm_password) {
        $error_message = "Passwords do not match. Please try again.";
    } else  {



    try {
        // $db is your PDO connection
        $sql = "INSERT INTO "user" (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $db->prepare($sql);

        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        $stmt->execute();
        echo "New record created successfully. Redirecting to landing page.";
        header("location:login.php");
        exit();
    }
    catch(PDOException $e) {
        echo "error: " . $e->getMessage();
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
    <title>Signup</title>
</head>

<body>
<section class="vh-100 bg-image"
  style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <!-- <h2 class="text-uppercase text-center mb-5">Create an account</h2> -->

              <form method="post">
              <div id="signin">
                <h1 class="text-uppercase text-center mb-5">Create an Account</h1>


                    <div class="form-outline mb-4">
                        <!-- <input type="text" id="form3Example1cg" class="form-control form-control-lg" /> -->
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        <?php
    // Display error message if it exists
    if (!empty($error_message)) {
        echo '<p>' . $error_message . '</p>';
    }
    ?>


                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Signup</button>
                    </div>

                <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="login.php"
                    class="fw-bold text-body"><u>Login here</u></a></p>

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