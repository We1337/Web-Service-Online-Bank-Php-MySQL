CREATE TABLE `Customers` (
    `CustomerID` INT PRIMARY KEY AUTO_INCREMENT,
    `FirstName` VARCHAR(50) NOT NULL,
    `LastName` VARCHAR(50) NOT NULL,
    `Email` VARCHAR(100) NOT NULL,
    `PhoneNumber` VARCHAR(100) NOT NULL,
    `Password` VARCHAR(100) NOT NULL,
    `Address` VARCHAR(255),
    `City` VARCHAR(50),
    `State` VARCHAR(50),
    `ZipCode` VARCHAR(10),
    `Country` VARCHAR(50),
    `RegistrationDate` DATE NOT NULL
);

CREATE TABLE `Deposit` (
    `DepositID` INT PRIMARY KEY AUTO_INCREMENT,
    `CustomerID` INT NOT NULL,
    `Amount` DECIMAL(10, 2) NOT NULL,
    `DepositDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`CustomerID`) REFERENCES `Customers`(`CustomerID`) ON DELETE CASCADE
);

CREATE TABLE `Transfer` (
    `TransferID` INT PRIMARY KEY AUTO_INCREMENT,
    `CustomerID` INT NOT NULL,
    `RecipientID` INT NOT NULL,
    `RecipientName` VARCHAR(100) NOT NULL, 
    `PhoneNumber` VARCHAR(100) NOT NULL,
    `TransferDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Amount` DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (`CustomerID`) REFERENCES `Customers`(`CustomerID`) ON DELETE CASCADE,
    FOREIGN KEY (`RecipientID`) REFERENCES `Customers`(`CustomerID`) ON DELETE CASCADE
);

CREATE TABLE `CreditCard` (
    `CreditCardID` INT PRIMARY KEY AUTO_INCREMENT,
    `CustomerID` INT NOT NULL,
    `CardNumber` VARCHAR(20) NOT NULL,
    `CardHolderName` VARCHAR(100) NOT NULL,
    `ExpirationDate` DATE NOT NULL,
    `CVV` VARCHAR(4) NOT NULL,
    `CreationDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`CustomerID`) REFERENCES `Customers`(`CustomerID`) ON DELETE CASCADE
);

-- Inserting more fake data into Customers table
INSERT INTO Customers (FirstName, LastName, Email, PhoneNumber, Password, Address, City, State, ZipCode, Country, RegistrationDate)
VALUES
    ('Alice', 'Johnson', 'alice.johnson@email.com', '111-222-3333', 'pass123', '789 Maple St', 'Villageton', 'Stateland', '67890', 'Countryland', '2022-03-01'),
    ('Bob', 'Miller', 'bob.miller@email.com', '555-444-3333', 'secret123', '456 Pine St', 'Cityburg', 'Stateland', '45678', 'Countryland', '2022-04-01');

-- Inserting more fake data into Deposit table
INSERT INTO Deposit (CustomerID, Amount)
VALUES
    (3, 1200.00),
    (4, 800.75);

-- Inserting more fake data into Transfer table
INSERT INTO Transfer (CustomerID, RecipientID, RecipientName, PhoneNumber, Amount)
VALUES
    (3, 4, 'Bob Miller', '555-444-3333', 300.00),
    (4, 3, 'Alice Johnson', '111-222-3333', 150.00);

-- Inserting more fake data into CreditCard table
INSERT INTO CreditCard (CustomerID, CardNumber, CardHolderName, ExpirationDate, CVV)
VALUES
    (3, '1111222233334444', 'Alice Johnson', '2025-05-01', '789'),
    (4, '5555666677778888', 'Bob Miller', '2026-08-01', '012');
