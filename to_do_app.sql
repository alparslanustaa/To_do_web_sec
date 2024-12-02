-- Database: todo_app

CREATE DATABASE IF NOT EXISTS todo_app;
USE todo_app;

-- Table structure for table `users`
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('user', 'admin') DEFAULT 'user',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table structure for table `tasks`
CREATE TABLE IF NOT EXISTS `tasks` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `description` TEXT NOT NULL,
    `is_completed` BOOLEAN DEFAULT FALSE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- Insert initial admin user
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('admin1', '$2b$12$aRAVH3pHlb3M/cajlBERreMVXcKf8jM2EtPUH4pHeBGIj/7SNanui', 'admin'); -- Password: 123

-- Example: Insert initial user (optional)
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('user1', '$2b$12$aRAVH3pHlb3M/cajlBERreMVXcKf8jM2EtPUH4pHeBGIj/7SNanui', 'user'); -- Password: 123
