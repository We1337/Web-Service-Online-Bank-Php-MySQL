CREATE TABLE `Backup` (
    `BackupID` INT PRIMARY KEY AUTO_INCREMENT,
    `BackupName` VARCHAR(255) NOT NULL,
    `BackupDescription` VARCHAR(255) NOT NULL,
    `BackupLocation` VARCHAR(255) NOT NULL,
    `BackupDate` DATE
);
