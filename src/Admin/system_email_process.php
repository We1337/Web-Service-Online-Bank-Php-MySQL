<?php

require '../../vendor/autoload.php';
require '../Modules/db_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Start a session
session_start();

// Validate form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $recipient = filter_var($_POST["recipient"], FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars($_POST["subject"], ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($_POST["message"], ENT_QUOTES, 'UTF-8');

    // Check if form data is valid
    if (!$recipient || empty($subject) || empty($message)) {
        echo "Error: Invalid input";
        exit;
    }

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = MAIL_HOST; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_NAME; // Replace with your SMTP username
        $mail->Password = MAIL_PASSWORD; // Replace with your SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = MAIL_PORT;

        $mail->setFrom($_SESSION['admin']['email'], $_SESSION['admin']['username']);
        $mail->addAddress($recipient);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        $mail->send();
        echo "Email sent successfully!";
    } catch (Exception $e) {
        echo "Error: " . $mail->ErrorInfo;
    }

} else {
    echo "Error: Invalid request method.";
}
