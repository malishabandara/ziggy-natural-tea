<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login");
    exit;
}

// Fetch all categories
try {
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY sort_order ASC, name ASC");
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    // Fallback if table doesn't exist yet, to avoid fatal error before migration
    $categories = [];
    $error = "Error fetching categories: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Ziggy Natural</title>
    <link rel="icon" type="image/png" href="../assets/logo.png">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #e67e22;
            --light: #ecf0f1;
            --dark: #34495e;
            --danger: #e74c3c;
            --success: #27ae60;
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

        .sidebar a:hover, .sidebar a.active {
            background-color: var(--dark);
            color: white;
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

        .card {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            max-width: 800px;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            background-color: var(--secondary);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
        }
        
        .btn:hover { opacity: 0.9; }

        .btn-danger {
            background-color: var(--danger);
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            color: var(--dark);
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

            .main-content {
                padding: 1rem;
            }
        }

        /* Desktop */
        @media (min-width: 769px) {
            .menu-toggle {
                display: none;
            }
            .nav-links {
                display: flex;
                flex-direction: column;
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
            <a href="dashboard.php">Products</a>
            <a href="#" class="active">Categories</a>
            <a href="orders.php">Orders</a>
            <a href="slider.php">Slider Settings</a>
            <a href="collections.php">Collections</a>
            <a href="messages">Messages</a>
            <a href="../index" target="_blank">View Site</a>
            <a href="actions.php?action=logout" style="color: var(--danger); margin-top: 2rem;">Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Manage Categories</h1>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 1rem; margin-bottom: 1rem; border-radius: 4px;">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 1rem; margin-bottom: 1rem; border-radius: 4px;">
                <?php echo htmlspecialchars($error); ?>
                <br>Please run the migration script or contact support.
            </div>
        <?php endif; ?>

        <div class="card">
            <h3>Add New Category</h3>
            <form action="actions.php" method="POST">
                <input type="hidden" name="action" value="add_category">
                <div style="display:flex; gap:1rem;">
                    <div class="form-group" style="flex:3">
                        <label>Category Name</label>
                        <input type="text" name="name" required placeholder="e.g. Green Tea Collection">
                    </div>
                    <div class="form-group" style="flex:1">
                        <label>Order</label>
                        <input type="number" name="sort_order" value="0" placeholder="0">
                    </div>
                </div>
                <button type="submit" class="btn">Add Category</button>
            </form>
        </div>

        <!-- Hidden Edit Form -->
        <div class="card" id="editFormContainer" style="display:none; border-left: 5px solid var(--secondary);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                <h3>Edit Category</h3>
                <button type="button" onclick="cancelEdit()" style="background:none; border:none; cursor:pointer; font-size:1.5rem;">&times;</button>
            </div>
            <form action="actions.php" method="POST">
                <input type="hidden" name="action" value="update_category">
                <input type="hidden" name="id" id="edit_id">
                <div style="display:flex; gap:1rem;">
                    <div class="form-group" style="flex:3">
                        <label>Category Name</label>
                        <input type="text" name="name" id="edit_name" required>
                    </div>
                    <div class="form-group" style="flex:1">
                        <label>Order</label>
                        <input type="number" name="sort_order" id="edit_order" value="0">
                    </div>
                </div>
                <button type="submit" class="btn">Update Category</button>
            </form>
        </div>

        <div class="card">
            <h3>Existing Categories</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categories)): ?>
                        <tr><td colspan="3">No categories found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td><?php echo $cat['sort_order']; ?></td>
                                <td><?php echo htmlspecialchars($cat['name']); ?></td>
                                <td>
                                    <button onclick="editCategory(<?php echo htmlspecialchars(json_encode($cat)); ?>)" 
                                            class="btn" style="padding: 0.4rem 0.8rem; font-size: 0.9rem; margin-right: 0.5rem; background-color:#3498db;">Edit</button>
                                    <a href="actions.php?action=delete_category&id=<?php echo $cat['id']; ?>" 
                                       class="btn-danger"
                                       onclick="return confirm('Are you sure? This might affect products assigned to this category.')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <script>
        function toggleSidebar() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('active');
        }

        function editCategory(cat) {
            document.getElementById('editFormContainer').style.display = 'block';
            document.getElementById('edit_id').value = cat.id;
            document.getElementById('edit_name').value = cat.name;
            document.getElementById('edit_order').value = cat.sort_order || 0;
            window.scrollTo(0, document.getElementById('editFormContainer').offsetTop - 20);
        }

        function cancelEdit() {
            document.getElementById('editFormContainer').style.display = 'none';
        }
    </script>
</body>
</html>
