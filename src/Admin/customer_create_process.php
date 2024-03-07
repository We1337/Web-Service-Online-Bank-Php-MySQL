<?php

session_start();

require_once("../Modules/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : '';
    $lastname = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
    $city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '';
    $region = isset($_POST['region']) ? htmlspecialchars($_POST['']) : '';
    $zipcode = isset($_POST['zipcode']) ? htmlspecialchars($_POST['']) : '';
    $country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
    $registrationDate = date('Y-m-d');

    try {



        $stmt = $conn->prepare("INSERT INTO Customers (`FirstName`, `LastName`, `Email`, `PhoneNumber`, `Password`, `Address`, `City`, `State`, `ZipCode`, `Country`, `RegistrationDate`
        ) VALUES (
            :customerfirstname, 
            :customerlastname,
            :customeremail,
            :customerphone,
            :customeraddress,
            :customercity,
            :customerregion,
            :customerzipcode,
            :customercountry,
            :customerpassword,
            :customerregistrationDate
        );");

        $stmt->bindParam(":customerfirstname", $firstname, PDO::PARAM_STR);
        $stmt->bindParam(":customerlastname", $lastname, PDO::PARAM_STR);
        $stmt->bindParam(":customeremail", $email, PDO::PARAM_STR);
        $stmt->bindParam(":customerphone", $phone, PDO::PARAM_STR);
        $stmt->bindParam(":customeraddress", $address, PDO::PARAM_STR);
        $stmt->bindParam(":customercity", $city, PDO::PARAM_STR);
        $stmt->bindParam(":customerregion", $region, PDO::PARAM_STR);
        $stmt->bindParam(":customerzipcode", $zipcode, PDO::PARAM_STR);
        $stmt->bindParam(":customercountry", $country, PDO::PARAM_STR);
        $stmt->bindParam(":customerpassword", $password, PDO::PARAM_STR);
        $stmt->bindParam(":customerregistrationDate", $registrationDate, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Get the last inserted CustomerID
            $customerID = $conn->lastInsertId();

            // Create a deposit for the customer with a value of 0
            $stmtDeposit = $conn->prepare("INSERT INTO Deposit (`CustomerID`, `Amount`, `DepositDate`) VALUES (:customerID, 0, CURRENT_TIMESTAMP);");
            $stmtDeposit->bindParam(":customerID", $customerID, PDO::PARAM_INT);
            $stmtDeposit->execute();

            $_SESSION['messages'][] = ['result' => "Success"];
            header("Location: customer.php");
            exit;
        } else {
            $_SESSION['messages'][] = ['result' => "Failed"];
            header("Location: customer_create.php");
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