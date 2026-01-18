<?php
require_once 'config.php';

try {
    $newPassword = 'password123';
    $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = 'admin'");
    $stmt->execute([$newHash]);
    
    echo "Password updated successfully for user 'admin' to '$newPassword'.\n";
    echo "New Hash: $newHash\n";
    
} catch (PDOException $e) {
    echo "Error updating password: " . $e->getMessage() . "\n";
}
?>
