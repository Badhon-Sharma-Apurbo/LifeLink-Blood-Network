-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2026 at 10:40 PM
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
-- Database: `lifelink_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood_inventory`
--

CREATE TABLE `blood_inventory` (
  `Inventory_ID` int(11) NOT NULL,
  `Hospital_ID` int(11) DEFAULT NULL,
  `Blood_Type` varchar(5) NOT NULL,
  `Units_Available` int(11) DEFAULT 0,
  `Last_Updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_inventory`
--

INSERT INTO `blood_inventory` (`Inventory_ID`, `Hospital_ID`, `Blood_Type`, `Units_Available`, `Last_Updated`) VALUES
(1, 1, 'O+', 10, '2026-05-15 12:50:57'),
(2, 1, 'A+', 8, '2026-05-15 08:30:10'),
(3, 1, 'B+', 0, '2026-05-15 08:30:10'),
(4, 2, 'O+', 10, '2026-05-15 08:30:10'),
(5, 2, 'AB-', 2, '2026-05-15 08:30:10'),
(6, 2, 'O-', 5, '2026-05-15 08:30:10'),
(7, 3, 'B+', 12, '2026-05-15 08:30:10'),
(8, 3, 'A-', 4, '2026-05-15 08:30:10'),
(9, 4, 'O+', 5, '2026-05-15 08:30:10'),
(10, 4, 'B-', 3, '2026-05-15 08:30:10'),
(11, 5, 'A+', 18, '2026-05-15 14:03:11'),
(12, 5, 'AB+', 7, '2026-05-15 08:30:10'),
(13, 6, 'O-', 1, '2026-05-15 08:30:10');

-- --------------------------------------------------------

--
-- Table structure for table `blood_requests`
--

CREATE TABLE `blood_requests` (
  `Request_ID` int(11) NOT NULL,
  `Requesting_Hospital_ID` int(11) DEFAULT NULL,
  `Target_Hospital_ID` int(11) DEFAULT NULL,
  `Blood_Type` varchar(5) NOT NULL,
  `Units_Requested` int(11) NOT NULL,
  `Request_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Request_Status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_requests`
--

INSERT INTO `blood_requests` (`Request_ID`, `Requesting_Hospital_ID`, `Target_Hospital_ID`, `Blood_Type`, `Units_Requested`, `Request_Date`, `Request_Status`) VALUES
(1, 2, 1, 'O+', 5, '2026-05-15 12:50:57', 'Fulfilled'),
(2, 3, 1, 'O+', 50, '2026-05-15 12:51:44', 'Failed - Low Stock'),
(3, 1, 5, 'A+', 2, '2026-05-15 14:03:11', 'Fulfilled');

-- --------------------------------------------------------

--
-- Table structure for table `donation_history`
--

CREATE TABLE `donation_history` (
  `Donation_ID` int(11) NOT NULL,
  `Donor_ID` int(11) DEFAULT NULL,
  `Hospital_ID` int(11) DEFAULT NULL,
  `Donation_Date` date NOT NULL,
  `Units_Donated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_history`
--

INSERT INTO `donation_history` (`Donation_ID`, `Donor_ID`, `Hospital_ID`, `Donation_Date`, `Units_Donated`) VALUES
(1, 3, 3, '2026-04-20', 1),
(2, 6, 5, '2026-04-25', 1),
(3, 8, 2, '2026-04-28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `Donor_ID` int(11) NOT NULL,
  `Full_Name` varchar(255) NOT NULL,
  `Blood_Type` varchar(5) NOT NULL,
  `City_Location` varchar(100) NOT NULL,
  `Contact_Number` varchar(20) NOT NULL,
  `Last_Donation_Date` date DEFAULT NULL,
  `Eligibility_Status` varchar(20) DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`Donor_ID`, `Full_Name`, `Blood_Type`, `City_Location`, `Contact_Number`, `Last_Donation_Date`, `Eligibility_Status`) VALUES
(1, 'Antor Rahman', 'O+', 'Dhaka', '01700111222', '2025-12-01', 'Available'),
(2, 'Earnest Aranya', 'A+', 'Dhaka', '01700222333', '2026-01-15', 'Available'),
(3, 'Nusrat Jahan', 'B+', 'Chittagong', '01800333444', '2026-03-10', 'Available'),
(4, 'Sabbir Hossain', 'O-', 'Rajshahi', '01900444555', '2025-11-20', 'Available'),
(5, 'Rehan Hasan', 'AB+', 'Dhaka', '01700555666', NULL, 'Available'),
(6, 'Medha Khatun', 'A-', 'Sylhet', '01600666777', '2026-02-28', 'Available'),
(7, 'Sunny Kayem', 'B-', 'Khulna', '01500777888', NULL, 'Available'),
(8, 'Ayesha Siddiqua', 'AB-', 'Dhaka', '01700888999', '2026-04-05', 'Available'),
(9, 'Ratin Hasan', 'O+', 'Chittagong', '01800999000', NULL, 'Available'),
(10, 'Farhana Yasmin', 'O-', 'Dhaka', '01700123123', '2026-03-20', 'Available'),
(11, 'APURBO SHARMA ', 'O+', 'SYLHET', '01723456765', NULL, 'Available'),
(12, 'Tahmid Ropuk ', 'AB-', 'Barishal', '01973456769', NULL, 'Available'),
(13, 'Zubayer Al-Mahmud', 'O+', 'Dhaka', '01711000111', NULL, 'Available'),
(14, 'Tahmina Akter', 'B+', 'Chittagong', '01822000222', NULL, 'Available'),
(15, 'Samiul Islam', 'A-', 'Sylhet', '01933000333', NULL, 'Available'),
(16, 'Ishrat Jahan', 'AB+', 'Dhaka', '01644000444', NULL, 'Available'),
(17, 'Nahid Hasan', 'O-', 'Rajshahi', '01555000555', NULL, 'Available'),
(18, 'Farhana Yasmin', 'B-', 'Khulna', '01766000666', NULL, 'Available'),
(19, 'Abidur Rahman', 'A+', 'Barisal', '01877000777', NULL, 'Available'),
(20, 'Niaz Morshed', 'O+', 'Comilla', '01988000888', NULL, 'Available'),
(21, 'Maliha Tabassum', 'AB-', 'Dhaka', '01699000999', NULL, 'Available'),
(22, 'Rezwan Ahmed', 'B+', 'Mymensingh', '01500111222', NULL, 'Available'),
(23, 'Sadia Afrin', 'O-', 'Gazipur', '01712345678', NULL, 'Available'),
(24, 'Tanzeem Ul Islam', 'A-', 'Rangpur', '01823456789', NULL, 'Available'),
(25, 'Kazi Mushfiq', 'B-', 'Jessore', '01934567890', NULL, 'Available'),
(26, 'Sumaiya Shafi', 'O+', 'Dhaka', '01645678901', NULL, 'Available'),
(27, 'Hasan Al-Banna', 'A+', 'Bogura', '01556789012', NULL, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `Hospital_ID` int(11) NOT NULL,
  `Hospital_Name` varchar(255) NOT NULL,
  `Region` varchar(100) NOT NULL,
  `Contact_Number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`Hospital_ID`, `Hospital_Name`, `Region`, `Contact_Number`) VALUES
(1, 'Dhaka Medical College Hospital', 'Dhaka', '01711223344'),
(2, 'Evercare Hospital', 'Dhaka', '01711556677'),
(3, 'Chittagong Medical College', 'Chittagong', '01811889900'),
(4, 'Rajshahi Medical College', 'Rajshahi', '01911224466'),
(5, 'Sylhet MAG Osmani Medical', 'Sylhet', '01611335577'),
(6, 'Khulna City Medical', 'Khulna', '01511446688');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  ADD PRIMARY KEY (`Inventory_ID`),
  ADD KEY `Hospital_ID` (`Hospital_ID`);

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`Request_ID`),
  ADD KEY `Requesting_Hospital_ID` (`Requesting_Hospital_ID`),
  ADD KEY `Target_Hospital_ID` (`Target_Hospital_ID`);

--
-- Indexes for table `donation_history`
--
ALTER TABLE `donation_history`
  ADD PRIMARY KEY (`Donation_ID`),
  ADD KEY `Donor_ID` (`Donor_ID`),
  ADD KEY `Hospital_ID` (`Hospital_ID`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`Donor_ID`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`Hospital_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  MODIFY `Inventory_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `blood_requests`
--
ALTER TABLE `blood_requests`
  MODIFY `Request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `donation_history`
--
ALTER TABLE `donation_history`
  MODIFY `Donation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `Donor_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `Hospital_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  ADD CONSTRAINT `blood_inventory_ibfk_1` FOREIGN KEY (`Hospital_ID`) REFERENCES `hospitals` (`Hospital_ID`) ON DELETE CASCADE;

--
-- Constraints for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD CONSTRAINT `blood_requests_ibfk_1` FOREIGN KEY (`Requesting_Hospital_ID`) REFERENCES `hospitals` (`Hospital_ID`),
  ADD CONSTRAINT `blood_requests_ibfk_2` FOREIGN KEY (`Target_Hospital_ID`) REFERENCES `hospitals` (`Hospital_ID`);

--
-- Constraints for table `donation_history`
--
ALTER TABLE `donation_history`
  ADD CONSTRAINT `donation_history_ibfk_1` FOREIGN KEY (`Donor_ID`) REFERENCES `donors` (`Donor_ID`),
  ADD CONSTRAINT `donation_history_ibfk_2` FOREIGN KEY (`Hospital_ID`) REFERENCES `hospitals` (`Hospital_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
