CREATE TABLE `AdminEmail` (
    `EmailID` INT PRIMARY KEY AUTO_INCREMENT,
    `EmailUser` VARCHAR(255) NOT NULL,
    `EmailSender` VARCHAR(255) NOT NULL,
    `EmailReciver` VARCHAR(255) NOT NULL,
    `EmailTitle` VARCHAR(255) NOT NULL,
    `EmailMessage` VARCHAR(1000) NOT NULL,
    `EmailTime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserting fake data into the AdminEmail table
INSERT INTO `AdminEmail` (`EmailUser`, `EmailSender`, `EmailReciver`, `EmailTitle`, `EmailMessage`)
VALUES
('john.doe@example.com', 'John Doe', 'alice.smith@example.com', 'Meeting Tomorrow', 'Hi Alice, Let\'s meet tomorrow at 2 PM to discuss the project.'),
('mary.jones@example.com', 'Mary Jones', 'bob.jackson@example.com', 'Important Update', 'Dear Bob, I wanted to inform you about the latest changes to the schedule. Please review the attached document.'),
('admin@company.com', 'Admin User', 'all.users@example.com', 'System Maintenance', 'Dear Users, We will be conducting system maintenance on Saturday from 10 PM to 2 AM. Expect some downtime during this period.');
