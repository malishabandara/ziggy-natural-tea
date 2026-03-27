<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar" id="sidebar">
    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
        <h2>Ziggy Admin</h2>
        <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
    </div>
    <div class="nav-links" id="navLinks">
        <a href="dashboard.php" class="<?php echo ($currentPage == 'dashboard.php' || $currentPage == 'dashboard') ? 'active' : ''; ?>">Products</a>
        <a href="categories.php" class="<?php echo $currentPage == 'categories.php' ? 'active' : ''; ?>">Categories</a>
        <a href="inquiries.php" class="<?php echo $currentPage == 'inquiries.php' ? 'active' : ''; ?>">Product Inquiries</a>
        <a href="orders.php" class="<?php echo $currentPage == 'orders.php' ? 'active' : ''; ?>">Orders</a>
        <a href="slider.php" class="<?php echo $currentPage == 'slider.php' ? 'active' : ''; ?>">Slider Settings</a>
        <a href="collections.php" class="<?php echo $currentPage == 'collections.php' ? 'active' : ''; ?>">Collections</a>
        <a href="messages.php" class="<?php echo ($currentPage == 'messages.php' || $currentPage == 'messages') ? 'active' : ''; ?>">Messages</a>
        <a href="../index.php" target="_blank">View Site</a>
        <a href="actions.php?action=logout" class="logout">Logout</a>
    </div>
</div>

<script>
    function toggleSidebar() {
        const navLinks = document.getElementById('navLinks');
        navLinks.classList.toggle('active');
    }
</script>
