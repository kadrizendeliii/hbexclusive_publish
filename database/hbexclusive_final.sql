-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2026 at 03:42 PM
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
-- Database: `hbexclusive`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `description`, `created_at`) VALUES
(1, 'Doors', NULL, '2026-01-03 22:48:29'),
(2, 'entry doors', NULL, '2026-01-03 22:53:14'),
(3, 'laminate', NULL, '2026-01-03 23:00:11'),
(4, 'Doors', NULL, '2026-01-03 23:04:13'),
(6, 'Windows', NULL, '2026-01-03 23:04:13'),
(7, 'wooden doors', NULL, '2026-01-03 23:08:13'),
(8, 'wooden doors', NULL, '2026-01-04 10:36:06'),
(9, 'steel doors', NULL, '2026-01-04 10:51:11'),
(10, 'steel doors', NULL, '2026-01-04 10:53:22'),
(11, 'steel doors', NULL, '2026-01-04 10:56:24'),
(12, 'steel doors', NULL, '2026-01-04 10:58:40'),
(13, 'steel doors', NULL, '2026-01-04 10:59:45'),
(14, 'steel doors', NULL, '2026-01-04 11:02:02'),
(16, 'aome door', NULL, '2026-01-04 11:05:35'),
(17, 'aome door', NULL, '2026-01-04 11:07:55'),
(21, 'many doors', NULL, '2026-01-04 11:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `total_amount`, `status`, `created_at`) VALUES
(1, 'kadri zendeli', 123.00, 'Cancelled', '2026-01-04 18:22:32'),
(2, '31233212131212 312312', 321.00, 'Cancelled', '2026-01-04 18:23:59'),
(3, 'boss si', 369.00, 'Completed', '2026-01-04 18:28:10'),
(4, 'easdasdaasd dadaaadssaa', 8642.00, 'Cancelled', '2026-01-04 18:41:29'),
(5, 'bosii gango', 246.00, 'Cancelled', '2026-01-07 15:26:53'),
(6, 'hamit zendeli', 1107.00, 'Completed', '2026-01-07 16:01:36'),
(7, 'BADER SMARTER', 8642.00, 'Completed', '2026-01-07 16:08:18'),
(8, 'abe halis a jkas', 246.00, 'Completed', '2026-01-07 16:10:17'),
(9, 'afssafd sadfsffs', 321.00, 'Completed', '2026-01-07 16:10:51'),
(10, 'Kadri Zendlei', 738.00, 'Pending', '2026-02-15 12:41:31'),
(11, 'kadro zendo', 642.00, 'Pending', '2026-02-15 12:44:30'),
(12, 'kadro zendo', 642.00, 'Completed', '2026-02-15 12:44:33'),
(13, 'kadro zendo', 642.00, 'Completed', '2026-02-15 12:44:33'),
(14, 'Kadri Zendlei', 369.00, 'Completed', '2026-02-15 12:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(1, 1, 5, 1, 123.00),
(2, 2, 4, 1, 321.00),
(3, 3, 5, 3, 123.00),
(4, 4, 3, 2, 4321.00),
(5, 5, 2, 2, 123.00),
(6, 6, 2, 9, 123.00),
(7, 7, 3, 2, 4321.00),
(8, 8, 2, 2, 123.00),
(9, 9, 4, 1, 321.00),
(10, 10, 5, 6, 123.00),
(11, 11, 4, 2, 321.00),
(12, 12, 4, 2, 321.00),
(13, 13, 4, 2, 321.00),
(14, 14, 1, 3, 123.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `category_id`, `image_url`, `created_at`, `quantity`) VALUES
(1, 'door wood', 123.00, 7, 'uploads/1767481726_Aston-Martin Valkyrie.webp', '2026-01-03 23:08:46', 25),
(2, 'door ba;ck', 123.00, 6, 'uploads/1767534016_Bugatti Divo.webp', '2026-01-04 13:40:16', 9),
(3, 'wqjbjlb', 4321.00, 6, 'uploads/1767534088_Bugatti Chiron Super Sport 300+.webp', '2026-01-04 13:41:28', 19),
(4, 'product', 321.00, 13, 'uploads/1767534199_About us enzo.webp', '2026-01-04 13:43:19', 2),
(5, 'yesssboss', 123.00, 16, 'uploads/1767990341_IMG_0200.jpeg', '2026-01-04 14:00:28', 96);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'kadri', 'kadri@gmail.com', '$2y$10$jJB.dXL1TlGDU1AlgXcVuOVUijejM4CIU9DDzMmkkprLYforRrO0O', 'user', '2026-02-05 15:33:12'),
(2, 'test', 'test@test.com', '$2y$10$2IE2aTJRMxQByQOu/uV7WuxdP4gOkA5sOXtBKG5lA/b2r/bMi69OW', 'admin', '2026-02-05 15:44:08'),
(3, 'Administrator', 'admin@hbexclusive.com', '$2y$10$qHgfRunBt4ztU2E529i3x.UHI8wnaaGeJEalJBvNA5Dn41.OCuai.', 'admin', '2026-02-05 15:45:18'),
(4, 'user', 'user@gmail.com', '$2y$10$yqApJ5UtuyddRxShTQQcz.Xgb.soF7lD6bsv6/GkNtkm9jKAEoXmu', 'user', '2026-02-15 10:35:10'),
(5, 'Kadri Zendeli', 'kadrizendeli759@gmail.com', '$2y$10$cjhmi4Z3IAq5Fo87N8ol0.09laRfExGVaJKnNEfsE/sEsQAqz35KG', 'admin', '2026-02-15 11:41:26'),
(6, 'newuser', 'user123@gmail.com', '$2y$10$U4QkeUXpV6dR/qJnj.ZuYu36i.7Gt77XB57M/MIVLaTlG7PCi/1rC', 'user', '2026-02-16 19:17:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
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
  ADD KEY `fk_order` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
