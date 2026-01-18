-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2026 at 05:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ziggy_natural`
--

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(50) NOT NULL DEFAULT 'Ceylon Tea Collection'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock`, `description`, `image`, `created_at`, `category`) VALUES
(1, 'Ceylon Black Tea 100g', 1200.00, 50, 'Pure Ceylon black tea with a rich aroma and strong flavor, perfect for daily drinking.', NULL, '2026-01-17 03:59:38', 'Ceylon Tea Collection'),
(2, 'Ceylon Green Tea 100g', 1300.00, 40, 'Naturally fresh green tea made from hand-picked Ceylon tea leaves.', NULL, '2026-01-17 03:59:38', 'Ceylon Tea Collection'),
(3, 'Ceylon Earl Grey Tea', 1500.00, 30, 'Premium Ceylon tea infused with natural bergamot flavor.', NULL, '2026-01-17 03:59:38', 'Ceylon Tea Collection'),
(4, 'Ceylon Cinnamon Tea', 1400.00, 35, 'A warming blend of Ceylon tea and Sri Lankan cinnamon.', NULL, '2026-01-17 03:59:38', 'Ceylon Tea Collection'),
(5, 'Ceylon Premium Tea 200g', 2200.00, 25, 'High-quality loose leaf Ceylon tea for tea lovers.', NULL, '2026-01-17 03:59:38', 'Ceylon Tea Collection'),
(6, 'Ceylon Herbal Tea', 1600.00, 45, 'A soothing herbal tea blend made with natural ingredients.', NULL, '2026-01-17 03:59:38', 'Ceylon Tea Collection'),
(7, 'Ceylon Arabica Coffee 100g', 1800.00, 40, 'Smooth and aromatic Arabica coffee grown in Sri Lanka.', NULL, '2026-01-17 03:59:38', 'Ceylon Coffee Collection'),
(8, 'Ceylon Robusta Coffee 100g', 1700.00, 50, 'Strong and bold Robusta coffee with a rich taste.', NULL, '2026-01-17 03:59:38', 'Ceylon Coffee Collection'),
(9, 'Ceylon Premium Coffee Blend', 2000.00, 30, 'A balanced blend of premium Ceylon coffee beans.', NULL, '2026-01-17 03:59:38', 'Ceylon Coffee Collection'),
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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
