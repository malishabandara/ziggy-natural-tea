<?php
require_once 'config.php';

try {
    // Create product_variations table
    $sql = "CREATE TABLE IF NOT EXISTS product_variations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT NOT NULL,
        weight VARCHAR(50) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        stock INT DEFAULT 0,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    )";
    $pdo->exec($sql);
    echo "Table 'product_variations' created successfully.<br>";

    // Optional: Add a 'weight' column to the main products table if we want to treat the main entry as a variant too, 
    // but better to just migrate existing data to variations if needed. 
    // For now, let's keep it simple: The `products` table stores the 'base' info.
    // Actually, to make it seamless, let's ensure existing products have at least one variation entry?
    // Or we can handle it in the code: IF variations exist, use them. ELSE use main product price.

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
