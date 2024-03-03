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

    // Reset session messages
    $_SESSION["message"] = array();

    // Check for empty fields
    if (empty($username)) {
        $_SESSION["message"]["username"] = "Please enter a username";
        $check_every_error = true;
    }

    if (empty($email)) {
        $_SESSION["message"]["email"] = "Please enter an email";
        $check_every_error = true;
    }

    if (empty($firstname)) {
        $_SESSION["message"]["firstname"] = "Please enter a first name";
        $check_every_error = true;
    }

    if (empty($lastname)) {
        $_SESSION["message"]["lastname"] = "Please enter a last name";
        $check_every_error = true;
    }

    if (empty($oldpassword)) {
        $_SESSION["message"]["oldpassword"] = "Please enter an old password";
        $check_every_error = true;
    }

    if (empty($password)) {
        $_SESSION["message"]["password"] = "Please enter a new password";
        $check_every_error = true;
    }

    if (empty($confirmpassword)) {
        $_SESSION["message"]["confirmpassword"] = "Please confirm the new password";
        $check_every_error = true;
    }

    // Check if passwords match
    if ($password != $confirmpassword) {
        $_SESSION["message"]["password_is_not_same"] = "The passwords do not match";
        $check_every_error = true;
    }

    // Check password length
    if (strlen($password) < 8) {
        $_SESSION["message"]["password_length"] = "The password length must be at least 8 characters";
        $check_every_error = true;
    }

    // If there are errors, redirect to profile.php
    if ($check_every_error) {
        header("Location: ../profile.php");
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT `AdminID`, `Password` FROM `Admins` WHERE `Username` = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {

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
                $updatestmt->bindParam(':username', $username, PDO::PARAM_STR);
                $updatestmt->bindParam(':newpassword', $new_password, PDO::PARAM_STR);
                $updatestmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
                $updatestmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
                $updatestmt->bindParam(':email', $email, PDO::PARAM_STR);
                $updatestmt->bindParam(':admin_id', $userid, PDO::PARAM_INT);
                $updatestmt->execute();

                if ($updatestmt->rowCount() > 0) {

                    $_SESSION['message']['admin_data_updated'] = 'success';

                    $_SESSION['admin']['username'] = $username;
                    $_SESSION['admin']['firstname'] = $firstname;
                    $_SESSION['admin']['lastname'] = $lastname;
                    $_SESSION['admin']['email'] = $email;

                    header("Location: ../index.php");
                    exit;
                } else {
                    $_SESSION['message']['admin_data_updated'] = 'failed';
                    header("Location: ../profile.php");
                    exit;
                }
            } else {
                $_SESSION['message']['password_verification'] = "Password verification failed";
                header("Location: ../profile.php");
                exit;
            }
        }
    } catch (PDOException $e) {
        $_SESSION['message']['error'] = "Error: " . $e->getMessage();
        header("Location: ../index.php");
        exit;
    } finally {
        $conn = null;
    }
}
