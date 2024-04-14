<?php
session_start();
require('connect.php');
include 'header.php';

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  $welcomeMessage = "Welcome, " . $_SESSION["name"] . "!";
} else {
  // If not logged in, redirect to the login page
  header("location: login.php");
  exit();
}

require 'vendor/autoload.php';
use Gumlet\ImageResize;
try{



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $category_id = $_POST["category_id"];
    // die($category_id);
    $goals = $_POST["goals"];
    $appearances = $_POST["appearances"];
    $image = $_FILES["image"]["name"];

    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // die( $imageFileType );

    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif","webp");

    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){
      // Upload file
      if(move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
        // Insert record
        $imageResizer = new ImageResize($target_file);
            $imageResizer->resizeToBestFit(300, 300); // Adjust the dimensions as needed
            $imageResizer->save($target_file);
            // die($category_id);

        $sql = "INSERT INTO football_legends (first_name, last_name, category_id, goals, appearances, images) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt= $db->prepare($sql);
        $stmt->execute([$first_name, $last_name, $category_id, $goals, $appearances, $target_file]);
       
        // Redirect to index.php
        header("Location: index.php");
        exit();
      }
    }
  }

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
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
            
         <form  method="post"  enctype="multipart/form-data">

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

     <!-- <input type="text" value=""> -->
     
        
     <div class="form-outline mb-4">
    <label for="category_id" class="form-label">Position:</label>
    
    <?php
try {
    // Fetch all positions from the categories table
    $sql = "SELECT * FROM categories";
    $stmt = $db->query($sql);

    // Check if there are rows returned
    if ($stmt->rowCount() > 0) {
        // Fetch all rows into an associative array
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output options using foreach loop
        echo '<select class="form-control form-control-lg" name="category_id" required>';
        foreach ($rows as $row) {
            $position = $row["position"];
            $id = $row["id"];
            echo "<option value=".$id.">$position</option>";
        }
        echo '</select>';
    } else {
        echo "No positions found in the categories table";
    }
} catch (PDOException $e) {
    echo "Caught exception: " . $e->getMessage();
}
?>

    
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
        </div>
    
        <div class="d-flex justify-content-center">
            <button type="submit"   class="btn btn-success btn-block btn-lg gradient-custom-4 text-body"  >Submit</button>
            </div>
    
            </div>
        </form>
    
            </div> 
            </div>
            </div>
            </div>
            </div>
            </div>
</body>
<footer style="background-color: #f8f9fa; padding: 20px; text-align: center;">
    <p>© 2023 T-Soccer Blog. All rights reserved.</p>
    <p><a href="aboutus.php">About Us</a> | <a href="contactus.php">Contact Us</a></p>


  </footer>
</html>