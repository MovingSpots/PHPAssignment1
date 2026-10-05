-- ASSIGNMENT 2 UPGRADE
-- Use this script when the Assignment 1 community_programs database already exists.
-- Import it ONE TIME in phpMyAdmin. It keeps all existing program records.

USE community_programs;

CREATE TABLE categories (
    category_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    category_name VARCHAR(60) NOT NULL,
    PRIMARY KEY (category_id),
    UNIQUE KEY uq_category_name (category_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copy every existing category value into the new related table.
INSERT IGNORE INTO categories (category_name)
SELECT DISTINCT category
FROM programs
WHERE category IS NOT NULL AND TRIM(category) <> '';

ALTER TABLE programs
    ADD COLUMN category_id INT UNSIGNED NULL AFTER program_name,
    ADD COLUMN image_filename VARCHAR(255) NULL AFTER description;

UPDATE programs AS p
INNER JOIN categories AS c ON c.category_name = p.category
SET p.category_id = c.category_id;

ALTER TABLE programs
    MODIFY category_id INT UNSIGNED NOT NULL,
    ADD INDEX idx_program_category (category_id),
    ADD CONSTRAINT fk_program_category
        FOREIGN KEY (category_id) REFERENCES categories(category_id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    DROP COLUMN category;

-- Optional extra categories for future records.
INSERT IGNORE INTO categories (category_name)
VALUES ('Fitness'), ('Music'), ('Technology'), ('Volunteering');
