<?php
require_once '../config.php';

try {
    $sql = "ALTER TABLE products ADD COLUMN image2 VARCHAR(255) DEFAULT NULL, ADD COLUMN image3 VARCHAR(255) DEFAULT NULL";
    $pdo->exec($sql);
    echo "Columns image2 and image3 added successfully.";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
       echo "Columns already exist.";
    } else {
       echo "Error: " . $e->getMessage();
    }
}
?>
