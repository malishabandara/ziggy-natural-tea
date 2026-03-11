-- 1. Add category_id column to products table
ALTER TABLE products ADD COLUMN category_id INT;

-- 2. Update category_id based on matches with category names
-- This ensures existing products get linked to the new categories table
UPDATE products p
JOIN categories c ON p.category = c.name
SET p.category_id = c.id;

-- 3. Add Foreign Key constraints
ALTER TABLE products 
ADD CONSTRAINT fk_products_category 
FOREIGN KEY (category_id) REFERENCES categories(id) 
ON DELETE SET NULL;

-- 4. (Optional) You can verify the link with:
-- SELECT p.name, p.category, c.name as cat_linked FROM products p LEFT JOIN categories c ON p.category_id = c.id;
