<?php
// Start the session to access session variables
session_start();

// Include the configuration file
require_once("../Modules/config.php");

// Get the username from the session
$username = $_SESSION['admin']['username'];

// Prepare and execute the query to update the logout time for the admin
$time = $conn->prepare('UPDATE `Admins` SET `LogoutTime` = CURRENT_TIMESTAMP WHERE `Username` = :username');
$time->bindParam(':username', $username, PDO::PARAM_STR);
$time->execute();

// Close the database connection
$conn = null;

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: login.php");

// Ensure that no further code is executed after redirection
exit();