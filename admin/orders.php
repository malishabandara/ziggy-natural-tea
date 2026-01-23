<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login");
    exit;
}

// Fetch all orders
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Ziggy Admin</title>
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

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-completed { background-color: #d4edda; color: #155724; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
        }

        .btn-view { background-color: var(--info); }
        .btn-success { background-color: var(--success); }
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
            padding: 2rem;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }
        
        .order-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .detail-item strong {
            display: block;
            color: #7f8c8d;
            font-size: 0.85rem;
            margin-bottom: 0.2rem;
        }
        
        .receipt-preview {
            max-width: 100%;
            max-height: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 0.5rem;
        }
        
        .items-list {
            margin-top: 1rem;
            border-top: 1px solid #eee;
            padding-top: 1rem;
        }
        
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: static; }
             .menu-toggle { display: block; background:none; border:none; color:white; font-size:1.5rem; }
            .nav-links { display: none; flex-direction: column; width: 100%; margin-top: 1rem; }
            .nav-links.active { display: flex; }
            .header { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .data-table { overflow-x: auto; }
        }
        @media (min-width: 769px) { 
            .menu-toggle { display: none; } 
            .nav-links {
                display: flex;
                flex-direction: column;
                width: 100%;
            }
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
            <a href="orders.php" class="active">Orders</a>
            <a href="slider.php">Slider Settings</a>
            <a href="messages">Messages</a>
            <a href="../index" target="_blank">View Site</a>
            <a href="actions.php?action=logout" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Order Management</h1>
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
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($orders) > 0): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?php echo $order['id']; ?></td>
                                <td><?php echo date('M d, H:i', strtotime($order['created_at'])); ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($order['customer_name']); ?></strong><br>
                                    <small><?php echo htmlspecialchars($order['customer_phone']); ?></small>
                                </td>
                                <td>LKR <?php echo number_format($order['total_amount'], 2); ?></td>
                                <td>
                                    <?php echo $order['payment_method'] == 'cod' ? 'Cash On Delivery' : 'Bank Transfer'; ?>
                                    <?php if($order['payment_method'] == 'bank_transfer' && $order['receipt_image']): ?>
                                        <i class="fas fa-paperclip" title="Receipt Attached"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo $order['status']; ?>">
                                        <?php echo ucfirst($order['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-view" onclick="viewOrder(<?php echo $order['id']; ?>)">View</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" style="text-align:center; padding: 2rem; color: #777;">No orders found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2>Order Details #<span id="modalOrderId"></span></h2>
            
            <div class="order-details-grid">
                <div class="detail-item">
                    <strong>Customer Name</strong>
                    <span id="modalName"></span>
                </div>
                <div class="detail-item">
                    <strong>Phone Number</strong>
                    <span id="modalPhone"></span>
                </div>
                <div class="detail-item" style="grid-column: 1/-1;">
                    <strong>Address</strong>
                    <span id="modalAddress"></span>
                </div>
                <div class="detail-item">
                    <strong>Payment Method</strong>
                    <span id="modalPayment"></span>
                </div>
                <div class="detail-item">
                    <strong>Status</strong>
                    <span id="modalStatus"></span>
                </div>
            </div>

            <div id="receiptSection" style="display:none; margin-bottom: 1.5rem;">
                <strong>Payment Receipt</strong>
                <a id="receiptLink" href="#" target="_blank">
                    <img id="receiptImage" src="" class="receipt-preview" alt="Receipt">
                </a>
            </div>

            <h3>Items</h3>
            <div id="modalItems" class="items-list">
                <!-- Items injected by JS -->
            </div>
            <div class="item-row" style="font-weight: bold; border-top: 1px solid #ddd; padding-top: 0.5rem; margin-top: 0.5rem;">
                <span>Total</span>
                <span id="modalTotal"></span>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1rem; border-top: 1px solid #eee; padding-top: 1rem;">
                <form action="actions.php" method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="update_order_status">
                    <input type="hidden" name="order_id" id="formOrderId">
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="btn btn-success" onclick="return confirm('Mark order as completed?')">Mark Completed</button>
                </form>
                
                <form action="actions.php" method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="update_order_status">
                    <input type="hidden" name="order_id" id="formOrderId2">
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Cancel this order?')">Cancel Order</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script>
        function closeModal() {
            document.getElementById('orderModal').style.display = 'none';
        }

        function viewOrder(orderId) {
            // Fetch order details via AJAX
            fetch('actions.php?action=get_order_details&id=' + orderId)
                .then(response => response.json())
                .then(data => {
                    if(data.error) {
                        alert(data.error);
                        return;
                    }
                    
                    const order = data.order;
                    const items = data.items;

                    document.getElementById('modalOrderId').innerText = order.id;
                    document.getElementById('formOrderId').value = order.id;
                    document.getElementById('formOrderId2').value = order.id;
                    
                    document.getElementById('modalName').innerText = order.customer_name;
                    document.getElementById('modalPhone').innerText = order.customer_phone;
                    document.getElementById('modalAddress').innerText = order.customer_address;
                    document.getElementById('modalPayment').innerText = order.payment_method == 'cod' ? 'Cash On Delivery' : 'Bank Transfer';
                    document.getElementById('modalStatus').innerText = order.status.charAt(0).toUpperCase() + order.status.slice(1);
                    document.getElementById('modalTotal').innerText = 'LKR ' + parseFloat(order.total_amount).toLocaleString(undefined, {minimumFractionDigits: 2});

                    // Receipt
                    const receiptSection = document.getElementById('receiptSection');
                    if (order.receipt_image) {
                        receiptSection.style.display = 'block';
                        document.getElementById('receiptImage').src = '../' + order.receipt_image;
                        document.getElementById('receiptLink').href = '../' + order.receipt_image;
                    } else {
                        receiptSection.style.display = 'none';
                    }

                    // Items
                    const itemsContainer = document.getElementById('modalItems');
                    itemsContainer.innerHTML = '';
                    items.forEach(item => {
                        const div = document.createElement('div');
                        div.className = 'item-row';
                        const total = parseFloat(item.price) * parseInt(item.quantity);
                        div.innerHTML = `
                            <span>${item.product_name} <span style="color:#777">x${item.quantity}</span></span>
                            <span>LKR ${total.toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                        `;
                        itemsContainer.appendChild(div);
                    });

                    document.getElementById('orderModal').style.display = 'flex';
                })
                .catch(err => {
                    console.error(err);
                    alert('Error loading order details');
                });
        }

        // Close on click outside
        window.onclick = function(event) {
            if (event.target == document.getElementById('orderModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>
