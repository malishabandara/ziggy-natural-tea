<?php
// Table creation for collection_cards
/*
CREATE TABLE IF NOT EXISTS collection_cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255),
    image_path VARCHAR(255) NOT NULL,
    link VARCHAR(255) DEFAULT 'products',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
*/

require_once 'config.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS collection_cards (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        subtitle VARCHAR(255),
        image_path VARCHAR(255) NOT NULL,
        link VARCHAR(255) DEFAULT 'products',
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'collection_cards' created successfully.<br>";

    // Insert Default Data if empty
    $check = $pdo->query("SELECT COUNT(*) FROM collection_cards")->fetchColumn();
    if ($check == 0) {
        $stmt = $pdo->prepare("INSERT INTO collection_cards (title, subtitle, image_path, link, sort_order) VALUES (?, ?, ?, ?, ?)");
        
        $defaults = [
            ['Premium Tea', 'Pure Ceylon Black, Green & Herbal Teas', 'assets/4.png', 'products', 1],
            ['Artisan Coffee', 'Rich Arabica & Robusta Blends', 'assets/6.png', 'products', 2],
            ['Gifts & Spices', 'Curated Sets & Authentic Spices', 'assets/5.png', 'products', 3]
        ];

        foreach ($defaults as $row) {
            $stmt->execute($row);
        }
        echo "Default collection cards inserted.<br>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
