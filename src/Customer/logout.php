<?php

session_start();

require_once("../Modules/config.php");

$phonenumber = $_SESSION["customer"]["phonenumber"];

$time = $conn->prepare("UPDATE `Customers` SET `LogoutTime` = CURRENT_TIMESTAMP WHERE `PhoneNumber` =:phonenumber");
$time->bindParam(":phonenumber", $phonenumber, PDO::PARAM_STR);
$time->execute();

$conn = null;

$_SESSION = array();

session_destroy();

header("Location: login.php");

exit();