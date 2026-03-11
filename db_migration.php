<?php
require_once 'config.php';

try {
    $sql = "ALTER TABLE products ADD COLUMN image2 VARCHAR(255) DEFAULT NULL, ADD COLUMN image3 VARCHAR(255) DEFAULT NULL";
    $pdo->exec($sql);
    echo "<h1>Migration Successful!</h1><p>Columns image2 and image3 added to products table.</p>";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
       echo "<h1>Migration Already Done</h1><p>Columns already exist.</p>";
    } else {
       echo "<h1>Migration Failed</h1><p>Error: " . $e->getMessage() . "</p>";
    }
}
?>
