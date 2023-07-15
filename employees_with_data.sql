-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2023 at 10:06 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emp_manager_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `dateEmployed` timestamp NOT NULL DEFAULT current_timestamp(),
  `position` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `salary`, `dateEmployed`, `position`, `status`, `timestamp`) VALUES
(1, 'John Doe', '58950.00', '2023-06-10 02:30:00', 'Developer', 1, '2023-06-10 05:34:56'),
(2, 'Jane Smith', '74639.00', '2023-06-10 03:15:00', 'Salesperson', 0, '2023-06-10 05:34:56'),
(3, 'David Johnson', '82105.00', '2023-06-10 04:45:00', 'Designer', 1, '2023-06-10 05:34:56'),
(4, 'Emily Wilson', '67215.00', '2023-06-10 06:20:00', 'Manager', 0, '2023-06-10 05:34:56'),
(5, 'Michael Brown', '41283.00', '2023-06-10 07:55:00', 'Administrator', 1, '2023-06-10 05:34:56'),
(6, 'Olivia Davis', '93545.00', '2023-06-10 09:40:00', 'Developer', 1, '2023-06-10 05:34:56'),
(7, 'William Johnson', '68951.00', '2023-06-10 11:25:00', 'Salesperson', 1, '2023-06-10 05:34:56'),
(8, 'Sophia Miller', '52684.00', '2023-06-10 13:10:00', 'Designer', 0, '2023-06-10 05:34:56'),
(9, 'Alexander Wilson', '78213.00', '2023-06-10 02:30:00', 'Developer', 1, '2023-06-10 05:34:56'),
(10, 'Emma Davis', '63952.00', '2023-06-10 03:15:00', 'Salesperson', 0, '2023-06-10 05:34:56'),
(11, 'James Johnson', '71495.00', '2023-06-10 04:45:00', 'Designer', 1, '2023-06-10 05:34:56'),
(12, 'Oliver Smith', '57639.00', '2023-06-10 06:20:00', 'Manager', 0, '2023-06-10 05:34:56'),
(13, 'Charlotte Wilson', '42971.00', '2023-06-10 07:55:00', 'Administrator', 1, '2023-06-10 05:34:56'),
(14, 'Liam Davis', '89546.00', '2023-06-10 09:40:00', 'Developer', 1, '2023-06-10 05:34:56'),
(15, 'Isabella Johnson', '65284.00', '2023-06-10 11:25:00', 'Salesperson', 1, '2023-06-10 05:34:56'),
(16, 'Mason Smith', '71951.00', '2023-06-10 13:10:00', 'Designer', 0, '2023-06-10 05:34:56'),
(17, 'Amelia Miller', '54526.00', '2023-06-10 02:30:00', 'Developer', 1, '2023-06-10 05:34:56'),
(18, 'Henry Wilson', '78962.00', '2023-06-10 03:15:00', 'Salesperson', 0, '2023-06-10 05:34:56'),
(19, 'Ava Davis', '61653.00', '2023-06-10 04:45:00', 'Designer', 1, '2023-06-10 05:34:56'),
(20, 'Oliver Smith', '75418.00', '2023-06-10 06:20:00', 'Manager', 0, '2023-06-10 05:34:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
