-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2026 at 01:37 AM
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
-- Database: `gym_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `attendance_date` date DEFAULT NULL,
  `status` enum('Present','Absent') NOT NULL DEFAULT 'Present',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `member_id`, `check_in`, `check_out`, `attendance_date`, `status`, `created_at`) VALUES
(12, 4, '2026-06-23 18:06:26', '2026-06-23 18:06:52', '2026-06-23', 'Present', '2026-06-23 15:06:26'),
(13, 5, NULL, NULL, '2026-06-23', 'Absent', '2026-06-23 15:12:27'),
(14, 6, NULL, '2026-06-23 23:20:24', '2026-06-23', 'Absent', '2026-06-23 20:19:23'),
(15, 6, NULL, '2026-06-23 23:20:24', '2026-06-23', 'Absent', '2026-06-23 20:19:23'),
(16, 6, '2026-06-24 11:21:53', '2026-06-24 12:33:04', '2026-06-24', 'Present', '2026-06-24 08:21:53'),
(17, 8, '2026-06-24 19:52:34', '2026-06-24 19:52:45', '2026-06-24', 'Present', '2026-06-24 16:52:34'),
(18, 10, NULL, NULL, '2026-06-24', 'Absent', '2026-06-24 16:52:54'),
(19, 10, NULL, NULL, '2026-06-24', 'Absent', '2026-06-24 16:52:54'),
(20, 9, NULL, NULL, '2026-06-24', 'Absent', '2026-06-24 16:53:13'),
(21, 9, NULL, NULL, '2026-06-24', 'Absent', '2026-06-24 16:53:13'),
(22, 12, NULL, NULL, '2026-06-25', 'Absent', '2026-06-25 17:46:41'),
(23, 12, NULL, NULL, '2026-06-25', 'Absent', '2026-06-25 17:46:41'),
(24, 5, NULL, NULL, '2026-06-25', 'Absent', '2026-06-25 21:05:47'),
(25, 8, NULL, NULL, '2026-06-25', 'Absent', '2026-06-25 21:07:03'),
(26, 8, NULL, NULL, '2026-06-25', 'Absent', '2026-06-25 21:07:03'),
(28, 4, '2026-06-26 01:25:45', '2026-06-26 01:26:16', '2026-06-26', 'Present', '2026-06-25 22:25:45');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `instructor` varchar(100) DEFAULT NULL,
  `schedule` datetime DEFAULT NULL,
  `capacity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diet_plans`
--

CREATE TABLE `diet_plans` (
  `id` int(11) NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `plan_name` varchar(100) DEFAULT NULL,
  `calories` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `meals` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `member_code` varchar(50) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `emergency_contact` varchar(20) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('Active','Expired','Suspended') DEFAULT 'Active',
  `plan_amount` decimal(10,2) DEFAULT 0.00,
  `amount_paid` decimal(10,2) DEFAULT 0.00,
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `member_code`, `fullname`, `gender`, `dob`, `phone`, `email`, `address`, `emergency_contact`, `plan_id`, `join_date`, `expiry_date`, `photo`, `status`, `plan_amount`, `amount_paid`, `balance`) VALUES
(4, '8151353e-6e74-11f1-ae6c-c8940232abb4', 'Nimson Muriuki', 'Male', NULL, '0769720655', 'nimmuriuki6@gmail.com', NULL, NULL, 3, '2026-06-26', '2026-07-26', '1782461030_6a3e326687747.jpg', 'Active', 5000.00, 3000.00, 2000.00),
(5, 'e9e5c54a-6f15-11f1-b93b-00155d146087', 'Kelvin Kiptum', 'Male', NULL, '0710405957', 'kelvin@gmail.com', NULL, NULL, 3, '2026-06-23', '2026-07-23', '', 'Active', 5000.00, 0.00, 5000.00),
(6, 'a1422688-6f40-11f1-b93b-00155d146087', 'John Kimathi', 'Male', NULL, '0735281725', 'john@gmail.com', NULL, NULL, 2, '2026-06-24', '2026-06-27', '1782245879_DSC096831.jpg', 'Active', 1800.00, 0.00, 1800.00),
(8, '0f322e89-6fb0-11f1-b93b-00155d146087', 'Brian Kamau', 'Male', NULL, '0720128329', 'brian@gmail.com', NULL, NULL, 5, '2026-06-24', '2026-06-24', '1782293736_WhatsApp Image 2026-03-15 at.jpeg', 'Expired', 50000.00, 0.00, 50000.00),
(9, '40bb3b95-6fb0-11f1-b93b-00155d146087', 'Lilian Njeri', 'Female', NULL, '0733895477', 'lilian@gmail.com', NULL, NULL, 4, '2026-06-24', '2026-07-24', '', 'Active', 20000.00, 0.00, 20000.00),
(10, 'c95c3309-6fb1-11f1-b93b-00155d146087', 'Enzo Munene', 'Male', NULL, '0789780976', 'enzoone@gmail.com', NULL, NULL, 5, '2026-06-24', '2026-07-24', '', 'Active', 50000.00, 30000.00, 20000.00),
(12, '075d2dc9-6fd9-11f1-b93b-00155d146087', 'Charles Munene', 'Male', NULL, '0714986732', 'charles@gmail.com', NULL, NULL, 4, '2026-06-24', '2026-09-22', '', 'Active', 20000.00, 0.00, 20000.00);

-- --------------------------------------------------------

--
-- Table structure for table `membership_plans`
--

CREATE TABLE `membership_plans` (
  `id` int(11) NOT NULL,
  `plan_name` varchar(100) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `duration_days` int(11) NOT NULL DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_plans`
