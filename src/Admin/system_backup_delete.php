<?php

// Include the configuration file
require_once("../Modules/config.php");

// Get the 'id' parameter from the GET request
$id = $_GET['id'];

try {
    // Step 1: Retrieve the file path associated with the BackupID
    $stmt = $conn->prepare("SELECT `BackupLocation` FROM `backup` WHERE `BackupID`=:backupid;");
    $stmt->bindParam(":backupid", $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Step 2: Check if the result is not empty
    if (!empty($result)) {
        $filePath = $result[0]['BackupLocation'];

        // Step 3: Check if the file exists
        if (file_exists($filePath)) {

            // Step 4: Attempt to delete the file
            if (unlink($filePath)) {
                // Step 5: If file deletion is successful, proceed to delete the record from the database
                $stmt_table = $conn->prepare("DELETE FROM `backup` WHERE `BackupID`=:id");
                $stmt_table->bindParam(":id", $id, PDO::PARAM_INT);

                // Step 6: Execute the database deletion query
                if ($stmt_table->execute()) {
                    echo "File and database record deleted successfully.";
                    $_SESSION["messages"][] = ['result' => 'Success'];
                    header("Location: system_backup_display.php");
                    exit;
                } else {
                    echo "Error deleting database record.";
                    $_SESSION['messages'][] = ['result' => 'Failed'];
                    header("Location: system_backup_information.php?id=" . $id);
                    exit;
                }
            } else {
                echo "Error deleting file.";
                $_SESSION["messages"][] = ["result"=> "Failed"];
                header("Location: system_backup_information.php?id=" . $id);
                exit;
            }
        } else {
            echo "File not found.";
            $_SESSION["messages"][] = ["result" => "Failed"];
            header("Location: system_backup_information.php?id=" . $id);
            exit;
        }
    } else {
        echo "Record not found.";
        $_SESSION["messages"][] = ["result" => "Failed"];
        header("Location: system_backup_information.php?id=" . $id);
        exit;
    }

} catch (PDOException $e) { 
    // Step 7: Handle any PDO exceptions
    echo "Error: " . $e->getMessage();
} finally {
    // Step 8: Close the database connection in the 'finally' block
    $conn = null;
}