<?php

session_start();

unset($_SESSION["message"]);

require_once("../Modules/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = isset($_POST["username"]) ? htmlspecialchars($_POST["username"]) : '';
    $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : '';
    $firstname = isset($_POST["firstname"]) ? htmlspecialchars($_POST["firstname"]) : '';
    $lastname = isset($_POST["lastname"]) ? htmlspecialchars($_POST["lastname"]) : '';
    $oldpassword = isset($_POST["oldpassword"]) ? htmlspecialchars($_POST["oldpassword"]) : '';
    $newpassword = isset($_POST["newpassword"]) ? htmlspecialchars($_POST["newpassword"]) : '';
    $confirmpassword = isset($_POST["confirmpassword"]) ? htmlspecialchars($_POST["confirmpassword"]) : '';

    $isValid = true;

    if (empty($username)) {
        $_SESSION["message"]["username"] = "Please enter a username";
        $isValid = false;
    }

    if (empty($email)) {
        $_SESSION["message"]["email"] = "Please enter an email";
        $isValid = false;
    }

    if (empty($firstname)) {
        $_SESSION["message"]["firstname"] = "Please enter a first name";
        $isValid = false;
    }

    if (empty($lastname)) {
        $_SESSION["message"]["lastname"] = "Please enter a last name";
        $isValid = false;
    }

    if (empty($oldpassword)) {
        $_SESSION["message"]["oldpassword"] = "Please enter the old password";
        $isValid = false;
    }

    if (!empty($newpassword) && strlen($newpassword) < 8) {
        $_SESSION["message"]["password_length"] = "The password length should be at least 8 characters";
        $isValid = false;
    }

    if (empty($confirmpassword)) {
        $_SESSION["message"]["confirm_password"] = "Please confirm the new password";
        $isValid = false;
    }

    if ($newpassword != $confirmpassword) {
        $_SESSION["message"]["password_is_not_same"] = "The passwords do not match";
        $isValid = false;
    }

    if (!$isValid) {
        header("Location: admin_profile.php");
        exit;
    }

    if (!isset($_SESSION["admin"]["id"])) {
        $_SESSION["messages"][] = ["result" => "User not logged in"];
        header("Location: login.php");
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT `Password` FROM `Admins` WHERE `Username` = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {

            if (password_verify($oldpassword, $result["Password"])) {
                $userid = $_SESSION["admin"]["id"];

                $updatestmt = $conn->prepare("UPDATE `Admins` SET 
                            `Username`=:username,
                            `FirstName`=:firstname,
                            `LastName`=:lastname,
                            `Email`=:email
                            " . (!empty($newpassword) ? ", `Password`=:newpassword" : "") . "
                        WHERE `AdminID`=:admin_id");

                if (!empty($newpassword)) {
                    $new_password = password_hash($newpassword, PASSWORD_DEFAULT);
                    $updatestmt->bindParam(":newpassword", $new_password, PDO::PARAM_STR);
                }

                $updatestmt->bindParam(":username", $username, PDO::PARAM_STR);
                $updatestmt->bindParam(":firstname", $firstname, PDO::PARAM_STR);
                $updatestmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
                $updatestmt->bindParam(":email", $email, PDO::PARAM_STR);
                $updatestmt->bindParam(":admin_id", $userid, PDO::PARAM_INT);

                if ($updatestmt->execute()) {
                    $_SESSION["admin"]["username"] = $username;
                    $_SESSION["admin"]["firstname"] = $firstname;
                    $_SESSION["admin"]["lastname"] = $lastname;
                    $_SESSION["admin"]["email"] = $email;

                    $_SESSION["messages"][] = ["result" => "Success"];

                    header("Location: dashboard.php");
                    exit;
                } else {
                    $_SESSION["messages"][] = ["result" => "Failed to update data in the database"];
                    header("Location: admin_profile.php");
                    exit;
                }
            } else {
                $_SESSION["message"]["password_verification_failed"] = "Password is not verified";
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
