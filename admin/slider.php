<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login");
    exit;
}

// Fetch all slides
$stmt = $pdo->query("SELECT * FROM hero_slides ORDER BY order_index ASC");
$slides = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider Settings - Ziggy Natural</title>
    <link rel="icon" type="image/png" href="../assets/logo.png">
    <link rel="shortcut icon" href="../assets/logo.png" type="image/png">
    <link rel="apple-touch-icon" href="../assets/logo.png">
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
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn-edit {
            background-color: #3498db;
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
            margin-right: 0.5rem;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Slide Table/Grid Styles */
        .table-responsive {
            overflow-x: auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: var(--dark);
        }

        .slide-preview {
            width: 120px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            background-color: #eee;
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
            max-width: 600px;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
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
        .form-group textarea,
        .form-group select {
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
            
            /* Responsive Table for Mobile */
            .table-responsive table, .table-responsive thead, .table-responsive tbody, .table-responsive th, .table-responsive td, .table-responsive tr { 
                display: block; 
            }
            .table-responsive thead tr { 
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            .table-responsive tr { 
                border: 1px solid #ccc; 
                margin-bottom: 1rem;
                background: white;
                border-radius: 8px;
                padding: 0.5rem;
            }
            .table-responsive td { 
                border: none;
                border-bottom: 1px solid #eee; 
                position: relative;
                padding-left: 40%; 
                text-align: right;
            }
            .table-responsive td:before { 
                position: absolute;
                top: 1rem;
                left: 1rem;
                width: 35%; 
                padding-right: 10px; 
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
                content: attr(data-label);
            }
            .table-responsive td:last-child {
                border-bottom: none;
                display: flex;
                justify-content: flex-end;
                gap: 0.5rem;
                padding-left: 0;
                text-align: right;
            }
             .table-responsive td:last-child:before {
                display: none;
            }
            .slide-preview {
                width: 100%; /* structured card look on mobile */
                height: auto;
                max-height: 200px;
                margin-bottom: 0.5rem;
            }
            .table-responsive td[data-label="Image"] {
                padding-left: 0;
                text-align: center;
            }
             .table-responsive td[data-label="Image"]:before {
                display: none;
            }
        }

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
            <a href="dashboard.php">Products</a>
            <a href="orders.php">Orders</a>
            <a href="#" class="active">Slider Settings</a>
            <a href="collections.php">Collections</a>
            <a href="messages">Messages</a>
            <a href="../index" target="_blank">View Site</a>
            <a href="actions.php?action=logout" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Slider Management</h1>
            <button class="btn" onclick="openModal()">+ Add New Slide</button>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 1rem; margin-bottom: 1rem; border-radius: 4px;">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">Order</th>
                        <th style="width: 140px;">Image</th>
                        <th>Content</th>
                        <th>Button</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($slides)): ?>
                        <tr>
                            <td colspan="5" style="text-align:center; padding: 2rem;">No slides found. Add one to get started!</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($slides as $slide): ?>
                            <tr>
                                <td data-label="Order"><?php echo $slide['order_index']; ?></td>
                                <td data-label="Image">
                                    <img src="../<?php echo htmlspecialchars($slide['image_path']); ?>" alt="Slide" class="slide-preview">
                                </td>
                                <td data-label="Content">
                                    <small style="color:var(--secondary); font-weight:bold;"><?php echo htmlspecialchars($slide['subtitle']); ?></small><br>
                                    <strong><?php echo strip_tags($slide['title']); ?></strong><br>
                                    <span style="color:#666; font-size:0.9rem;"><?php echo htmlspecialchars(substr($slide['description'], 0, 50)) . '...'; ?></span>
                                </td>
                                <td data-label="Button">
                                    <?php echo htmlspecialchars($slide['button_text']); ?><br>
                                    <small style="color:#999;">Link: <?php echo htmlspecialchars($slide['button_link']); ?></small>
                                </td>
                                <td>
                                    <button class="btn btn-edit" onclick='editSlide(<?php echo json_encode($slide); ?>)'>Edit</button>
                                    <a href="actions.php?action=delete_slide&id=<?php echo $slide['id']; ?>" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="slideModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Add Slide</h2>
            <form action="actions.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="formAction" value="add_slide">
                <input type="hidden" name="id" id="slideId">

                <div class="form-group">
                    <label>Order Index (Sort)</label>
                    <input type="number" name="order_index" id="sOrder" value="0" required>
                </div>

                <div class="form-group">
                    <label>Subtitle (Top Small Text)</label>
                    <input type="text" name="subtitle" id="sSubtitle" placeholder="e.g. Premium Ceylon Collection">
                </div>

                <div class="form-group">
                    <label>Title (Main Heading)</label>
                    <textarea name="title" id="sTitle" rows="2" placeholder="e.g. Sip the Essence of <br>Nature's Purest"></textarea>
                    <small>HTML allowed (use &lt;br&gt; for line breaks)</small>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="sDesc" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label>Button Text</label>
                    <input type="text" name="button_text" id="sBtnText" value="Explore Collection">
                </div>

                <div class="form-group">
                    <label>Button Link</label>
                    <input type="text" name="button_link" id="sBtnLink" value="products">
                </div>

                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" accept="image/*">
                    <small style="color:#666; display:block; margin-top:5px;">Leave empty to keep current image when editing</small>
                </div>

                <div style="text-align: right; margin-top: 1.5rem;">
                    <button type="submit" class="btn" style="width: 100%;">Save Slide</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('active');
        }

        const modal = document.getElementById('slideModal');
        const modalTitle = document.getElementById('modalTitle');
        const formAction = document.getElementById('formAction');
        const slideId = document.getElementById('slideId');
        
        const sOrder = document.getElementById('sOrder');
        const sSubtitle = document.getElementById('sSubtitle');
        const sTitle = document.getElementById('sTitle');
        const sDesc = document.getElementById('sDesc');
        const sBtnText = document.getElementById('sBtnText');
        const sBtnLink = document.getElementById('sBtnLink');

        function openModal() {
            modal.style.display = 'flex';
            modalTitle.textContent = 'Add Slide';
            formAction.value = 'add_slide';
            slideId.value = '';
            
            sOrder.value = '0';
            sSubtitle.value = '';
            sTitle.value = '';
            sDesc.value = '';
            sBtnText.value = 'Explore Collection';
            sBtnLink.value = 'products';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        function editSlide(slide) {
            modal.style.display = 'flex';
            modalTitle.textContent = 'Edit Slide';
            formAction.value = 'update_slide';
            slideId.value = slide.id;
            
            sOrder.value = slide.order_index;
            sSubtitle.value = slide.subtitle;
            sTitle.value = slide.title; // Should handle raw HTML if any
            sDesc.value = slide.description;
            sBtnText.value = slide.button_text;
            sBtnLink.value = slide.button_link;
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
