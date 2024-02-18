<?php

require_once("../../Modules/config.php");

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare('SELECT `password` FROM `admins` WHERE `username` = :username');
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $hashed_password = $result['password'];
    if(password_verify($password, $hashed_password)){
        $_SESSION['admin_session'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: ../index.php");
        exit();
    } else{
        $_SESSION["message"] = "Invalid username or password";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION["message"] = "Invalid username or password";
    header("Location: index.php");
    exit();
}

$conn = null;
exit();
?>