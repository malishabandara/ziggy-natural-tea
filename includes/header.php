<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziggy Natural - Premium Tea & Coffee</title>
    <link rel="icon" type="image/png" href="assets/logo.png">
    <link rel="shortcut icon" href="assets/logo.png" type="image/png">
    <link rel="apple-touch-icon" href="assets/logo.png">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time() . rand(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time() . rand(); ?>">
    <script src="assets/js/cart.js?v=<?php echo time(); ?>"></script>
    <style>
        .cart-link {
            position: relative;
            margin-left: 10px; /* details */
        }
        .cart-link i {
            font-size: 1.5rem; /* Increased size */
            color: #2c3e50;
        }
        #cart-count {
            background-color: #2c3e50; /* Uses var(--primary) usually, but hardcoded for safety or use var */
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.8rem;
            position: absolute;
            top: -5px;
            right: -10px;
        }
    </style>
</head>

<body>

    <header>
        <a href="index" class="logo">
            <img src="assets/logo.png" alt="Ziggy Natural" style="height: 50px; margin-right: 10px;">
            <div class="logo-text">Ziggy <span>Natural</span></div>
        </a>
        <nav>
            <a href="index" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a>
            <a href="products" class="<?php echo $current_page == 'products.php' ? 'active' : ''; ?>">Shop</a>
            <a href="about" class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">About</a>
            <a href="contact" class="<?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact</a>
            <a href="cart" class="cart-link <?php echo $current_page == 'cart.php' ? 'active' : ''; ?>">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count">0</span>
            </a>
        </nav>
    </header>