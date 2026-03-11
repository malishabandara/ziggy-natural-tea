-- Create the collection_cards table
CREATE TABLE IF NOT EXISTS collection_cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255),
    image_path VARCHAR(255) NOT NULL,
    link VARCHAR(255) DEFAULT 'products',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default data
INSERT INTO collection_cards (title, subtitle, image_path, link, sort_order) VALUES 
('Premium Tea', 'Pure Ceylon Black, Green & Herbal Teas', 'assets/4.png', 'products', 1),
('Artisan Coffee', 'Rich Arabica & Robusta Blends', 'assets/6.png', 'products', 2),
('Gifts & Spices', 'Curated Sets & Authentic Spices', 'assets/5.png', 'products', 3);
