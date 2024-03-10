<?php

session_start();

require_once("../Modules/db_config.php");
require_once("../Modules/config.php");


$username = DB_USER;
$password = DB_PASSWORD;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
    $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';

    if (empty($title)) {
        $_SESSION['message'][] = ["result" => "Please enter title name"];
    }

    if (empty($description)) {
        $_SESSION['messages'][] = ["result" => "Please enter description"];
    }

    try {
        $date = date("Y-m-d-G-i-s");
        $filename = str_replace([' ', ':'], '_', $title) . "_" . $date . ".sql";
        $backuppath = "backup/" . $filename;

        $stmt = $conn->prepare("INSERT INTO `Backup`(`BackupName`, `BackupDescription`, `BackupLocation`, `BackupDate`) VALUES 
        (:backuptitle, :backupdescription, :backuppath, :backupdate);");

        $stmt->bindParam(":backuptitle", $title, PDO::PARAM_STR);
        $stmt->bindParam(":backupdescription", $description, PDO::PARAM_STR);
        $stmt->bindParam(":backuppath", $backuppath, PDO::PARAM_STR);
        $stmt->bindParam(":backupdate", $date, PDO::PARAM_STR);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

            if ($isWindows) {
                // Windows command
                $command = "mysqldump -u " . $username . " -p" . $password . " bank > " . $backuppath . " -P 3300";
            } else {
                // Linux command
                $command = "mysqldump -u " . $username . " -p" . $password . " bank > " . $backuppath;
            }

            exec($command, $output, $returnValue);

            if ($returnValue === 0) {
                $_SESSION['messages'][] = ['result' => 'Success'];
            } else {
                $_SESSION['messages'][] = ['result' => 'Failed'];
            }
        } else {
            $_SESSION['messages'][] = ['result' => 'Failed'];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }

    header("Location: system_backup_display.php");
    exit;
}
