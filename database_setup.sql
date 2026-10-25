-- =============================================
-- EventEase Database Setup
-- =============================================
-- Run this file in phpMyAdmin or MySQL CLI
-- =============================================

-- Create database
CREATE DATABASE IF NOT EXISTS EventEase CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE EventEase;

-- =============================================
-- Create Users Table
-- =============================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Create Events Table
-- =============================================
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    capacity INT NOT NULL,
    organizer VARCHAR(100) NOT NULL,
    image VARCHAR(255) DEFAULT 'default-event.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_event_date (event_date),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Create Registrations Table
-- =============================================
CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    UNIQUE KEY unique_registration (user_id, event_id),
    INDEX idx_user_id (user_id),
    INDEX idx_event_id (event_id),
    INDEX idx_registration_date (registration_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Create Admins Table
-- =============================================
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Insert Default Admin Account
-- =============================================
-- Username: admin
-- Password: admin123
-- Note: Change this password after first login!
INSERT INTO admins (username, password, email) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@eventease.com')
ON DUPLICATE KEY UPDATE username = username;

-- =============================================
-- Insert Sample Events (Optional)
-- =============================================
INSERT INTO events (title, description, event_date, event_time, location, capacity, organizer, image) VALUES
('Web Development Workshop', 'Learn the basics of HTML, CSS, and JavaScript in this comprehensive workshop. Perfect for beginners who want to start their web development journey.', '2025-12-15', '10:00:00', 'Tech Hub, Building A, Room 301', 50, 'Tech Academy', 'default-event.jpg'),
('Annual Tech Conference 2025', 'Join industry leaders and innovators for a day of networking, learning, and inspiration. Keynote speeches, panel discussions, and hands-on workshops.', '2025-12-20', '09:00:00', 'Convention Center, Downtown', 500, 'TechCorp International', 'default-event.jpg'),
('Digital Marketing Masterclass', 'Master the art of digital marketing with expert guidance. Learn SEO, social media marketing, content strategy, and analytics.', '2025-12-18', '14:00:00', 'Business Center, 5th Floor', 30, 'Marketing Pros', 'default-event.jpg'),
('Mobile App Development Bootcamp', 'Intensive 3-day bootcamp covering iOS and Android app development. Build real-world applications with React Native.', '2025-12-22', '09:00:00', 'Innovation Lab, Tech Park', 25, 'CodeCamp Institute', 'default-event.jpg'),
('Networking Mixer for Professionals', 'Connect with like-minded professionals across various industries. Casual networking event with refreshments and entertainment.', '2025-12-10', '18:00:00', 'Skyline Lounge, 20th Floor', 100, 'Professional Network Group', 'default-event.jpg')
ON DUPLICATE KEY UPDATE id = id;

-- =============================================
-- Verification Queries
-- =============================================
-- Uncomment these to verify the setup:
-- SELECT 'Users Table' as Table_Name, COUNT(*) as Record_Count FROM users;
-- SELECT 'Events Table' as Table_Name, COUNT(*) as Record_Count FROM events;
-- SELECT 'Registrations Table' as Table_Name, COUNT(*) as Record_Count FROM registrations;
-- SELECT 'Admins Table' as Table_Name, COUNT(*) as Record_Count FROM admins;

-- =============================================
-- Setup Complete!
-- =============================================
-- Default Admin Credentials:
-- Username: admin
-- Password: admin123
--
-- Access the website at: http://localhost/EventEase/
-- Access admin panel at: http://localhost/EventEase/admin/login.php
-- =============================================
