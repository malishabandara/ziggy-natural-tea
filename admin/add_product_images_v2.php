<?php
// Database credentials
$host = '127.0.0.1';
$dbname = 'ziggy_natural';
$username = 'root'; // Default XAMPP user
$password = '';     // Default XAMPP password is empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

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
