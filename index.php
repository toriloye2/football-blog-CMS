<?php
/************

    Name: oriooooooooooooooooooo
    Date: 20th Sep. 2023
    Description: The project is a simple blogging application

************/
session_start();
require('connect.php');
include 'header.php';

// Check if the user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $welcomeMessage = "Welcome, " . $_SESSION["name"] . "!";
} else {
    // If not logged in, redirect to the login page
    header("location: login.php");
    exit();
}

// Check if a search term is provided
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $stmt = $db->prepare("SELECT * FROM football_legends WHERE first_name LIKE :search OR last_name LIKE :search");
    $stmt->bindValue(':search', "%$searchTerm%", PDO::PARAM_STR);
} else {
    // If no search term, proceed without sorting
    $stmt = $db->prepare("SELECT * FROM football_legends");
}

// Execute the statement
$stmt->execute();

// Fetch all the players' data
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Football Legends</title>
</head>

<body>
    <!-- Jumbotron -->
    <div class="jumbotron text-center bg-success text-white">
        <h1 class="display-4">Explore the Legends of Football</h1>
        <p class="lead">Uncover the stories of football's greatest legends and relive their iconic moments.</p>
        <hr class="my-4">
        <p>Discover exclusive insights and tributes to the football heroes who shaped the game.</p>
        <a class="btn btn-light btn-lg" href="players.php" role="button">Read Legends' Stories</a>
    </div>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="img1.jpg" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
        <h5>Explore the Legends of Football</h5>
        <p>Uncover the stories of football's greatest legends and relive their iconic moments.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="img2.jpg" alt="Second slide">
      <div class="carousel-caption d-none d-md-block">
        <h5>Discover exclusive insights</h5>
        <p>Tributes to the football heroes who shaped the game.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="img3.jpg" alt="Third slide">
      <div class="carousel-caption d-none d-md-block">
        <h5>Read Legends' Stories</h5>
        <p><a class="btn btn-light" href="players.php" role="button">Click Here</a></p>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


    <!-- Featured Legends Section -->
    
    <!-- Searching Form Container -->
    <div class="col-md-6">
        <form class="form-inline" method="get" action="">
            <label class="mr-2" for="search">Search:</label>
            <input type="text" class="form-control mr-2" name="search" id="search" placeholder="Player name">
            <button type="submit" class="btn btn-secondary">Search</button>
        </form>
    </div>

    <nav class="navbar navbar-dark default-color">
        <form class="form-inline">
            <!-- <div class="md-form my-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            </div>
            <button class="btn btn-outline-white btn-md my-2 my-sm-0 ml-3" type="submit">Search</button> -->
        </form>
    </nav>

    <a href="players.php">explore the legends here</a>

</body>

</html>
