<?php
$host = '127.0.0.1';
$dbname = 'ziggy_natural';
$username = 'root'; 
$password = '';  

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
     // Create categories table
    $sql = "CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Categories table created successfully.\n";

    // Seed some initial categories if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM categories");
    if ($stmt->fetchColumn() == 0) {
        $initialCategories = [
            'Ceylon Tea Collection',
            'Ceylon Coffee Collection',
            'Gift Collection'
        ];
        
        $insertStmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        foreach ($initialCategories as $cat) {
            $insertStmt->execute([$cat]);
        }
        echo "Initial categories seeded.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
