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
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time() . rand(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        </nav>
    </header>