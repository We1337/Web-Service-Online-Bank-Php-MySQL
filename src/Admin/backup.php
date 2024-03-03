<?php

require_once("../../Modules/config.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (empty($title)) {
        $_SESSION['message']['backup_title'] = "Please enter title name";
    }

    if (empty($description)) {
        $_SESSION['message']['backup_description'] = "Please enter description";
    }

    try {
        $username = 'root';
        $password = ''; // Replace with your actual database password

        $date = date("Y-m-d-G-i-s");
        $filename = str_replace([' ', ':'], '_', $title) . "_" . $date . ".sql";

        $stmt = $conn->prepare("INSERT INTO `Backup`(`BackupName`, `BackupDescription`, `BackupLocation`, `BackupDate`) VALUES 
        (:backuptitle, :backupdescription, :backuppath, :backupdate);");

        $backuppath = "backup/" . $filename;

        $stmt->bindParam(":backuptitle", $title, PDO::PARAM_STR);
        $stmt->bindParam(":backupdescription", $description, PDO::PARAM_STR);
        $stmt->bindParam(":backuppath", $backuppath, PDO::PARAM_STR);
        $stmt->bindParam(":backupdate", $date, PDO::PARAM_STR);

        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

        if ($isWindows) {
            // Windows command
            $command = "mysqldump -u" . $username . " -p" . $password . " bank > backup/" . $filename;
        } else {
            // Linux command
            $command = "mysqldump -u" . $username . " -p" . $password . " bank > backup/" . $filename;
        }

        exec($command, $output, $returnValue);
        $stmt->execute();

        if ($stmt->rowCount() > 0 && $returnValue === 0) {
            $_SESSION['message']['backup_completed'] = 'success';
            header("Location: ../index.php");
        } else {
            $_SESSION['message']['backup_completed'] = 'failed';
            header("Location: ../index.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}
?>



// TODO: connect to ftp server and send data to backup folder
