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
        header("Location: dashboard");
    } else {
        header("Location: login?error=Invalid credentials");
    }
    exit;
}

if ($action === 'logout') {
    session_destroy();
    header("Location: login");
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
        header("Location: ../contact?msg=Thank you! Your message has been sent successfully.");
    } else {
        header("Location: ../contact?msg=Please fill in all fields.");
    }
    exit;
}

// Check auth for other actions
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login");
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
        // Use absolute path for reliability or relative to this script
        $targetDir = __DIR__ . "/../assets/uploads/";

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
    } else {
        // Log error if upload failed but was attempted
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== 4) { // 4 is "no file uploaded"
             $error = $_FILES['image']['error'];
             header("Location: dashboard?msg=Image upload failed: Error code $error");
             exit;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO products (name, category, price, stock, description, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $category, $price, $stock, $description, $imagePath]);

    header("Location: dashboard?msg=Product added");
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
        $targetDir = __DIR__ . "/../assets/uploads/";

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
    header("Location: dashboard?msg=Product updated");
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
    header("Location: dashboard?msg=Product deleted");
    exit;
}

if ($action === 'add_slide') {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];
    $order_index = $_POST['order_index'] ?? 0;

    // Image Upload
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = __DIR__ . "/../assets/uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_slide_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $imagePath = 'assets/uploads/' . $fileName;
            }
        }
    }

    if (empty($imagePath)) {
         header("Location: slider.php?msg=Image is required for new slide");
         exit;
    }

    $stmt = $pdo->prepare("INSERT INTO hero_slides (image_path, subtitle, title, description, button_text, button_link, order_index) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$imagePath, $subtitle, $title, $description, $button_text, $button_link, $order_index]);

    header("Location: slider.php?msg=Slide added");
    exit;
}

if ($action === 'update_slide') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];
    $order_index = $_POST['order_index'];

    $sql = "UPDATE hero_slides SET title = ?, subtitle = ?, description = ?, button_text = ?, button_link = ?, order_index = ?";
    $params = [$title, $subtitle, $description, $button_text, $button_link, $order_index];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = __DIR__ . "/../assets/uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_slide_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $sql .= ", image_path = ?";
                $params[] = 'assets/uploads/' . $fileName;
            }
        }
    }

    $sql .= " WHERE id = ?";
    $params[] = $id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    header("Location: slider.php?msg=Slide updated");
    exit;
}

if ($action === 'delete_slide') {
    $id = $_GET['id'];
    
    // Delete image file
    $stmt = $pdo->prepare("SELECT image_path FROM hero_slides WHERE id = ?");
    $stmt->execute([$id]);
    $slide = $stmt->fetch();
    if ($slide && $slide['image_path'] && file_exists("../" . $slide['image_path'])) {
        // Only delete if it's in uploads, not if it's a default asset (security precaution though all new ones are in uploads)
        if (strpos($slide['image_path'], 'assets/uploads/') !== false) {
             unlink("../" . $slide['image_path']);
        }
    }

    $stmt = $pdo->prepare("DELETE FROM hero_slides WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: slider.php?msg=Slide deleted");
    exit;
}

if ($action === 'get_order_details') {
    $id = $_GET['id'];
    
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        echo json_encode(['error' => 'Order not found']);
        exit;
    }
    
    $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->execute([$id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'order' => $order,
        'items' => $items
    ]);
    exit;
}

if ($action === 'update_order_status') {
    $id = $_POST['order_id'];
    $status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    
    header("Location: orders.php?msg=Order updated to " . ucfirst($status));
    exit;
}
?>