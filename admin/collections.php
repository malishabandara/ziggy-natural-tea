<?php
session_start();
require_once '../config.php';

// Check Admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login");
    exit;
}

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    try {
        if ($action === 'add_card' || $action === 'update_card') {
            $title = $_POST['title'];
            $subtitle = $_POST['subtitle'];
            $link = $_POST['link'];
            $order = $_POST['sort_order'];
            
            // Image Upload
            $imagePath = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = "../assets/uploads/collections/";
                if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
                
                $fileName = time() . "_" . basename($_FILES["image"]["name"]);
                $targetFile = $targetDir . $fileName;
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    $imagePath = "assets/uploads/collections/" . $fileName;
                }
            }

            if ($action === 'add_card') {
                if (empty($imagePath)) throw new Exception("Image is required for new cards.");
                
                $stmt = $pdo->prepare("INSERT INTO collection_cards (title, subtitle, link, sort_order, image_path) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$title, $subtitle, $link, $order, $imagePath]);
                
            } elseif ($action === 'update_card') {
                $id = $_POST['id'];
                $removeImage = isset($_POST['remove_image']) && $_POST['remove_image'] === '1';

                if (!empty($imagePath)) {
                    $stmt = $pdo->prepare("UPDATE collection_cards SET title=?, subtitle=?, link=?, sort_order=?, image_path=? WHERE id=?");
                    $stmt->execute([$title, $subtitle, $link, $order, $imagePath, $id]);
                } elseif ($removeImage) {
                    // Remove image (set to empty string)
                    $stmt = $pdo->prepare("UPDATE collection_cards SET title=?, subtitle=?, link=?, sort_order=?, image_path='' WHERE id=?");
                    $stmt->execute([$title, $subtitle, $link, $order, $id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE collection_cards SET title=?, subtitle=?, link=?, sort_order=? WHERE id=?");
                    $stmt->execute([$title, $subtitle, $link, $order, $id]);
                }
            }
            
            header("Location: collections.php?msg=Saved Successfully");
            exit;
        }
        
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Delete Action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM collection_cards WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    header("Location: collections.php?msg=Deleted Successfully");
    exit;
}

// Fetch Cards
$cards = $pdo->query("SELECT * FROM collection_cards ORDER BY sort_order ASC")->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collections - Ziggy Admin</title>
    <link rel="icon" type="image/png" href="../assets/logo.png">
    <!-- Reuse CSS from dashboard/slider -->
    <style>
        :root { --primary: #2c3e50; --secondary: #e67e22; --light: #ecf0f1; --dark: #34495e; --danger: #e74c3c; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f7; margin: 0; display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: var(--primary); color: white; padding: 2rem 1rem; display: flex; flex-direction: column; height: 100vh; position: sticky; top: 0; }
        .sidebar h2 { font-size: 1.5rem; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem; }
        .sidebar a { color: #bdc3c7; text-decoration: none; padding: 0.75rem; margin-bottom: 0.5rem; border-radius: 4px; display: block; transition: all 0.3s; }
        .sidebar a:hover, .sidebar a.active { background-color: var(--dark); color: white; }
        .sidebar .logout { margin-top: auto; color: var(--danger); }
        .main-content { flex: 1; padding: 2rem; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .card-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; }
        .admin-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .admin-card img { width: 100%; height: 150px; object-fit: cover; }
        .card-body { padding: 1rem; }
        .btn { background: var(--secondary); color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; text-decoration: none; }
        .btn-sm { font-size: 0.85rem; padding: 0.3rem 0.6rem; }
        .btn-danger { background: var(--danger); color: white; }
        
        /* Modal */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000; }
        .modal-content { background: white; padding: 2rem; border-radius: 8px; width: 90%; max-width: 500px; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input { width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        
        @media (max-width: 768px) {
            .sidebar { display: none; } /* Simplified mobile for brevity, dashboard has toggle logic */
            .main-content { padding: 1rem; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Ziggy Admin</h2>
        <a href="dashboard.php">Products</a>
        <a href="categories.php">Categories</a>
        <a href="orders.php">Orders</a>
        <a href="slider.php">Slider Settings</a>
        <a href="collections.php" class="active">Collections</a>
        <a href="messages">Messages</a>
        <a href="../index" target="_blank">View Site</a>
        <a href="actions.php?action=logout" class="logout">Logout</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Collections Management</h1>
            <button class="btn" onclick="openModal()">+ Add New Card</button>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 1rem; margin-bottom: 1rem; border-radius: 4px;">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="card-grid">
            <?php foreach ($cards as $card): ?>
                <div class="admin-card">
                    <img src="../<?php echo htmlspecialchars($card['image_path']); ?>" alt="Card Image">
                    <div class="card-body">
                        <h3 style="margin: 0 0 0.5rem 0;"><?php echo htmlspecialchars($card['title']); ?></h3>
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($card['subtitle']); ?></p>
                        <div style="font-size: 0.8rem; color: #999; margin-bottom: 1rem;">
                            Sort: <?php echo $card['sort_order']; ?> | Link: <?php echo $card['link']; ?>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <button class="btn btn-sm" onclick='editCard(<?php echo json_encode($card); ?>)'>Edit</button>
                            <a href="?action=delete&id=<?php echo $card['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this card?')">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal -->
    <div id="cardModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle">Add Collection Card</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="formAction" value="add_card">
                <input type="hidden" name="id" id="cardId">
                
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" id="pTitle" required placeholder="e.g. Premium Tea">
                </div>
                
                <div class="form-group">
                    <label>Subtitle</label>
                    <input type="text" name="subtitle" id="pSubtitle" placeholder="e.g. Pure Ceylon Black...">
                </div>
                
                <div class="form-group">
                    <label>Link (Page URL)</label>
                    <input type="text" name="link" id="pLink" value="products" placeholder="products">
                </div>
                
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" id="pOrder" value="0">
                </div>
                
                <div class="form-group">
                    <label>Image</label>
                    <!-- Preview Container -->
                    <div id="imagePreviewContainer" style="display:none; margin-bottom: 10px; align-items: start; gap: 10px;">
                        <img id="imagePreview" src="" alt="Current Image" style="max-height: 100px; border-radius: 4px; border: 1px solid #ddd;">
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeImage()">Remove</button>
                    </div>
                    <input type="hidden" name="remove_image" id="removeImageInput" value="0">
                    <input type="file" name="image" accept="image/*">
                    <small style="color:#666; font-size:0.85rem;">Leave empty to keep current image when editing</small>
                </div>
                
                <div style="text-align: right; margin-top: 1rem;">
                    <button type="button" onclick="closeModal()" style="margin-right: 1rem; background: none; border: none; cursor: pointer;">Cancel</button>
                    <button type="submit" class="btn">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('cardModal');
        const modalTitle = document.getElementById('modalTitle');
        const formAction = document.getElementById('formAction');
        const cardId = document.getElementById('cardId');
        
        function openModal() {
            modal.style.display = 'flex';
            modalTitle.innerText = "Add Collection Card";
            formAction.value = 'add_card';
            cardId.value = '';
            document.getElementById('pTitle').value = '';
            document.getElementById('pSubtitle').value = '';
            document.getElementById('pLink').value = 'products';
            document.getElementById('pOrder').value = '0';
            
            // Reset Image
            document.getElementById('imagePreviewContainer').style.display = 'none';
            document.getElementById('imagePreview').src = '';
            document.getElementById('removeImageInput').value = '0';
        }
        
        function editCard(card) {
            modal.style.display = 'flex';
            modalTitle.innerText = "Edit Collection Card";
            formAction.value = 'update_card';
            cardId.value = card.id;
            document.getElementById('pTitle').value = card.title;
            document.getElementById('pSubtitle').value = card.subtitle;
            document.getElementById('pLink').value = card.link;
            document.getElementById('pOrder').value = card.sort_order;
            
            // Show Image
            if(card.image_path) {
                document.getElementById('imagePreview').src = '../' + card.image_path;
                document.getElementById('imagePreviewContainer').style.display = 'flex';
            } else {
                document.getElementById('imagePreviewContainer').style.display = 'none';
            }
            document.getElementById('removeImageInput').value = '0';
        }
        
        function removeImage() {
            document.getElementById('imagePreviewContainer').style.display = 'none';
            document.getElementById('removeImageInput').value = '1';
        }
        
        function closeModal() {
            modal.style.display = 'none';
        }
        
        window.onclick = function(e) {
            if (e.target == modal) closeModal();
        }
    </script>
</body>
</html>
