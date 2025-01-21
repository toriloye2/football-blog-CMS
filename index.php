<?php
session_start();
require('connect.php'); // Database connection
include 'header.php';

$welcomeMessage = null;

// Display welcome message if logged in and not shown before
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && !isset($_SESSION["welcome_shown"])) {
    $welcomeMessage = "Welcome, " . htmlspecialchars($_SESSION["name"]) . "!";
    $_SESSION["welcome_shown"] = true; // Set the welcome message as shown
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Welcome to T.O Blog</title>

    <style>
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            text-align: center;
            padding: 100px 20px;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 30px;
        }

        .hero .btn {
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 1.2rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .hero .btn-primary {
            background: linear-gradient(to right, #1abc9c, #16a085);
            border: none;
            color: white;
        }

        .hero .btn-primary:hover {
            background: linear-gradient(to right, #16a085, #1abc9c);
            transform: translateY(-5px);
        }

        .hero .btn-secondary {
            background: white;
            color: #27ae60;
            border: 2px solid #27ae60;
        }

        .hero .btn-secondary:hover {
            background: #27ae60;
            color: white;
            transform: translateY(-5px);
        }

        /* Highlights Section */
        .highlights {
            background: #f8fdf4;
            padding: 50px 20px;
        }

        .highlights h2 {
            text-align: center;
            margin-bottom: 40px;
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .highlight-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .highlight-card:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.2);
        }

        .highlight-card img {
    max-width: 300px; /* Increase the max-width */
    max-height: 280px; /* Maintain proportional height */
    margin-bottom: 15px;
    object-fit: cover; /* Ensures the image scales properly */
}


        .highlight-card h5 {
            font-size: 1.2rem;
            color: #27ae60;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .highlight-card p {
            font-size: 0.9rem;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <!-- Display Welcome Message -->
    <?php if ($welcomeMessage): ?>
        <div class="alert alert-success text-center">
            <?= $welcomeMessage ?>
        </div>
    <?php endif; ?>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Welcome to T.O Blog</h1>
        <p>Your go-to source for football legends, match insights, and engaging stories.</p>
        <a href="players.php" class="btn btn-primary">Explore Legends</a>
        <a href="categories.php" class="btn btn-secondary">View Categories</a>
    </div>

    <!-- Highlights Section -->
    <div class="highlights">
    <h2>Why Choose T.O Blog?</h2>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <a href="players.php" style="text-decoration: none;">
                    <div class="highlight-card">
                        <img src="images/leg.webp" alt="Icon">
                        <h5>100+ Legends</h5>
                        <p>Read profiles of the greatest footballers who made history.</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="insights.php" style="text-decoration: none;">
                    <div class="highlight-card">
                        <img src="images/tac1.webp" alt="Icon">
                        <h5>Match Insights</h5>
                        <p>Stay updated with match reviews, analyses, and predictions.</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="player_details.php" style="text-decoration: none;">
                    <div class="highlight-card">
                        <img src="images/treb new.png" alt="Icon">
                        <h5>Engaging Stories</h5>
                        <p>Relive iconic moments and behind-the-scenes stories of legends.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>


    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>

</html>
<?php
// Random player selection logic
$stmt = $db->prepare("SELECT player_id FROM football_legends ORDER BY RAND() LIMIT 1");
$stmt->execute();
$randomPlayer = $stmt->fetch(PDO::FETCH_ASSOC);

if ($randomPlayer) {
    $randomPlayerId = $randomPlayer['player_id'];
    $randomPlayerLink = "player_details.php?id=$randomPlayerId";
} else {
    $randomPlayerLink = "#";
}
?>

