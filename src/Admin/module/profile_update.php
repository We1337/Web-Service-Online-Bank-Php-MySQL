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
    }

    if (!empty($email)) {
        $_SESSION["message"]["email"] = "Please enter an email";
    }

    if (!empty($firstname)) {
        $_SESSION["message"]["firstname"] = "Please enter a first name";
    }

    if (!empty($lastname)) {
        $_SESSION["message"]["lastname"] = "Please enter a last name";
    }

    if (!empty($oldpassword)) {
        $_SESSION["message"]["oldpassword"] = "Please enter a old password";
    }

    if (!empty($password)) {
        $_SESSION["message"]["password"] = "Please enter new password";
    }

    if (!empty($confirmpassword)) {
        $_SESSION["message"]["confirmpassword"] = "Please confirm new password";
    }

    if ($password == $confirmpassword) {
        $_SESSION["message"]["password_is_not_same"] = "The password is not same";
    }

    if(strlen($password) >= 8) {
        $_SESSION["message"]["password_length"] = "The passwrod length must not be less than 8";
    }

    foreach($_SESSION["message"] as $key=>$val) { 
        if (!empty($key)) {
            $check_every_error = true;    
        } else {
            header("Location: ../profile.php");
        }
    }

    try {
        $stmt = $conn->prepare("SELECT `AdminID`, `Password` FROM `Admins` WHERE `Username` = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $check_every_error) {

            $hashed_password = $result['Password'];

            if (password_verify($oldpassword, $hashed_password)) {

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

                    $_SESSION['admin']['username'] = $updatestmt['Username'];
                    $_SESSION['admin']['firstname'] = $updatestmt['FirstName'];
                    $_SESSION['admin']['lastname'] = $updatestmt['LastName'];
                    $_SESSION['admin']['email'] = $updatestmt['Email'];
                    header("Location: ../index.php");
                } else {
                    $_SESSION['message']['admin_data_updated'] = 'failed';
                    header("Location: ../profile.php");
                }
            } else {
                $_SESSION['message']['password_verification'] = "Password is not verified";
                header("Location: ../profile.php");
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        header("Location: ../index.php");
    } finally {
        $conn = null;
    }
}