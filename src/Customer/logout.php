<?php

session_start();

require_once("../Modules/config.php");

$conn = null;

$_SESSION = array();

session_destroy();

header("Location: login.php");

exit();