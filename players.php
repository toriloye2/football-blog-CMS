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

try {
    // Search functionality
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $stmt = $db->prepare("SELECT * FROM football_legends WHERE first_name LIKE :search OR last_name LIKE :search");
        $stmt->bindValue(':search', "%$searchTerm%", PDO::PARAM_STR);
    } else {
        $stmt = $db->prepare("SELECT * FROM football_legends");
    }
    $stmt->execute();
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$players) {
        $players = []; // Ensure $players is always an array
    }
} catch (PDOException $e) {
    die("Error fetching players: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Football Legends</title>
    <style>
        body {
            background: #f8f9fa;
        }

        .jumbotron {
            background-image: url('https://via.placeholder.com/1500x500?text=Football+Legends');
            background-size: cover;
            background-position: center;
            color: #ffffff;
            text-shadow: 2px 2px 5px rgb(22, 215, 18);
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card-title a {
            color: #343a40;
            text-transform: capitalize;
        }

        .card-title a:hover {
            text-decoration: none;
            color: #007bff;
        }

    .fixed-size {
        width: 100%;
        height: 200px;
        object-fit: contain; /* Ensure the entire image is visible */
        background-color: #f0f0f0;
        border-radius: 5px;
    }


        .custom-hover {
            background-color: #007bff;
            color: #ffffff;
            border: 2px solid #ffffff;
            transition: all 0.3s ease-in-out;
        }

        .custom-hover:hover {
            background-color: #0056b3;
            color: #ffffff;
            border-color: #007bff;
            transform: scale(1.1);
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
    <div class="jumbotron text-center text-white py-5" style="background:linear-gradient(135deg, #27ae60, #2ecc71);">
    <h1 class="display-4">Football Legends</h1>
    <p class="lead">Browse through the iconic players who shaped the history of football.</p>
    <hr class="my-4" style="border-color: #ffffff;">
    <p>Learn more about their achievements, stories, and contributions to the game.</p>
</div>



    <!-- Search Form -->
    <div class="container my-4">
    <form class="form-inline" method="get" action="">
        <div class="row">
            <div class="col-md-8">
                <input type="text" class="form-control w-100" name="search" id="search" placeholder="Search player name">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn w-100" style="background: linear-gradient(to right, #a8ff78, #78ffd6); color: white; border: none; border-radius: 5px; padding: 10px; font-weight: bold; transition: all 0.3s ease-in-out;">
                    Search
                </button>
            </div>
        </div>
    </form>
</div>

    <!-- Title Above Player List -->
    <div class="container my-4">
        <h2 class="text-center mb-4">Explore Legendary Players</h2>
        <p class="text-center">Discover profiles, stats, and stories of football's most iconic figures.</p>
    </div>

    <!-- Players List -->
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            if (!empty($players)) {
                foreach ($players as $player) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card shadow-sm border-0">';

                    // Default image handling
                    $imageUrl = $player['images'] ?? 'https://placeimg.com/300/200/sports';
                    echo '<img src="' . htmlspecialchars($imageUrl) . '" class="card-img-top fixed-size rounded-top" alt="' . htmlspecialchars($player['first_name']) . '">';

                    // Capitalize first and last name
                    $firstName = ucfirst(strtolower($player['first_name']));
                    $lastName = ucfirst(strtolower($player['last_name']));

                    echo '<div class="card-body text-center">';
                    echo '<h5 class="card-title"><a href="player_details.php?id=' . htmlspecialchars($player['player_id']) . '" class="text-decoration-none text-dark fw-bold">' . $firstName . ' ' . $lastName . '</a></h5>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<div class='alert alert-warning text-center'>No players found.</div>";
            }
            ?>
        </div>
    </div>
</body>
<?php include 'footer.php'; ?>
</html>
