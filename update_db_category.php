<?php
require_once 'config.php';

try {
    $sql = "ALTER TABLE products ADD COLUMN category VARCHAR(50) NOT NULL DEFAULT 'Ceylon Tea Collection'";
    $pdo->exec($sql);
    echo "Successfully added 'category' column to 'products' table.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "Duplicate column") !== false) {
         echo "Column 'category' already exists.\n";
    } else {
        echo "Error updating database: " . $e->getMessage() . "\n";
    }
}
?>
