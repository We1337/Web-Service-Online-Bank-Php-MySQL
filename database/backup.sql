CREATE TABLE `Backup` (
    `BackupID` INT PRIMARY KEY AUTO_INCREMENT,
    `BackupName` VARCHAR(255) NOT NULL,
    `BackupDescription` VARCHAR(255) NOT NULL,
    `BackupLocation` VARCHAR(255) NOT NULL,
    `BackupDate` DATE
);

INSERT INTO `Backup` (`BackupName`, `BackupDescription`, `BackupLocation`, `BackupDate`) VALUES
('Backup1', 'Description for Backup1', '/path/to/backup1', '2022-01-01'),
('Backup2', 'Description for Backup2', '/path/to/backup2', '2022-02-01'),
('Backup3', 'Description for Backup3', '/path/to/backup3', '2022-03-01');
