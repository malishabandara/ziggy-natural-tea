-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2026 at 02:12 PM
-- Server version: 10.11.15-MariaDB-cll-lve-log
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ziggynat_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('unread','read') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`, `status`) VALUES
(1, 'gdgfh', 'dghdf@gmail.com', 'ergeg', '2026-01-17 08:59:54', 'unread'),
(2, 'Jens Bagwell', 'jens.bagwell@outlook.com', 'SoundSparkGenerator is a cloud-based tool that lets you create custom music styles in seconds by mixing genres, instruments, and vocal options. \r\n\r\nhttps://finsup.site/SoundSparkGenerator\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nto UNSUBSCRIBE:\r\nhttps://www.novaai.expert/unsubscribe?domain=ziggynaturalceylon.com\r\nAddress: 108 West Street Comstock Park, MI 48721\r\n', '2026-01-21 21:47:21', 'unread'),
(3, 'Rhys Eklund', 'rhys.eklund@gmail.com', 'Book Ninja does everything for you in mINUTES,\r\nbuilding you a passive income for years to come...\r\nhttps://facommunication.site/BookNinja\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nto UNSUBSCRIBE:\r\nhttps://facommunication.site/unsubscribe?domain=ziggynaturalceylon.com\r\nAddress: 108 West Street Comstock Park, MI 48721', '2026-01-22 08:43:18', 'unread'),
(4, 'Damian Threlkeld', 'threlkeld.damian@yahoo.com', 'World\'s First AI App That Creates\r\nCinematic Clips, Shorts & Reels Completely Hands-Free\r\nIn 100s Of Language - In Just 60 Seconds\r\n\r\nhttps://fitgirlpack.site/MagicClipsAI\r\n\r\n\r\n\r\n\r\n\r\nto UNSUBSCRIBE:\r\nhttps://fitgirlpack.site/unsubscribe?domain=ziggynaturalceylon.com\r\nAddress: 209 West Street Comstock Park, MI 49321', '2026-01-22 13:17:22', 'unread'),
(5, 'Latonya Grider', 'grider.latonya54@gmail.com', 'Apple HATES This... But They Can\'t Stop Me From Showing You How I Built A Money-Making App In 12 Minutes\r\nNow I\'m Handing You The Exact System To Do The Same — Zero Coding Required\r\nhttps://hitclub66.site/MeeloAppEmpire\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nYou got this message because we suppose it might be useful.  \r\nIf you want to discontinue, please open this link to UNSUBSCRIBE:  \r\nhttps://hitclub66.site/unsubscribe?domain=ziggynaturalceylon.com  \r\nAddress: 209 West Street Comstock Park, MI 49321  \r\nRegards, Ethan Parker', '2026-01-23 00:51:04', 'unread'),
(6, 'Mike Olivier Muller\r\n', 'info@professionalseocleanup.com', 'Hi, \r\nWhile reviewing ziggynaturalceylon.com, we spotted toxic backlinks that could put your site at risk of a Google penalty. Especially that this Google SPAM update had a high impact in ranks. This is an easy and quick fix for you. Totally free of charge. No obligations. \r\n \r\nFix it now: \r\nhttps://www.professionalseocleanup.com/ \r\n \r\nNeed help or questions? Chat here: \r\nhttps://www.professionalseocleanup.com/whatsapp/ \r\n \r\nBest, \r\nMike Olivier Muller\r\n \r\n+1 (855) 221-7591 \r\ninfo@professionalseocleanup.com', '2026-01-25 01:07:20', 'unread'),
(7, 'Robertdob', 'mariajesusmateo79@gmail.com', 'Through death, the family is not destroyed, it is transformed; a part of it passes into the unseen. We believe that death is an absence, when in fact it is a discreet presence. \r\nI am suffering from a serious illness that will lead to my certain death. \r\nI have €512,000 in my bank account, which I would like to donate. \r\nPlease contact me if you are interested. \r\n \r\nEmail: mariajesusgarciaa86@gmail.com', '2026-01-25 15:52:58', 'unread'),
(8, 'Marquita Grimes', 'marquita.grimes52@gmail.com', 'While you’re rotting away building complex funnels and burning cash on ads that don’t convert, Amazon is paying out over half a billion dollars in royalties to people who aren’t even \"writers\". You’re working too hard for pennies. Stop being a \"content slave\" and start building a digital asset portfolio that actually pays while you sleep. Book Ninja is an AI-powered beast that uses nine different tools to research, write, and design high-demand books in under 4 minutes.\r\nNo writing, no design skills, and zero marketing are required because Amazon already has the buyers waiting for you. Simply pick a niche, click a button, and upload your assets to Amazon, Etsy, or Shopify to start stacking royalties 24/7. Every day you hesitate is another day you are literally handing your share of that $520M to someone else who was faster than you. Stop wondering \"what if\" and start collecting—it\'s 100% risk-free for 30 days.\r\n\r\nhttps://jrvtns4nrv9jekfx.site/BookNinja?domain=ziggynaturalceylon.com \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nYou are getting this email \r\nbecause we believe \r\nthe offer we provide \r\nmight be of interest to you.\r\n\r\nIf you do not wish to receive \r\nfurther communications from us, \r\nyou can \r\nunsubscribe:\r\n\r\nhttps://jrvtns4nrv9jekfx.site/unsub?domain=ziggynaturalceylon.com \r\nAddress: Address: 3748   Via Pasquale Scura 122, MS  54010\r\nLooking out for you, Marquita Grimes.', '2026-01-27 21:28:43', 'unread'),
(9, 'Maybell Wegener', 'maybell.wegener2@hotmail.com', 'Stop kidding yourself. To a busy business owner, your \"SEO\" or \"Ads\" pitch is just more noise they’ve heard a thousand times. You’re begging for attention and getting ignored because you’re selling confusing services instead of providing instant, usable value. You aren\'t an authority; you\'re just another salesperson in their inbox.\r\nLocal Toolkit Fortune flips the script: you stop pitching and start owning the platform they actually use daily. We give you a complete, ready-to-launch website with 20 essential tools—like QR generators and Wi-Fi cards—that require zero technical skills or API keys. With 10 free tools to build trust and 10 premium tools to generate automated profits, you finally become the \"go-to\" resource instead of a desperate lead-chaser. \r\nGet Local Toolkit Fortune Now: https://nightbet.site/LocalToolkitFortune?domain=ziggynaturalceylon.com \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nYou’re receiving this email \r\nsince we think \r\nthe offer we provide \r\ncould be useful to you.\r\n\r\nIf you do not wish to receive \r\nadditional emails from us, \r\nplease click here to \r\nstop receiving emails:\r\n\r\nhttps://nightbet.site/unsub?domain=ziggynaturalceylon.com \r\nAddress: Address: 6591   Boarnsterdijk 20, FR  8491 Kr\r\nLooking out for you, Maybell Wegener.', '2026-01-28 08:23:34', 'unread'),
(10, 'Wilburn Swan', 'wilburn.swan@gmail.com', 'Let’s be honest: your business is invisible because you have zero traffic. You’re wasting hours \"creating content\" and editing videos that nobody watches, while the pros are stealing all the views. Most marketers fail because they are tired of the grind. Stop trying to be a filmmaker and start using a shortcut that actually works while you sleep.\r\nI’m using a \"Secret Script\" that auto-creates viral shorts in my browser in seconds—no recording, no editing, and zero technical skills required. YouTube literally forces traffic to these videos, accounting for 90% of the views; I banked 678 visitors in 25 hours from a single \"lucky accident\". This is your last point of access to get 100s of daily visitors for a one-time payment of $17. Either grab this unfair advantage now or keep struggling with an empty shop.\r\nAccess the Script & Instructions Here: https://kotel.site/10SecondScrollTraffic?domain=ziggynaturalceylon.com \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nThis message is sent to you \r\nbecause we think \r\nwhat we’re offering \r\ncould be useful to you.\r\n\r\nIf you do not wish to receive \r\nany more messages from us, \r\nplease click here to \r\nunsubscribe:\r\n\r\nhttps://kotel.site/unsub?domain=ziggynaturalceylon.com \r\nAddress: Address: 2673   Perksesteenweg 473, WLG  4280\r\nLooking out for you, Wilburn Swan.\r\n', '2026-01-28 09:28:57', 'unread'),
(11, 'Delbert Boggs', 'boggs.delbert@gmail.com', 'Stop lying to yourself. If you’re stuck selling one-off products, you aren’t a business owner—you’re a slave to the next sale. Every single month, your bank account resets to zero, and you’re forced back onto the \"entrepreneurial hamster wheel\". It’s exhausting, it\'s demoralizing, and it’s stealing your financial freedom.\r\nThe R.A.P.I.D. TimeShift™ System is your only way out. It is a \"set-it-and-forget-it\" blueprint designed to build predictable monthly income that deposits money into your account like clockwork.\r\n\r\nGet Out of the Trap Here: https://indianxvideos.site/RapidRecurringRevenue?domain=ziggynaturalceylon.com \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nYou are getting this email \r\nsince we think \r\nour offer \r\nmight be of interest to you.\r\n\r\nIf you would prefer not to receive \r\nadditional emails from us, \r\nyou can \r\nunsubscribe from these emails:\r\n\r\nhttps://indianxvideos.site/unsub?domain=ziggynaturalceylon.com \r\nAddress: Address: 2928   Golfskalinn 5, NA  310\r\nLooking out for you, Delbert Boggs.', '2026-01-29 04:14:02', 'unread'),
(12, 'Michael Williams', 'michaelswills2022@gmail.com', 'Greetings, Mr./Ms., \r\n \r\nI’m Michael Williams from an investment consultancy. We connect clients globally with low interest loans to help achieve your goals. Whether for personal, business or project funding, we collaborate with reputable investors to turn your proposals into reality. Share your business plan and executive summary with us at: michael.williams@lotusfinconsults.com to explore funding options. \r\n \r\nSincerely, Michael Williams \r\nSenior Financial Consultant \r\nhttp://www.lotusfinanceconsults.com/', '2026-01-30 04:15:56', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `hero_slides`
--

CREATE TABLE `hero_slides` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `subtitle` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `button_text` varchar(50) DEFAULT 'Explore Collection',
  `button_link` varchar(255) DEFAULT 'products',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_index` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero_slides`
--

INSERT INTO `hero_slides` (`id`, `image_path`, `subtitle`, `title`, `description`, `button_text`, `button_link`, `created_at`, `order_index`) VALUES
(2, 'assets/customers/1.JPG', 'Premium Ceylon Collection', 'Sip the Essence of <br>Nature\'s Purest', 'Experience the finest hand-picked organic tea and artisan coffee blends.', 'Explore Collection', 'products', '2026-01-23 07:08:23', 1),
(3, 'assets/1.PNG', 'Artisan Roasted Coffee', 'Awaken Your <br>Senses Today', 'Rich, aromatic, and bold coffee blends for the perfect morning ritual.', 'Shop Coffee', 'products', '2026-01-23 07:08:23', 2),
(4, 'assets/3.JPG', 'Wellness & Harmony', 'Discover the Art <br>of Fine Living', 'Curated gift sets and herbal blends to soothe your soul.', 'View Gifts', 'products', '2026-01-23 07:08:23', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(50) NOT NULL,
  `customer_address` text NOT NULL,
  `payment_method` enum('cod','bank_transfer') NOT NULL,
  `receipt_image` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_phone`, `customer_address`, `payment_method`, `receipt_image`, `total_amount`, `status`, `created_at`) VALUES
