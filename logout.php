<?php

// Name: oriooooooooooooooooooo
// Date: 20th Sep. 2023
// Description:The project is a simple blogging application 

require('connect.php');



// Start the session
session_start();

// Remove all session variables
session_unset();

// Destroy the session
session_destroy();
echo "You have been logged out!";
header('Location: login.php');
exit;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    
</body>
</html>