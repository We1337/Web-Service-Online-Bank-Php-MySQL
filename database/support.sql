CREATE TABLE `Workers` (
    `WorkerID` INT PRIMARY KEY AUTO_INCREMENT,
    `FirstName` VARCHAR(50) NOT NULL,
    `LastName` VARCHAR(50) NOT NULL,
    `Email` VARCHAR(100) NOT NULL,
    `Password` VARCHAR(100) NOT NULL,
    `PhoneNumber` VARCHAR(20),
    `Address` VARCHAR(255),
    `City` VARCHAR(50),
    `State` VARCHAR(50),
    `ZipCode` VARCHAR(10),
    `Country` VARCHAR(50),
    `HireDate` DATE NOT NULL,
    `Position` VARCHAR(50) NOT NULL,
    `Salary` DECIMAL(15, 2) NOT NULL,
    `SupervisorID` INT,
    FOREIGN KEY (`SupervisorID`) REFERENCES `Workers`(`WorkerID`) ON DELETE SET NULL
);

-- Insert Fake Data
INSERT INTO Workers (`FirstName`, `LastName`, `Email`, `Password`, `PhoneNumber`, `Address`, `City`, `State`, `ZipCode`, `Country`, `HireDate`, `Position`, `Salary`, `SupervisorID`)
VALUES
    ('John', 'Doe', 'john.doe@example.com', 'password123', '123-456-7890', '123 Main St', 'Cityville', 'Stateville', '12345', 'Countryland', '2022-01-01', 'Manager', 60000.00, NULL),
    ('Jane', 'Smith', 'jane.smith@example.com', 'securepass', '987-654-3210', '456 Oak St', 'Townsville', 'Stateville', '54321', 'Countryland', '2022-02-01', 'Developer', 55000.00, 1),
    ('Alice', 'Johnson', 'alice.johnson@example.com', 'pass123', '111-222-3333', '789 Maple St', 'Villageton', 'Stateland', '67890', 'Countryland', '2022-03-01', 'Analyst', 50000.00, 1),
    ('Bob', 'Miller', 'bob.miller@example.com', 'secret123', '555-444-3333', '456 Pine St', 'Cityburg', 'Stateland', '45678', 'Countryland', '2022-04-01', 'Teller', 45000.00, 2);
