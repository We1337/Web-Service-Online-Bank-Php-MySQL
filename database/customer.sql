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
    `RegistrationDate` DATE NOT NULL,
    `LoginTime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `LogoutTime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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

-- Customers
INSERT INTO Customers (FirstName, LastName, Email, PhoneNumber, Password, Address, City, State, ZipCode, Country, RegistrationDate)
VALUES
('John', 'Doe', 'john.doe@example.com', '77470000000', '$2y$10$iwVJovXdgi1Ggc3Y80y/Z.LQa13pP6y.lgoxTDQP50CAfcSg.QRGG', '123 Main St', 'Anytown', 'CA', '12345', 'USA', '2023-01-15'),
('Jane', 'Smith', 'jane.smith@example.com', '9876543210', 'letmein', '456 Elm St', 'Smallville', 'NY', '54321', 'USA', '2023-02-20'),
('Alice', 'Johnson', 'alice.johnson@example.com', '5551234567', 'securepassword', '789 Oak St', 'Big City', 'TX', '67890', 'USA', '2023-03-10');

-- Deposits
INSERT INTO Deposit (CustomerID, Amount, DepositDate)
VALUES
(1, 1000.00, '2024-03-01 08:15:00'),
(2, 500.00, '2024-03-02 10:30:00'),
(3, 750.00, '2024-03-03 12:45:00');

-- Transfers
INSERT INTO Transfer (CustomerID, RecipientID, RecipientName, PhoneNumber, TransferDate, Amount)
VALUES
(1, 2, 'Jane Smith', '9876543210', '2024-03-04 09:00:00', 200.00),
(2, 3, 'Alice Johnson', '5551234567', '2024-03-05 11:15:00', 300.00),
(3, 1, 'John Doe', '1234567890', '2024-03-06 13:30:00', 400.00);

-- Credit Cards
INSERT INTO CreditCard (CustomerID, CardNumber, CardHolderName, ExpirationDate, CVV)
VALUES
(1, '1234567812345678', 'John Doe', '2025-12-01', '123'),
(2, '8765432187654321', 'Jane Smith', '2026-06-01', '456'),
(3, '9876543298765432', 'Alice Johnson', '2024-09-01', '789');
