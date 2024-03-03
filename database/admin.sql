CREATE TABLE `Admins` (
    `AdminID` INT PRIMARY KEY AUTO_INCREMENT,
    `Username` VARCHAR(255) UNIQUE NOT NULL,
    `Password` VARCHAR(255) NOT NULL,
    `FirstName` VARCHAR(50) NOT NULL,
    `LastName` VARCHAR(50) NOT NULL,
    `Email` VARCHAR(100) UNIQUE NOT NULL,
    `LoginTime` TIMESTAMP DEFAULT NULL,
    `LogoutTime` TIMESTAMP DEFAULT NULL 
);

-- Insert fake data
-- username: admin
-- password: password
INSERT INTO `Admins` (`Username`, `Password`, `FirstName`, `LastName`, `Email`,  `LoginTime`, `LogoutTime`)
VALUES
    ('admin', '$2y$10$iwVJovXdgi1Ggc3Y80y/Z.LQa13pP6y.lgoxTDQP50CAfcSg.QRGG', 'John', 'Doe', 'admin1@example.com', '2024-03-03 12:00:00', '2024-03-03 18:30:00');