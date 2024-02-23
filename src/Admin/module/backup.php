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
        $username = 'We1337';
        $password = 'password';

        $date = date("Y-m-d-G-i-s");
        $filename = str_replace([' ', ':'], '_', $title) . "_" . $date . ".sql";

        $stmt = $conn->prepare("INSERT INTO `Backup`(`BackupName`, `BackupDescription`, `BackupLocation`, `BackupDate`) VALUES 
        (:backuptitle, :backupdescription, :backuppath, :backupdate);");

        // Use --all-databases option to backup all databases
        $command = "mysqldump -u " . $username . " -p" . $password . " bank > backup/" . $filename;

        $backuppath = "backup/" . $filename;

        $stmt->bindParam(":backuptitle", $title, PDO::PARAM_STR);
        $stmt->bindParam(":backupdescription", $description, PDO::PARAM_STR);
        $stmt->bindParam(":backuppath", $backuppath, PDO::PARAM_STR);
        $stmt->bindParam(":backupdate", $date, PDO::PARAM_STR);

        exec($command, $output, $returnValue);
        $stmt->execute();

        if ($stmt->rowCount() > 0 && $returnValue === 0) {
            $_SESSION['message']['backup_complited'] = 'success';
        } else {
            $_SESSION['message']['backup_complited'] = 'failed';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

// TODO: connect to ftp server and send data to backup folder
