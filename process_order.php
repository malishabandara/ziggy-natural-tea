<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $payment_method = $_POST['payment_method'] ?? 'cod';
    $cart_json = $_POST['cart_data'] ?? '[]';
    
    $cart_items = json_decode($cart_json, true);
    
    if (empty($name) || empty($phone) || empty($address) || empty($cart_items)) {
        die("Invalid request. Please fill all fields.");
    }

    $total_amount = 0;
    foreach ($cart_items as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    // Handle Receipt Upload
    $receipt_path = null;
    if ($payment_method === 'bank_transfer') {
        if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === 0) {
            $targetDir = "assets/uploads/receipts/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $fileName = time() . "_" . basename($_FILES["receipt"]["name"]);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES["receipt"]["tmp_name"], $targetFile)) {
                $receipt_path = $targetFile;
            }
        }
    }

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_phone, customer_address, payment_method, receipt_image, total_amount) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $phone, $address, $payment_method, $receipt_path, $total_amount]);
        $order_id = $pdo->lastInsertId();

        $stmtItems = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($cart_items as $item) {
            $stmtItems->execute([$order_id, $item['id'], $item['name'], $item['quantity'], $item['price']]);
        }

        $pdo->commit();
        
        // Redirect to success page (or back to home with msg)
        // Clear cart via JS on the success page
        header("Location: order_success?id=$order_id");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Order failed: " . $e->getMessage());
    }
}
?>