(1, 'sdfgdsfg', '0775014756', 'etgergt', 'cod', NULL, 1800.00, 'completed', '2026-01-21 16:33:14');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`) VALUES
(1, 1, 2, 'Ceylon Green Tea 100g', 3, 100.00),
(2, 1, 3, 'Ceylon Earl Grey Tea', 1, 1500.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(50) NOT NULL DEFAULT 'Ceylon Tea Collection'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock`, `description`, `image`, `created_at`, `category`) VALUES
(1, 'Ceylon Black Tea 100g', 380.00, 200, 'Pure Ceylon black tea with a rich aroma and strong flavor, perfect for daily drinking.', 'assets/uploads/1769626534_IMG_0750.jpeg', '2026-01-17 03:59:38', 'Ceylon Tea Collection'),
(2, 'Ceylon Green Peaces Tea 50g', 100.00, 40, 'Naturally fresh green tea made from hand-picked Ceylon tea leaves.', 'assets/uploads/1769626925_IMG_0752.jpeg', '2026-01-17 03:59:38', 'Ceylon Tea Collection'),
(3, 'Ceylon Earl Grey Tea', 500.00, 30, 'Premium Ceylon tea infused with natural bergamot flavor.', 'assets/uploads/1769139895_IMG_6724.png', '2026-01-17 03:59:38', 'Ceylon Tea Collection'),
(4, 'Ceylon Cinnamon Tea', 1400.00, 35, 'A warming blend of Ceylon tea and Sri Lankan cinnamon.', NULL, '2026-01-17 03:59:38', 'Ceylon Tea Collection'),
(5, 'Ceylon Premium Tea 200g', 2200.00, 25, 'High-quality loose leaf Ceylon tea for tea lovers.', NULL, '2026-01-17 03:59:38', 'Ceylon Tea Collection'),
(6, 'Ceylon Herbal Tea', 1600.00, 45, 'A soothing herbal tea blend made with natural ingredients.', NULL, '2026-01-17 03:59:38', 'Ceylon Tea Collection'),
(8, 'Ceylon Coffee 100g Craft Pack', 820.00, 300, 'Benefits of Ziggy Natural Ceylon Coffee\r\n🔋 Natural Energy & Alertness\r\n\r\nLike all quality coffee, it provides a gentle caffeine boost to help you start your day with focus, alertness, and sustained energy. Coffee naturally stimulates the central nervous system, which supports better mental clarity.\r\n\r\n💪 Rich in Antioxidants\r\n\r\nCeylon coffee beans are packed with antioxidants that help neutralize free radicals in the body — supporting overall wellbeing. Antioxidants in coffee contribute to reduced oxidative stress.\r\n\r\n❤️ Digestive Comfort\r\n\r\nCoffee can gently stimulate digestion and metabolism, making it a pleasant and natural part of your morning routine when enjoyed in moderation.\r\n\r\n☕ Authentic Taste Experience\r\n\r\nWith its smooth profile and balanced character, this coffee appeals to those who care about quality, terroir, and craftsmanship — not just caffeine.\r\n\r\n🎁 Perfect Gift Choice\r\n\r\nThe craft pack format makes it ideal as a thoughtful present for coffee lovers — whether for holidays, birthdays, or corporate gifting.', 'assets/uploads/1769662137_Coffee.jpg', '2026-01-17 03:59:38', 'Ceylon Coffee Collection'),
(9, 'Ceylon Premium Coffee Blend', 2000.00, 30, 'A balanced blend of premium Ceylon coffee beans.', 'assets/uploads/1768930734_IMG_6712.png', '2026-01-17 03:59:38', 'Ceylon Coffee Collection'),
(10, 'Ceylon Dark Roast Coffee', 2100.00, 20, 'Intense dark roasted coffee for strong coffee lovers.', NULL, '2026-01-17 03:59:38', 'Ceylon Coffee Collection'),
(11, 'Ceylon Medium Roast Coffee', 1950.00, 35, 'Perfectly roasted medium coffee with smooth flavor.', NULL, '2026-01-17 03:59:38', 'Ceylon Coffee Collection'),
(12, 'Ceylon Ground Coffee 250g', 2600.00, 25, 'Freshly ground Ceylon coffee ideal for home brewing.', NULL, '2026-01-17 03:59:38', 'Ceylon Coffee Collection'),
(13, 'Tea Lover Gift Pack', 3500.00, 20, 'A special gift pack with assorted Ceylon teas.', NULL, '2026-01-17 03:59:38', 'Gift Collection'),
(14, 'Coffee Lover Gift Pack', 3700.00, 20, 'A curated selection of premium Ceylon coffees.', NULL, '2026-01-17 03:59:38', 'Gift Collection'),
(15, 'Ceylon Tea & Coffee Combo', 4200.00, 15, 'A perfect combination of Ceylon tea and coffee.', NULL, '2026-01-17 03:59:38', 'Gift Collection'),
(16, 'Luxury Tea Gift Box', 5000.00, 10, 'An elegant gift box featuring luxury Ceylon tea blends.', NULL, '2026-01-17 03:59:38', 'Gift Collection'),
(17, 'Premium Coffee Gift Box', 5200.00, 10, 'High-end coffee gift set for true coffee enthusiasts.', NULL, '2026-01-17 03:59:38', 'Gift Collection'),
(18, 'Ceylon Heritage Gift Set', 6000.00, 8, 'A heritage-inspired gift set showcasing Sri Lankan flavors.', NULL, '2026-01-17 03:59:38', 'Gift Collection');

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `weight` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$c9TMu2m43cWb/04h7JaD4uYf.E2FOtMG31oV0IX40oDoJO20Q..fe', '2026-01-15 08:14:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero_slides`
--
ALTER TABLE `hero_slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hero_slides`
--
ALTER TABLE `hero_slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
