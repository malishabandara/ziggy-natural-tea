<?php
require_once 'config.php';

try {
    // Create categories table
    $sql = "CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Categories table created successfully.<br>";

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
        echo "Initial categories seeded.<br>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
