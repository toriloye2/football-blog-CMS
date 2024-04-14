<?php
require('connect.php');
include 'header.php'; 

session_start();

if(!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
   $position = $_POST['position'];
   $goals = $_POST['goals'];
   $appearances = $_POST['appearances'];

   try {
    //  $db is your PDO connection
    $sql = "INSERT INTO football_legends (first_name, last_name, position, goals, appearances) VALUES (:first_name, :last_name, :position, :goals, :appearances)";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':first_name', $firstname);
    $stmt->bindParam(':last_name', $lastname);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':goals', $goals);
    $stmt->bindParam(':appearances', $appearances);

    $stmt->execute();
    echo "New record created successfully. Redirecting to landing page.";
    header("location:index.php");
    exit();
    } 
catch(PDOException $e) {
    echo "error: " . $e->getMessage();
}
};

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect value of input field
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $position = $_POST['position'];
    $goals = $_POST['goals'];
    $appearances = $_POST['appearances'];

    // Store data in session variables
    $_SESSION["first_name"] = $first_name;
    $_SESSION["last_name"] = $last_name;
    $_SESSION["position"] = $position;
    $_SESSION["goals"] = $goals;
    $_SESSION["appearances"] = $appearances;

    // Redirect to new page to display the result
    header('Location: index.php');
}


if (isset($_POST['submit'])) {
    $uploadDir = 'uploads/';  // Specify the directory where you want to store the uploaded images

    $uploadedFile = $uploadDir . basename($_FILES['image']['name']);
    $imageFileType = strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check !== false) {
        // Check if the file already exists
        if (!file_exists($uploadedFile)) {
            // Check file size (you can adjust the limit as needed)
            if ($_FILES['image']['size'] <= 5000000) { // 5 MB
                // Allow certain file formats
                if ($imageFileType === 'jpg' || $imageFileType === 'png' || $imageFileType === 'jpeg' || $imageFileType === 'gif') {
                    // Move the uploaded file to the specified directory
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
                        echo "The file " . basename($_FILES['image']['name']) . " has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
                }
            } else {
                echo "Sorry, your file is too large. It should be less than 5 MB.";
            }
        } else {
            echo "Sorry, the file already exists.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    <title> Football legends</title>
    
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
            
         <form  method="post" id="createPlayerform" enctype="multipart/form-data">

            <div id="create">
            <h1 class="text-uppercase text-center mb-5" >Create a new player</h1>

      <div class="form-outline mb-4">
      <label for="first_name" class="form-label">First name</label>
      <input type="text" class="form-control form-control-lg" id="first_name" name="first_name" required>
      </div>

      <div class="form-outline mb-4">
      <label for="last_name" class="form-label">Last Name:</label>
     <input type="text" class="form-control form-control-lg" id="last_name" name="last_name" required>
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

     <div class="form-outline mb-4">
      <label for="international_goals" class="form-label">Goals:</label>
     <input type="number"  class="form-control form-control-lg" id="goals" name="goals"required>
     </div>

     <div class="form-outline mb-4">
      <label for="international_appearances" class="form-label">Appearances:</label>
      <input type="number"  class="form-control form-control-lg" id="appearances" name="appearances"required>
      </div>


      <div class="form-outline mb-4">
      <h5>Upload Image</h5>
      <label for="image">Select Image:</label>
        <input type="file" name="image" id="image" accept="image/*">
        <button type="submit"  class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body"name="submit">Upload</button>
        </div>
    
        <div class="d-flex justify-content-center">
            <button type="submit" value="submit"  class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" onclick="validateAndSubmit(event)" >Submit</button>
            </div>
    
            </div>
        </form>
    
            </div> 
            </div>
            </div>
            </div>
            </div>


     
    
    


</div>
<script>
      function validateAndUpload(event) {
        // Add validation logic for image upload if needed
        alert('Image upload validation logic goes here.');
      }

      function validateAndSubmit(event) {
        var first_name = document.getElementById('first_name').value;
        var last_name = document.getElementById('last_name').value;
        var position = document.getElementById('position').value;
        var goals = document.getElementById('goals').value;
        var appearances = document.getElementById('appearances').value;

        // Validate first_name, last_name, position, goals, and appearances
        if (first_name.trim() === '' || last_name.trim() === '' || position === '' ) {
          alert('Please enter valid values for all fields.');
         return; 
        }  
         // Validate goals and appearances
         if (!isValidNumber(goals) || !isValidNumber(appearances)) {
                    alert('Please enter valid positive numbers for Goals and Appearances.');
                    return;
                    event.preventDefault();

                }
        

        // If validation passes, submit the form
        document.getElementById('createPlayerForm').submit();
      }
    
    function isValidNumber(value) {
                // Check if the value is a positive integer greater than or equal to 1
                return /^\d+$/.test(value) && parseInt(value, 10) >= 1;
            }
    </script>
</body>


</html>
<?php

// function filtered_first_name() {
//         return filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//     }

//     function valid_first_name() {
//         return strlen(filtered_first_name()) > 0;
//     }

//     function filtered_last_name() {
//         return filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//     }

//     function valid_last_name() {
//         return strlen(filtered_last_name()) > 0;
//     }

//     function filtered_position() {
//         return filter_input(INPUT_POST, 'position', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//     }

//     function valid_position() {
//         return strlen(filtered_position()) > 0;
//     }

 
//     function filtered_goals() {
//         return filter_input(INPUT_POST, 'goals', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//     }

//     function valid_goals() {
//         return filter_var(filtered_goals(), FILTER_VALIDATE_INT);
//     }

//     function filtered_appearances() {
//         return filter_input(INPUT_POST, 'appearances', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//     }

//     function valid_appearances() {
//         return filter_var(filtered_appearances(), FILTER_VALIDATE_INT);
//     }
//     {

//     $first_name = filtered_first_name();
//     if (!valid_first_name()) {
//         echo "Invalid first name";
//         return;
//     }

//     $last_name = filtered_last_name();
//     if (!valid_last_name()) {
//         echo "Invalid last name";
//         return;
//     }

//     $position = filtered_position();
//     if (!valid_position()) {
//         echo "Invalid position";
//         return;
//     }

//     $goals = filtered_goals();
//     if (!valid_goals()) {
//         echo "Invalid goals";
//         return;
//     }

//     $appearances = filtered_appearances();
//     if (!valid_appearances()) {
//         echo "Invalid appearances";
//         return;
//     }
// }


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Function to sanitize input data
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Function to validate and sanitize numeric input
    function validate_numeric_input($input) {
        $sanitized_input = filter_var($input, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)));
        return ($sanitized_input !== false) ? $sanitized_input : null;
    }

    // Sanitize and validate first name
    $first_name = sanitize_input($_POST["first_name"]);

    // Sanitize and validate last name
    $last_name = sanitize_input($_POST["last_name"]);

    // Sanitize and validate position
    $position = sanitize_input($_POST["position"]);

    // Validate and sanitize numeric input for goals and appearances
    $goals = validate_numeric_input($_POST["goals"]);
    $appearances = validate_numeric_input($_POST["appearances"]);

    // Check if image file is selected
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        // Image file handling code can be added here
    }

    // Check if all required fields are filled and numeric inputs are valid
    if (!empty($first_name) && !empty($last_name) && !empty($position) && !is_null($goals) && !is_null($appearances)) {
       
        
        echo "Form submitted successfully!";
    } else {
        // Validation failed, display an error message or take other appropriate actions
        echo "Form submission failed. Please check your inputs.";
    }
}



?>