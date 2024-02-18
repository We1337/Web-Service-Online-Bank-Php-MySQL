<?php

session_start();

if (isset($_SESSION['admin_session'])) {
    $username = $_SESSION['admin_username'];
    $username = $_SESSION['message'];
    echo "Welcome, $username!";
} else {
    echo "Please log in.";
    header("Location: login.php");
}

echo "<br><br><a href='include/exit.php'>exit</a>";