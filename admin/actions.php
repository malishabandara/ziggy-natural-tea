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

// Check auth for other actions
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

if ($action === 'add_product') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    // Image Upload
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "../assets/uploads/";
        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = 'assets/uploads/' . $fileName;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $price, $description, $imagePath]);
    
    header("Location: dashboard.php?msg=Product added");
    exit;
}

if ($action === 'update_product') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    $sql = "UPDATE products SET name = ?, price = ?, description = ?";
    $params = [$name, $price, $description];

    // Check if new image uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "../assets/uploads/";
        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $sql .= ", image = ?";
            $params[] = 'assets/uploads/' . $fileName;
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
