CREATE TABLE `Customers` (
    `CustomerID` INT PRIMARY KEY AUTO_INCREMENT,
    `FirstName` VARCHAR(50) NOT NULL,
    `LastName` VARCHAR(50) NOT NULL,
    `Email` VARCHAR(100) NOT NULL,
    `PhoneNumber` VARCHAR(20) NOT NULL,
    `Password` VARCHAR(100) NOT NULL,
    `Address` VARCHAR(255),
    `City` VARCHAR(50),
    `State` VARCHAR(50),
    `ZipCode` VARCHAR(10),
    `Country` VARCHAR(50),
    `Image` VARCHAR(200),
    `RegistrationDate` DATE NOT NULL,
    `LastLogin` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `Accounts` (
    `AccountID` INT PRIMARY KEY AUTO_INCREMENT,
    `CustomerID` INT NOT NULL,
    `AccountType` ENUM('Checking', 'Savings') NOT NULL,
    `Balance` DECIMAL(10, 2) DEFAULT 0,
    FOREIGN KEY (`CustomerID`) REFERENCES `Customers`(`CustomerID`) ON DELETE CASCADE
);

CREATE TABLE `Transactions` (
    `TransactionID` INT PRIMARY KEY AUTO_INCREMENT,
    `AccountID` INT NOT NULL,
    `TransactionType` ENUM('Deposit', 'Withdrawal', 'Transfer') NOT NULL,
    `Amount` DECIMAL(10, 2) NOT NULL,
    `TransactionDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`AccountID`) REFERENCES `Accounts`(`AccountID`) ON DELETE CASCADE
);

CREATE TABLE `Transfers` (
    `TransferID` INT PRIMARY KEY AUTO_INCREMENT,
    `SenderAccountID` INT NOT NULL,
    `RecipientAccountID` INT NOT NULL,
    `Amount` DECIMAL(10, 2) NOT NULL,
    `TransferDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`SenderAccountID`) REFERENCES `Accounts`(`AccountID`) ON DELETE CASCADE,
    FOREIGN KEY (`RecipientAccountID`) REFERENCES `Accounts`(`AccountID`) ON DELETE CASCADE
);

CREATE TABLE `CreditCards` (
    `CreditCardID` INT PRIMARY KEY AUTO_INCREMENT,
    `CustomerID` INT NOT NULL,
    `CardNumber` VARCHAR(20) NOT NULL,
    `CardHolderName` VARCHAR(100) NOT NULL,
    `ExpirationDate` DATE NOT NULL,
    `CVV` VARCHAR(4) NOT NULL,
    `CreationDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`CustomerID`) REFERENCES `Customers`(`CustomerID`) ON DELETE CASCADE
);

-- Inserting fake data into Customers table
INSERT INTO Customers (FirstName, LastName, Email, PhoneNumber, Password, Address, City, State, ZipCode, Country, Image, RegistrationDate)
VALUES 
    ('John', 'Doe', 'john.doe@example.com', '77470000000', '$2y$10$iwVJovXdgi1Ggc3Y80y/Z.LQa13pP6y.lgoxTDQP50CAfcSg.QRGG', '123 Main St', 'Anytown', 'CA', '12345', 'USA', 'john_doe.jpg', '2023-01-15'),
    ('Jane', 'Smith', 'jane.smith@example.com', '9876543210', 'password456', '456 Oak Ave', 'Otherville', 'NY', '54321', 'USA', 'jane_smith.jpg', '2023-02-20'),
    ('Michael', 'Johnson', 'michael.johnson@example.com', '5551234567', 'password789', '789 Elm St', 'Sometown', 'TX', '67890', 'USA', 'michael_johnson.jpg', '2023-03-10');

-- Inserting fake data into Accounts table
INSERT INTO Accounts (CustomerID, AccountType, Balance)
VALUES 
    (1, 'Checking', 1500.00),
    (1, 'Savings', 5000.00),
    (2, 'Checking', 2500.00),
    (3, 'Checking', 10000.00),
    (3, 'Savings', 20000.00);

-- Inserting fake data into Transactions table
INSERT INTO Transactions (AccountID, TransactionType, Amount, TransactionDate)
VALUES 
    (1, 'Deposit', 500.00, '2023-01-16 09:30:00'),
    (2, 'Deposit', 1000.00, '2023-01-17 10:45:00'),
    (3, 'Withdrawal', 200.00, '2023-02-25 14:20:00'),
    (4, 'Deposit', 5000.00, '2023-03-05 16:00:00'),
    (5, 'Withdrawal', 1000.00, '2023-03-15 11:10:00');

-- Inserting fake data into Transfers table
INSERT INTO Transfers (SenderAccountID, RecipientAccountID, Amount, TransferDate)
VALUES 
    (1, 2, 200.00, '2023-01-20 15:00:00'),
    (3, 5, 500.00, '2023-02-28 12:30:00'),
    (4, 2, 1000.00, '2023-03-08 09:45:00');

-- Inserting fake data into CreditCards table
INSERT INTO CreditCards (CustomerID, CardNumber, CardHolderName, ExpirationDate, CVV)
VALUES 
    (1, '1234567890123456', 'John Doe', '2025-05-31', '123'),
    (2, '9876543210987654', 'Jane Smith', '2024-12-31', '456'),
    (3, '5555555555555555', 'Michael Johnson', '2023-09-30', '789');
