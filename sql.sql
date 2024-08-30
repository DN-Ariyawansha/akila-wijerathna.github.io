CREATE DATABASE akila_sir;

USE akila_sir;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    mobile_number VARCHAR(15),
    school VARCHAR(100),
    address TEXT,
    password VARCHAR(255)
);

CREATE TABLE pdf_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    file_path TEXT NOT NULL
);

CREATE TABLE class_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    time TIME NOT NULL,
    class_link VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL
);







-- Database: akila_sir
CREATE DATABASE IF NOT EXISTS akila_sir;
USE akila_sir;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    mobile_number VARCHAR(20) NOT NULL,
    school VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    password VARCHAR(255) NOT NULL
    session_id VARCHAR(255) DEFAULT NULL;

);

-- PDF Files table
CREATE TABLE IF NOT EXISTS pdf_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    url TEXT NOT NULL
);

-- Class Links table
CREATE TABLE IF NOT EXISTS class_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    time TIME NOT NULL,
    class_link TEXT NOT NULL,
    title VARCHAR(255) NOT NULL
);

