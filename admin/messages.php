<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login");
    exit;
}

// Fetch all messages
$stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Ziggy Natural</title>
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

        .messages-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
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
        }

        .status-unread {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-read {
            background-color: #d4edda;
            color: #155724;
        }

        .message-preview {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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

            .messages-table {
                overflow-x: auto;
            }

            .message-preview {
                max-width: 150px;
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
            <a href="dashboard">Products</a>
            <a href="messages" class="active">Messages</a>
            <a href="../index" target="_blank">View Site</a>
            <a href="actions.php?action=logout" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Contact Messages</h1>
        </div>

        <div class="messages-table">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($messages) > 0): ?>
                        <?php foreach ($messages as $msg): ?>
                            <tr>
                                <td><?php echo date('M d, Y H:i', strtotime($msg['created_at'])); ?></td>
                                <td><?php echo htmlspecialchars($msg['name']); ?></td>
                                <td><?php echo htmlspecialchars($msg['email']); ?></td>
                                <td class="message-preview" title="<?php echo htmlspecialchars($msg['message']); ?>">
                                    <?php echo htmlspecialchars($msg['message']); ?>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo $msg['status']; ?>">
                                        <?php echo ucfirst($msg['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem; color: #999;">
                                No messages yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('active');
        }
    </script>

</body>

</html>