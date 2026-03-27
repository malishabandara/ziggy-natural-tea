<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login");
    exit;
}

// Fetch all inquiries
$stmt = $pdo->query("SELECT i.*, p.name as product_name FROM product_inquiries i LEFT JOIN products p ON i.product_id = p.id ORDER BY i.created_at DESC");
$inquiries = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiries - Ziggy Admin</title>
    <link rel="icon" type="image/png" href="../assets/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #e67e22;
            --light: #ecf0f1;
            --dark: #34495e;
            --danger: #e74c3c;
            --success: #27ae60;
            --warning: #f39c12;
            --info: #3498db;
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

        .data-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: var(--primary);
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            display: inline-block;
        }

        .btn-view { background-color: var(--info); }
        .btn-danger { background-color: var(--danger); }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 2.5rem;
            border-radius: 12px;
            width: 90%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .close-modal {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
            transition: color 0.3s;
        }
        
        .close-modal:hover { color: #333; }
        
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .detail-item {
            margin-bottom: 1rem;
        }

        .detail-item strong {
            display: block;
            color: #7f8c8d;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.3rem;
        }
        
        .detail-item span {
            font-size: 1.05rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .comment-box {
            grid-column: 1 / -1;
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid var(--secondary);
            margin-top: 1rem;
        }

        .badge {
            padding: 0.2rem 0.6rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        .badge-sl { background: #d4edda; color: #155724; }
        .badge-intl { background: #cce5ff; color: #004085; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: static; }
             .menu-toggle { display: block; background:none; border:none; color:white; font-size:1.5rem; }
            .nav-links { display: none; flex-direction: column; width: 100%; margin-top: 1rem; }
            .nav-links.active { display: flex; }
            .header { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .data-table { overflow-x: auto; }
            .details-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <h2>Ziggy Admin</h2>
            <button class="menu-toggle" onclick="document.getElementById('navLinks').classList.toggle('active')">☰</button>
        </div>
        <div class="nav-links" id="navLinks">
            <a href="dashboard">Products</a>
            <a href="inquiries.php" class="active">Product Inquiries</a>
            <a href="slider.php">Slider Settings</a>
            <a href="collections.php">Collections</a>
            <a href="messages">Messages</a>
            <a href="../index" target="_blank">View Site</a>
            <a href="actions.php?action=logout" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Product Inquiries</h1>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 1rem; margin-bottom: 1rem; border-radius: 4px;">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>User Type</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($inquiries) > 0): ?>
                        <?php foreach ($inquiries as $row): ?>
                            <tr>
                                <td>#<?php echo $row['id']; ?></td>
                                <td><?php echo date('M d, H:i', strtotime($row['created_at'])); ?></td>
                                <td><strong><?php echo htmlspecialchars($row['product_name'] ?? 'N/A'); ?></strong></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
                                    <small><?php echo htmlspecialchars($row['email']); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($row['user_type']); ?></td>
                                <td>
                                    <span class="badge <?php echo $row['location'] == 'Sri Lanka' ? 'badge-sl' : 'badge-intl'; ?>">
                                        <?php echo htmlspecialchars($row['location']); ?>
                                        <?php if($row['country']): ?> (<?php echo htmlspecialchars($row['country']); ?>)<?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-view" onclick="viewInquiry(<?php echo $row['id']; ?>)">View</button>
                                    <a href="actions.php?action=delete_inquiry&id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this inquiry?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" style="text-align:center; padding: 2rem; color: #777;">No inquiries found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inquiry Details Modal -->
    <div id="inquiryModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Inquiry Details</h2>
            
            <div class="details-grid">
                <div class="detail-item">
                    <strong>Product Inquired</strong>
                    <span id="modalProduct"></span>
                </div>
                <div class="detail-item">
                    <strong>Date Received</strong>
                    <span id="modalDate"></span>
                </div>
                <div class="detail-item">
                    <strong>Full Name</strong>
                    <span id="modalName"></span>
                </div>
                <div class="detail-item">
                    <strong>Phone / WhatsApp</strong>
                    <span id="modalPhone"></span>
                </div>
                <div class="detail-item">
                    <strong>Email Address</strong>
                    <span id="modalEmail"></span>
                </div>
                <div class="detail-item">
                    <strong>User Type</strong>
                    <span id="modalUserType"></span>
                </div>
                <div class="detail-item">
                    <strong>Location</strong>
                    <span id="modalLocation"></span>
                </div>
                <div class="detail-item">
                    <strong>Country</strong>
                    <span id="modalCountry"></span>
                </div>
                
                <div class="comment-box">
                    <strong>Comments / Questions:</strong>
                    <p id="modalComments" style="margin-top: 10px; line-height: 1.6; white-space: pre-wrap;"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('inquiryModal').style.display = 'none';
        }

        function viewInquiry(id) {
            fetch('actions.php?action=get_inquiry_details&id=' + id)
                .then(response => response.json())
                .then(data => {
                    if(data.error) {
                        alert(data.error);
                        return;
                    }
                    
                    const i = data.inquiry;
                    document.getElementById('modalProduct').innerText = i.product_name || 'N/A';
                    document.getElementById('modalDate').innerText = i.created_at;
                    document.getElementById('modalName').innerText = i.name;
                    document.getElementById('modalPhone').innerText = i.phone;
                    document.getElementById('modalEmail').innerText = i.email;
                    document.getElementById('modalUserType').innerText = i.user_type;
                    document.getElementById('modalLocation').innerText = i.location;
                    document.getElementById('modalCountry').innerText = i.country || 'N/A';
                    document.getElementById('modalComments').innerText = i.comments || 'No comments provided.';

                    document.getElementById('inquiryModal').style.display = 'flex';
                })
                .catch(err => {
                    console.error(err);
                    alert('Error loading details');
                });
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('inquiryModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>