--

INSERT INTO `membership_plans` (`id`, `plan_name`, `duration`, `price`, `description`, `benefits`, `duration_days`) VALUES
(1, 'Daily', 1, 500.00, 'Daily Membership', 'GYM Access', 1),
(2, 'Weekly', 7, 1800.00, 'Weekly Membership', 'Gym Access', 7),
(3, 'Monthly', 30, 5000.00, 'Monthly Membership', 'Gym + Classes', 30),
(4, 'Quarterly', 90, 20000.00, 'Quarterly Membership', 'Gym + Classes', 90),
(5, 'Annual', 365, 50000.00, 'Annual Membership', 'All Benefits', 365);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Unread','Read') DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `reference_number` varchar(100) DEFAULT NULL,
  `status` enum('Paid','Pending','Failed') DEFAULT 'Paid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `member_id`, `amount`, `payment_date`, `payment_method`, `reference_number`, `status`, `created_at`) VALUES
(9, 10, 30000.00, '2026-06-24', 'M-Pesa', 'UFN3C99KVW', 'Paid', '2026-06-24 14:03:20'),
(12, 4, 3000.00, '2026-06-26', 'Cash', '', 'Paid', '2026-06-25 22:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `id` int(11) NOT NULL,
  `receipt_no` varchar(50) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`id`, `receipt_no`, `payment_id`, `member_id`, `created_at`) VALUES
(1, 'FP-20260625-00010', 10, 3, '2026-06-25 21:27:47'),
(2, 'FP-20260625-00011', 11, 3, '2026-06-25 21:32:35'),
(3, 'FP-20260626-00012', 12, 4, '2026-06-25 22:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `report_name` varchar(100) DEFAULT NULL,
  `generated_by` varchar(100) DEFAULT NULL,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'Admin'),
(3, 'Member'),
(2, 'Trainer');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `email`, `phone`, `address`, `logo`) VALUES
(1, 'FitPro Gym', 'info@fitprogym.com', '+254700000000', 'Nairobi, Kenya', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` int(11) NOT NULL,
  `trainer_code` varchar(50) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `trainer_code`, `fullname`, `specialization`, `phone`, `email`, `salary`, `photo`, `status`) VALUES
(2, NULL, 'Mary Coach', 'Yoga', '0700000002', 'mary@test.com', 45000.00, '1782160208_6a399b50dad80.jpg', 'Active'),
(3, 'df3eb997-6e74-11f1-ae6c-c8940232abb4', 'Ken Kimathi', 'Group Exercise', '0796720655', 'nimmuriuki6@gmail.com', 30000.00, '1782158366_download (9).jpg', 'Active'),
(4, '1ff9724f-6fd0-11f1-b93b-00155d146087', 'Coach Fortune', 'Weight Training', '0769720655', 'nimmuriuki6@gmail.com', 35000.00, '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remember_token` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `fullname`, `email`, `password`, `phone`, `photo`, `status`, `created_at`, `remember_token`, `reset_token`, `reset_expiry`) VALUES
(1, 1, 'System Administrator', 'admin@fitpro.com', '$2y$10$7v4xh8cFN0zbcZLB12.Kx.jS7r9ed4m/kUZT2XtT6NGxTTvf2on9S', NULL, NULL, 'Active', '2026-06-22 15:22:36', NULL, NULL, NULL),
(2, 3, 'Nim Muriuki', 'nimmuriuki6@gmail.com', '$2y$10$.55xLVJ9SIL8kYvUtZuwE.GPLcsBCAVoQZh4gL7C7xBXaXdZh/VIC', '0769720655', NULL, 'Active', '2026-06-22 16:04:37', NULL, NULL, NULL),
(3, 2, 'John Trainer', 'trainer@fitpro.com', '$2y$10$ag0LyEIe/jKEhTfoYNCej.1fDr29RByjUdE3IyVQJDs6.4nPiuFo2', '0735281724', NULL, 'Active', '2026-06-22 16:34:21', NULL, NULL, NULL),
(12, 2, 'Kelvin Muriuki', 'nimmuriuki1@gmail.com', '$2y$10$8q/.4tMvBQDSGGPcxjOCcuRk9GcADGj6WFsXnTuV7IEWEguGyosLq', '0769720655', NULL, 'Active', '2026-06-25 12:59:27', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

CREATE TABLE `workouts` (
  `id` int(11) NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `workout_name` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `difficulty` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diet_plans`
--
ALTER TABLE `diet_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_code` (`member_code`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `membership_plans`
--
ALTER TABLE `membership_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `receipt_no` (`receipt_no`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `workouts`
--
ALTER TABLE `workouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diet_plans`
--
ALTER TABLE `diet_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `membership_plans`
--
ALTER TABLE `membership_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `workouts`
--
ALTER TABLE `workouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `diet_plans`
--
ALTER TABLE `diet_plans`
  ADD CONSTRAINT `diet_plans_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`);

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `membership_plans` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `workouts`
--
ALTER TABLE `workouts`
  ADD CONSTRAINT `workouts_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
