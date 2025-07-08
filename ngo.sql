
CREATE DATABASE IF NOT EXISTS ngo;
USE ngo;
CREATE TABLE IF NOT EXISTS campaigns (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  goal_amount DECIMAL(10,2),
  amount_raised DECIMAL(10,2),
  category VARCHAR(100)
);


CREATE TABLE IF NOT EXISTS `registrations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `enrollment` VARCHAR(20)NOT NULL UNIQUE,
  `name` VARCHAR(100),
  `email` VARCHAR(100) UNIQUE,
  `dob` DATE,
  `father` VARCHAR(100),
  `contact` VARCHAR(15),
  `address` TEXT,
  `motive` TEXT,
  `password` VARCHAR(255) NOT NULL
);
