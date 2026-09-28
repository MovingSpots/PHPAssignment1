-- Import this file from phpMyAdmin to create the database and sample rows.
CREATE DATABASE IF NOT EXISTS community_programs
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE community_programs;

CREATE TABLE IF NOT EXISTS programs (
    program_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    program_name VARCHAR(100) NOT NULL,
    category VARCHAR(60) NOT NULL,
    location VARCHAR(120) NOT NULL,
    schedule VARCHAR(100) NOT NULL,
    contact_email VARCHAR(160) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (program_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Fixed sample IDs make importing this file again safe: existing rows are kept.
INSERT IGNORE INTO programs
    (program_id, program_name, category, location, schedule, contact_email, description)
VALUES
    (1, 'Beginner Painting Circle', 'Arts', 'Maple Community Hall', 'Mondays, 6:00 PM', 'painting@example.com', 'Practice simple painting techniques with friendly neighbours.'),
    (2, 'Weekend Photography Walk', 'Arts', 'Riverside Park Gate', 'Saturdays, 9:00 AM', 'photos@example.com', 'Explore light and composition on an easy outdoor walk.'),
    (3, 'Community Garden Club', 'Outdoors', 'Green Lane Garden', 'Wednesdays, 5:30 PM', 'garden@example.com', 'Learn to plant and care for vegetables in a shared garden.'),
    (4, 'Nature Discovery Walk', 'Outdoors', 'Cedar Trail Entrance', 'Sundays, 10:00 AM', 'nature@example.com', 'Discover local plants and wildlife with a volunteer guide.'),
    (5, 'Family Cooking Workshop', 'Food', 'Oak Street Kitchen', 'Thursdays, 6:30 PM', 'cooking@example.com', 'Make a simple meal together and learn kitchen safety basics.'),
    (6, 'Community Bread Basics', 'Food', 'Oak Street Kitchen', 'Tuesdays, 5:00 PM', 'bread@example.com', 'Try an introductory class in mixing and baking bread.'),
    (7, 'Digital Skills Hour', 'Learning', 'Central Learning Room', 'Fridays, 3:00 PM', 'digital@example.com', 'Build confidence using email, web browsers, and everyday apps.'),
    (8, 'Conversation Café', 'Learning', 'Maple Community Hall', 'Saturdays, 11:00 AM', 'conversation@example.com', 'Practice conversation in a relaxed and welcoming group.');
