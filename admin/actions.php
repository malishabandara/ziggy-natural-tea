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
    $categoryId = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'] ?? 0;
    $order = $_POST['sort_order'] ?? 0;
    $description = $_POST['description'];


    // Image Upload
    // Image Uploads
    $imagePaths = ['image' => '', 'image2' => '', 'image3' => ''];
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $targetDir = __DIR__ . "/../assets/uploads/";

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    foreach (['image', 'image2', 'image3'] as $imgKey) {
        if (isset($_FILES[$imgKey]) && $_FILES[$imgKey]['error'] === 0) {
            $fileName = time() . "_" . $imgKey . "_" . basename($_FILES[$imgKey]["name"]);
            $targetFile = $targetDir . $fileName;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES[$imgKey]["tmp_name"], $targetFile)) {
                    $imagePaths[$imgKey] = 'assets/uploads/' . $fileName;
                }
            }
        }
    }

    $stmt = $pdo->prepare("INSERT INTO products (name, category_id, price, stock, sort_order, description, image, image2, image3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $categoryId, $price, $stock, $order, $description, $imagePaths['image'], $imagePaths['image2'], $imagePaths['image3']]);
    $newProductId = $pdo->lastInsertId();

    // Handle Variations
    if (isset($_POST['variations_json']) && !empty($_POST['variations_json'])) {
        $variations = json_decode($_POST['variations_json'], true);
        if (json_last_error() === JSON_ERROR_NONE && !empty($variations)) {
            $vStmt = $pdo->prepare("INSERT INTO product_variations (product_id, weight, price, stock) VALUES (?, ?, ?, ?)");
            foreach ($variations as $v) {
                $vStmt->execute([$newProductId, $v['weight'], $v['price'], $v['stock']]);
            }
        }
    }

    header("Location: dashboard?msg=Product added");
    exit;
}

if ($action === 'update_product') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $categoryId = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'] ?? 0; // Add stock
    $order = $_POST['sort_order'] ?? 0;
    $description = $_POST['description'];

    $sql = "UPDATE products SET name = ?, category_id = ?, price = ?, stock = ?, sort_order = ?, description = ?";
    $params = [$name, $categoryId, $price, $stock, $order, $description];


    // Check if new image uploaded
    // Image Uploads Update
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $targetDir = __DIR__ . "/../assets/uploads/";

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    foreach (['image', 'image2', 'image3'] as $imgKey) {
        $shouldRemove = isset($_POST['remove_' . $imgKey]) && $_POST['remove_' . $imgKey] == '1';
        $newFileUploaded = isset($_FILES[$imgKey]) && $_FILES[$imgKey]['error'] === 0;

        if ($shouldRemove && !$newFileUploaded) {
            // Fetch existing image to delete file
            $stmt = $pdo->prepare("SELECT $imgKey FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $currentImg = $stmt->fetchColumn();
            
            if ($currentImg && file_exists("../" . $currentImg)) {
                 if (strpos($currentImg, 'assets/uploads/') !== false) {
                    unlink("../" . $currentImg);
                 }
            }

            $sql .= ", $imgKey = NULL";
        }
        
        if ($newFileUploaded) {
            $fileName = time() . "_" . $imgKey . "_" . basename($_FILES[$imgKey]["name"]);
            $targetFile = $targetDir . $fileName;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (in_array($imageFileType, $allowedTypes)) {
                // If replacing, maybe delete old one? Optional but good practice.
                // For now, let's just upload new one.
                if (move_uploaded_file($_FILES[$imgKey]["tmp_name"], $targetFile)) {
                    $sql .= ", $imgKey = ?";
                    $params[] = 'assets/uploads/' . $fileName;
                }
            }
        }
    }

    $sql .= " WHERE id = ?";
    $params[] = $id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Handle Variations (Easy way: Delete all for this product and re-insert)
    if (isset($_POST['variations_json'])) {
        // First delete existing
        $pdo->prepare("DELETE FROM product_variations WHERE product_id = ?")->execute([$id]);
        
        $variations = json_decode($_POST['variations_json'], true);
        if (json_last_error() === JSON_ERROR_NONE && !empty($variations)) {
            $vStmt = $pdo->prepare("INSERT INTO product_variations (product_id, weight, price, stock) VALUES (?, ?, ?, ?)");
            foreach ($variations as $v) {
                $vStmt->execute([$id, $v['weight'], $v['price'], $v['stock']]);
            }
        }
    }

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
}if ($action === 'get_variations') {
    $id = $_GET['id'] ?? 0;
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM product_variations WHERE product_id = ?");
        $stmt->execute([$id]);
        $rows = $stmt->fetchAll();
        echo json_encode($rows);
    } else {
        echo json_encode([]);
    }
    exit;
}
// Category Management
if ($action === 'add_category') {
    $name = trim($_POST['name'] ?? '');
    $order = $_POST['sort_order'] ?? 0;
    
    if (!empty($name)) {
        // Check duplicate
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE name = ?");
        $stmt->execute([$name]);
        if ($stmt->fetchColumn() > 0) {
            header("Location: categories.php?msg=Category already exists");
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO categories (name, sort_order) VALUES (?, ?)");
        $stmt->execute([$name, $order]);
        header("Location: categories.php?msg=Category added successfully");
    } else {
        header("Location: categories.php?msg=Category name is required");
    }
    exit;
}

if ($action === 'update_category') {
    $id = $_POST['id'];
    $name = trim($_POST['name'] ?? '');
    $order = $_POST['sort_order'] ?? 0;

    if (!empty($name)) {
        // Check duplicate excluding self
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE name = ? AND id != ?");
        $stmt->execute([$name, $id]);
        if ($stmt->fetchColumn() > 0) {
            header("Location: categories.php?error=Category name already exists");
            exit;
        }

        $stmt = $pdo->prepare("UPDATE categories SET name = ?, sort_order = ? WHERE id = ?");
        $stmt->execute([$name, $order, $id]);
        header("Location: categories.php?msg=Category updated successfully");
    }
    exit;
}

if ($action === 'delete_category') {
    $id = $_GET['id'] ?? 0;
    
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: categories.php?msg=Category deleted");
    }
    exit;
}

?>