<?php

require_once("../../Modules/config.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $check_every_error = false;

    $username = $_POST["username"];
    $email = $_POST["email"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $oldpassword = $_POST["oldpassword"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];

    if (!empty($username)) {
        $_SESSION["message"]["username"] = "Please enter a username";
        var_dump("Good with username<br>");
    }

    if (!empty($email)) {
        $_SESSION["message"]["email"] = "Please enter an email";
        var_dump("Good with email<br>");
    }

    if (!empty($firstname)) {
        $_SESSION["message"]["firstname"] = "Please enter a first name";
        var_dump("Good with firstname<br>");
    }

    if (!empty($lastname)) {
        $_SESSION["message"]["lastname"] = "Please enter a last name";
        var_dump("Good with lastname<br>");
    }

    if (!empty($oldpassword)) {
        $_SESSION["message"]["oldpassword"] = "Please enter a old password";
        var_dump("Good with old password<br>");
    }

    if (!empty($password)) {
        $_SESSION["message"]["password"] = "Please enter new password";
        var_dump("Good with new password<br>");
    }

    if (!empty($confirmpassword)) {
        $_SESSION["message"]["confirmpassword"] = "Please confirm new password";
        var_dump("Good with confirm password<br>");
    }

    if ($password == $confirmpassword) {
        $_SESSION["message"]["password_is_not_same"] = "The password is not same";
        var_dump("Good with same password<br>");
    }

    if(strlen($password) >= 8) {
        $_SESSION["message"]["password_length"] = "The passwrod length must not be less than 8";
        var_dump("Good with password length<br>");
    }

    foreach($_SESSION["message"] as $key=>$val) { 
        //var_dump($key. " ". $val);
        if (!empty($key)) 
        {
            $check_every_error = true;    
            var_dump("Everything is good: " . $key . "<br>");
        } else {
        var_dump("Wrong: " . $key . "<br>");
        //header("Location: ../profile.php");
        }
    }

    if ($check_every_error) {
        var_dump("Check is passsed<br>");
        //header("Location: ../profile.php");
    } else {
        var_dump("Check did'nt passsed<br>");
        //header("Location: ../profile.php");
    }

    try {
        $stmt = $conn->prepare("SELECT `AdminID`, `Password` FROM `Admins` WHERE `Username` = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {

            var_dump("request data from database passed<br>");
            var_dump("password: " . $oldpassword . "<br>");

            $hashed_password = $result['Password'];

            if (password_verify($oldpassword, $hashed_password)) {
                var_dump("password verified<br>");

                $userid = $_SESSION['admin_id'];
                $updatestmt = $conn->prepare("UPDATE `Admins` SET 
                    `Username`=:username,
                    `Password`=:newpassword,
                    `FirstName`=:firstname,
                    `LastName`=:lastname,
                    `Email`=:email
                WHERE `AdminID`=:admin_id");

                $new_password = password_hash($password, PASSWORD_DEFAULT);
                $updatestmt->bindParam('username', $username, PDO::PARAM_STR);
                $updatestmt->bindParam('newpassword', $new_password, PDO::PARAM_STR);
                $updatestmt->bindParam('firstname', $firstname, PDO::PARAM_STR);
                $updatestmt->bindParam('lastname', $lastname, PDO::PARAM_STR);
                $updatestmt->bindParam('email', $email, PDO::PARAM_STR);
                $updatestmt->bindParam(':admin_id', $userid, PDO::PARAM_INT);
                $updatestmt->execute();
                    
                if ($updatestmt->rowCount() > 0) {
                    $_SESSION['message']['admin_data_updated'] = 'success';
                    var_dump("Success");
                    //header("Location: ../index.php");
                } else {
                    $_SESSION['message']['admin_data_updated'] = 'failed';
                    var_dump("Failed");
                    //header("Location: ../profile.php");
                }
            } else {
                var_dump("password not verified");
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}