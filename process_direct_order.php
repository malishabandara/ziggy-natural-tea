<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    if (empty($name) || empty($phone) || empty($address) || $product_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
        exit;
    }

    try {
        // Fetch product details for the order
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Product not found.']);
            exit;
        }

        $price = $product['price'];
        $total_amount = $price * $quantity;

        $pdo->beginTransaction();

        // Insert into orders table
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_phone, customer_address, payment_method, total_amount) VALUES (?, ?, ?, 'cod', ?)");
        $stmt->execute([$name, $phone, $address, $total_amount]);
        $order_id = $pdo->lastInsertId();

        // Insert into order_items table
        $stmtItems = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
        $stmtItems->execute([$order_id, $product_id, $product['name'], $quantity, $price]);

        $pdo->commit();

        // Send Email
        $to = "info@ziggynaturalceylon.com";
        $subject = "New Order Recieved - #" . $order_id;
        
        $message = "You have received a new order.\n\n";
        $message .= "Order ID: #" . $order_id . "\n";
        $message .= "Customer: " . $name . "\n";
        $message .= "Phone: " . $phone . "\n";
        $message .= "Address: " . $address . "\n\n";
        $message .= "Product: " . $product['name'] . "\n";
        $message .= "Quantity: " . $quantity . "\n";
        $message .= "Price per unit: LKR " . number_format($price, 2) . "\n";
        $message .= "Total Amount: LKR " . number_format($total_amount, 2) . "\n\n";
        $message .= "View order in dashboard: https://" . $_SERVER['HTTP_HOST'] . "/admin/orders.php\n";

        $headers = "From: webmaster@ziggynaturalceylon.com\r\n";
        $headers .= "Reply-To: " . $phone . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        @mail($to, $subject, $message, $headers);

        echo json_encode(['success' => true, 'message' => 'Order placed successfully!', 'order_id' => $order_id]);
        exit;

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo json_encode(['success' => false, 'message' => 'Order failed: ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}
