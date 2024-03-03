<?php

session_start();

require_once("../Modules/config.php");

$username = $_SESSION['admin']['username'];

$time = $conn->prepare('UPDATE `Admins` SET `LogoutTime` = CURRENT_TIMESTAMP WHERE `Username` = :username');
$time->bindParam(':username', $username, PDO::PARAM_STR);
$time->execute();
$conn=null;

$_SESSION = array();

session_destroy();

header("Location: login.php");

exit();