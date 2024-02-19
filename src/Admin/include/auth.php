<?php

require_once("../../Modules/config.php");

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare('SELECT `AdminID`, `Password` FROM `Admins` WHERE `Username` = :username');
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $hashed_password = $result['Password'];
    if (password_verify($password, $hashed_password)) {

        // Session is active
        $_SESSION['admin_session'] = true;

        // Information about Admin
        $_SESSION['admin_id'] = $result['AdminID'];
        $_SESSION['admin_username'] = $result['Username'];
        $_SESSION['admin_firstname'] = $result['FirstName'];
        $_SESSION['admin_lastname'] = $result['LastName'];
        $_SESSION['admin_email'] = $result['Email'];

        // Message log
        $_SESSION['message'] = "Welcome: " . $username;

        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION["message"] = "Invalid username or password";
        header("Location: ../index.php");
        exit();
    }
} else {
    $_SESSION["message"] = "Invalid username or password";
    header("Location: ../index.php");
    exit();
}

$conn = null;
exit();
?>