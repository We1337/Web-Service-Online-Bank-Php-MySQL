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

INSERT INTO Customers (FirstName, LastName, Email, PhoneNumber, Password, Address, City, State, ZipCode, Country, RegistrationDate)
VALUES
('John', 'Doe', 'john.doe@email.com', '123-456-7890', 'password123', '123 Main St', 'Anytown', 'CA', '12345', 'USA', '2022-01-01'),
('Jane', 'Smith', 'jane.smith@email.com', '987-654-3210', 'securepass', '456 Oak St', 'Another City', 'NY', '54321', 'USA', '2022-02-15'),
('Bob', 'Johnson', 'bob.johnson@email.com', '555-123-4567', 'pass123', '789 Pine St', 'Somewhere', 'TX', '67890', 'USA', '2022-03-20');
