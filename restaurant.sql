-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2023 at 07:10 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(4) NOT NULL,
  `menu_item_id` int(4) NOT NULL,
  `qty` int(4) NOT NULL,
  `price` int(4) NOT NULL,
  `subtotal` int(4) NOT NULL,
  `status` varchar(50) NOT NULL,
  `order_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `customer_id`, `menu_item_id`, `qty`, `price`, `subtotal`, `status`, `order_id`) VALUES
(20, 9, 4, 1, 250, 250, 'process', 10),
(21, 9, 5, 2, 190, 380, 'process', 10),
(22, 9, 4, 1, 250, 250, 'process', 11),
(23, 9, 9, 2, 299, 598, 'process', 11),
(24, 9, 4, 1, 250, 250, 'process', 12),
(26, 9, 3, 2, 120, 240, 'reject', 13),
(27, 9, 2, 1, 200, 200, 'reject', 13),
(28, 9, 4, 1, 250, 250, 'process', 14),
(29, 9, 6, 1, 200, 200, 'process', 15),
(30, 9, 3, 2, 120, 240, 'process', 16),
(31, 9, 4, 1, 250, 250, 'process', 16),
(32, 9, 3, 6, 120, 720, 'process', 17),
(33, 9, 4, 1, 250, 250, 'process', 17),
(34, 9, 3, 1, 120, 120, 'process', 18),
(35, 9, 4, 1, 250, 250, 'draft', 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `image`) VALUES
(23, 'Chinese', '/restaurants/uploads/category/Chinese-1690694115.jpeg'),
(24, 'Punjabi', '/restaurants/uploads/category/Punjabi-1690654853.jpg'),
(31, 'Italian', '/restaurants/uploads/category/Italian-1691300824.jpg'),
(32, 'North-Indian', '/restaurants/uploads/category/North Indian-1691339381.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `pincode` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `fname`, `lname`, `email`, `phone_number`, `pincode`, `password`, `is_admin`) VALUES
(9, 'Satyam', 'Gangani', 'satyam@gmail.com', '8899776677', 3567887, '$2y$10$YuPkHi288Mm8F6ojUYT/geghUFxFFfqy7DT9o9cyAkNoCIhiRse7u', 1),
(10, 'Vishva', 'B', 'vishva@gmail.com', '8899009988', 667788, '$2y$10$fO7ViZtJNkHYjQU9ZnLuBeU58MsO3wGj62AFc8hpB9aobUzU.YZiu', 0),
(11, 'Bhavin', 'Vasavada', 'bhavin1@gmail.com', '1236547896', 365214, '$2y$10$7CRCqHDA.dDluAxrnNI9dO161B46XDEr1DF7eGJEzfxkW1dmWsl.W', 1),
(12, 'Nayan', 'Suhagiya', 'nayan1@gmail.com', '1236547896', 123654, '$2y$10$Y6LFAQNxYh1Xb.mN/SlgFuDojC9PrqCloK0dIjoUh/jQAU2sFGqaa', 0),
(13, 'Utsav', 'Parmar', 'utsav1@gmail.com', '1236547896', 123654, '$2y$10$U4hut/dGacdelgqULW3kNO5/zpbH9i731JsagfQNw6grhj7wpn0hm', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `id` int(11) NOT NULL,
  `customer_id` int(4) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`id`, `customer_id`, `date`, `status`) VALUES
(10, 9, '2023-08-15 20:04:26', 'done'),
(11, 9, '2023-08-15 21:09:48', 'done'),
(12, 9, '2023-08-15 21:10:37', 'done'),
(13, 9, '2023-08-15 21:28:56', 'reject'),
(14, 9, '2023-08-15 21:32:09', 'done'),
(15, 9, '2023-08-15 21:34:36', 'done'),
(16, 9, '2023-08-15 21:37:22', 'done'),
(17, 9, '2023-08-15 22:35:58', 'done'),
(18, 9, '2023-08-15 22:36:30', 'process');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE `menu_item` (
  `id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `detail` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`id`, `item_name`, `category_id`, `price`, `qty`, `image`, `detail`) VALUES
(2, 'Margheritta Pizza', 31, 200, 24, '/restaurants/uploads/menu_item/Margheritta Pizza-1691302754.jpeg', 'Serves 2 Person'),
(3, 'Manchurian', 23, 120, 6, '/restaurants/uploads/menu_item/Manchurian-1691302815.jpeg', 'Serves 1 Person'),
(4, 'Hakka Noodles', 23, 250, 10, '/restaurants/uploads/menu_item/Hakka Noodles-1691307365.jpeg', 'Long amazing noodles'),
(5, 'Schezwan Noodles', 23, 190, 20, '/restaurants/uploads/menu_item/Schezwan Noodles-1691307403.jpeg', 'Spicy noodles. Serves 1 Person'),
(6, 'Chinese Bhel', 23, 200, 30, '/restaurants/uploads/menu_item/Chinese Bhel-1691307462.jpeg', 'Serves 1 Person'),
(7, 'Tawa Paneer', 24, 300, 14, '/restaurants/uploads/menu_item/Tawa Paneer-1691308674.jpeg', 'Serves 1 Person'),
(8, 'Cheesy Pizza', 31, 450, 29, '/restaurants/uploads/menu_item/Cheesy Pizza-1691339319.jpeg', 'Serves 3 person'),
(9, 'Paneer Tikka Rice Bowl', 32, 299, 10, '/restaurants/uploads/menu_item/Paneer Tikka Rice Bowl-1691339521.jpeg', 'Serves 2 Person');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
