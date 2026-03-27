<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $user_type = isset($_POST['user_type']) ? trim($_POST['user_type']) : '';
    $location = isset($_POST['location']) ? trim($_POST['location']) : '';
    $country = isset($_POST['country']) ? trim($_POST['country']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $comments = isset($_POST['comments']) ? trim($_POST['comments']) : '';
    
    if (empty($name) || empty($phone) || $product_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
        exit;
    }

    try {
        // Fetch product name for email
        $stmt = $pdo->prepare("SELECT name FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Product not found.']);
            exit;
        }

        // Insert into product_inquiries table (assuming the user will run the SQL)
        $stmt = $pdo->prepare("INSERT INTO product_inquiries (product_id, user_type, location, country, name, phone, email, comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$product_id, $user_type, $location, $country, $name, $phone, $email, $comments]);
        $inquiry_id = $pdo->lastInsertId();

        // Send Email to Admin
        $to = "info@ziggynaturalceylon.com";
        $subject = "New Product Inquiry Recieved - #" . $inquiry_id;
        
        $message = "You have received a new product inquiry.\n\n";
        $message .= "Inquiry ID: #" . $inquiry_id . "\n";
        $message .= "Product: " . $product['name'] . "\n";
        $message .= "Customer: " . $name . "\n";
        $message .= "User Type: " . $user_type . "\n";
        $message .= "Location: " . $location . ($location == 'Overseas' ? " ($country)" : "") . "\n";
        $message .= "Phone: " . $phone . "\n";
        $message .= "Email: " . $email . "\n";
        $message .= "Comments: " . $comments . "\n\n";
        $message .= "Date: " . date("Y-m-d H:i:s") . "\n";

        $headers = "From: webmaster@ziggynaturalceylon.com\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        @mail($to, $subject, $message, $headers);

        echo json_encode(['success' => true, 'message' => 'Your inquiry has been sent successfully! We will contact you soon.']);
        exit;

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}
