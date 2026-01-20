<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login");
    exit;
}

// Fetch all products grouped by category
$stmt = $pdo->query("SELECT * FROM products ORDER BY category, created_at DESC");
$allProducts = $stmt->fetchAll();

// Group products by category
$productsByCategory = [];
foreach ($allProducts as $product) {
    $category = $product['category'] ?? 'Uncategorized';
    if (!isset($productsByCategory[$category])) {
        $productsByCategory[$category] = [];
    }
    $productsByCategory[$category][] = $product;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ziggy Natural</title>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #e67e22;
            --light: #ecf0f1;
            --dark: #34495e;
            --danger: #e74c3c;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f7;
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--primary);
            color: white;
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: sticky;
            top: 0;
            overflow-y: auto;
        }

        .sidebar h2 {
            margin-top: 0;
            font-size: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar a {
            color: #bdc3c7;
            text-decoration: none;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: 4px;
            transition: all 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: var(--dark);
            color: white;
        }

        .sidebar .logout {
            margin-top: auto;
            color: var(--danger);
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .btn {
            background-color: var(--secondary);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-danger {
            background-color: var(--danger);
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
        }

        .btn-edit {
            background-color: #3498db;
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
            margin-right: 0.5rem;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .product-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .product-img {
            height: 200px;
            width: 100%;
            object-fit: cover;
            background-color: #eee;
        }

        .product-info {
            padding: 1rem;
        }

        .product-title {
            margin: 0 0 0.5rem 0;
            font-size: 1.1rem;
            color: var(--dark);
        }

        .product-price {
            font-weight: bold;
            color: var(--secondary);
            font-size: 1.1rem;
        }

        .product-actions {
            padding: 1rem;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: inherit;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 1rem;
                box-sizing: border-box;
                height: auto;
                position: static;
            }

            .sidebar h2 {
                margin-bottom: 0;
                font-size: 1.2rem;
                border-bottom: none;
                padding-bottom: 0;
            }

            .menu-toggle {
                display: block;
                background: none;
                border: none;
                color: white;
                font-size: 1.5rem;
                cursor: pointer;
            }

            .nav-links {
                display: none;
                margin-top: 1rem;
                flex-direction: column;
                width: 100%;
            }

            .nav-links.active {
                display: flex;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .header h1 {
                margin-bottom: 0.5rem;
            }

            .main-content {
                padding: 1rem;
            }
        }

        /* Desktop styles for new structure */
        @media (min-width: 769px) {
            .menu-toggle {
                display: none;
            }

            .nav-links {
                display: flex;
                flex-direction: column;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar" id="sidebar">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <h2>Ziggy Admin</h2>
            <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
        </div>
        <div class="nav-links" id="navLinks">
            <a href="#" class="active">Products</a>
            <a href="messages">Messages</a>
            <a href="../index" target="_blank">View Site</a>
            <a href="actions.php?action=logout" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Product Management</h1>
            <button class="btn" onclick="openModal()">+ Add New Product</button>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 1rem; margin-bottom: 1rem; border-radius: 4px;">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <!-- Category Filter -->
        <div class="filter-container" style="margin-bottom: 1.5rem;">
            <label for="categoryFilter"
                style="display:block; margin-bottom:0.5rem; font-weight:600; color:var(--dark);">Select
                Category:</label>
            <select id="categoryFilter" onchange="filterCategories()"
                style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; background-color: white;">
                <option value="all">Show All Categories</option>
                <?php foreach (array_keys($productsByCategory) as $catName): ?>
                    <option value="<?php echo htmlspecialchars($catName); ?>"><?php echo htmlspecialchars($catName); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php foreach ($productsByCategory as $categoryName => $products): ?>
            <div class="category-section" data-category="<?php echo htmlspecialchars($categoryName); ?>">
                <h2
                    style="margin-top: 2rem; margin-bottom: 1rem; color: var(--dark); border-bottom: 2px solid var(--secondary); padding-bottom: 0.5rem;">
                    <?php echo htmlspecialchars($categoryName); ?> (<?php echo count($products); ?>)
                </h2>
                <div class="product-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <?php if ($product['image']): ?>
                                <img src="../<?php echo htmlspecialchars($product['image']); ?>" alt="Product" class="product-img">
                            <?php else: ?>
                                <div class="product-img" style="display:flex;align-items:center;justify-content:center;color:#999;">
                                    No Image</div>
                            <?php endif; ?>
                            <div class="product-info">
                                <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <div class="product-price">LKR <?php echo number_format($product['price'], 2); ?></div>
                                <p style="color:#666; font-size: 0.9rem; margin-top: 0.5rem;">
                                    <?php echo htmlspecialchars(substr($product['description'], 0, 50)) . '...'; ?>
                                </p>
                                <div style="margin-top: 0.5rem; font-size: 0.85rem;">
                                    <strong>Stock:</strong>
                                    <span
                                        style="color: <?php echo ($product['stock'] ?? 0) > 10 ? '#27ae60' : (($product['stock'] ?? 0) > 0 ? '#f39c12' : '#e74c3c'); ?>;">
                                        <?php echo $product['stock'] ?? 0; ?> units
                                    </span>
                                </div>
                            </div>
                            <div class="product-actions">
                                <button class="btn btn-edit"
                                    onclick="editProduct(<?php echo htmlspecialchars(json_encode($product)); ?>)">Edit</button>
                                <a href="actions.php?action=delete_product&id=<?php echo $product['id']; ?>"
                                    class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Add/Edit Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Add Product</h2>
            <form action="actions.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="formAction" value="add_product">
                <input type="hidden" name="id" id="productId">

                <div class="form-group">
                    <label>Category</label>
                    <select name="category" id="pCategory" required
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="Ceylon Tea Collection">Ceylon Tea Collection</option>
                        <option value="Ceylon Coffee Collection">Ceylon Coffee Collection</option>
                        <option value="Gift Collection">Gift Collection</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="name" id="pName" required>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" id="pPrice" required>
                </div>
                <div class="form-group">
                    <label>Stock Quantity</label>
                    <input type="number" name="stock" id="pStock" value="0" min="0" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="pDesc" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" accept="image/*">
                    <small style="color:#666; display:block; margin-top:5px;">Leave empty to keep current image when
                        editing</small>
                </div>

                <div style="text-align: right; margin-top: 1.5rem;">
                    <button type="submit" class="btn" style="width: 100%;">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function filterCategories() {
            const selectedCategory = document.getElementById('categoryFilter').value;
            const sections = document.querySelectorAll('.category-section');

            sections.forEach(section => {
                const category = section.getAttribute('data-category');
                if (selectedCategory === 'all' || category === selectedCategory) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        }

        function toggleSidebar() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('active');
        }

        const modal = document.getElementById('productModal');
        const modalTitle = document.getElementById('modalTitle');
        const formAction = document.getElementById('formAction');
        const productId = document.getElementById('productId');
        const pCategory = document.getElementById('pCategory');
        const pName = document.getElementById('pName');
        const pPrice = document.getElementById('pPrice');
        const pStock = document.getElementById('pStock');
        const pDesc = document.getElementById('pDesc');

        function openModal() {
            modal.style.display = 'flex';
            modalTitle.textContent = 'Add Product';
            formAction.value = 'add_product';
            productId.value = '';
            pCategory.value = 'Ceylon Tea Collection'; // Default
            pName.value = '';
            pPrice.value = '';
            pStock.value = '0';
            pDesc.value = '';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        function editProduct(product) {
            modal.style.display = 'flex';
            modalTitle.textContent = 'Edit Product';
            formAction.value = 'update_product';
            productId.value = product.id;
            pCategory.value = product.category || 'Ceylon Tea Collection';
            pName.value = product.name;
            pPrice.value = product.price;
            pStock.value = product.stock || 0;
            pDesc.value = product.description;
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>