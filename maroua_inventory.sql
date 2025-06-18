-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2025 at 03:05 AM
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
-- Database: `maroua_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `supplier_id`, `user_id`, `created_at`, `status`, `total`) VALUES
(1, NULL, NULL, '2025-06-01 09:00:00', 'pending', 100.00),
(2, NULL, NULL, '2025-06-02 10:00:00', 'completed', 300.00),
(3, NULL, NULL, '2025-06-03 11:00:00', 'pending', 150.00),
(4, NULL, NULL, '2025-06-04 12:00:00', 'completed', 400.00),
(5, NULL, NULL, '2025-06-05 13:00:00', 'pending', 250.00),
(6, NULL, NULL, '2025-06-06 14:00:00', 'completed', 180.00),
(7, NULL, NULL, '2025-06-07 15:00:00', 'pending', 220.00),
(8, NULL, NULL, '2025-06-08 16:00:00', 'completed', 350.00),
(9, NULL, NULL, '2025-06-09 17:00:00', 'pending', 130.00),
(10, NULL, NULL, '2025-06-10 18:00:00', 'completed', 275.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 5),
(2, 1, 2, 3),
(3, 2, 3, 10),
(4, 2, 4, 8),
(5, 3, 5, 7),
(6, 3, 6, 5),
(7, 4, 7, 12),
(8, 4, 8, 4),
(9, 5, 9, 6),
(10, 5, 10, 5),
(11, 6, 1, 8),
(12, 6, 3, 6),
(13, 7, 2, 7),
(14, 7, 4, 9),
(15, 8, 5, 11),
(16, 8, 6, 7),
(17, 9, 7, 3),
(18, 9, 8, 8),
(19, 10, 9, 10),
(20, 10, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `supplier_id`, `price`, `stock`, `created_at`) VALUES
(1, 'Product A', 6, 10.00, 100, '2025-06-18 00:34:04'),
(2, 'Product B', 6, 12.50, 80, '2025-06-18 00:34:04'),
(3, 'Product C', 7, 8.75, 150, '2025-06-18 00:34:04'),
(4, 'Product D', 7, 15.00, 60, '2025-06-18 00:34:04'),
(5, 'Product E', 8, 20.00, 200, '2025-06-18 00:34:04'),
(6, 'Product F', 9, 5.00, 300, '2025-06-18 00:34:04'),
(7, 'Product G', 10, 7.50, 120, '2025-06-18 00:34:04'),
(8, 'Product H', 11, 22.00, 90, '2025-06-18 00:34:04'),
(9, 'Product I', 12, 18.00, 110, '2025-06-18 00:34:04'),
(10, 'Product J', 13, 9.99, 75, '2025-06-18 00:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_name`, `created_at`, `total`) VALUES
(1, 'Customer Alpha', '2025-06-01 09:30:00', 50.00),
(2, 'Customer Beta', '2025-06-02 10:30:00', 75.00),
(3, 'Customer Gamma', '2025-06-03 11:30:00', 60.00),
(4, 'Customer Delta', '2025-06-04 12:30:00', 120.00),
(5, 'Customer Epsilon', '2025-06-05 13:30:00', 90.00),
(6, 'Customer Zeta', '2025-06-06 14:30:00', 110.00),
(7, 'Customer Eta', '2025-06-07 15:30:00', 40.00),
(8, 'Customer Theta', '2025-06-08 16:30:00', 95.00),
(9, 'Customer Iota', '2025-06-09 17:30:00', 130.00),
(10, 'Customer Kappa', '2025-06-10 18:30:00', 85.00);

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 2, 10.00),
(2, 1, 2, 3, 12.50),
(3, 2, 3, 5, 8.75),
(4, 2, 4, 2, 15.00),
(5, 3, 5, 4, 20.00),
(6, 3, 6, 1, 5.00),
(7, 4, 7, 6, 7.50),
(8, 4, 8, 2, 22.00),
(9, 5, 9, 3, 18.00),
(10, 5, 10, 2, 9.99),
(11, 6, 1, 4, 10.00),
(12, 6, 3, 3, 8.75),
(13, 7, 2, 2, 12.50),
(14, 7, 4, 5, 15.00),
(15, 8, 5, 7, 20.00),
(16, 8, 6, 2, 5.00),
(17, 9, 7, 3, 7.50),
(18, 9, 8, 4, 22.00),
(19, 10, 9, 5, 18.00),
(20, 10, 10, 1, 9.99);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_name` varchar(100) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_name`, `contact_email`, `phone`, `address`, `contact`, `email`, `created_at`) VALUES
(6, 'Alpha Supplies', 'John Doe', 'contact@alphasupplies.com', '+1-555-1001', '123 Main St, Cityville', 'John Doe, 123 Main St, Cityville, +1-555-1001', 'contact@alphasupplies.com', '2025-06-18 00:35:34'),
(7, 'Beta Distributors', 'Jane Smith', 'info@betadistributors.com', '+1-555-1002', '456 Elm St, Townsburg', 'Jane Smith, 456 Elm St, Townsburg, +1-555-1002', 'info@betadistributors.com', '2025-06-18 00:35:34'),
(8, 'Gamma Wholesale', 'Mike Brown', 'sales@gammawholesale.com', '+1-555-1003', '789 Oak Ave, Villagefield', 'Mike Brown, 789 Oak Ave, Villagefield, +1-555-1003', 'sales@gammawholesale.com', '2025-06-18 00:35:34'),
(9, 'Delta Traders', 'Emily White', 'support@deltatraders.com', '+1-555-1004', '321 Pine Rd, Hamlet', 'Emily White, 321 Pine Rd, Hamlet, +1-555-1004', 'support@deltatraders.com', '2025-06-18 00:35:34'),
(10, 'Epsilon Importers', 'Chris Green', 'orders@epsilonimporters.com', '+1-555-1005', '654 Cedar Blvd, Metropolis', 'Chris Green, 654 Cedar Blvd, Metropolis, +1-555-1005', 'orders@epsilonimporters.com', '2025-06-18 00:35:34'),
(11, 'Zeta Logistics', 'Sarah Black', 'logistics@zetalogistics.com', '+1-555-1006', '987 Maple Ln, Capital City', 'Sarah Black, 987 Maple Ln, Capital City, +1-555-1006', 'logistics@zetalogistics.com', '2025-06-18 00:35:34'),
(12, 'Eta Global', 'David Blue', 'service@etaglobal.com', '+1-555-1007', '246 Birch Dr, Riverside', 'David Blue, 246 Birch Dr, Riverside, +1-555-1007', 'service@etaglobal.com', '2025-06-18 00:35:34'),
(13, 'Theta Enterprises', 'Laura Red', 'hello@thetaenterprises.com', '+1-555-1008', '135 Spruce Ct, Hilltown', 'Laura Red, 135 Spruce Ct, Hilltown, +1-555-1008', 'hello@thetaenterprises.com', '2025-06-18 00:35:34'),
(14, 'Iota Partners', 'Tom Yellow', 'contact@iotapartners.com', '+1-555-1009', '864 Willow Way, Lakeview', 'Tom Yellow, 864 Willow Way, Lakeview, +1-555-1009', 'contact@iotapartners.com', '2025-06-18 00:35:34'),
(15, 'Kappa Ventures', 'Anna Purple', 'partners@kappaventures.com', '+1-555-1010', '579 Aspen Pl, Forestside', 'Anna Purple, 579 Aspen Pl, Forestside, +1-555-1010', 'partners@kappaventures.com', '2025-06-18 00:35:34'),
(16, 'mohamed aymane elachri', 'mohamed aymane elachri', 'satayman41@gmail.com', '0707407425', 'tangier birchifa', NULL, NULL, '2025-06-18 00:38:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'manager',
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `status`, `password`, `created_at`) VALUES
(6, 'Admin', 'admin@demo.com', 'admin', 'active', '$2y$10$e0NRn1z9w2rM8Z1/0QqP0uIu0wKjW1iC1kJ8f6F5sT8u8w9F4Qk0O', '2025-06-18 00:34:04'),
(7, 'Manager One', 'manager1@demo.com', 'manager', 'active', '$2y$10$e0NRn1z9w2rM8Z1/0QqP0uIu0wKjW1iC1kJ8f6F5sT8u8w9F4Qk0O', '2025-06-18 00:34:04'),
(8, 'Supplier User', 'supplier@demo.com', 'supplier', 'active', '$2y$10$e0NRn1z9w2rM8Z1/0QqP0uIu0wKjW1iC1kJ8f6F5sT8u8w9F4Qk0O', '2025-06-18 00:34:04'),
(9, 'Inactive User', 'inactive@demo.com', 'manager', 'inactive', '$2y$10$e0NRn1z9w2rM8Z1/0QqP0uIu0wKjW1iC1kJ8f6F5sT8u8w9F4Qk0O', '2025-06-18 00:34:04'),
(10, 'Ayman', 'test@aymna.com', 'admin', 'active', '$2y$10$wQoIUrEdQMYa..p6Ud82weMR9g9W1XLvR4GpW3jOISSN2JX/0J052', '2025-06-18 00:34:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `fk_orders_user` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
