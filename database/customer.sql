CREATE TABLE `Customers` (
    `CustomerID` INT PRIMARY KEY AUTO_INCREMENT,
    `FirstName` VARCHAR(50) NOT NULL,
    `LastName` VARCHAR(50) NOT NULL,
    `Email` VARCHAR(100) NOT NULL,
    `PhoneNumber` VARCHAR(100) NOT NULL,
    `Address` VARCHAR(255),
    `City` VARCHAR(50),
    `State` VARCHAR(50),
    `ZipCode` VARCHAR(10),
    `Country` VARCHAR(50),
    `RegistrationDate` DATE NOT NULL
);

-- Accounts table
CREATE TABLE `Accounts` (
    `AccountID` INT PRIMARY KEY AUTO_INCREMENT,
    `CustomerID` INT,
    `AccountType` VARCHAR(20) NOT NULL,
    `Balance` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    FOREIGN KEY (`CustomerID`) REFERENCES `Customers`(`CustomerID`)
);

CREATE TABLE `Transactions` (
    `TransactionID` INT PRIMARY KEY AUTO_INCREMENT,
    `AccountID` INT,
    `TransactionType` VARCHAR(20) NOT NULL,
    `Amount` DECIMAL(10, 2) NOT NULL,
    `TransactionDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`AccountID`) REFERENCES `Accounts`(`AccountID`)
);