<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    /* $email    = $_POST["email"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $oldpassword = $_POST["oldpassword"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"]; */

    if(empty($username)) {
        $_SESSION["message"]["username"] = "Username is empty";
        header("Location: ../profile.php");
    }

    /* if(empty($email)) {
        $_SESSION["message_email"] = "Email is empty";
    }

    if(empty($firstname)) {
        $_SESSION["message_firstname"] = "Firstname is empty";
    }

    if(empty($lastname)) {
        $_SESSION["message_lastname"] = "";
    }

    if(empty($oldpassword)) {
        $_SESSION["message_oldpassword"] = "";
    }

    if(empty($password)) {
        $_SESSION["message_password"] = "";
    }

    if(empty($confirmpassword)) {
        $_SESSION["message_confirmpassword"] = "";
    }

    if($password == $confirmpassword) {
        $_SESSION["message_password_is_not_same"] = "";
    }
 */
    header("Location: ../profile.php");
}