<?php

<?php
    // Use Heroku's environment variable for DATABASE_URL in production
    $dbUrl = getenv('DATABASE_URL') ?: 'postgres://u6t2brpb6illts:p6a1cfd224349d562a376a40147f19fa4f364bde4d9c102b7b16ff5ec041055d6@c6sfjnr30ch74e.cluster-czrs8kj4isg7.us-east-1.rds.amazonaws.com:5432/df46ec5dt0krj4';

    // Parse the URL into its components
    $url = parse_url($dbUrl);

    // Extract the necessary components for PostgreSQL connection
    $host = $url["host"];
    $port = $url["port"];
    $user = $url["user"];
    $password = $url["pass"];
    $dbname = ltrim($url["path"], "/");

    // Define DSN for PostgreSQL
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

    try {
        // Create a new PDO instance with PostgreSQL
        $db = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        // Set a success message if connection is successful
        $message = "Connected successfully!";
    } catch (PDOException $e) {
        // Print error message in case of connection failure
        print "Error: " . $e->getMessage();
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Connection Status</title>
    <script>
        // When the window loads, start a timer to hide the message after 5 seconds
        window.onload = function() {
            setTimeout(function() {
                var messageElement = document.getElementById('connection-message');
                if (messageElement) {
                    messageElement.style.display = 'none';
                }
            }, 5000);
        };
    </script>
    <style>
        /* Optional: Style the message container */
        #connection-message {
            padding: 10px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            font-family: Arial, sans-serif;
            margin: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Display the connection message if it exists -->
    <?php if (isset($message)) { ?>
        <div id="connection-message"><?php echo $message; ?></div>
    <?php } ?>
</body>
</html>

    // // Use Heroku's environment variable for DATABASE_URL in production
    // $dbUrl = getenv('DATABASE_URL') ?: 'postgres://u6t2brpb6illts:p6a1cfd224349d562a376a40147f19fa4f364bde4d9c102b7b16ff5ec041055d6@c6sfjnr30ch74e.cluster-czrs8kj4isg7.us-east-1.rds.amazonaws.com:5432/df46ec5dt0krj4';

    // // Parse the URL into its components
    // $url = parse_url($dbUrl);

    // // Extract the necessary components for PostgreSQL connection
    // $host = $url["host"];
    // $port = $url["port"];
    // $user = $url["user"];
    // $password = $url["pass"];
    // $dbname = ltrim($url["path"], "/");

    // // Define DSN for PostgreSQL
    // $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

    // try {
    //     // Create a new PDO instance with PostgreSQL
    //     $db = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    //     // echo "Connected successfully!";
    // } catch (PDOException $e) {
    //     // Print error message in case of connection failure
    //     print "Error: " . $e->getMessage();
    //     die();
    // }

//      define('DB_DSN','mysql:host=localhost;dbname=footballside;charset=utf8');
//      define('DB_USER','root');
//      define('DB_PASS','');

//     //  PDO is PHP Data Objects
//     //  mysqli <-- BAD.
//     //  PDO <-- GOOD.
//      try {
//          // Try creating new PDO connection to MySQL.
//          $db = new PDO(DB_DSN, DB_USER, DB_PASS);
//          //,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
//      } catch (PDOException $e) {
//          print "Error: " . $e->getMessage();
//          die(); // Force execution to stop on errors.
//          // When deploying to production you should handle this
//          // situation more gracefully. ¯\_(ツ)_/¯
//      }
//  ?>