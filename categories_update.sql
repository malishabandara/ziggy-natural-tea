-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed initial categories (ignore if they exist to prevent errors or duplication)
INSERT IGNORE INTO categories (name) VALUES 
('Ceylon Tea Collection'),
('Ceylon Coffee Collection'),
('Gift Collection');
