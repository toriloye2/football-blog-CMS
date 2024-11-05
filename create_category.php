<?php
// Include the database connection file
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the positions value from the form
    $position = $_POST["position"];

    try {
        // Insert the positions into the categories table using PDO
        $sql = "INSERT INTO categories (position) VALUES (:position)";
        $stmt = $db->prepare($sql);

        // Bind the parameter using named placeholders
        $stmt->bindParam(':position', $position, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Position inserted successfully";
            header("Location: categories.php");
        } else {
            throw new Exception("Error: " . $stmt->errorInfo()[2]);
        }

        // Close the prepared statement
        $stmt->closeCursor();
    } catch (Exception $e) {
        echo "Caught exception: " . $e->getMessage();
    }
}

// Close the database connection if needed
$db = null;
?>
