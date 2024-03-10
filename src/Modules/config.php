<?php

// Include the database configuration file
require_once("db_config.php");

try {
    // Create a new PDO connection using the provided database credentials
    $conn = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASSWORD);

    // Set PDO attributes to enable error handling
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle any exceptions that might occur during the connection setup
    // Print an alert message with the error details if the connection fails
    echo "<div class='alert alert-info' role='alert'>Connection failed: " . $e->getMessage() . "</div>";
}