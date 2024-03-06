<?php

session_start();

require_once("../Modules/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customerid = isset($_POST["customerid"]) ? htmlspecialchars($_POST["customerid"]) : '';
    $firstname = isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : '';
    $lastname = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
    $city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '';
    $region = isset($_POST['region']) ? htmlspecialchars($_POST['region']) : '';
    $zipcode = isset($_POST['zipcode']) ? htmlspecialchars($_POST['zipcode']) : '';
    $country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : '';
    $password = isset($_POST['currentpassword']) ? htmlspecialchars($_POST['currentpassword']) : '';

    try {
        $stmt = $conn->prepare("UPDATE `Customers` SET 
            `FirstName`     = :customerfirstname,
            `LastName`      = :customerlastname,
            `Email`         = :customeremail,
            `PhoneNumber`   = :customerphone,
            `Password`      = :customerpassword,
            `Address`       = :customeraddress,
            `City`          = :customercity,
            `State`         = :customerstate,
            `ZipCode`       = :customerzipcode,
            `Country`       = :customercountry
        WHERE `CustomerID` = :customerid");

        $stmt->bindParam(":customerid", $customerid, PDO::PARAM_INT);
        $stmt->bindParam(":customerfirstname", $firstname, PDO::PARAM_STR);
        $stmt->bindParam(":customerlastname", $lastname, PDO::PARAM_STR);
        $stmt->bindParam(":customeremail", $email, PDO::PARAM_STR);
        $stmt->bindParam(":customerphone", $phone, PDO::PARAM_STR);
        $stmt->bindParam(":customerpassword", $password, PDO::PARAM_STR);
        $stmt->bindParam(":customeraddress", $address, PDO::PARAM_STR);
        $stmt->bindParam(":customercity", $city, PDO::PARAM_STR);
        $stmt->bindParam(":customerstate", $region, PDO::PARAM_STR);
        $stmt->bindParam(":customerzipcode", $zipcode, PDO::PARAM_STR);
        $stmt->bindParam(":customercountry", $country, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['messages'][] = ['result' => "Success changed"];
            header("Location: customer_profile.php?id=" . $customerid);
            exit;
        } else {
            $_SESSION['messages'][] = ['result' => "Failed"];
            header("Location: customer_profile.php?id=" . $customerid);
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['messages'][] = ['result' => "Error: {$e->getMessage()}"];
        header("Location: dashboard.php");
        exit;
    } finally {
        $conn = null;
    }
}