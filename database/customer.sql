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

-- Fake data for Customers table
INSERT INTO `Customers` (`FirstName`, `LastName`, `Email`, `PhoneNumber`, `Password`, `Address`, `City`, `State`, `ZipCode`, `Country`, `RegistrationDate`)
VALUES
    ('John', 'Doe', 'john.doe@email.com', '123-456-7890', 'password123', '123 Main St', 'Anytown', 'CA', '12345', 'USA', '2022-01-01'),
    ('Jane', 'Smith', 'jane.smith@email.com', '987-654-3210', 'securepass', '456 Oak St', 'Another City', 'NY', '54321', 'USA', '2022-02-15'),
    ('Bob', 'Johnson', 'bob.johnson@email.com', '555-123-4567', 'pass123', '789 Pine St', 'Somewhere', 'TX', '67890', 'USA', '2022-03-20'),
    ('Alice', 'Johnson', 'alice.johnson@email.com', '111-222-3333', 'pass123', '456 Oak St', 'Cityville', 'CA', '54321', 'USA', '2022-04-10'),
    ('Charlie', 'Davis', 'charlie.davis@email.com', '444-555-6666', 'securepass', '789 Pine St', 'Townsville', 'TX', '98765', 'USA', '2022-05-15'),
    ('John', 'Doe', 'john.doe@email.com', '123-456-7890', 'password123', '123 Main St', 'Anytown', 'CA', '12345', 'USA', '2022-01-01'),
    ('Jane', 'Smith', 'jane.smith@email.com', '987-654-3210', 'securepass', '456 Oak St', 'Another City', 'NY', '54321', 'USA', '2022-02-15'),
    ('Bob', 'Johnson', 'bob.johnson@email.com', '555-123-4567', 'pass123', '789 Pine St', 'Somewhere', 'TX', '67890', 'USA', '2022-03-20'),
    ('Alice', 'Johnson', 'alice.johnson@email.com', '111-222-3333', 'pass123', '456 Oak St', 'Cityville', 'CA', '54321', 'USA', '2022-04-10'),
    ('Charlie', 'Davis', 'charlie.davis@email.com', '444-555-6666', 'securepass', '789 Pine St', 'Townsville', 'TX', '98765', 'USA', '2022-05-15');


-- Fake data for Deposit table
INSERT INTO `Deposit` (`CustomerID`, `Amount`)
VALUES
    (1, 1000.50),
    (2, 500.25),
    (3, 750.75),
    (4, 1200.75),
    (5, 800.50),
    (6, 1000.50),
    (7, 500.25),
    (8, 750.75),
    (9, 1200.75),
    (10, 800.50);

-- Fake data for Transfer table
INSERT INTO `Transfer` (`CustomerID`, `RecipientID`, `RecipientName`, `PhoneNumber`, `Amount`)
VALUES
    (1, 2, 'Jane Smith', '987-654-3210', 200.00),
    (2, 3, 'Bob Johnson', '555-123-4567', 150.50),
    (3, 1, 'John Doe', '123-456-7890', 300.25),
    (4, 1, 'John Doe', '123-456-7890', 300.00),
    (5, 2, 'Jane Smith', '987-654-3210', 150.25),
    (1, 4, 'Alice Johnson', '111-222-3333', 200.50),
    (2, 5, 'Charlie Davis', '444-555-6666', 100.75),
    (6, 1, 'Jane Smith', '987-654-3210', 200.00),
    (2, 7, 'Bob Johnson', '555-123-4567', 150.50),
    (3, 1, 'John Doe', '123-456-7890', 300.25),
    (10, 9, 'John Doe', '123-456-7890', 300.00),
    (5, 2, 'Jane Smith', '987-654-3210', 150.25),
    (9, 8, 'Alice Johnson', '111-222-3333', 200.50),
    (2, 7, 'Charlie Davis', '444-555-6666', 100.75);
