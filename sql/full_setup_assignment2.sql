-- CLEAN ASSIGNMENT 2 SETUP
-- Use only for a fresh installation or when it is acceptable to reset sample data.

CREATE DATABASE IF NOT EXISTS community_programs
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE community_programs;

DROP TABLE IF EXISTS programs;
DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
    category_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    category_name VARCHAR(60) NOT NULL,
    PRIMARY KEY (category_id),
    UNIQUE KEY uq_category_name (category_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE programs (
    program_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    program_name VARCHAR(100) NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    location VARCHAR(120) NOT NULL,
    schedule VARCHAR(100) NOT NULL,
    contact_email VARCHAR(160) NOT NULL,
    description TEXT NOT NULL,
    image_filename VARCHAR(255) NULL,
    PRIMARY KEY (program_id),
    KEY idx_program_category (category_id),
    CONSTRAINT fk_program_category
        FOREIGN KEY (category_id) REFERENCES categories(category_id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO categories (category_id, category_name) VALUES
    (1, 'Arts'), (2, 'Outdoors'), (3, 'Food'), (4, 'Learning'),
    (5, 'Fitness'), (6, 'Music'), (7, 'Technology'), (8, 'Volunteering');

INSERT INTO programs
    (program_id, program_name, category_id, location, schedule, contact_email, description, image_filename)
VALUES
    (1, 'Beginner Painting Circle', 1, 'Maple Community Hall', 'Mondays, 6:00 PM', 'painting@example.com', 'Practice simple painting techniques with friendly neighbours.', NULL),
    (2, 'Weekend Photography Walk', 1, 'Riverside Park Gate', 'Saturdays, 9:00 AM', 'photos@example.com', 'Explore light and composition on an easy outdoor walk.', NULL),
    (3, 'Community Garden Club', 2, 'Green Lane Garden', 'Wednesdays, 5:30 PM', 'garden@example.com', 'Learn to plant and care for vegetables in a shared garden.', NULL),
    (4, 'Nature Discovery Walk', 2, 'Cedar Trail Entrance', 'Sundays, 10:00 AM', 'nature@example.com', 'Discover local plants and wildlife with a volunteer guide.', NULL),
    (5, 'Family Cooking Workshop', 3, 'Oak Street Kitchen', 'Thursdays, 6:30 PM', 'cooking@example.com', 'Make a simple meal together and learn kitchen safety basics.', NULL),
    (6, 'Community Bread Basics', 3, 'Oak Street Kitchen', 'Tuesdays, 5:00 PM', 'bread@example.com', 'Try an introductory class in mixing and baking bread.', NULL),
    (7, 'Digital Skills Hour', 4, 'Central Learning Room', 'Fridays, 3:00 PM', 'digital@example.com', 'Build confidence using email, web browsers, and everyday apps.', NULL),
    (8, 'Conversation Cafe', 4, 'Maple Community Hall', 'Saturdays, 11:00 AM', 'conversation@example.com', 'Practice conversation in a relaxed and welcoming group.', NULL);
