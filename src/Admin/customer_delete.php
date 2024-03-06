<?php

session_start();

require_once("../Modules/config.php");

$userid = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : '';

try {
    $delete_customer_stmt = $conn->prepare("DELETE FROM `Customers` WHERE `CustomerID` = :userid");
    $delete_customer_stmt->bindParam(':userid', $userid, PDO::PARAM_INT);

    if ($delete_customer_stmt->execute()) {
        $_SESSION['messages'][] = ["result" => "Success"];
        header("Location: customer.php");
        exit;
    } else {
        $_SESSION['messages'][] = ["result" => "Failed"];
        header("Location: customer.php");
        exit;
    }

} catch (Exception $e) {
    $_SESSION['messages'][] = ['result' => "Error: {$e->getMessage()}"];
    header("Location: customer.php");
    exit;
} finally {
    $conn = null;
}
