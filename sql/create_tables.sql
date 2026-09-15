-- =========================================================
-- ant_grid project - database setup
-- Run this in phpMyAdmin / MySQL CLI (user: root, pass: root)
-- =========================================================

CREATE DATABASE IF NOT EXISTS `work` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `work`;

CREATE TABLE IF NOT EXISTS `users` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `username`   VARCHAR(50)  NOT NULL UNIQUE,
    `password`   VARCHAR(255) NOT NULL,
    `email`      VARCHAR(100) DEFAULT NULL,
    `created_at` TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Note: the demo login "Erica" / "mdp" is handled as a hardcoded
-- shortcut inside controllers/AuthController.php, so she does NOT
-- need a row here. Every other user created through signin.php
-- gets inserted into this table with a properly hashed password.
