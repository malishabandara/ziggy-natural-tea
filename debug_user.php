<?php
require_once 'config.php';

echo "Checking database connection...\n";
try {
    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = 'admin'");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "User 'admin' found.\n";
        echo "Stored Hash: " . $user['password'] . "\n";
        
        $inputPassword = 'password123';
        if (password_verify($inputPassword, $user['password'])) {
            echo "SUCCESS: Password 'password123' matches the stored hash.\n";
        } else {
            echo "FAILURE: Password 'password123' DOES NOT match the stored hash.\n";
            echo "Generating new hash for 'password123'...\n";
            $newHash = password_hash($inputPassword, PASSWORD_DEFAULT);
            echo "New Hash: " . $newHash . "\n";
            
            // Auto-fix? Maybe not yet, let's just inform.
        }
    } else {
        echo "User 'admin' NOT FOUND in database.\n";
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
}
?>
