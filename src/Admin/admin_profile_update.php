<?php

session_start();

require_once("../Modules/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $check_every_error = array();

    $username = isset($_POST["username"]) ? htmlspecialchars($_POST['username']) : '';
    $email = isset($_POST["email"]) ? htmlspecialchars($_POST['email']) : '';
    $firstname = isset($_POST["firstname"]) ? htmlspecialchars($_POST['firstname']) : '';
    $lastname = isset($_POST["lastname"]) ? htmlspecialchars($_POST['lastname']) : '';
    $oldpassword = isset($_POST["oldpassword"]) ? htmlspecialchars($_POST['oldpassword']) : '';
    $password = isset($_POST["password"]) ? htmlspecialchars($_POST['password']) : '';
    $confirmpassword = isset($_POST["confirmpassword"]) ? htmlspecialchars($_POST['confirmpassword']) : '';

    // Reset session messages
    $_SESSION["message"] = array();

    // Check for empty fields
    if (empty($username)) {
        $_SESSION["message"]["username"] = "Please enter a username";
        array($check_every_error, true);
    }

    if (empty($email)) {
        $_SESSION["message"]["email"] = "Please enter an email";
        array($check_every_error, true);
    }

    if (empty($firstname)) {
        $_SESSION["message"]["firstname"] = "Please enter a first name";
        array($check_every_error, true);
    }

    if (empty($lastname)) {
        $_SESSION["message"]["lastname"] = "Please enter a last name";
        array($check_every_error, true);
    }

    if (empty($oldpassword)) {
        $_SESSION["message"]["oldpassword"] = "Please enter an old password";
        array($check_every_error, true);
    }

    if (empty($password)) {
        $_SESSION["message"]["password"] = "Please enter a new password";
        array($check_every_error, true);
    }

    if (empty($confirmpassword)) {
        $_SESSION["message"]["confirmpassword"] = "Please confirm the new password";
        array($check_every_error, true);
    }

    // Check if passwords match
    if ($password != $confirmpassword) {
        $_SESSION["message"]["password_is_not_same"] = "The passwords do not match";
        array($check_every_error, true);
    }

    // Check password length
    if (strlen($password) < 8) {
        $_SESSION["message"]["password_length"] = "The password length must be at least 8 characters";
        array($check_every_error, true);
    }

    $allTrue = array_reduce($myArray, function($carry, $item){
        return $carry && $item;
    }, true);

    // If there are errors, redirect to profile.php
    if ($allTrue) {
        $_SESSION["messages"][] = ["result" => "failed"];
        header("Location: admin_profile.php");
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

                    header("Location: admin_index.php");
                    exit;
                } else {
                    $_SESSION['messages'][] = ["result" => "failed"];
                    header("Location: admin_profile.php");
                    exit;
                }
            } else {
                $_SESSION['message']['password_verification'] = "Password verification failed";
                header("Location: admin_profile.php");
                exit;
            }
        }
    } catch (PDOException $e) {
        $_SESSION["messages"][] = ["result" => "Error: " . $e->getMessage()];
        header("Location: dashboard.php");
        exit;
    } finally {
        $conn = null;
    }
}
