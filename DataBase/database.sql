CREATE DATABASE hospital_management;

USE hospital_management;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'receptionist', 'doctor') DEFAULT 'receptionist',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);