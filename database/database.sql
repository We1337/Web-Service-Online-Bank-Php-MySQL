CREATE TABLE `admins` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(255) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL
);

INSERT INTO `admins` (`username`, `password`) VALUES
('admin', '$2y$10$IxubwZ/o8gr49hROC7gYiemGQx2orUac3BRb6kxphiUvf3kyoi3eO');
