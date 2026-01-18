<?php
session_start();
require_once '../config.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'login') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        header("Location: dashboard.php");
    } else {
        header("Location: login.php?error=Invalid credentials");
    }
    exit;
}

if ($action === 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Handle contact form submission (no auth required)
if ($action === 'submit_contact') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    
    if ($name && $email && $message) {
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);
        header("Location: ../contact.php?msg=Thank you! Your message has been sent successfully.");
    } else {
        header("Location: ../contact.php?msg=Please fill in all fields.");
    }
    exit;
}

// Check auth for other actions
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

if ($action === 'add_product') {
    $name = $_POST['name'];
    $category = $_POST['category']; // Add category
    $price = $_POST['price'];
    $stock = $_POST['stock'] ?? 0; // Add stock
    $description = $_POST['description'];
    
    
    // Image Upload
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "../assets/uploads/";
        
        // Create directory if it doesn't exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;
        
        // Check file type
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $imagePath = 'assets/uploads/' . $fileName;
            }
        }
    }

    $stmt = $pdo->prepare("INSERT INTO products (name, category, price, stock, description, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $category, $price, $stock, $description, $imagePath]);
    
    header("Location: dashboard.php?msg=Product added");
    exit;
}

if ($action === 'update_product') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category']; // Add category
    $price = $_POST['price'];
    $stock = $_POST['stock'] ?? 0; // Add stock
    $description = $_POST['description'];
    
    $sql = "UPDATE products SET name = ?, category = ?, price = ?, stock = ?, description = ?";
    $params = [$name, $category, $price, $stock, $description];


    // Check if new image uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "../assets/uploads/";
        
        // Create directory if it doesn't exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;
        
        // Check file type
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $sql .= ", image = ?";
                $params[] = 'assets/uploads/' . $fileName;
            }
        }
    }
    
    $sql .= " WHERE id = ?";
    $params[] = $id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    header("Location: dashboard.php?msg=Product updated");
    exit;
}

if ($action === 'delete_product') {
    $id = $_GET['id'];
    
    // Optional: Delete image file
    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    if ($product && $product['image'] && file_exists("../" . $product['image'])) {
        unlink("../" . $product['image']);
    }

    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: dashboard.php?msg=Product deleted");
    exit;
}
?>
