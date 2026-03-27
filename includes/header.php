<?php
$current_page = basename($_SERVER['PHP_SELF']);
$hero_pages = ['index.php', '', 'index', 'about.php', 'about', 'products.php', 'products', 'contact.php', 'contact'];
$has_hero = in_array($current_page, $hero_pages);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziggy Natural - Premium Tea & Coffee</title>
    <link rel="icon" type="image/png" sizes="32x32" href="assets/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/logo.png">
    <link rel="shortcut icon" href="assets/logo.png" type="image/png">
    <link rel="apple-touch-icon" href="assets/logo.png">
    
    <!-- Search Engine & Social Media Optimization -->
    <meta property="og:title" content="Ziggy Natural - Premium Tea & Coffee">
    <meta property="og:description" content="Experience the finest hand-picked organic tea and artisan coffee blends from Sri Lanka.">
    <meta property="og:image" content="https://ziggynaturalceylon.com/assets/logo.png">
    <meta property="og:url" content="https://ziggynaturalceylon.com/">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="https://ziggynaturalceylon.com/assets/logo.png">
    <meta name="theme-color" content="#1a1a1a">

    <!-- Schema.org for Organization Logo -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "url": "https://ziggynaturalceylon.com/",
      "logo": "https://ziggynaturalceylon.com/assets/logo.png",
      "name": "Ziggy Natural"
    }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time() . rand(); ?>">
</head>

<body class="<?php echo $has_hero ? 'home-page' : ''; ?>">

    <header class="<?php echo $has_hero ? 'header-transparent' : ''; ?>">
        <a href="index" class="logo">
            <img src="assets/logo.png" alt="Ziggy Natural" style="height: 50px; margin-right: 10px;">
            <div class="logo-text">Ziggy <span>Natural</span></div>
        </a>
        <nav id="nav-menu">
            <a href="index" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a>
            <a href="products" class="<?php echo $current_page == 'products.php' ? 'active' : ''; ?>">Shop</a>
            <a href="about" class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">About</a>
            <a href="contact" class="<?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact</a>
        </nav>
        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
    </header>