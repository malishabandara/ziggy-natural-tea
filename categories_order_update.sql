-- Add sort_order column to categories table
ALTER TABLE categories ADD COLUMN sort_order INT DEFAULT 0;

-- Update existing categories to have a default order (optional)
SET @row_number = 0;
UPDATE categories SET sort_order = (@row_number:=@row_number + 1) ORDER BY id;
