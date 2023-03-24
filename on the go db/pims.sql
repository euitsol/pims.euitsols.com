-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2023 at 01:03 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pims`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_infos`
--

CREATE TABLE `academic_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_infos_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `passing_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `board_id` bigint(20) UNSIGNED NOT NULL,
  `roll` int(11) NOT NULL,
  `reg_no` int(11) NOT NULL,
  `gpa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_card` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marksheet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_infos`
--

INSERT INTO `academic_infos` (`id`, `student_infos_id`, `exam_id`, `passing_year`, `group`, `board_id`, `roll`, `reg_no`, `gpa`, `reg_card`, `marksheet`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(12, 1, 1, '2019', 'Science', 1, 112233, 2147483647, '5', 'public/student-info/1/registration/0/logo.png', 'public/student-info/1/marksheet/0/Screenshot_2.png', '2022-10-01 08:01:32', '2022-10-01 08:01:32', NULL, 1, NULL, NULL),
(14, 2, 1, '2002', 'Science', 1, 100001, 3958674, '4.5', 'public/student-info/2/registration/Plan for Successfull Completing Inustrial Training22 - 2022.pdf', 'public/student-info/2/marksheet/2022_10_11_15-56-04_pm.pdf', '2022-10-12 11:53:30', '2022-10-12 11:53:30', NULL, 1, NULL, NULL),
(15, 2, 2, '2004', 'Science', 1, 20002, 987456321, '4.8', 'public/student-info/2/registration/Plan for Successfull Completing Inustrial Training22 - 2022.pdf', 'public/student-info/2/marksheet/Shakil_Ahamed.pdf', '2022-10-12 11:53:30', '2022-10-12 11:53:30', NULL, 1, NULL, NULL),
(16, 3, 1, '2017', 'Science', 3, 145616541, 2147483647, '4.58', 'public/student-info/3/registration/0/Screenshot_50.png', 'public/student-info/3/marksheet/0/Screenshot_50.png', '2023-01-25 01:57:25', '2023-01-25 01:57:25', NULL, 1, NULL, NULL),
(17, 4, 3, '1971', 'Humanities', 3, 2515415, 2151651, '1.0', 'public/student-info/4/registration/0/Screenshot_50.png', 'public/student-info/4/marksheet/0/Screenshot_50.png', '2023-01-25 04:11:30', '2023-01-25 04:11:30', NULL, 1, NULL, NULL),
(18, 5, 4, '2018', 'Science', 4, 101369, 1500900386, '4.56', 'public/student-info/5/registration/0/Reg Card-1.jfif', 'public/student-info/5/marksheet/0/marksheet-1.jfif', '2023-01-28 06:33:53', '2023-01-28 06:33:53', NULL, 1, NULL, NULL),
(20, 7, 4, '2003', 'Science', 4, 99, 76, '3', 'public/student-info/7/registration/0/marksheet-1.jfif', 'public/student-info/7/marksheet/0/marksheet-2.png', '2023-02-01 04:50:36', '2023-02-01 04:50:36', NULL, 1, NULL, NULL),
(21, 8, 4, '2009', 'Humanities', 4, 23, 22, '1', 'public/student-info/8/registration/0/download.jfif', 'public/student-info/8/marksheet/0/marksheet-1.jfif', '2023-02-03 03:47:23', '2023-02-03 03:47:23', NULL, 1, NULL, NULL),
(26, 6, 4, '1971', 'Humanities', 4, 6, 56, '2', 'public/student-info/6/registration/0/marksheet-1.jfif', 'public/student-info/6/marksheet/0/Reg Card-1.jfif', '2023-02-10 06:00:57', '2023-02-10 06:00:57', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admitted_std_assigns`
--

CREATE TABLE `admitted_std_assigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_infos_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `semester_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admitted_std_assigns`
--

INSERT INTO `admitted_std_assigns` (`id`, `student_infos_id`, `session_id`, `semester_id`, `group_id`, `shift_id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(2, 5, 5, 7, 7, 5, '2023-01-28 06:34:51', '2023-01-28 06:34:51', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_base_units`
--

CREATE TABLE `asset_base_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_base_units`
--

INSERT INTO `asset_base_units` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Meter', '2023-01-28 03:30:52', '2023-01-28 03:30:52', NULL, NULL, NULL, NULL),
(2, 'Kilogram', '2023-01-28 03:30:52', '2023-01-28 03:30:52', NULL, NULL, NULL, NULL),
(3, 'Piece', '2023-01-28 03:30:52', '2023-01-28 03:30:52', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_brands`
--

CREATE TABLE `asset_brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_brands`
--

INSERT INTO `asset_brands` (`id`, `name`, `img`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Orion Brand', '', '1', '2023-01-28 06:44:53', '2023-01-28 06:44:53', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_categories`
--

CREATE TABLE `asset_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_categories`
--

INSERT INTO `asset_categories` (`id`, `name`, `img`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Cat-1', '', '1', '2023-01-28 06:45:12', '2023-01-28 06:45:12', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_damages`
--

CREATE TABLE `asset_damages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `main_assign_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `des` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_damages`
--

INSERT INTO `asset_damages` (`id`, `main_assign_id`, `product_id`, `supplier_id`, `qty`, `des`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1, 1, 4, 1, 'This is an damage product', '2023-02-03 07:07:12', '2023-02-03 07:07:12', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_units`
--

CREATE TABLE `asset_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_unit_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_units`
--

INSERT INTO `asset_units` (`id`, `name`, `short_name`, `base_unit_id`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(2, 'Unit-1', 'U-1', 2, '2023-01-28 06:49:26', '2023-01-28 06:49:26', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assign_books`
--

CREATE TABLE `assign_books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `std_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `assign_date` date NOT NULL,
  `return_date` date NOT NULL,
  `returned_date` date DEFAULT NULL,
  `status` enum('0','1','-1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assign_books`
--

INSERT INTO `assign_books` (`id`, `std_id`, `book_id`, `qty`, `assign_date`, `return_date`, `returned_date`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1, 4, 1, '2023-01-28', '2023-01-23', NULL, '0', '2023-01-28 08:06:44', '2023-01-28 08:06:44', NULL, 1, NULL, NULL),
(2, 1, 4, 1, '2023-01-28', '2023-01-10', NULL, '0', '2023-01-28 08:13:27', '2023-01-28 08:13:27', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assign_products`
--

CREATE TABLE `assign_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subsection_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assign_products`
--

INSERT INTO `assign_products` (`id`, `department_id`, `section_id`, `subsection_id`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 4, 1, 1, '2023-01-28 06:56:58', '2023-01-28 06:56:58', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `departments_id` bigint(20) UNSIGNED NOT NULL,
  `semester_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `session_id`, `departments_id`, `semester_id`, `teacher_id`, `subject_id`, `group_id`, `shift_id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(6, 5, 4, 7, 15, 7, 7, 5, '2023-01-28 06:26:02', '2023-01-28 06:26:02', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bloodgroups`
--

CREATE TABLE `bloodgroups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bloodgroups`
--

INSERT INTO `bloodgroups` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(10, 'A+', '2023-01-28 05:08:09', '2023-01-28 05:08:09', 1, NULL, NULL, NULL),
(11, 'A-', '2023-01-28 05:08:16', '2023-01-28 05:08:16', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `boards`
--

CREATE TABLE `boards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `boards`
--

INSERT INTO `boards` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(4, 'Dinajpur Board', '2023-01-28 05:09:02', '2023-01-28 05:09:02', 1, NULL, NULL, NULL),
(5, 'Dhaka Board', '2023-01-28 05:09:12', '2023-01-28 05:09:12', 1, NULL, NULL, NULL),
(6, 'Rajshahi Board', '2023-01-28 05:09:18', '2023-01-28 05:09:18', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `bookshelf_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `name`, `author_name`, `qty`, `category_id`, `bookshelf_id`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(4, 'Python Basic', 'Sir-P', 98, 4, 3, '2023-01-28 06:30:42', '2023-01-28 08:13:27', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bookshelves`
--

CREATE TABLE `bookshelves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookshelves`
--

INSERT INTO `bookshelves` (`id`, `name`, `capacity`, `details`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(3, 'Bookshelf-1', 100, 'This is bookshelf-1', '2023-01-28 06:29:10', '2023-01-28 06:29:10', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`id`, `name`, `location`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(5, 'East Building', '0', '2023-01-28 05:19:25', '2023-01-28 05:19:25', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `departments_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `departments_id`, `name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(4, 4, 'General', '2023-01-28 06:28:24', '2023-01-28 06:28:24', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_contents`
--

CREATE TABLE `class_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `std_attendance_id` bigint(20) UNSIGNED NOT NULL,
  `class_content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_contents`
--

INSERT INTO `class_contents` (`id`, `std_attendance_id`, `class_content`, `class`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(6, 7, '<h1>This is the first java class.</h1><p>&nbsp;</p>', '', '2023-01-28 06:38:34', '2023-01-28 06:38:34', 1, NULL, NULL, NULL),
(7, 8, '<h1>This is class two</h1><p>&nbsp;</p>', '', '2023-01-28 06:39:47', '2023-01-28 06:39:47', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_files`
--

CREATE TABLE `class_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `std_attendance_id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `credits`
--

CREATE TABLE `credits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `credit_number` double(8,2) NOT NULL,
  `marks` double(8,2) NOT NULL,
  `class_hour` double(8,2) NOT NULL,
  `hour_minute` int(11) NOT NULL,
  `total_class` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `credits`
--

INSERT INTO `credits` (`id`, `credit_number`, `marks`, `class_hour`, `hour_minute`, `total_class`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(7, 4.50, 100.00, 2.00, 1, 40, '2023-01-28 05:21:20', '2023-01-28 05:21:20', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `short_name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(4, 'Computer Science and Engineering', 'C.S.E', '2023-01-28 05:22:12', '2023-01-28 05:22:12', NULL, NULL, NULL, NULL),
(5, 'Food Technology', 'Food', '2023-01-28 05:22:27', '2023-01-28 05:22:27', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'Principal', '2023-02-06 01:23:04', '2023-02-06 01:28:20', 1, 1, NULL, NULL),
(2, 'Teacher', '2023-02-07 04:19:23', '2023-02-07 04:19:23', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `division_id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'Comilla', 1, '2022-09-09 12:39:38', '2022-09-09 12:39:38', NULL, NULL, NULL, NULL),
(2, 'Feni', 1, '2022-09-09 12:39:38', '2022-09-09 12:39:38', NULL, NULL, NULL, NULL),
(3, 'Brahmanbaria', 1, '2022-09-09 12:39:38', '2022-09-09 12:39:38', NULL, NULL, NULL, NULL),
(4, 'Rangamati', 1, '2022-09-09 12:39:38', '2022-09-09 12:39:38', NULL, NULL, NULL, NULL),
(5, 'Noakhali', 1, '2022-09-09 12:39:38', '2022-09-09 12:39:38', NULL, NULL, NULL, NULL),
(6, 'Chandpur', 1, '2022-09-09 12:39:38', '2022-09-09 12:39:38', NULL, NULL, NULL, NULL),
(7, 'Lakshmipur', 1, '2022-09-09 12:39:38', '2022-09-09 12:39:38', NULL, NULL, NULL, NULL),
(8, 'Chattogram', 1, '2022-09-09 12:39:38', '2022-09-09 12:39:38', NULL, NULL, NULL, NULL),
(9, 'Coxsbazar', 1, '2022-09-09 12:39:38', '2022-09-09 12:39:38', NULL, NULL, NULL, NULL),
(10, 'Khagrachhari', 1, '2022-09-09 12:39:38', '2022-09-09 12:39:38', NULL, NULL, NULL, NULL),
(11, 'Bandarban', 1, '2022-09-09 12:39:38', '2022-09-09 12:39:38', NULL, NULL, NULL, NULL),
(12, 'Sirajganj', 2, '2022-09-09 12:39:38', '2022-09-09 12:39:38', NULL, NULL, NULL, NULL),
(13, 'Pabna', 2, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(14, 'Bogura', 2, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(15, 'Rajshahi', 2, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(16, 'Natore', 2, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(17, 'Joypurhat', 2, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(18, 'Chapainawabganj', 2, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(19, 'Naogaon', 2, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(20, 'Jashore', 3, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(21, 'Satkhira', 3, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(22, 'Meherpur', 3, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(23, 'Narail', 3, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(24, 'Chuadanga', 3, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(25, 'Kushtia', 3, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(26, 'Magura', 3, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(27, 'Khulna', 3, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(28, 'Bagerhat', 3, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(29, 'Jhenaidah', 3, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(30, 'Jhalakathi', 4, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(31, 'Patuakhali', 4, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(32, 'Pirojpur', 4, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(33, 'Barisal', 4, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(34, 'Bhola', 4, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(35, 'Barguna', 4, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(36, 'Sylhet', 5, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(37, 'Moulvibazar', 5, '2022-09-09 12:39:39', '2022-09-09 12:39:39', NULL, NULL, NULL, NULL),
(38, 'Habiganj', 5, '2022-09-09 12:39:39', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(39, 'Sunamganj', 5, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(40, 'Narsingdi', 6, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(41, 'Gazipur', 6, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(42, 'Shariatpur', 6, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(43, 'Narayanganj', 6, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(44, 'Tangail', 6, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(45, 'Kishoreganj', 6, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(46, 'Manikganj', 6, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(47, 'Dhaka', 6, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(48, 'Munshiganj', 6, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(49, 'Rajbari', 6, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(50, 'Madaripur', 6, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(51, 'Gopalganj', 6, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(52, 'Faridpur', 6, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(53, 'Panchagarh', 7, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(54, 'Dinajpur', 7, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(55, 'Lalmonirhat', 7, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(56, 'Nilphamari', 7, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(57, 'Gaibandha', 7, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(58, 'Thakurgaon', 7, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(59, 'Rangpur', 7, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(60, 'Kurigram', 7, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(61, 'Sherpur', 8, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(62, 'Mymensingh', 8, '2022-09-09 12:39:40', '2022-09-09 12:39:40', NULL, NULL, NULL, NULL),
(63, 'Jamalpur', 8, '2022-09-09 12:39:41', '2022-09-09 12:39:41', NULL, NULL, NULL, NULL),
(64, 'Netrokona', 8, '2022-09-09 12:39:41', '2022-09-09 12:39:41', NULL, NULL, NULL, NULL),
(65, 'Dhanmondi.', 6, '2023-01-24 03:46:23', '2023-01-24 03:46:43', 1, 1, NULL, NULL),
(66, 'District-1', 1, '2023-01-28 05:39:28', '2023-01-28 05:39:28', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'Chattagram', '2022-09-09 12:40:23', '2022-09-09 12:40:23', NULL, NULL, NULL, NULL),
(2, 'Rajshahi', '2022-09-09 12:40:23', '2022-09-09 12:40:23', NULL, NULL, NULL, NULL),
(3, 'Khulna', '2022-09-09 12:40:23', '2022-09-09 12:40:23', NULL, NULL, NULL, NULL),
(4, 'Barisal', '2022-09-09 12:40:23', '2022-09-09 12:40:23', NULL, NULL, NULL, NULL),
(5, 'Sylhet', '2022-09-09 12:40:23', '2022-09-09 12:40:23', NULL, NULL, NULL, NULL),
(6, 'Dhaka', '2022-09-09 12:40:23', '2022-09-09 12:40:23', NULL, NULL, NULL, NULL),
(7, 'Rangpur', '2022-09-09 12:40:23', '2022-09-09 12:40:23', NULL, NULL, NULL, NULL),
(8, 'Mymensingh', '2022-09-09 12:40:23', '2022-09-09 12:40:23', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eadmissions`
--

CREATE TABLE `eadmissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `eadmissions`
--

INSERT INTO `eadmissions` (`id`, `name`, `short_name`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(4, 'Secondary School Certificate', 'S.S.C', '2023-01-28 05:13:51', '2023-01-28 05:13:51', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_academic_infos`
--

CREATE TABLE `employee_academic_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_infos_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `passing_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `board_id` bigint(20) UNSIGNED NOT NULL,
  `roll` int(11) NOT NULL,
  `reg_no` int(11) NOT NULL,
  `gpa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_card` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marksheet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `certificate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_academic_infos`
--

INSERT INTO `employee_academic_infos` (`id`, `employee_infos_id`, `exam_id`, `passing_year`, `group`, `board_id`, `roll`, `reg_no`, `gpa`, `reg_card`, `marksheet`, `certificate`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1, 4, '2001', 'Science', 5, 88, 13, '4', 'public/employee-info/1/registration/0/Reg Card-1.jfif', 'public/employee-info/1/marksheet/0/Reg Card-2.jfif', 'public/employee-info/1/certificate/0/marksheet-1.jfif', '2023-02-10 04:54:57', '2023-02-10 04:54:57', NULL, 1, NULL, NULL),
(8, 2, 4, '2019', 'Bussiness Studies', 6, 101369, 1500900386, '4.56', 'public/employee-info/2/registration/0/marksheet-1.jfif', 'public/employee-info/2/marksheet/0/marksheet-2.png', 'public/employee-info/2/certificate/0/Reg Card-2.jfif', '2023-02-10 05:53:28', '2023-02-10 05:53:28', NULL, 1, NULL, NULL),
(12, 4, 4, '2017', 'Humanities', 5, 55, 24, '4', 'public/employee-info/4/registration/0/marksheet-1.jfif', 'public/employee-info/4/marksheet/0/marksheet-2.png', 'public/employee-info/4/certificate/0/Reg Card-1.jfif', '2023-02-10 05:58:50', '2023-02-10 05:58:50', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_documents`
--

CREATE TABLE `employee_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_infos_id` bigint(20) UNSIGNED NOT NULL,
  `designation_id` bigint(20) UNSIGNED NOT NULL,
  `nid_or_dob` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `character_certificate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_documents`
--

INSERT INTO `employee_documents` (`id`, `employee_infos_id`, `designation_id`, `nid_or_dob`, `cv`, `character_certificate`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1, 2, 'public/employee-info/1/nid_or_dob/0/marksheet-2.png', 'public/employee-info/1/cv/0/Reg Card-1.jfif', 'public/employee-info/1/character_certificate/0/Reg Card-2.jfif', '2023-02-10 04:54:57', '2023-02-10 04:54:57', NULL, 1, NULL, NULL),
(8, 2, 2, 'public/employee-info/2/nid_or_dob/0/marksheet-2.png', 'public/employee-info/2/cv/0/Reg Card-2.jfif', 'public/employee-info/2/character_certificate/0/marksheet-2.png', '2023-02-10 05:53:28', '2023-02-10 05:53:28', NULL, 1, NULL, NULL),
(12, 4, 2, 'public/employee-info/4/nid_or_dob/0/marksheet-1.jfif', 'public/employee-info/4/cv/0/Reg Card-1.jfif', 'public/employee-info/4/character_certificate/0/Reg Card-2.jfif', '2023-02-10 05:58:50', '2023-02-10 05:58:50', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_experiences`
--

CREATE TABLE `employee_experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_infos_id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_start` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_end` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ex_certificate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_experiences`
--

INSERT INTO `employee_experiences` (`id`, `employee_infos_id`, `designation`, `company_name`, `job_start`, `job_end`, `ex_certificate`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1, 'Ab voluptas sed et a', 'Harmon Willis Associates', 'January 2023', 'August 2023', 'public/employee-info/1/ex_certificate/download.jfif', '2023-02-10 04:54:57', '2023-02-10 04:54:57', NULL, 1, NULL, NULL),
(5, 2, 'Manager', 'SEM IT', 'January 2023', 'December 2023', 'public/employee-info/2/ex_certificate/marksheet-1.jfif', '2023-02-10 05:50:31', '2023-02-10 05:50:31', NULL, 1, NULL, NULL),
(6, 2, 'Manager', 'SEM IT', 'January 2023', 'December 2023', 'public/employee-info/2/ex_certificate/marksheet-1.jfif', '2023-02-10 05:52:57', '2023-02-10 05:52:57', NULL, 1, NULL, NULL),
(7, 2, 'Manager', 'SEM IT', 'January 2023', 'December 2023', 'public/employee-info/2/ex_certificate/marksheet-1.jfif', '2023-02-10 05:53:28', '2023-02-10 05:53:28', NULL, 1, NULL, NULL),
(8, 4, 'Director', 'NewIT', 'January 2023', 'May 2023', 'public/employee-info/4/ex_certificate/marksheet-1.jfif', '2023-02-10 05:57:01', '2023-02-10 05:57:01', NULL, 1, NULL, NULL),
(9, 4, 'Director', 'NewIT', 'January 2023', 'May 2023', 'public/employee-info/4/ex_certificate/marksheet-1.jfif', '2023-02-10 05:57:17', '2023-02-10 05:57:17', NULL, 1, NULL, NULL),
(10, 4, 'Director', 'NewIT', 'January 2023', 'May 2023', 'public/employee-info/4/ex_certificate/marksheet-1.jfif', '2023-02-10 05:57:51', '2023-02-10 05:57:52', NULL, 1, NULL, NULL),
(11, 4, 'Directorsd', 'NewITS', 'January 2023', 'May 2023', 'public/employee-info/4/ex_certificate/0/marksheet-1.jfif', '2023-02-10 05:58:50', '2023-02-10 05:58:50', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_infos`
--

CREATE TABLE `employee_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `departments_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `present_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parmanent_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marital_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spouse_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spouse_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bg_id` bigint(20) UNSIGNED DEFAULT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_infos`
--

INSERT INTO `employee_infos` (`id`, `departments_id`, `employee_id`, `name`, `father_name`, `mother_name`, `present_address`, `parmanent_address`, `email`, `phone`, `gender`, `marital_status`, `spouse_name`, `spouse_number`, `dob`, `nationality`, `bg_id`, `division_id`, `district_id`, `photo`, `session`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 4, NULL, 'Caleb Decker', 'Connor Vaughan', 'Ann Huber', 'Inventore fugit nih', 'Qui odio beatae dign', 'talogav@mailinator.com', '01792980502', 'Male', 'single', 'Chloe Wallace', '315', '22-Dec-1982', 'Esse velit recusand', 11, 5, 37, NULL, NULL, '1', '2023-02-10 04:54:57', '2023-02-10 05:21:59', NULL, 1, NULL, NULL),
(2, 4, NULL, 'Md Shariful Islam', 'Md Enamul Haque Kabir', 'Most Sayeda Banu', 'Dhaka, Bangladesh', 'Dhaka, Bangladesh', 'shariful@gmail.com', '01792980503', 'Male', 'married', 'ABCD', '01877018395', '01/30/2023', 'Bangladeshi', 10, 1, 1, NULL, NULL, '1', '2023-02-10 05:53:28', '2023-02-10 05:53:28', NULL, 1, NULL, NULL),
(4, 4, NULL, 'Sayful Islam', 'BABA', 'MA', 'Dhaka, Bangladesh', 'Dhaka, Bangladesh', 'sayful@gmail.com', '01877018308', 'Male', 'married', 'SSSSSSS', '01877018307', '01/29/2023', 'Bangladeshi', 10, 1, 1, 'public/employee-info/4/photo/download.jfif', NULL, '0', '2023-02-10 05:58:50', '2023-02-10 05:58:50', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_creates`
--

CREATE TABLE `exam_creates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `search_id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `total_mark` double(8,2) NOT NULL,
  `duration` double(8,2) NOT NULL,
  `hour_minute` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2',
  `total_fee` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_creates`
--

INSERT INTO `exam_creates` (`id`, `search_id`, `type_id`, `total_mark`, `duration`, `hour_minute`, `total_fee`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 1, 100.00, 2.00, '1', 300.00, '2023-01-28 07:06:18', '2023-01-28 07:06:18', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedules`
--

CREATE TABLE `exam_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `create_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `exam_shift_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_schedules`
--

INSERT INTO `exam_schedules` (`id`, `create_id`, `shift_id`, `group_id`, `exam_shift_id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 5, 7, 1, '2023-01-28 07:06:18', '2023-01-28 07:06:18', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_searches`
--

CREATE TABLE `exam_searches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `semester_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_searches`
--

INSERT INTO `exam_searches` (`id`, `session_id`, `department_id`, `semester_id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 5, 4, 7, '2023-01-28 07:05:30', '2023-01-28 07:05:30', 1, NULL, NULL, NULL),
(2, 5, 5, 7, '2023-02-06 08:40:55', '2023-02-06 08:40:55', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_shifts`
--

CREATE TABLE `exam_shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_shifts`
--

INSERT INTO `exam_shifts` (`id`, `name`, `start`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, '1st Shift', '14:00:00', '2023-01-28 05:41:03', '2023-01-28 05:41:03', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_subjects`
--

CREATE TABLE `exam_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `create_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `exam_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_subjects`
--

INSERT INTO `exam_subjects` (`id`, `create_id`, `subject_id`, `exam_date`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 7, '2023-01-01', '2023-01-28 07:06:18', '2023-01-28 07:06:18', 1, NULL, NULL, NULL),
(2, 1, 6, '2023-01-02', '2023-01-28 07:06:18', '2023-01-28 07:06:18', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_types`
--

CREATE TABLE `exam_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_types`
--

INSERT INTO `exam_types` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Final Exam', '2023-01-28 05:42:25', '2023-01-28 05:42:25', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE `floors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `building_id` bigint(20) UNSIGNED NOT NULL,
  `floor` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `floors`
--

INSERT INTO `floors` (`id`, `building_id`, `floor`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(12, 5, 1, '2023-01-28 05:19:25', '2023-01-28 05:19:25', NULL, 1, NULL, NULL),
(13, 5, 2, '2023-01-28 05:19:25', '2023-01-28 05:19:25', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lettergrades_id` bigint(20) UNSIGNED NOT NULL,
  `mark_start` double(8,2) NOT NULL,
  `mark_end` double(8,2) NOT NULL,
  `grade_point` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `lettergrades_id`, `mark_start`, `mark_end`, `grade_point`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(2, 5, 80.00, 100.00, 5.00, '2023-01-28 05:45:56', '2023-01-28 05:45:56', 1, NULL, NULL, NULL),
(3, 6, 70.00, 80.00, 4.50, '2023-01-28 05:46:13', '2023-01-28 05:46:13', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(7, 'A', '2023-01-28 05:42:53', '2023-01-28 05:42:53', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lettergrades`
--

CREATE TABLE `lettergrades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lettergrades`
--

INSERT INTO `lettergrades` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(5, 'A+', '2023-01-28 05:44:19', '2023-01-28 05:44:19', 1, NULL, NULL, NULL),
(6, 'A', '2023-01-28 05:44:25', '2023-01-28 05:44:25', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `library_members`
--

CREATE TABLE `library_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `std_id` bigint(20) UNSIGNED DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `member_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `present_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ec_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_members`
--

INSERT INTO `library_members` (`id`, `std_id`, `teacher_id`, `member_id`, `name`, `phone`, `dob`, `present_address`, `permanent_address`, `ec_name`, `ec_phone`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 5, NULL, '2023015', 'Md Shariful Islam', '01792980503', '09/11/2001', 'Rajshahi, Bangladesh', 'Rajshahi, Bangladesh', 'Enamul Haque', '01740955009', '2023-01-28 06:41:37', '2023-01-28 06:41:37', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `library_students`
--

CREATE TABLE `library_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `std_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` int(11) NOT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `present_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `library_students`
--

INSERT INTO `library_students` (`id`, `std_id`, `name`, `phone`, `dob`, `present_address`, `permanent_address`, `ec_name`, `ec_phone`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(4, 2, 'Md. Mamun Ur Rasid', 1717221398, '09/09/1985', 'House#259/1, Senpara Parbata, Mirpur 10, Dhaka.', 'Village: Varlarvita, Post: Ghogadaha, P/S: Kurigram, District: Kurigram', 'Md. Abul Kalam Azad', '01889977951', '2022-11-11 13:01:11', '2022-11-11 13:01:11', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `main_assign_products`
--

CREATE TABLE `main_assign_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assign_product_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_assign_products`
--

INSERT INTO `main_assign_products` (`id`, `assign_product_id`, `product_id`, `supplier_id`, `qty`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1, 1, 4, 1, '2023-01-28 06:58:09', '2023-01-28 06:58:09', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\AssetBrand', 1, '0627cb44-494f-497e-bb93-812755cd21af', 'asset-brand-img', 'download (1)', 'download-(1).jfif', 'image/jpeg', 'public', 'public', 6442, '[]', '[]', '[]', '[]', 1, '2023-01-28 06:44:53', '2023-01-28 06:44:53'),
(2, 'App\\Models\\AssetCategory', 1, 'ac72badb-f812-4a0e-8fc5-d522535dbc2c', 'asset-category-img', 'download (1)', 'download-(1).jfif', 'image/jpeg', 'public', 'public', 6442, '[]', '[]', '[]', '[]', 1, '2023-01-28 06:45:12', '2023-01-28 06:45:12');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_08_31_182455_create_permission_tables', 1),
(6, '2022_09_02_092410_add_foreign_keys_users_table', 1),
(7, '2022_09_02_092649_add_foreign_keys_roles_table', 1),
(8, '2022_12_17_132136_create_exam_shifts_table', 2),
(9, '2022_12_16_161853_create_exam_types_table', 3),
(10, '2022_11_09_131936_create_library_members_table', 4),
(11, '2022_11_30_112113_create_asset_categories_table', 5),
(12, '2022_11_30_125119_create_asset_brands_table', 6),
(13, '2022_11_30_128609_create_asset_base_units_table', 7),
(14, '2022_11_30_132516_create_asset_units_table', 8),
(15, '2022_12_13_073129_create_subcategories_table', 9),
(16, '2022_12_13_084547_create_products_table', 10),
(17, '2022_12_14_134712_create_sections_table', 11),
(18, '2022_12_14_141611_create_subsections_table', 12),
(19, '2022_12_15_074511_create_suppliers_table', 13),
(20, '2022_12_15_140957_create_more_products_table', 14),
(21, '2022_12_17_063845_create_exam_searches_table', 15),
(22, '2022_12_17_144501_create_assign_products_table', 16),
(23, '2022_12_22_155325_create_main_assign_products_table', 17),
(24, '2022_12_17_063920_create_exam_creates_table', 18),
(25, '2023_01_03_083516_create_asset_damages_table', 19),
(26, '2023_01_06_143118_add_email_to_suppliers_table', 20),
(28, '2022_11_11_151458_create_assign_books_table', 21),
(29, '2023_02_06_062623_create_designations_table', 22),
(36, '2023_02_06_083752_create_employee_infos_table', 28),
(37, '2023_02_06_102124_create_employee_academic_infos_table', 29),
(38, '2023_02_06_104317_create_employee_experiences_table', 30),
(39, '2023_02_06_113039_create_employee_documents_table', 31);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 6),
(4, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 7),
(4, 'App\\Models\\User', 8),
(8, 'App\\Models\\User', 10);

-- --------------------------------------------------------

--
-- Table structure for table `more_products`
--

CREATE TABLE `more_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warranty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `more_products`
--

INSERT INTO `more_products` (`id`, `product_id`, `supplier_id`, `quantity`, `warranty`, `total_price`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1, 4, '200', '2', '600', '2023-01-28 06:54:43', '2023-01-28 06:54:43', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nationalities`
--

CREATE TABLE `nationalities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nationalities`
--

INSERT INTO `nationalities` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(4, 'Bangladeshi', '2023-01-28 05:46:42', '2023-01-28 05:46:42', 1, NULL, NULL, NULL),
(5, 'Indian', '2023-01-28 05:46:59', '2023-01-28 05:46:59', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('fahim.euitsols@gmail.com', '$2y$10$TdgXcPlGgEwVzNWEKRzV7.8fM.s1L/Pf9vRxLn2p9tJujamk4OPFy', '2023-01-10 13:32:35'),
('admin@email.com', '$2y$10$HNjHC.bQQavJsfcLABgMs.9yX.z5HvE434ehgpHN2M9yQTGSsjFN2', '2023-01-10 13:33:04');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `prefix`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'setup', 'view setup', 'web', '2022-09-16 21:48:31', '2022-09-17 01:48:43', '2022-09-17 01:48:43', 1, NULL, 1),
(2, 'setup', 'add setup', 'web', '2022-09-16 21:49:04', '2022-09-17 01:48:55', '2022-09-17 01:48:55', 1, NULL, 1),
(3, 'setup', 'edit setup', 'web', '2022-09-16 21:49:20', '2022-09-17 01:48:58', '2022-09-17 01:48:58', 1, NULL, 1),
(4, 'setup', 'delete setup', 'web', '2022-09-16 21:49:35', '2022-09-17 01:49:01', '2022-09-17 01:49:01', 1, NULL, 1),
(5, 'user', 'view user', 'web', '2022-09-16 21:50:02', '2022-09-16 21:50:02', NULL, 1, NULL, NULL),
(6, 'user', 'add user', 'web', '2022-09-16 21:50:15', '2022-09-16 21:50:15', NULL, 1, NULL, NULL),
(7, 'user', 'edit user', 'web', '2022-09-16 21:50:31', '2022-09-16 21:50:31', NULL, 1, NULL, NULL),
(8, 'user', 'delete user', 'web', '2022-09-16 21:50:47', '2022-09-16 21:50:47', NULL, 1, NULL, NULL),
(9, 'role', 'view role', 'web', '2022-09-16 21:51:34', '2022-09-16 21:51:34', NULL, 1, NULL, NULL),
(10, 'role', 'add role', 'web', '2022-09-16 21:51:47', '2022-09-16 21:51:47', NULL, 1, NULL, NULL),
(11, 'role', 'edit role', 'web', '2022-09-16 21:51:59', '2022-09-16 21:51:59', NULL, 1, NULL, NULL),
(12, 'role', 'delete role', 'web', '2022-09-16 21:52:17', '2022-09-16 21:52:17', NULL, 1, NULL, NULL),
(13, 'permission', 'view permission', 'web', '2022-09-17 00:11:28', '2022-09-17 00:11:28', NULL, 1, NULL, NULL),
(14, 'permission', 'add permission', 'web', '2022-09-17 00:11:48', '2022-09-17 00:11:48', NULL, 1, NULL, NULL),
(15, 'permission', 'edit permission', 'web', '2022-09-17 00:12:07', '2022-09-17 00:12:07', NULL, 1, NULL, NULL),
(16, 'permission', 'delete permission', 'web', '2022-09-17 00:12:22', '2022-09-17 00:12:22', NULL, 1, NULL, NULL),
(17, 'department', 'view department', 'web', '2022-09-17 00:40:57', '2022-09-17 00:40:57', NULL, 1, NULL, NULL),
(18, 'department', 'add department', 'web', '2022-09-17 00:41:12', '2022-09-17 00:41:12', NULL, 1, NULL, NULL),
(19, 'department', 'edit department', 'web', '2022-09-17 00:41:34', '2022-09-17 00:41:34', NULL, 1, NULL, NULL),
(20, 'department', 'delete department', 'web', '2022-09-17 00:41:52', '2022-09-17 00:41:52', NULL, 1, NULL, NULL),
(21, 'exam-name', 'view exam-name', 'web', '2022-09-17 00:42:41', '2022-09-17 00:42:41', NULL, 1, NULL, NULL),
(22, 'exam-name', 'add exam-name', 'web', '2022-09-17 00:43:01', '2022-09-17 00:43:01', NULL, 1, NULL, NULL),
(23, 'exam-name', 'edit exam-name', 'web', '2022-09-17 00:43:17', '2022-09-17 00:43:17', NULL, 1, NULL, NULL),
(24, 'exam-name', 'delete exam-name', 'web', '2022-09-17 00:43:29', '2022-09-17 00:43:29', NULL, 1, NULL, NULL),
(25, 'board', 'view board', 'web', '2022-09-17 00:46:39', '2022-09-17 00:46:39', NULL, 1, NULL, NULL),
(26, 'board', 'add board', 'web', '2022-09-17 00:46:52', '2022-09-17 00:46:52', NULL, 1, NULL, NULL),
(27, 'board', 'edit board', 'web', '2022-09-17 00:47:01', '2022-09-17 00:47:01', NULL, 1, NULL, NULL),
(28, 'board', 'delete board', 'web', '2022-09-17 00:47:19', '2022-09-17 00:47:19', NULL, 1, NULL, NULL),
(29, 'semester', 'view semester', 'web', '2022-09-17 00:52:48', '2022-09-17 00:52:48', NULL, 1, NULL, NULL),
(30, 'semester', 'add semester', 'web', '2022-09-17 00:53:19', '2022-09-17 00:53:19', NULL, 1, NULL, NULL),
(31, 'semester', 'edit semester', 'web', '2022-09-17 00:53:36', '2022-09-17 00:53:36', NULL, 1, NULL, NULL),
(32, 'semester', 'delete semester', 'web', '2022-09-17 00:53:49', '2022-09-17 00:53:49', NULL, 1, NULL, NULL),
(33, 'session', 'view session', 'web', '2022-09-17 01:06:44', '2022-09-17 01:06:44', NULL, 1, NULL, NULL),
(34, 'session', 'add session', 'web', '2022-09-17 01:06:53', '2022-09-17 01:06:53', NULL, 1, NULL, NULL),
(35, 'session', 'edit session', 'web', '2022-09-17 01:07:02', '2022-09-17 01:07:02', NULL, 1, NULL, NULL),
(36, 'session', 'delete session', 'web', '2022-09-17 01:07:12', '2022-09-17 01:07:12', NULL, 1, NULL, NULL),
(37, 'semester-duration', 'view semester-duration', 'web', '2022-09-17 01:08:39', '2022-09-17 01:08:39', NULL, 1, NULL, NULL),
(38, 'semester-duration', 'add semester-duration', 'web', '2022-09-17 01:08:48', '2022-09-17 01:08:48', NULL, 1, NULL, NULL),
(39, 'semester-duration', 'edit semester-duration', 'web', '2022-09-17 01:08:58', '2022-09-17 01:08:58', NULL, 1, NULL, NULL),
(40, 'semester-duration', 'delete semester-duration', 'web', '2022-09-17 01:09:08', '2022-09-17 01:09:08', NULL, 1, NULL, NULL),
(41, 'group', 'view group', 'web', '2022-09-17 01:10:18', '2022-09-17 01:10:18', NULL, 1, NULL, NULL),
(42, 'group', 'add group', 'web', '2022-09-17 01:10:36', '2022-09-17 01:10:36', NULL, 1, NULL, NULL),
(43, 'group', 'edit group', 'web', '2022-09-17 01:10:50', '2022-09-17 01:10:50', NULL, 1, NULL, NULL),
(44, 'group', 'delete group', 'web', '2022-09-17 01:10:58', '2022-09-17 01:10:58', NULL, 1, NULL, NULL),
(45, 'blood-group', 'view blood-group', 'web', '2022-09-17 01:35:24', '2022-09-17 01:35:24', NULL, 1, NULL, NULL),
(46, 'blood-group', 'add blood-group', 'web', '2022-09-17 01:35:45', '2022-09-17 01:35:45', NULL, 1, NULL, NULL),
(47, 'blood-group', 'edit blood-group', 'web', '2022-09-17 01:35:54', '2022-09-17 01:35:54', NULL, 1, NULL, NULL),
(48, 'blood-group', 'delete blood-group', 'web', '2022-09-17 01:36:02', '2022-09-17 01:36:02', NULL, 1, NULL, NULL),
(49, 'divsion', 'view divsion', 'web', '2022-09-17 01:36:48', '2022-09-17 01:36:48', NULL, 1, NULL, NULL),
(50, 'divsion', 'add divsion', 'web', '2022-09-17 01:36:58', '2022-09-17 01:36:58', NULL, 1, NULL, NULL),
(51, 'divsion', 'edit divsion', 'web', '2022-09-17 01:37:07', '2022-09-17 01:37:07', NULL, 1, NULL, NULL),
(52, 'divsion', 'delete divsion', 'web', '2022-09-17 01:37:15', '2022-09-17 01:37:15', NULL, 1, NULL, NULL),
(53, 'district', 'view district', 'web', '2022-09-17 01:37:35', '2022-09-17 01:37:35', NULL, 1, NULL, NULL),
(54, 'district', 'add district', 'web', '2022-09-17 01:37:54', '2022-09-17 01:37:54', NULL, 1, NULL, NULL),
(55, 'district', 'edit district', 'web', '2022-09-17 01:38:03', '2022-09-17 01:38:03', NULL, 1, NULL, NULL),
(56, 'district', 'delete district', 'web', '2022-09-17 01:38:18', '2022-09-17 01:38:18', NULL, 1, NULL, NULL),
(57, 'shift', 'view shift', 'web', '2022-09-17 01:38:42', '2022-09-17 01:38:42', NULL, 1, NULL, NULL),
(58, 'shift', 'add shift', 'web', '2022-09-17 01:38:51', '2022-09-17 01:38:51', NULL, 1, NULL, NULL),
(59, 'shift', 'edit shift', 'web', '2022-09-17 01:38:59', '2022-09-17 01:38:59', NULL, 1, NULL, NULL),
(60, 'shift', 'delete shift', 'web', '2022-09-17 01:39:17', '2022-09-17 01:39:17', NULL, 1, NULL, NULL),
(61, 'letter-grade', 'view letter-grade', 'web', '2022-09-17 01:39:42', '2022-09-17 01:39:42', NULL, 1, NULL, NULL),
(62, 'letter-grade', 'add letter-grade', 'web', '2022-09-17 01:39:51', '2022-09-17 01:39:51', NULL, 1, NULL, NULL),
(63, 'letter-grade', 'edit letter-grade', 'web', '2022-09-17 01:39:59', '2022-09-17 01:39:59', NULL, 1, NULL, NULL),
(64, 'letter-grade', 'delete letter-grade', 'web', '2022-09-17 01:40:07', '2022-09-17 01:40:07', NULL, 1, NULL, NULL),
(65, 'credit', 'view credit', 'web', '2022-09-17 01:40:40', '2022-09-17 01:40:40', NULL, 1, NULL, NULL),
(66, 'credit', 'add credit', 'web', '2022-09-17 01:40:48', '2022-09-17 01:40:48', NULL, 1, NULL, NULL),
(67, 'credit', 'edit credit', 'web', '2022-09-17 01:40:56', '2022-09-17 01:40:56', NULL, 1, NULL, NULL),
(68, 'credit', 'delete credit', 'web', '2022-09-17 01:41:06', '2022-09-17 01:41:06', NULL, 1, NULL, NULL),
(69, 'subject', 'view subject', 'web', '2022-09-17 01:45:22', '2022-09-17 01:45:22', NULL, 1, NULL, NULL),
(70, 'subject', 'add subject', 'web', '2022-09-17 01:45:32', '2022-09-17 01:45:32', NULL, 1, NULL, NULL),
(71, 'subject', 'edit subject', 'web', '2022-09-17 01:45:40', '2022-09-17 01:45:40', NULL, 1, NULL, NULL),
(72, 'subject', 'delete subject', 'web', '2022-09-17 01:45:48', '2022-09-17 01:45:48', NULL, 1, NULL, NULL),
(73, 'grade-calculation', 'view grade-calculation', 'web', '2022-09-17 01:46:09', '2022-09-17 01:46:09', NULL, 1, NULL, NULL),
(74, 'grade-calculation', 'add grade-calculation', 'web', '2022-09-17 01:46:18', '2022-09-17 01:46:18', NULL, 1, NULL, NULL),
(75, 'grade-calculation', 'edit grade-calculation', 'web', '2022-09-17 01:46:26', '2022-09-17 01:46:26', NULL, 1, NULL, NULL),
(76, 'grade-calculation', 'delete grade-calculation', 'web', '2022-09-17 01:46:42', '2022-09-17 01:46:42', NULL, 1, NULL, NULL),
(77, 'nationality', 'view nationality', 'web', '2022-09-17 01:47:02', '2022-09-17 01:47:02', NULL, 1, NULL, NULL),
(78, 'nationality', 'add nationality', 'web', '2022-09-17 01:47:13', '2022-09-17 01:47:13', NULL, 1, NULL, NULL),
(79, 'nationality', 'edit nationality', 'web', '2022-09-17 01:47:28', '2022-09-17 01:47:28', NULL, 1, NULL, NULL),
(80, 'nationality', 'delete nationality', 'web', '2022-09-17 01:47:43', '2022-09-17 01:47:43', NULL, 1, NULL, NULL),
(83, 'test', 'add test', 'web', '2023-01-28 05:07:27', '2023-01-28 05:07:27', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `subcat_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warranty` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `cat_id`, `subcat_id`, `brand_id`, `unit_id`, `department_id`, `name`, `description`, `warranty`, `qty`, `total_price`, `img`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1, 1, 1, 2, 4, 'Asset-1', '<h1>This is asset-1 product</h1><p>&nbsp;</p>', '2', 199, 600, NULL, '2023-01-28 06:54:43', '2023-01-28 06:58:09', NULL, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Super Admin', 'web', '2022-09-02 17:58:48', NULL, '2022-09-02 17:58:48', NULL, NULL, NULL),
(3, 'User Management', 'web', '2022-09-22 08:41:30', '2022-09-22 08:41:30', NULL, 1, NULL, NULL),
(4, 'Setup Management', 'web', '2022-09-26 10:41:37', '2022-09-26 10:41:37', NULL, 1, NULL, NULL),
(8, 'Admin', 'web', '2023-01-28 05:05:18', '2023-01-28 05:05:18', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(5, 3),
(6, 3),
(7, 3),
(9, 3),
(10, 3),
(11, 3),
(13, 4),
(14, 4),
(15, 4),
(16, 4),
(17, 4),
(18, 4),
(19, 4),
(20, 4),
(21, 4),
(22, 4),
(23, 4),
(24, 4),
(25, 4),
(26, 4),
(27, 4),
(28, 4),
(29, 4),
(30, 4),
(31, 4),
(32, 4),
(33, 4),
(34, 4),
(35, 4),
(36, 4),
(37, 4),
(38, 4),
(39, 4),
(40, 4),
(41, 4),
(42, 4),
(43, 4),
(44, 4),
(45, 4),
(46, 4),
(47, 4),
(48, 4),
(49, 4),
(50, 4),
(51, 4),
(52, 4),
(53, 4),
(54, 4),
(55, 4),
(56, 4),
(57, 4),
(58, 4),
(59, 4),
(60, 4),
(61, 4),
(62, 4),
(63, 4),
(64, 4),
(65, 4),
(66, 4),
(67, 4),
(68, 4),
(69, 4),
(69, 8),
(70, 4),
(70, 8),
(71, 4),
(71, 8),
(72, 4),
(72, 8),
(73, 4),
(73, 8),
(74, 4),
(74, 8),
(75, 4),
(75, 8),
(76, 4),
(76, 8),
(77, 4),
(77, 8),
(78, 4),
(78, 8),
(79, 4),
(79, 8),
(80, 4),
(80, 8);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `floor_id` bigint(20) UNSIGNED NOT NULL,
  `room` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_seat` int(11) DEFAULT NULL,
  `room_details` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `floor_id`, `room`, `name`, `total_seat`, `room_details`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(6, 12, 101, 'Room-1', 30, 'This is room -1', '2023-01-28 05:19:25', '2023-01-28 05:19:25', NULL, 1, NULL, NULL),
(7, 12, 102, 'Room-2', 30, 'This is room-2', '2023-01-28 05:19:25', '2023-01-28 05:19:25', NULL, 1, NULL, NULL),
(8, 13, 201, 'Room-1', 40, 'This is room-1', '2023-01-28 05:19:25', '2023-01-28 05:19:25', NULL, 1, NULL, NULL),
(9, 13, 202, 'Room-2', 40, 'This is room-2', '2023-01-28 05:19:25', '2023-01-28 05:19:25', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `routines`
--

CREATE TABLE `routines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `semester_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routine_dates`
--

CREATE TABLE `routine_dates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `routine_id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `week` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `department_id`, `name`, `short_name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 4, 'Section-A', 'S-A', '2023-01-28 06:45:33', '2023-01-28 06:45:33', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`id`, `name`, `details`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(4, '1st semester', 'This is first semester', '2023-01-28 05:47:59', '2023-01-28 05:47:59', NULL, 1, NULL, NULL),
(5, '2nd Semester', 'This is second semester', '2023-01-28 05:48:23', '2023-01-28 05:48:23', NULL, 1, NULL, NULL),
(6, '3rd Semester', 'This is third semester', '2023-01-28 05:48:47', '2023-01-28 05:48:47', NULL, 1, NULL, NULL),
(7, '4th Semester', 'This is fourth semester', '2023-01-28 05:49:22', '2023-01-28 05:49:22', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `semester_durations`
--

CREATE TABLE `semester_durations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `semester_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `semester_durations`
--

INSERT INTO `semester_durations` (`id`, `semester_id`, `session_id`, `start`, `end`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(9, 7, 5, '2022-01-01 00:00:00', '2022-06-01 00:00:00', '2023-01-28 06:18:17', '2023-01-28 06:18:17', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `start` year(4) NOT NULL,
  `end` year(4) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `start`, `end`, `name`, `details`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(5, 2020, 2021, NULL, 'This is 20-21 session', '2023-01-28 06:16:21', '2023-01-28 06:16:21', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(5, '1st Shift', '2023-01-28 06:18:43', '2023-01-28 06:18:43', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `std_attendances`
--

CREATE TABLE `std_attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_infos_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_id` bigint(20) UNSIGNED NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attendance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `std_attendances`
--

INSERT INTO `std_attendances` (`id`, `student_infos_id`, `attendance_id`, `class`, `date`, `attendance`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(7, 5, 6, '1', '01/02/2023', '1', '2023-01-28 06:36:48', '2023-01-28 06:36:48', 1, NULL, NULL, NULL),
(8, 5, 6, '2', '01/02/2023', '1', '2023-01-28 06:39:23', '2023-01-28 06:39:23', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_infos`
--

CREATE TABLE `student_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `departments_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `present_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parmanent_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gardian_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bg_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_infos`
--

INSERT INTO `student_infos` (`id`, `departments_id`, `student_id`, `name`, `father_name`, `mother_name`, `present_address`, `parmanent_address`, `email`, `phone`, `gardian_phone`, `gender`, `dob`, `nationality`, `bg_id`, `quota`, `division_id`, `district_id`, `photo`, `session`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(5, 4, '2023015', 'Md Shariful Islam', 'Enamul Haque', 'Sayeda Banu', 'Rajshahi, Bangladesh', 'Rajshahi, Bangladesh', 'shariful@gmail.com', '01792980503', '01740955009', 'Male', '09/11/2001', 'Bangladeshi', 10, NULL, 7, 55, 'public/student-info/5/photo/download (1).jfif', NULL, '1', '2023-01-28 06:33:52', '2023-01-28 06:34:50', NULL, 1, NULL, NULL),
(6, 4, NULL, 'Justin Ellison', 'Palmer Sellers', 'Reese Hoover', 'Ab asperiores nisi m', 'Rerum cum eaque tene', 'mazynasom@mailinator.com', '01789756789', '01787568888', 'Male', '18-Dec-2015', 'Eligendi libero quae', 10, 'Saepe iste unde ex c', 3, 22, NULL, NULL, '0', '2023-02-01 04:48:19', '2023-02-10 06:00:57', NULL, 1, 1, NULL),
(7, 4, NULL, 'Jayme Collins', 'Christen Guerra', 'Lynn Howell', 'Ab ipsum sed magnam', 'Est ullam excepturi', 'gobycy@mailinator.com', '01793454324', '01782898767', 'Male', '10-Jul-1990', 'Reprehenderit mollit', 11, 'In eaque ab est et', 2, 13, NULL, NULL, '-1', '2023-02-01 04:50:36', '2023-02-03 06:01:40', NULL, 1, NULL, NULL),
(8, 4, NULL, 'Raven Mendez', 'Macon Reyes', 'Neville Baldwin', 'Ut sint dolorum dolo', 'Qui esse sint porro', 'gypul@mailinator.com', '01792980502', '01792980502', 'Female', '27-May-1978', 'Possimus harum volu', 10, NULL, 3, 21, NULL, NULL, '-1', '2023-02-03 03:47:23', '2023-02-03 05:14:33', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `cat_id`, `name`, `img`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1, 'Subcat-1', NULL, '2023-01-28 06:45:52', '2023-01-28 06:45:52', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `code`, `credit_id`, `department_id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(6, 'Python', '757574', 7, 4, '2023-01-28 06:19:28', '2023-01-28 06:19:28', 1, NULL, NULL, NULL),
(7, 'Java', '666786', 7, 4, '2023-01-28 06:20:50', '2023-01-28 06:20:50', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject_assigns`
--

CREATE TABLE `subject_assigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `semester_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject_assigns`
--

INSERT INTO `subject_assigns` (`id`, `session_id`, `department_id`, `subject_id`, `semester_id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(8, 5, 4, 7, 7, '2023-01-28 06:21:12', '2023-01-28 06:21:12', 1, NULL, NULL, NULL),
(9, 5, 4, 6, 7, '2023-01-28 06:21:12', '2023-01-28 06:21:12', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subsections`
--

CREATE TABLE `subsections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subsections`
--

INSERT INTO `subsections` (`id`, `section_id`, `name`, `short_name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1, 'Sub-section-1', 'S-S-1', '2023-01-28 06:46:14', '2023-01-28 06:46:14', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `shop_name`, `owner_name`, `address`, `phone`, `details`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `email`) VALUES
(4, 'Shop-1', 'Shariful', 'Dhaka, Bangladesh', '01792980503', 'This is shop-1 details', '2023-01-28 06:48:28', '2023-01-28 06:48:28', NULL, 1, NULL, NULL, 'shariful@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departments_id` bigint(20) UNSIGNED NOT NULL,
  `divisions_id` bigint(20) UNSIGNED NOT NULL,
  `districts_id` bigint(20) UNSIGNED NOT NULL,
  `bloodgroups_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_birth` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `present_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanant_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `departments_id`, `divisions_id`, `districts_id`, `bloodgroups_id`, `date_of_birth`, `phone`, `email`, `nid`, `gender`, `present_address`, `permanant_address`, `photo`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(15, 'Shariful', 4, 7, 59, 10, '21-11-2001', '01792980503', 'shariful@gmail.com', '5662654588', 'Male', 'Dhaka, Bangladesh', 'Dhaka, Bangladesh', 'public/teacher-info/15/photo/logo.png', '2023-01-28 06:24:28', '2023-01-28 06:24:28', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_assigns`
--

CREATE TABLE `teacher_assigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_assign_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `shift_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_assigns`
--

INSERT INTO `teacher_assigns` (`id`, `subject_assign_id`, `teacher_id`, `shift_id`, `group_id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(8, 9, 15, 5, 7, '2023-01-28 06:25:00', '2023-01-28 06:25:00', NULL, NULL, NULL, NULL),
(9, 8, 15, 5, 7, '2023-01-28 06:25:00', '2023-01-28 06:25:00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_files`
--

CREATE TABLE `tmp_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tmp_files`
--

INSERT INTO `tmp_files` (`id`, `path`, `filename`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'file/tmp/6320284c18b90/hedi_page-img.png', '', '2022-09-13 06:50:52', '2022-09-13 06:50:52', NULL, 1, NULL, NULL),
(2, 'file/tmp/6320286391a12/942142-bigthumbnail.jpg', '', '2022-09-13 06:51:15', '2022-09-13 06:51:15', NULL, 1, NULL, NULL),
(3, 'file/tmp/632028683b4a5/PIMS metting summary 01-09-2022 .pdf', '', '2022-09-13 06:51:20', '2022-09-13 06:51:20', NULL, 1, NULL, NULL),
(4, 'file/tmp/632c6f394ae55/hedi_page-img.png', '', '2022-09-22 14:20:41', '2022-09-22 14:20:41', NULL, 1, NULL, NULL),
(5, 'file/tmp/632fff0f2e168', '284551877_1291793464683090_7328783694672356468_n.jpg', '2022-09-25 07:11:11', '2022-09-25 07:11:11', NULL, 1, NULL, NULL),
(6, 'file/tmp/632fff4c8c431', 'WhatsApp Image 2022-08-21 at 10.19.10 PM.jpeg', '2022-09-25 07:12:12', '2022-09-25 07:12:12', NULL, 1, NULL, NULL),
(7, 'file/tmp/632fff50e30e1', 'WhatsApp Image 2022-08-21 at 10.19.10 PM.jpeg', '2022-09-25 07:12:16', '2022-09-25 07:12:16', NULL, 1, NULL, NULL),
(8, 'file/tmp/6330011d8c0dc', '284551877_1291793464683090_7328783694672356468_n.jpg', '2022-09-25 07:19:57', '2022-09-25 07:19:57', NULL, 1, NULL, NULL),
(9, 'file/tmp/6330013d11ee0', 'logo.png', '2022-09-25 07:20:29', '2022-09-25 07:20:29', NULL, 1, NULL, NULL),
(10, 'file/tmp/63300148944f2', 'Screenshot_2.png', '2022-09-25 07:20:40', '2022-09-25 07:20:40', NULL, 1, NULL, NULL),
(11, 'file/tmp/633582c9059aa', 'Sup-n-dine-Icon-with-bcg.png', '2022-09-29 11:34:33', '2022-09-29 11:34:33', NULL, 1, NULL, NULL),
(12, 'file/tmp/633582f8a691c', 'Sup-n-dine-Icon-with-bcg.png', '2022-09-29 11:35:20', '2022-09-29 11:35:20', NULL, 1, NULL, NULL),
(13, 'file/tmp/633588dc4dbcd', 'Sup-n-dine-Icon-with-bcg.png', '2022-09-29 12:00:28', '2022-09-29 12:00:28', NULL, 1, NULL, NULL),
(14, 'file/tmp/63358920e6869', 'Sup-n-dine-Icon-with-bcg.png', '2022-09-29 12:01:36', '2022-09-29 12:01:36', NULL, 1, NULL, NULL),
(15, 'file/tmp/633d4f3168e28', 'Sup-n-dine-Icon-with-bcg.png', '2022-10-05 09:32:33', '2022-10-05 09:32:33', NULL, 1, NULL, NULL),
(16, 'file/tmp/633d4f76b15dd', 'accounting chapter 4.pdf', '2022-10-05 09:33:42', '2022-10-05 09:33:42', NULL, 1, NULL, NULL),
(17, 'file/tmp/633d4f88b7bde', 'Chapter 01 (2).pdf', '2022-10-05 09:34:00', '2022-10-05 09:34:00', NULL, 1, NULL, NULL),
(18, 'file/tmp/633d52b42a9f2', '284551877_1291793464683090_7328783694672356468_n.jpg', '2022-10-05 09:47:32', '2022-10-05 09:47:32', NULL, 1, NULL, NULL),
(19, 'file/tmp/633d530644a10', 'Admitted student - Polytechnic Information Managenment System.pdf', '2022-10-05 09:48:54', '2022-10-05 09:48:54', NULL, 1, NULL, NULL),
(20, 'file/tmp/633d530889106', 'Admitted student - Polytechnic Information Managenment System.pdf', '2022-10-05 09:48:56', '2022-10-05 09:48:56', NULL, 1, NULL, NULL),
(21, 'file/tmp/633d53397fb14', 'logo.png', '2022-10-05 09:49:45', '2022-10-05 09:49:45', NULL, 1, NULL, NULL),
(22, 'file/tmp/633d533bef74b', 'logo.png', '2022-10-05 09:49:47', '2022-10-05 09:49:47', NULL, 1, NULL, NULL),
(23, 'file/tmp/633d53856c973', '284551877_1291793464683090_7328783694672356468_n.jpg', '2022-10-05 09:51:01', '2022-10-05 09:51:01', NULL, 1, NULL, NULL),
(24, 'file/tmp/633d53c0a5059', '284551877_1291793464683090_7328783694672356468_n.jpg', '2022-10-05 09:52:00', '2022-10-05 09:52:00', NULL, 1, NULL, NULL),
(25, 'file/tmp/633d53e0e8d8b', 'Admitted student - Polytechnic Information Managenment System.pdf', '2022-10-05 09:52:32', '2022-10-05 09:52:32', NULL, 1, NULL, NULL),
(26, 'file/tmp/633d53e261060', 'logo.png', '2022-10-05 09:52:34', '2022-10-05 09:52:34', NULL, 1, NULL, NULL),
(27, 'file/tmp/633e9a73ddef6', '7C2EB572-FA06-47F2-B259-22C4A86A79AC-scaled (1).jpeg', '2022-10-06 09:05:55', '2022-10-06 09:05:55', NULL, 1, NULL, NULL),
(28, 'file/tmp/6346a854d6544', '1.jpg', '2022-10-12 11:43:16', '2022-10-12 11:43:16', NULL, 1, NULL, NULL),
(29, 'file/tmp/6346a8b70888f', '1.jpg', '2022-10-12 11:44:55', '2022-10-12 11:44:55', NULL, 1, NULL, NULL),
(30, 'file/tmp/6346a8be31397', '2022_10_11_15-56-04_pm.pdf', '2022-10-12 11:45:02', '2022-10-12 11:45:02', NULL, 1, NULL, NULL),
(31, 'file/tmp/6346a8c9e9e8f', '_ Covid 9 - Vacine Card - MUHAMMAD MASARRAT ARYAN (1).pdf', '2022-10-12 11:45:13', '2022-10-12 11:45:13', NULL, 1, NULL, NULL),
(32, 'file/tmp/6346a9a0b5db2', '1.jpg', '2022-10-12 11:48:48', '2022-10-12 11:48:48', NULL, 1, NULL, NULL),
(33, 'file/tmp/6346a9de39da9', 'Plan for Successfull Completing Inustrial Training22 - 2022.pdf', '2022-10-12 11:49:50', '2022-10-12 11:49:50', NULL, 1, NULL, NULL),
(34, 'file/tmp/6346a9e61db16', 'Ath Thibbun ppt final_pdf.pdf', '2022-10-12 11:49:58', '2022-10-12 11:49:58', NULL, 1, NULL, NULL),
(35, 'file/tmp/6346aa42b280e', 'Ath Thibbun ppt final_pdf.pdf', '2022-10-12 11:51:30', '2022-10-12 11:51:30', NULL, 1, NULL, NULL),
(36, 'file/tmp/6346aa437a45e', 'MD._AMINUL_ISLAM.pdf', '2022-10-12 11:51:31', '2022-10-12 11:51:31', NULL, 1, NULL, NULL),
(37, 'file/tmp/6346aa73d63c4', 'WhatsApp Image 2022-10-12 at 1.42.13 PM.jpeg', '2022-10-12 11:52:19', '2022-10-12 11:52:19', NULL, 1, NULL, NULL),
(38, 'file/tmp/6346aa7e447aa', '1.jpg', '2022-10-12 11:52:30', '2022-10-12 11:52:30', NULL, 1, NULL, NULL),
(39, 'file/tmp/6346aa9040f9e', 'Plan for Successfull Completing Inustrial Training22 - 2022.pdf', '2022-10-12 11:52:48', '2022-10-12 11:52:48', NULL, 1, NULL, NULL),
(40, 'file/tmp/6346aa95b8e95', '2022_10_11_15-56-04_pm.pdf', '2022-10-12 11:52:53', '2022-10-12 11:52:53', NULL, 1, NULL, NULL),
(41, 'file/tmp/6346aaaf299b4', 'Plan for Successfull Completing Inustrial Training22 - 2022.pdf', '2022-10-12 11:53:19', '2022-10-12 11:53:19', NULL, 1, NULL, NULL),
(42, 'file/tmp/6346aab28dc05', 'Shakil_Ahamed.pdf', '2022-10-12 11:53:22', '2022-10-12 11:53:22', NULL, 1, NULL, NULL),
(43, 'file/tmp/63cf8c00acc59', 'Screenshot_50.png', '2023-01-24 01:42:57', '2023-01-24 01:42:57', NULL, 1, NULL, NULL),
(44, 'file/tmp/63cf8edf5ee3b', 'Screenshot_50.png', '2023-01-24 01:55:11', '2023-01-24 01:55:11', NULL, 1, NULL, NULL),
(45, 'file/tmp/63cf8f1febce0', 'Screenshot_50.png', '2023-01-24 01:56:15', '2023-01-24 01:56:16', NULL, 1, NULL, NULL),
(46, 'file/tmp/63cf901e15545', 'Screenshot_50.png', '2023-01-24 02:00:30', '2023-01-24 02:00:30', NULL, 1, NULL, NULL),
(47, 'file/tmp/63cf90a879763', 'Screenshot_50.png', '2023-01-24 02:02:48', '2023-01-24 02:02:48', NULL, 1, NULL, NULL),
(48, 'file/tmp/63cf9210e7b3c', 'Screenshot_50.png', '2023-01-24 02:08:48', '2023-01-24 02:08:48', NULL, 1, NULL, NULL),
(49, 'file/tmp/63cf9399d6c8e', 'Screenshot_50.png', '2023-01-24 02:15:21', '2023-01-24 02:15:21', NULL, 1, NULL, NULL),
(50, 'file/tmp/63cf940ceb52e', 'Screenshot_50.png', '2023-01-24 02:17:16', '2023-01-24 02:17:17', NULL, 1, NULL, NULL),
(51, 'file/tmp/63cfb22cc90f2', 'Screenshot_50.png', '2023-01-24 04:25:49', '2023-01-24 04:25:49', NULL, 1, NULL, NULL),
(52, 'file/tmp/63cfc1abb2bb9', 'Screenshot_50.png', '2023-01-24 05:31:55', '2023-01-24 05:31:55', NULL, 1, NULL, NULL),
(53, 'file/tmp/63cfc1cdd60ec', 'Screenshot_50.png', '2023-01-24 05:32:29', '2023-01-24 05:32:29', NULL, 1, NULL, NULL),
(54, 'file/tmp/63cfc283120b7', 'Screenshot_50.png', '2023-01-24 05:35:31', '2023-01-24 05:35:31', NULL, 1, NULL, NULL),
(55, 'file/tmp/63cfc31bd5164', 'Screenshot_50.png', '2023-01-24 05:38:03', '2023-01-24 05:38:03', NULL, 1, NULL, NULL),
(56, 'file/tmp/63cfc32b9f8ce', 'Screenshot_50.png', '2023-01-24 05:38:19', '2023-01-24 05:38:19', NULL, 1, NULL, NULL),
(57, 'file/tmp/63cfc353edb43', 'Screenshot_50.png', '2023-01-24 05:39:00', '2023-01-24 05:39:00', NULL, 1, NULL, NULL),
(58, 'file/tmp/63cfc380b395a', 'Screenshot_50.png', '2023-01-24 05:39:44', '2023-01-24 05:39:44', NULL, 1, NULL, NULL),
(59, 'file/tmp/63cfc397e7ae4', 'Screenshot_50.png', '2023-01-24 05:40:07', '2023-01-24 05:40:07', NULL, 1, NULL, NULL),
(60, 'file/tmp/63d0e0c05332b', 'Screenshot_50.png', '2023-01-25 01:56:48', '2023-01-25 01:56:48', NULL, 1, NULL, NULL),
(61, 'file/tmp/63d0e0d979fa6', 'Screenshot_50.png', '2023-01-25 01:57:13', '2023-01-25 01:57:13', NULL, 1, NULL, NULL),
(62, 'file/tmp/63d0e0decfa49', 'Screenshot_50.png', '2023-01-25 01:57:18', '2023-01-25 01:57:18', NULL, 1, NULL, NULL),
(63, 'file/tmp/63d0e79107915', 'Screenshot_50.png', '2023-01-25 02:25:53', '2023-01-25 02:25:53', NULL, 1, NULL, NULL),
(64, 'file/tmp/63d0e79546a53', 'Screenshot_50.png', '2023-01-25 02:25:57', '2023-01-25 02:25:57', NULL, 1, NULL, NULL),
(65, 'file/tmp/63d0e7f20d084', 'Screenshot_50.png', '2023-01-25 02:27:30', '2023-01-25 02:27:30', NULL, 1, NULL, NULL),
(66, 'file/tmp/63d0e7ff1a455', 'Screenshot_50.png', '2023-01-25 02:27:43', '2023-01-25 02:27:43', NULL, 1, NULL, NULL),
(67, 'file/tmp/63d0e80357a82', 'Screenshot_50.png', '2023-01-25 02:27:47', '2023-01-25 02:27:47', NULL, 1, NULL, NULL),
(68, 'file/tmp/63d100198854c', 'Screenshot_50.png', '2023-01-25 04:10:33', '2023-01-25 04:10:33', NULL, 1, NULL, NULL),
(69, 'file/tmp/63d1004917688', 'Screenshot_50.png', '2023-01-25 04:11:21', '2023-01-25 04:11:21', NULL, 1, NULL, NULL),
(70, 'file/tmp/63d1004c8a40b', 'Screenshot_50.png', '2023-01-25 04:11:24', '2023-01-25 04:11:24', NULL, 1, NULL, NULL),
(71, 'file/tmp/63d141e8bc1a4', 'Thomas projects checklist.pdf', '2023-01-25 08:51:21', '2023-01-25 08:51:21', NULL, 1, NULL, NULL),
(72, 'file/tmp/63d141ee25900', 'Thomas projects checklist.pdf', '2023-01-25 08:51:26', '2023-01-25 08:51:26', NULL, 1, NULL, NULL),
(73, 'file/tmp/63d3c1f84fbdb', 'Screenshot_50.png', '2023-01-27 06:22:16', '2023-01-27 06:22:16', NULL, 1, NULL, NULL),
(74, 'file/tmp/63d5137a5b103', 'logo.png', '2023-01-28 06:22:18', '2023-01-28 06:22:18', NULL, 1, NULL, NULL),
(75, 'file/tmp/63d515eddd835', 'download (1).jfif', '2023-01-28 06:32:45', '2023-01-28 06:32:45', NULL, 1, NULL, NULL),
(76, 'file/tmp/63d51629aee8c', 'Reg Card-1.jfif', '2023-01-28 06:33:45', '2023-01-28 06:33:45', NULL, 1, NULL, NULL),
(77, 'file/tmp/63d5162d2eaa5', 'marksheet-1.jfif', '2023-01-28 06:33:49', '2023-01-28 06:33:49', NULL, 1, NULL, NULL),
(78, 'file/tmp/63da436cdb2be', 'marksheet-1.jfif', '2023-02-01 04:48:13', '2023-02-01 04:48:13', NULL, 1, NULL, NULL),
(79, 'file/tmp/63da436fdbb55', 'Reg Card-1.jfif', '2023-02-01 04:48:15', '2023-02-01 04:48:15', NULL, 1, NULL, NULL),
(80, 'file/tmp/63da43f65efee', 'marksheet-1.jfif', '2023-02-01 04:50:30', '2023-02-01 04:50:30', NULL, 1, NULL, NULL),
(81, 'file/tmp/63da43fa1e1a9', 'marksheet-2.png', '2023-02-01 04:50:34', '2023-02-01 04:50:34', NULL, 1, NULL, NULL),
(82, 'file/tmp/63dccadfeca0c', 'marksheet-1.jfif', '2023-02-03 02:50:40', '2023-02-03 02:50:40', NULL, 1, NULL, NULL),
(83, 'file/tmp/63dccebfccd60', 'marksheet-2.png', '2023-02-03 03:07:12', '2023-02-03 03:07:12', NULL, 1, NULL, NULL),
(84, 'file/tmp/63dccec32d818', 'marksheet-2.png', '2023-02-03 03:07:15', '2023-02-03 03:07:15', NULL, 1, NULL, NULL),
(85, 'file/tmp/63dccec6c1974', 'marksheet-2.png', '2023-02-03 03:07:18', '2023-02-03 03:07:18', NULL, 1, NULL, NULL),
(86, 'file/tmp/63dcd032c2459', 'download.jfif', '2023-02-03 03:13:22', '2023-02-03 03:13:22', NULL, 1, NULL, NULL),
(87, 'file/tmp/63dcd03588590', 'marksheet-2.png', '2023-02-03 03:13:25', '2023-02-03 03:13:25', NULL, 1, NULL, NULL),
(88, 'file/tmp/63dcd03954167', 'marksheet-1.jfif', '2023-02-03 03:13:29', '2023-02-03 03:13:29', NULL, 1, NULL, NULL),
(89, 'file/tmp/63dcd1648187c', 'Reg Card-1.jfif', '2023-02-03 03:18:28', '2023-02-03 03:18:28', NULL, 1, NULL, NULL),
(90, 'file/tmp/63dcd16985bba', 'Reg Card-2.jfif', '2023-02-03 03:18:33', '2023-02-03 03:18:33', NULL, 1, NULL, NULL),
(91, 'file/tmp/63dcd16d03e25', 'download.jfif', '2023-02-03 03:18:37', '2023-02-03 03:18:37', NULL, 1, NULL, NULL),
(92, 'file/tmp/63dcd3ff37d8a', 'marksheet-2.png', '2023-02-03 03:29:35', '2023-02-03 03:29:35', NULL, 1, NULL, NULL),
(93, 'file/tmp/63dcd40221418', 'Reg Card-1.jfif', '2023-02-03 03:29:38', '2023-02-03 03:29:38', NULL, 1, NULL, NULL),
(94, 'file/tmp/63dcd4060c731', 'download.jfif', '2023-02-03 03:29:42', '2023-02-03 03:29:42', NULL, 1, NULL, NULL),
(95, 'file/tmp/63dcd41285901', 'marksheet-1.jfif', '2023-02-03 03:29:54', '2023-02-03 03:29:54', NULL, 1, NULL, NULL),
(96, 'file/tmp/63dcd41681f86', 'marksheet-2.png', '2023-02-03 03:29:58', '2023-02-03 03:29:58', NULL, 1, NULL, NULL),
(97, 'file/tmp/63dcd41af2c72', 'marksheet-1.jfif', '2023-02-03 03:30:03', '2023-02-03 03:30:03', NULL, 1, NULL, NULL),
(98, 'file/tmp/63dcd49411857', 'marksheet-1.jfif', '2023-02-03 03:32:04', '2023-02-03 03:32:04', NULL, 1, NULL, NULL),
(99, 'file/tmp/63dcd4a1b7108', 'download.jfif', '2023-02-03 03:32:17', '2023-02-03 03:32:17', NULL, 1, NULL, NULL),
(100, 'file/tmp/63dcd4a876a61', 'marksheet-1.jfif', '2023-02-03 03:32:24', '2023-02-03 03:32:24', NULL, 1, NULL, NULL),
(101, 'file/tmp/63dcd622de9b8', 'marksheet-1.jfif', '2023-02-03 03:38:42', '2023-02-03 03:38:42', NULL, 1, NULL, NULL),
(102, 'file/tmp/63dcd625b2529', 'Reg Card-1.jfif', '2023-02-03 03:38:45', '2023-02-03 03:38:45', NULL, 1, NULL, NULL),
(103, 'file/tmp/63dcd6299c273', 'Reg Card-2.jfif', '2023-02-03 03:38:49', '2023-02-03 03:38:49', NULL, 1, NULL, NULL),
(104, 'file/tmp/63dcd76b445d2', 'marksheet-1.jfif', '2023-02-03 03:44:11', '2023-02-03 03:44:11', NULL, 1, NULL, NULL),
(105, 'file/tmp/63dcd76ddf1c4', 'marksheet-2.png', '2023-02-03 03:44:13', '2023-02-03 03:44:13', NULL, 1, NULL, NULL),
(106, 'file/tmp/63dcd771b35d1', 'Reg Card-2.jfif', '2023-02-03 03:44:17', '2023-02-03 03:44:17', NULL, 1, NULL, NULL),
(107, 'file/tmp/63dcd7ca0f5d7', 'download.jfif', '2023-02-03 03:45:46', '2023-02-03 03:45:46', NULL, 1, NULL, NULL),
(108, 'file/tmp/63dcd7cd03886', 'marksheet-1.jfif', '2023-02-03 03:45:49', '2023-02-03 03:45:49', NULL, 1, NULL, NULL),
(109, 'file/tmp/63dcd7d044261', 'marksheet-2.png', '2023-02-03 03:45:52', '2023-02-03 03:45:52', NULL, 1, NULL, NULL),
(110, 'file/tmp/63dcd80163b46', 'marksheet-1.jfif', '2023-02-03 03:46:41', '2023-02-03 03:46:41', NULL, 1, NULL, NULL),
(111, 'file/tmp/63dcd804f35fa', 'Reg Card-1.jfif', '2023-02-03 03:46:45', '2023-02-03 03:46:45', NULL, 1, NULL, NULL),
(112, 'file/tmp/63dcd80a6add1', 'Reg Card-2.jfif', '2023-02-03 03:46:50', '2023-02-03 03:46:50', NULL, 1, NULL, NULL),
(113, 'file/tmp/63dcd80d4e2da', 'Reg Card-2.jfif', '2023-02-03 03:46:53', '2023-02-03 03:46:53', NULL, 1, NULL, NULL),
(114, 'file/tmp/63dcdc0858adb', 'download.jfif', '2023-02-03 04:03:52', '2023-02-03 04:03:52', NULL, 1, NULL, NULL),
(115, 'file/tmp/63dcdc0d01244', 'Reg Card-2.jfif', '2023-02-03 04:03:57', '2023-02-03 04:03:57', NULL, 1, NULL, NULL),
(116, 'file/tmp/63dcdc127101b', 'download.jfif', '2023-02-03 04:04:02', '2023-02-03 04:04:02', NULL, 1, NULL, NULL),
(117, 'file/tmp/63dcec14caa1b', 'download.jfif', '2023-02-03 05:12:20', '2023-02-03 05:12:20', NULL, 1, NULL, NULL),
(118, 'file/tmp/63dcec17e65d2', 'marksheet-1.jfif', '2023-02-03 05:12:23', '2023-02-03 05:12:23', NULL, 1, NULL, NULL),
(119, 'file/tmp/63dcec1df1e00', 'Reg Card-1.jfif', '2023-02-03 05:12:30', '2023-02-03 05:12:30', NULL, 1, NULL, NULL),
(120, 'file/tmp/63dcec3d1f4e8', 'download.jfif', '2023-02-03 05:13:01', '2023-02-03 05:13:01', NULL, 1, NULL, NULL),
(121, 'file/tmp/63dcec4068521', 'marksheet-1.jfif', '2023-02-03 05:13:04', '2023-02-03 05:13:04', NULL, 1, NULL, NULL),
(122, 'file/tmp/63dcec43c04f9', 'Reg Card-1.jfif', '2023-02-03 05:13:07', '2023-02-03 05:13:07', NULL, 1, NULL, NULL),
(123, 'file/tmp/63dcec56cce82', 'marksheet-1.jfif', '2023-02-03 05:13:26', '2023-02-03 05:13:26', NULL, 1, NULL, NULL),
(124, 'file/tmp/63dcec59ef9d7', 'marksheet-2.png', '2023-02-03 05:13:29', '2023-02-03 05:13:30', NULL, 1, NULL, NULL),
(125, 'file/tmp/63dcec5fbe14b', 'Reg Card-2.jfif', '2023-02-03 05:13:35', '2023-02-03 05:13:35', NULL, 1, NULL, NULL),
(126, 'file/tmp/63dcec665f641', 'download (1).jfif', '2023-02-03 05:13:42', '2023-02-03 05:13:42', NULL, 1, NULL, NULL),
(127, 'file/tmp/63dcf84caca19', 'marksheet-1.jfif', '2023-02-03 06:04:28', '2023-02-03 06:04:28', NULL, 1, NULL, NULL),
(128, 'file/tmp/63dcf85085795', 'Reg Card-1.jfif', '2023-02-03 06:04:32', '2023-02-03 06:04:32', NULL, 1, NULL, NULL),
(129, 'file/tmp/63dcf85488f1f', 'Reg Card-2.jfif', '2023-02-03 06:04:36', '2023-02-03 06:04:36', NULL, 1, NULL, NULL),
(130, 'file/tmp/63dcf873c3b09', 'marksheet-2.png', '2023-02-03 06:05:07', '2023-02-03 06:05:07', NULL, 1, NULL, NULL),
(131, 'file/tmp/63dcf87774ba4', 'Reg Card-1.jfif', '2023-02-03 06:05:11', '2023-02-03 06:05:11', NULL, 1, NULL, NULL),
(132, 'file/tmp/63dcf87bc78d2', 'marksheet-1.jfif', '2023-02-03 06:05:15', '2023-02-03 06:05:15', NULL, 1, NULL, NULL),
(133, 'file/tmp/63dcf87f86988', 'Reg Card-2.jfif', '2023-02-03 06:05:19', '2023-02-03 06:05:19', NULL, 1, NULL, NULL),
(134, 'file/tmp/63dcff420d266', 'download.jfif', '2023-02-03 06:34:10', '2023-02-03 06:34:10', NULL, 1, NULL, NULL),
(135, 'file/tmp/63dcff448ac5e', 'marksheet-2.png', '2023-02-03 06:34:12', '2023-02-03 06:34:12', NULL, 1, NULL, NULL),
(136, 'file/tmp/63dcff4858114', 'marksheet-2.png', '2023-02-03 06:34:16', '2023-02-03 06:34:16', NULL, 1, NULL, NULL),
(137, 'file/tmp/63dcff51e344d', 'marksheet-1.jfif', '2023-02-03 06:34:25', '2023-02-03 06:34:25', NULL, 1, NULL, NULL),
(138, 'file/tmp/63dcff54b1341', 'marksheet-2.png', '2023-02-03 06:34:28', '2023-02-03 06:34:28', NULL, 1, NULL, NULL),
(139, 'file/tmp/63dcff57abffe', 'marksheet-1.jfif', '2023-02-03 06:34:31', '2023-02-03 06:34:31', NULL, 1, NULL, NULL),
(140, 'file/tmp/63dcff5b83f66', 'Reg Card-1.jfif', '2023-02-03 06:34:35', '2023-02-03 06:34:35', NULL, 1, NULL, NULL),
(141, 'file/tmp/63dd006868459', 'Reg Card-1.jfif', '2023-02-03 06:39:04', '2023-02-03 06:39:04', NULL, 1, NULL, NULL),
(142, 'file/tmp/63dd00a6a72e5', 'marksheet-1.jfif', '2023-02-03 06:40:06', '2023-02-03 06:40:06', NULL, 1, NULL, NULL),
(143, 'file/tmp/63dd00aa02e01', 'marksheet-2.png', '2023-02-03 06:40:10', '2023-02-03 06:40:10', NULL, 1, NULL, NULL),
(144, 'file/tmp/63dd00ad88278', 'Reg Card-2.jfif', '2023-02-03 06:40:13', '2023-02-03 06:40:13', NULL, 1, NULL, NULL),
(145, 'file/tmp/63dd07cbee2b6', 'marksheet-1.jfif', '2023-02-03 07:10:35', '2023-02-03 07:10:36', NULL, 1, NULL, NULL),
(146, 'file/tmp/63dd07d08fa18', 'marksheet-2.png', '2023-02-03 07:10:40', '2023-02-03 07:10:40', NULL, 1, NULL, NULL),
(147, 'file/tmp/63dd07d4c2aa7', 'Reg Card-1.jfif', '2023-02-03 07:10:44', '2023-02-03 07:10:44', NULL, 1, NULL, NULL),
(148, 'file/tmp/63dd07ec0f329', 'marksheet-1.jfif', '2023-02-03 07:11:08', '2023-02-03 07:11:08', NULL, 1, NULL, NULL),
(149, 'file/tmp/63dd07ef20442', 'marksheet-2.png', '2023-02-03 07:11:11', '2023-02-03 07:11:11', NULL, 1, NULL, NULL),
(150, 'file/tmp/63dd07f29910f', 'Reg Card-2.jfif', '2023-02-03 07:11:14', '2023-02-03 07:11:14', NULL, 1, NULL, NULL),
(151, 'file/tmp/63dd07f5bac70', 'Reg Card-2.jfif', '2023-02-03 07:11:17', '2023-02-03 07:11:17', NULL, 1, NULL, NULL),
(152, 'file/tmp/63de08b18a895', 'marksheet-2.png', '2023-02-04 01:26:41', '2023-02-04 01:26:41', NULL, 1, NULL, NULL),
(153, 'file/tmp/63de08b48f1eb', 'Reg Card-2.jfif', '2023-02-04 01:26:44', '2023-02-04 01:26:44', NULL, 1, NULL, NULL),
(154, 'file/tmp/63de08b815219', 'marksheet-2.png', '2023-02-04 01:26:48', '2023-02-04 01:26:48', NULL, 1, NULL, NULL),
(155, 'file/tmp/63de08c0a83d4', 'marksheet-2.png', '2023-02-04 01:26:56', '2023-02-04 01:26:56', NULL, 1, NULL, NULL),
(156, 'file/tmp/63de08c35d855', 'Reg Card-1.jfif', '2023-02-04 01:26:59', '2023-02-04 01:26:59', NULL, 1, NULL, NULL),
(157, 'file/tmp/63de08c7144d6', 'Reg Card-2.jfif', '2023-02-04 01:27:03', '2023-02-04 01:27:03', NULL, 1, NULL, NULL),
(158, 'file/tmp/63de08caa7a95', 'Reg Card-1.jfif', '2023-02-04 01:27:06', '2023-02-04 01:27:06', NULL, 1, NULL, NULL),
(159, 'file/tmp/63de138e264ba', 'marksheet-2.png', '2023-02-04 02:13:02', '2023-02-04 02:13:02', NULL, 1, NULL, NULL),
(160, 'file/tmp/63de1390cbe7f', 'Reg Card-2.jfif', '2023-02-04 02:13:04', '2023-02-04 02:13:04', NULL, 1, NULL, NULL),
(161, 'file/tmp/63de13947703c', 'Reg Card-1.jfif', '2023-02-04 02:13:08', '2023-02-04 02:13:08', NULL, 1, NULL, NULL),
(162, 'file/tmp/63de13a2bd1a9', 'marksheet-2.png', '2023-02-04 02:13:22', '2023-02-04 02:13:22', NULL, 1, NULL, NULL),
(163, 'file/tmp/63de13a5a8f6f', 'Reg Card-1.jfif', '2023-02-04 02:13:25', '2023-02-04 02:13:25', NULL, 1, NULL, NULL),
(164, 'file/tmp/63de13a903f2c', 'marksheet-2.png', '2023-02-04 02:13:29', '2023-02-04 02:13:29', NULL, 1, NULL, NULL),
(165, 'file/tmp/63de13abd62e2', 'Reg Card-2.jfif', '2023-02-04 02:13:31', '2023-02-04 02:13:31', NULL, 1, NULL, NULL),
(166, 'file/tmp/63de1cb6f0973', 'marksheet-2.png', '2023-02-04 02:52:06', '2023-02-04 02:52:07', NULL, 1, NULL, NULL),
(167, 'file/tmp/63de1cba15185', 'marksheet-2.png', '2023-02-04 02:52:10', '2023-02-04 02:52:10', NULL, 1, NULL, NULL),
(168, 'file/tmp/63de1cbd7fa1e', 'Reg Card-1.jfif', '2023-02-04 02:52:13', '2023-02-04 02:52:13', NULL, 1, NULL, NULL),
(169, 'file/tmp/63de24f8669c9', 'download.jfif', '2023-02-04 03:27:20', '2023-02-04 03:27:20', NULL, 1, NULL, NULL),
(170, 'file/tmp/63de24fc76de5', 'marksheet-1.jfif', '2023-02-04 03:27:24', '2023-02-04 03:27:24', NULL, 1, NULL, NULL),
(171, 'file/tmp/63de2500e42e6', 'Reg Card-2.jfif', '2023-02-04 03:27:28', '2023-02-04 03:27:28', NULL, 1, NULL, NULL),
(172, 'file/tmp/63de25b98763d', 'marksheet-2.png', '2023-02-04 03:30:33', '2023-02-04 03:30:33', NULL, 1, NULL, NULL),
(173, 'file/tmp/63de25bc191cf', 'Reg Card-2.jfif', '2023-02-04 03:30:36', '2023-02-04 03:30:36', NULL, 1, NULL, NULL),
(174, 'file/tmp/63de25bf23e78', 'marksheet-1.jfif', '2023-02-04 03:30:39', '2023-02-04 03:30:39', NULL, 1, NULL, NULL),
(175, 'file/tmp/63de2642abf15', 'download.jfif', '2023-02-04 03:32:50', '2023-02-04 03:32:50', NULL, 1, NULL, NULL),
(176, 'file/tmp/63de26458c931', 'marksheet-2.png', '2023-02-04 03:32:53', '2023-02-04 03:32:53', NULL, 1, NULL, NULL),
(177, 'file/tmp/63de264a2bb92', 'Reg Card-1.jfif', '2023-02-04 03:32:58', '2023-02-04 03:32:58', NULL, 1, NULL, NULL),
(178, 'file/tmp/63de26aad6c2e', 'marksheet-2.png', '2023-02-04 03:34:34', '2023-02-04 03:34:34', NULL, 1, NULL, NULL),
(179, 'file/tmp/63de26ae48410', 'Reg Card-1.jfif', '2023-02-04 03:34:38', '2023-02-04 03:34:38', NULL, 1, NULL, NULL),
(180, 'file/tmp/63de26b1be95c', 'Reg Card-1.jfif', '2023-02-04 03:34:41', '2023-02-04 03:34:41', NULL, 1, NULL, NULL),
(181, 'file/tmp/63de28d0ed5c3', 'Reg Card-1.jfif', '2023-02-04 03:43:44', '2023-02-04 03:43:44', NULL, 1, NULL, NULL),
(182, 'file/tmp/63de28d3a00b4', 'Reg Card-2.jfif', '2023-02-04 03:43:47', '2023-02-04 03:43:47', NULL, 1, NULL, NULL),
(183, 'file/tmp/63de28d757fe7', 'marksheet-1.jfif', '2023-02-04 03:43:51', '2023-02-04 03:43:51', NULL, 1, NULL, NULL),
(184, 'file/tmp/63de2971e4400', 'marksheet-2.png', '2023-02-04 03:46:25', '2023-02-04 03:46:25', NULL, 1, NULL, NULL),
(185, 'file/tmp/63de29749a943', 'Reg Card-2.jfif', '2023-02-04 03:46:28', '2023-02-04 03:46:28', NULL, 1, NULL, NULL),
(186, 'file/tmp/63de2978465a6', 'marksheet-1.jfif', '2023-02-04 03:46:32', '2023-02-04 03:46:32', NULL, 1, NULL, NULL),
(187, 'file/tmp/63de29fc0a688', 'marksheet-1.jfif', '2023-02-04 03:48:44', '2023-02-04 03:48:44', NULL, 1, NULL, NULL),
(188, 'file/tmp/63de29ff490f9', 'Reg Card-1.jfif', '2023-02-04 03:48:47', '2023-02-04 03:48:47', NULL, 1, NULL, NULL),
(189, 'file/tmp/63de2a0327e24', 'marksheet-2.png', '2023-02-04 03:48:51', '2023-02-04 03:48:51', NULL, 1, NULL, NULL),
(190, 'file/tmp/63de2aabddd2b', 'marksheet-2.png', '2023-02-04 03:51:39', '2023-02-04 03:51:39', NULL, 1, NULL, NULL),
(191, 'file/tmp/63de2aaf18fb3', 'Reg Card-1.jfif', '2023-02-04 03:51:43', '2023-02-04 03:51:43', NULL, 1, NULL, NULL),
(192, 'file/tmp/63de2ab28f9ca', 'Reg Card-2.jfif', '2023-02-04 03:51:46', '2023-02-04 03:51:46', NULL, 1, NULL, NULL),
(193, 'file/tmp/63de2bac3e49e', 'marksheet-2.png', '2023-02-04 03:55:56', '2023-02-04 03:55:56', NULL, 1, NULL, NULL),
(194, 'file/tmp/63de2baf1b0d8', 'Reg Card-1.jfif', '2023-02-04 03:55:59', '2023-02-04 03:55:59', NULL, 1, NULL, NULL),
(195, 'file/tmp/63de2bb22f4ce', 'Reg Card-2.jfif', '2023-02-04 03:56:02', '2023-02-04 03:56:02', NULL, 1, NULL, NULL),
(196, 'file/tmp/63de2c02d5469', 'marksheet-1.jfif', '2023-02-04 03:57:23', '2023-02-04 03:57:23', NULL, 1, NULL, NULL),
(197, 'file/tmp/63de2c0648760', 'Reg Card-1.jfif', '2023-02-04 03:57:26', '2023-02-04 03:57:26', NULL, 1, NULL, NULL),
(198, 'file/tmp/63de2c09a20dd', 'marksheet-2.png', '2023-02-04 03:57:29', '2023-02-04 03:57:29', NULL, 1, NULL, NULL),
(199, 'file/tmp/63de2d190e5ef', 'marksheet-1.jfif', '2023-02-04 04:02:01', '2023-02-04 04:02:01', NULL, 1, NULL, NULL),
(200, 'file/tmp/63de2d1c26a99', 'marksheet-2.png', '2023-02-04 04:02:04', '2023-02-04 04:02:04', NULL, 1, NULL, NULL),
(201, 'file/tmp/63de2d1faa24d', 'Reg Card-1.jfif', '2023-02-04 04:02:07', '2023-02-04 04:02:07', NULL, 1, NULL, NULL),
(202, 'file/tmp/63de31fdcdce0', 'Reg Card-1.jfif', '2023-02-04 04:22:53', '2023-02-04 04:22:53', NULL, 1, NULL, NULL),
(203, 'file/tmp/63de3201084d3', 'Reg Card-2.jfif', '2023-02-04 04:22:57', '2023-02-04 04:22:57', NULL, 1, NULL, NULL),
(204, 'file/tmp/63de3204c0234', 'marksheet-2.png', '2023-02-04 04:23:00', '2023-02-04 04:23:00', NULL, 1, NULL, NULL),
(205, 'file/tmp/63de32947751e', 'Reg Card-1.jfif', '2023-02-04 04:25:24', '2023-02-04 04:25:24', NULL, 1, NULL, NULL),
(206, 'file/tmp/63de3296c1dd5', 'Reg Card-2.jfif', '2023-02-04 04:25:26', '2023-02-04 04:25:26', NULL, 1, NULL, NULL),
(207, 'file/tmp/63de329a3dc95', 'marksheet-2.png', '2023-02-04 04:25:30', '2023-02-04 04:25:30', NULL, 1, NULL, NULL),
(208, 'file/tmp/63de33ae2e2c3', 'marksheet-2.png', '2023-02-04 04:30:06', '2023-02-04 04:30:06', NULL, 1, NULL, NULL),
(209, 'file/tmp/63de33b11b00d', 'Reg Card-1.jfif', '2023-02-04 04:30:09', '2023-02-04 04:30:09', NULL, 1, NULL, NULL),
(210, 'file/tmp/63de33b44babd', 'Reg Card-2.jfif', '2023-02-04 04:30:12', '2023-02-04 04:30:12', NULL, 1, NULL, NULL),
(211, 'file/tmp/63de34f41efc1', 'marksheet-1.jfif', '2023-02-04 04:35:32', '2023-02-04 04:35:32', NULL, 1, NULL, NULL),
(212, 'file/tmp/63de34f662ff3', 'Reg Card-1.jfif', '2023-02-04 04:35:34', '2023-02-04 04:35:34', NULL, 1, NULL, NULL),
(213, 'file/tmp/63de34f9bfdcb', 'Reg Card-2.jfif', '2023-02-04 04:35:37', '2023-02-04 04:35:37', NULL, 1, NULL, NULL),
(214, 'file/tmp/63de40859a6c8', 'marksheet-1.jfif', '2023-02-04 05:24:53', '2023-02-04 05:24:53', NULL, 1, NULL, NULL),
(215, 'file/tmp/63de40887e87f', 'marksheet-2.png', '2023-02-04 05:24:56', '2023-02-04 05:24:56', NULL, 1, NULL, NULL),
(216, 'file/tmp/63de408c6eef4', 'Reg Card-2.jfif', '2023-02-04 05:25:00', '2023-02-04 05:25:00', NULL, 1, NULL, NULL),
(217, 'file/tmp/63de4164e67b6', 'marksheet-1.jfif', '2023-02-04 05:28:36', '2023-02-04 05:28:36', NULL, 1, NULL, NULL),
(218, 'file/tmp/63de4167e92c6', 'Reg Card-1.jfif', '2023-02-04 05:28:39', '2023-02-04 05:28:39', NULL, 1, NULL, NULL),
(219, 'file/tmp/63de416b94923', 'Reg Card-2.jfif', '2023-02-04 05:28:43', '2023-02-04 05:28:43', NULL, 1, NULL, NULL),
(220, 'file/tmp/63de45685330f', 'marksheet-2.png', '2023-02-04 05:45:44', '2023-02-04 05:45:44', NULL, 1, NULL, NULL),
(221, 'file/tmp/63de456b37da8', 'Reg Card-2.jfif', '2023-02-04 05:45:47', '2023-02-04 05:45:47', NULL, 1, NULL, NULL),
(222, 'file/tmp/63de456ea155c', 'Reg Card-1.jfif', '2023-02-04 05:45:50', '2023-02-04 05:45:50', NULL, 1, NULL, NULL),
(223, 'file/tmp/63de460f26ab0', 'marksheet-2.png', '2023-02-04 05:48:31', '2023-02-04 05:48:31', NULL, 1, NULL, NULL),
(224, 'file/tmp/63de461231954', 'Reg Card-2.jfif', '2023-02-04 05:48:34', '2023-02-04 05:48:34', NULL, 1, NULL, NULL),
(225, 'file/tmp/63de461511c7d', 'Reg Card-1.jfif', '2023-02-04 05:48:37', '2023-02-04 05:48:37', NULL, 1, NULL, NULL),
(226, 'file/tmp/63de462889e1b', 'marksheet-2.png', '2023-02-04 05:48:56', '2023-02-04 05:48:56', NULL, 1, NULL, NULL),
(227, 'file/tmp/63de46399a0a5', 'marksheet-2.png', '2023-02-04 05:49:13', '2023-02-04 05:49:13', NULL, 1, NULL, NULL),
(228, 'file/tmp/63de463c6efe1', 'Reg Card-2.jfif', '2023-02-04 05:49:16', '2023-02-04 05:49:16', NULL, 1, NULL, NULL),
(229, 'file/tmp/63de463fb7531', 'marksheet-2.png', '2023-02-04 05:49:19', '2023-02-04 05:49:19', NULL, 1, NULL, NULL),
(230, 'file/tmp/63de5aac29c27', 'marksheet-1.jfif', '2023-02-04 07:16:28', '2023-02-04 07:16:28', NULL, 1, NULL, NULL),
(231, 'file/tmp/63de5aaeaa518', 'Reg Card-1.jfif', '2023-02-04 07:16:30', '2023-02-04 07:16:30', NULL, 1, NULL, NULL),
(232, 'file/tmp/63de5ab188df1', 'Reg Card-2.jfif', '2023-02-04 07:16:33', '2023-02-04 07:16:33', NULL, 1, NULL, NULL),
(233, 'file/tmp/63de5abe8ad48', 'marksheet-1.jfif', '2023-02-04 07:16:46', '2023-02-04 07:16:46', NULL, 1, NULL, NULL),
(234, 'file/tmp/63de5b21f171f', 'marksheet-2.png', '2023-02-04 07:18:25', '2023-02-04 07:18:26', NULL, 1, NULL, NULL),
(235, 'file/tmp/63de5b2462ef5', 'Reg Card-2.jfif', '2023-02-04 07:18:28', '2023-02-04 07:18:28', NULL, 1, NULL, NULL),
(236, 'file/tmp/63de5b27412dc', 'marksheet-2.png', '2023-02-04 07:18:31', '2023-02-04 07:18:31', NULL, 1, NULL, NULL),
(237, 'file/tmp/63de5b55644ad', 'Reg Card-1.jfif', '2023-02-04 07:19:17', '2023-02-04 07:19:17', NULL, 1, NULL, NULL),
(238, 'file/tmp/63de6142ef839', 'marksheet-1.jfif', '2023-02-04 07:44:34', '2023-02-04 07:44:35', NULL, 1, NULL, NULL),
(239, 'file/tmp/63de61466545d', 'Reg Card-1.jfif', '2023-02-04 07:44:38', '2023-02-04 07:44:38', NULL, 1, NULL, NULL),
(240, 'file/tmp/63de614ab6a2b', 'Reg Card-2.jfif', '2023-02-04 07:44:42', '2023-02-04 07:44:42', NULL, 1, NULL, NULL),
(241, 'file/tmp/63e0ffb16527c', 'marksheet-1.jfif', '2023-02-06 07:25:05', '2023-02-06 07:25:05', NULL, 1, NULL, NULL),
(242, 'file/tmp/63e0ffb403074', 'marksheet-2.png', '2023-02-06 07:25:08', '2023-02-06 07:25:08', NULL, 1, NULL, NULL),
(243, 'file/tmp/63e0ffb76eace', 'marksheet-2.png', '2023-02-06 07:25:11', '2023-02-06 07:25:11', NULL, 1, NULL, NULL),
(244, 'file/tmp/63e1008978c57', 'marksheet-1.jfif', '2023-02-06 07:28:41', '2023-02-06 07:28:41', NULL, 1, NULL, NULL),
(245, 'file/tmp/63e1008bdd11f', 'marksheet-2.png', '2023-02-06 07:28:43', '2023-02-06 07:28:43', NULL, 1, NULL, NULL),
(246, 'file/tmp/63e1008eaef99', 'Reg Card-2.jfif', '2023-02-06 07:28:46', '2023-02-06 07:28:46', NULL, 1, NULL, NULL),
(247, 'file/tmp/63e1009c3a041', 'marksheet-2.png', '2023-02-06 07:29:00', '2023-02-06 07:29:00', NULL, 1, NULL, NULL),
(248, 'file/tmp/63e10785394fb', 'marksheet-1.jfif', '2023-02-06 07:58:29', '2023-02-06 07:58:29', NULL, 1, NULL, NULL),
(249, 'file/tmp/63e10788048dc', 'Reg Card-1.jfif', '2023-02-06 07:58:32', '2023-02-06 07:58:32', NULL, 1, NULL, NULL),
(250, 'file/tmp/63e1078b4095f', 'Reg Card-2.jfif', '2023-02-06 07:58:35', '2023-02-06 07:58:35', NULL, 1, NULL, NULL),
(251, 'file/tmp/63e1079a1d1ff', 'marksheet-2.png', '2023-02-06 07:58:50', '2023-02-06 07:58:50', NULL, 1, NULL, NULL),
(252, 'file/tmp/63e107a38a3e6', 'marksheet-2.png', '2023-02-06 07:58:59', '2023-02-06 07:58:59', NULL, 1, NULL, NULL),
(253, 'file/tmp/63e107a6e39d1', 'Reg Card-2.jfif', '2023-02-06 07:59:02', '2023-02-06 07:59:02', NULL, 1, NULL, NULL),
(254, 'file/tmp/63e107aaa75bf', 'marksheet-1.jfif', '2023-02-06 07:59:06', '2023-02-06 07:59:06', NULL, 1, NULL, NULL),
(255, 'file/tmp/63e1ef0a4c2df', 'marksheet-2.png', '2023-02-07 00:26:18', '2023-02-07 00:26:18', NULL, 1, NULL, NULL),
(256, 'file/tmp/63e1ef0d0a0f5', 'Reg Card-1.jfif', '2023-02-07 00:26:21', '2023-02-07 00:26:21', NULL, 1, NULL, NULL),
(257, 'file/tmp/63e1ef110763e', 'Reg Card-2.jfif', '2023-02-07 00:26:25', '2023-02-07 00:26:25', NULL, 1, NULL, NULL),
(258, 'file/tmp/63e1ef1e3041d', 'Reg Card-1.jfif', '2023-02-07 00:26:38', '2023-02-07 00:26:38', NULL, 1, NULL, NULL),
(259, 'file/tmp/63e1ef299e66a', 'marksheet-2.png', '2023-02-07 00:26:49', '2023-02-07 00:26:49', NULL, 1, NULL, NULL),
(260, 'file/tmp/63e1ef2d5cb10', 'Reg Card-1.jfif', '2023-02-07 00:26:53', '2023-02-07 00:26:53', NULL, 1, NULL, NULL),
(261, 'file/tmp/63e1ef30bbf07', 'Reg Card-2.jfif', '2023-02-07 00:26:56', '2023-02-07 00:26:56', NULL, 1, NULL, NULL),
(262, 'file/tmp/63e1fe2ea6cd3', 'download.jfif', '2023-02-07 01:30:55', '2023-02-07 01:30:55', NULL, 1, NULL, NULL),
(263, 'file/tmp/63e1fe3384825', 'marksheet-2.png', '2023-02-07 01:30:59', '2023-02-07 01:30:59', NULL, 1, NULL, NULL),
(264, 'file/tmp/63e1fe423fccc', 'marksheet-1.jfif', '2023-02-07 01:31:14', '2023-02-07 01:31:14', NULL, 1, NULL, NULL),
(265, 'file/tmp/63e215c623ebd', 'marksheet-1.jfif', '2023-02-07 03:11:34', '2023-02-07 03:11:34', NULL, 1, NULL, NULL),
(266, 'file/tmp/63e215c982bf2', 'marksheet-2.png', '2023-02-07 03:11:37', '2023-02-07 03:11:37', NULL, 1, NULL, NULL),
(267, 'file/tmp/63e215cdef94c', 'Reg Card-1.jfif', '2023-02-07 03:11:41', '2023-02-07 03:11:42', NULL, 1, NULL, NULL),
(268, 'file/tmp/63e215d30784a', 'Reg Card-2.jfif', '2023-02-07 03:11:47', '2023-02-07 03:11:47', NULL, 1, NULL, NULL),
(269, 'file/tmp/63e215f9c6ef4', 'Reg Card-1.jfif', '2023-02-07 03:12:25', '2023-02-07 03:12:25', NULL, 1, NULL, NULL),
(270, 'file/tmp/63e2160369643', 'marksheet-2.png', '2023-02-07 03:12:35', '2023-02-07 03:12:35', NULL, 1, NULL, NULL),
(271, 'file/tmp/63e21606d70ba', 'Reg Card-1.jfif', '2023-02-07 03:12:38', '2023-02-07 03:12:38', NULL, 1, NULL, NULL),
(272, 'file/tmp/63e2160caadb4', 'Reg Card-2.jfif', '2023-02-07 03:12:44', '2023-02-07 03:12:44', NULL, 1, NULL, NULL),
(273, 'file/tmp/63e21f258c53d', 'marksheet-2.png', '2023-02-07 03:51:33', '2023-02-07 03:51:33', NULL, 1, NULL, NULL),
(274, 'file/tmp/63e21f2ce8b92', 'Reg Card-1.jfif', '2023-02-07 03:51:40', '2023-02-07 03:51:40', NULL, 1, NULL, NULL),
(275, 'file/tmp/63e21f35468fb', 'marksheet-2.png', '2023-02-07 03:51:49', '2023-02-07 03:51:49', NULL, 1, NULL, NULL),
(276, 'file/tmp/63e2210cafd02', 'marksheet-2.png', '2023-02-07 03:59:40', '2023-02-07 03:59:40', NULL, 1, NULL, NULL),
(277, 'file/tmp/63e2210f41a04', 'Reg Card-2.jfif', '2023-02-07 03:59:43', '2023-02-07 03:59:43', NULL, 1, NULL, NULL),
(278, 'file/tmp/63e22112c84d6', 'Reg Card-1.jfif', '2023-02-07 03:59:46', '2023-02-07 03:59:46', NULL, 1, NULL, NULL),
(279, 'file/tmp/63e2212051648', 'Reg Card-1.jfif', '2023-02-07 04:00:00', '2023-02-07 04:00:00', NULL, 1, NULL, NULL),
(280, 'file/tmp/63e221292d7e3', 'Reg Card-1.jfif', '2023-02-07 04:00:09', '2023-02-07 04:00:09', NULL, 1, NULL, NULL),
(281, 'file/tmp/63e2212c0b507', 'Reg Card-2.jfif', '2023-02-07 04:00:12', '2023-02-07 04:00:12', NULL, 1, NULL, NULL),
(282, 'file/tmp/63e2212f5a52b', 'Reg Card-2.jfif', '2023-02-07 04:00:15', '2023-02-07 04:00:15', NULL, 1, NULL, NULL),
(283, 'file/tmp/63e2222235b1a', 'Reg Card-1.jfif', '2023-02-07 04:04:18', '2023-02-07 04:04:18', NULL, 1, NULL, NULL),
(284, 'file/tmp/63e2222dd4018', 'marksheet-1.jfif', '2023-02-07 04:04:29', '2023-02-07 04:04:29', NULL, 1, NULL, NULL),
(285, 'file/tmp/63e222353de92', 'Reg Card-1.jfif', '2023-02-07 04:04:37', '2023-02-07 04:04:37', NULL, 1, NULL, NULL),
(286, 'file/tmp/63e222adf224a', 'Reg Card-1.jfif', '2023-02-07 04:06:37', '2023-02-07 04:06:38', NULL, 1, NULL, NULL),
(287, 'file/tmp/63e222bf5a2df', 'Reg Card-2.jfif', '2023-02-07 04:06:55', '2023-02-07 04:06:55', NULL, 1, NULL, NULL),
(288, 'file/tmp/63e222ca24153', 'marksheet-2.png', '2023-02-07 04:07:06', '2023-02-07 04:07:06', NULL, 1, NULL, NULL),
(289, 'file/tmp/63e222ccc931d', 'Reg Card-2.jfif', '2023-02-07 04:07:08', '2023-02-07 04:07:08', NULL, 1, NULL, NULL),
(290, 'file/tmp/63e222d082c2a', 'Reg Card-1.jfif', '2023-02-07 04:07:12', '2023-02-07 04:07:12', NULL, 1, NULL, NULL),
(291, 'file/tmp/63e222fe555c2', 'marksheet-1.jfif', '2023-02-07 04:07:58', '2023-02-07 04:07:58', NULL, 1, NULL, NULL),
(292, 'file/tmp/63e22300dd9ea', 'marksheet-2.png', '2023-02-07 04:08:00', '2023-02-07 04:08:00', NULL, 1, NULL, NULL),
(293, 'file/tmp/63e2230679052', 'Reg Card-2.jfif', '2023-02-07 04:08:06', '2023-02-07 04:08:06', NULL, 1, NULL, NULL),
(294, 'file/tmp/63e22314e76bc', 'marksheet-2.png', '2023-02-07 04:08:20', '2023-02-07 04:08:20', NULL, 1, NULL, NULL),
(295, 'file/tmp/63e2231f81ae3', 'marksheet-2.png', '2023-02-07 04:08:31', '2023-02-07 04:08:31', NULL, 1, NULL, NULL),
(296, 'file/tmp/63e22322948b0', 'Reg Card-1.jfif', '2023-02-07 04:08:34', '2023-02-07 04:08:34', NULL, 1, NULL, NULL),
(297, 'file/tmp/63e22325d0fb3', 'Reg Card-2.jfif', '2023-02-07 04:08:37', '2023-02-07 04:08:37', NULL, 1, NULL, NULL),
(298, 'file/tmp/63e223a8698f8', 'marksheet-2.png', '2023-02-07 04:10:48', '2023-02-07 04:10:48', NULL, 1, NULL, NULL),
(299, 'file/tmp/63e223c5e6576', 'marksheet-2.png', '2023-02-07 04:11:17', '2023-02-07 04:11:17', NULL, 1, NULL, NULL),
(300, 'file/tmp/63e223cad1ba9', 'Reg Card-2.jfif', '2023-02-07 04:11:22', '2023-02-07 04:11:22', NULL, 1, NULL, NULL),
(301, 'file/tmp/63e223d176e92', 'marksheet-2.png', '2023-02-07 04:11:29', '2023-02-07 04:11:29', NULL, 1, NULL, NULL),
(302, 'file/tmp/63e223e77ab76', 'Reg Card-1.jfif', '2023-02-07 04:11:51', '2023-02-07 04:11:51', NULL, 1, NULL, NULL),
(303, 'file/tmp/63e2240670d32', 'marksheet-2.png', '2023-02-07 04:12:22', '2023-02-07 04:12:22', NULL, 1, NULL, NULL),
(304, 'file/tmp/63e2240944658', 'Reg Card-1.jfif', '2023-02-07 04:12:25', '2023-02-07 04:12:25', NULL, 1, NULL, NULL),
(305, 'file/tmp/63e2240ce14a3', 'Reg Card-2.jfif', '2023-02-07 04:12:28', '2023-02-07 04:12:28', NULL, 1, NULL, NULL),
(306, 'file/tmp/63e2243ee3344', 'Reg Card-1.jfif', '2023-02-07 04:13:18', '2023-02-07 04:13:18', NULL, 1, NULL, NULL),
(307, 'file/tmp/63e22441a2458', 'Reg Card-1.jfif', '2023-02-07 04:13:21', '2023-02-07 04:13:21', NULL, 1, NULL, NULL),
(308, 'file/tmp/63e224450780c', 'Reg Card-2.jfif', '2023-02-07 04:13:25', '2023-02-07 04:13:25', NULL, 1, NULL, NULL),
(309, 'file/tmp/63e22451ef274', 'Reg Card-2.jfif', '2023-02-07 04:13:37', '2023-02-07 04:13:38', NULL, 1, NULL, NULL),
(310, 'file/tmp/63e2245c273ab', 'marksheet-1.jfif', '2023-02-07 04:13:48', '2023-02-07 04:13:48', NULL, 1, NULL, NULL),
(311, 'file/tmp/63e2245ed6dd0', 'Reg Card-2.jfif', '2023-02-07 04:13:50', '2023-02-07 04:13:50', NULL, 1, NULL, NULL),
(312, 'file/tmp/63e22462933f1', 'marksheet-1.jfif', '2023-02-07 04:13:54', '2023-02-07 04:13:54', NULL, 1, NULL, NULL),
(313, 'file/tmp/63e2262c83b25', 'download.jfif', '2023-02-07 04:21:32', '2023-02-07 04:21:32', NULL, 1, NULL, NULL),
(314, 'file/tmp/63e2265115911', 'marksheet-1.jfif', '2023-02-07 04:22:09', '2023-02-07 04:22:09', NULL, 1, NULL, NULL),
(315, 'file/tmp/63e2265465986', 'Reg Card-1.jfif', '2023-02-07 04:22:12', '2023-02-07 04:22:12', NULL, 1, NULL, NULL),
(316, 'file/tmp/63e22657c84bc', 'Reg Card-2.jfif', '2023-02-07 04:22:15', '2023-02-07 04:22:15', NULL, 1, NULL, NULL),
(317, 'file/tmp/63e2267f75bf2', 'Reg Card-1.jfif', '2023-02-07 04:22:55', '2023-02-07 04:22:55', NULL, 1, NULL, NULL),
(318, 'file/tmp/63e22688e0235', 'marksheet-1.jfif', '2023-02-07 04:23:04', '2023-02-07 04:23:04', NULL, 1, NULL, NULL),
(319, 'file/tmp/63e2268b9cce6', 'marksheet-2.png', '2023-02-07 04:23:07', '2023-02-07 04:23:07', NULL, 1, NULL, NULL),
(320, 'file/tmp/63e22691c3c95', 'Reg Card-2.jfif', '2023-02-07 04:23:13', '2023-02-07 04:23:13', NULL, 1, NULL, NULL),
(321, 'file/tmp/63e22975438fc', 'marksheet-1.jfif', '2023-02-07 04:35:33', '2023-02-07 04:35:33', NULL, 1, NULL, NULL),
(322, 'file/tmp/63e22992d28ae', 'marksheet-1.jfif', '2023-02-07 04:36:02', '2023-02-07 04:36:02', NULL, 1, NULL, NULL),
(323, 'file/tmp/63e22995a7dda', 'Reg Card-1.jfif', '2023-02-07 04:36:05', '2023-02-07 04:36:05', NULL, 1, NULL, NULL),
(324, 'file/tmp/63e229989a646', 'Reg Card-2.jfif', '2023-02-07 04:36:08', '2023-02-07 04:36:08', NULL, 1, NULL, NULL),
(325, 'file/tmp/63e229a8e2fa7', 'Reg Card-1.jfif', '2023-02-07 04:36:24', '2023-02-07 04:36:24', NULL, 1, NULL, NULL),
(326, 'file/tmp/63e229b22d933', 'marksheet-2.png', '2023-02-07 04:36:34', '2023-02-07 04:36:34', NULL, 1, NULL, NULL),
(327, 'file/tmp/63e229b4858f1', 'Reg Card-2.jfif', '2023-02-07 04:36:36', '2023-02-07 04:36:36', NULL, 1, NULL, NULL),
(328, 'file/tmp/63e229ba84ed7', 'marksheet-2.png', '2023-02-07 04:36:42', '2023-02-07 04:36:42', NULL, 1, NULL, NULL),
(329, 'file/tmp/63e24f25ed290', 'download.jfif', '2023-02-07 07:16:21', '2023-02-07 07:16:21', NULL, 1, NULL, NULL),
(330, 'file/tmp/63e24f41566b3', 'marksheet-2.png', '2023-02-07 07:16:49', '2023-02-07 07:16:49', NULL, 1, NULL, NULL),
(331, 'file/tmp/63e24f45cf7fa', 'download.jfif', '2023-02-07 07:16:53', '2023-02-07 07:16:53', NULL, 1, NULL, NULL),
(332, 'file/tmp/63e24f4977116', 'download (1).jfif', '2023-02-07 07:16:57', '2023-02-07 07:16:57', NULL, 1, NULL, NULL),
(333, 'file/tmp/63e24f6d198f4', 'download.jfif', '2023-02-07 07:17:33', '2023-02-07 07:17:33', NULL, 1, NULL, NULL),
(334, 'file/tmp/63e24f7887d1c', 'download (1).jfif', '2023-02-07 07:17:44', '2023-02-07 07:17:44', NULL, 1, NULL, NULL),
(335, 'file/tmp/63e24f7b6ba2f', 'download.jfif', '2023-02-07 07:17:47', '2023-02-07 07:17:47', NULL, 1, NULL, NULL),
(336, 'file/tmp/63e24f7ed6419', 'Reg Card-1.jfif', '2023-02-07 07:17:50', '2023-02-07 07:17:50', NULL, 1, NULL, NULL),
(337, 'file/tmp/63e2514946f98', 'download.jfif', '2023-02-07 07:25:29', '2023-02-07 07:25:29', NULL, 1, NULL, NULL),
(338, 'file/tmp/63e2516304cc3', 'download (1).jfif', '2023-02-07 07:25:55', '2023-02-07 07:25:55', NULL, 1, NULL, NULL),
(339, 'file/tmp/63e2516609c23', 'download.jfif', '2023-02-07 07:25:58', '2023-02-07 07:25:58', NULL, 1, NULL, NULL),
(340, 'file/tmp/63e2516991d88', 'marksheet-1.jfif', '2023-02-07 07:26:01', '2023-02-07 07:26:01', NULL, 1, NULL, NULL),
(341, 'file/tmp/63e2517b033c9', 'marksheet-1.jfif', '2023-02-07 07:26:19', '2023-02-07 07:26:19', NULL, 1, NULL, NULL),
(342, 'file/tmp/63e251834ade6', 'download (1).jfif', '2023-02-07 07:26:27', '2023-02-07 07:26:27', NULL, 1, NULL, NULL),
(343, 'file/tmp/63e251866331b', 'download.jfif', '2023-02-07 07:26:30', '2023-02-07 07:26:30', NULL, 1, NULL, NULL),
(344, 'file/tmp/63e2518a0f9a3', 'marksheet-1.jfif', '2023-02-07 07:26:34', '2023-02-07 07:26:34', NULL, 1, NULL, NULL),
(345, 'file/tmp/63e253234844f', 'download (1).jfif', '2023-02-07 07:33:23', '2023-02-07 07:33:23', NULL, 1, NULL, NULL),
(346, 'file/tmp/63e25346b7ed8', 'download (1).jfif', '2023-02-07 07:33:58', '2023-02-07 07:33:58', NULL, 1, NULL, NULL),
(347, 'file/tmp/63e253496e23e', 'download.jfif', '2023-02-07 07:34:01', '2023-02-07 07:34:01', NULL, 1, NULL, NULL),
(348, 'file/tmp/63e2534ce17b8', 'marksheet-1.jfif', '2023-02-07 07:34:04', '2023-02-07 07:34:04', NULL, 1, NULL, NULL),
(349, 'file/tmp/63e2536d13194', 'Reg Card-1.jfif', '2023-02-07 07:34:37', '2023-02-07 07:34:37', NULL, 1, NULL, NULL),
(350, 'file/tmp/63e2537837da7', 'download (1).jfif', '2023-02-07 07:34:48', '2023-02-07 07:34:48', NULL, 1, NULL, NULL),
(351, 'file/tmp/63e2537ac4e14', 'download.jfif', '2023-02-07 07:34:50', '2023-02-07 07:34:50', NULL, 1, NULL, NULL),
(352, 'file/tmp/63e2537e7c01d', 'Reg Card-1.jfif', '2023-02-07 07:34:54', '2023-02-07 07:34:54', NULL, 1, NULL, NULL),
(353, 'file/tmp/63e255d3eaf48', 'download (1).jfif', '2023-02-07 07:44:51', '2023-02-07 07:44:51', NULL, 1, NULL, NULL),
(354, 'file/tmp/63e255f92444a', 'download (1).jfif', '2023-02-07 07:45:29', '2023-02-07 07:45:29', NULL, 1, NULL, NULL),
(355, 'file/tmp/63e255fb748fe', 'marksheet-1.jfif', '2023-02-07 07:45:31', '2023-02-07 07:45:31', NULL, 1, NULL, NULL),
(356, 'file/tmp/63e255feb35ee', 'Reg Card-1.jfif', '2023-02-07 07:45:34', '2023-02-07 07:45:34', NULL, 1, NULL, NULL),
(357, 'file/tmp/63e2561833397', 'marksheet-1.jfif', '2023-02-07 07:46:00', '2023-02-07 07:46:00', NULL, 1, NULL, NULL),
(358, 'file/tmp/63e25622c7990', 'download (1).jfif', '2023-02-07 07:46:10', '2023-02-07 07:46:10', NULL, 1, NULL, NULL),
(359, 'file/tmp/63e256256eea1', 'download.jfif', '2023-02-07 07:46:13', '2023-02-07 07:46:13', NULL, 1, NULL, NULL),
(360, 'file/tmp/63e25628b6b60', 'marksheet-1.jfif', '2023-02-07 07:46:16', '2023-02-07 07:46:16', NULL, 1, NULL, NULL),
(361, 'file/tmp/63e259361720d', 'download (1).jfif', '2023-02-07 07:59:18', '2023-02-07 07:59:18', NULL, 1, NULL, NULL),
(362, 'file/tmp/63e2595303b3e', 'download (1).jfif', '2023-02-07 07:59:47', '2023-02-07 07:59:47', NULL, 1, NULL, NULL),
(363, 'file/tmp/63e259562e143', 'marksheet-1.jfif', '2023-02-07 07:59:50', '2023-02-07 07:59:50', NULL, 1, NULL, NULL),
(364, 'file/tmp/63e2595a2eb18', 'Reg Card-1.jfif', '2023-02-07 07:59:54', '2023-02-07 07:59:54', NULL, 1, NULL, NULL),
(365, 'file/tmp/63e25998c9e2e', 'Reg Card-2.jfif', '2023-02-07 08:00:56', '2023-02-07 08:00:56', NULL, 1, NULL, NULL),
(366, 'file/tmp/63e259a2eb90f', 'download (1).jfif', '2023-02-07 08:01:07', '2023-02-07 08:01:07', NULL, 1, NULL, NULL),
(367, 'file/tmp/63e259a6188e7', 'download.jfif', '2023-02-07 08:01:10', '2023-02-07 08:01:10', NULL, 1, NULL, NULL),
(368, 'file/tmp/63e259acd332c', 'download.jfif', '2023-02-07 08:01:16', '2023-02-07 08:01:16', NULL, 1, NULL, NULL),
(369, 'file/tmp/63e25b4b5d0c4', 'download (1).jfif', '2023-02-07 08:08:11', '2023-02-07 08:08:11', NULL, 1, NULL, NULL),
(370, 'file/tmp/63e25b589e872', 'download (1).jfif', '2023-02-07 08:08:24', '2023-02-07 08:08:24', NULL, 1, NULL, NULL),
(371, 'file/tmp/63e25b5cb1f44', 'download.jfif', '2023-02-07 08:08:28', '2023-02-07 08:08:28', NULL, 1, NULL, NULL),
(372, 'file/tmp/63e25b5fed042', 'marksheet-2.png', '2023-02-07 08:08:32', '2023-02-07 08:08:32', NULL, 1, NULL, NULL),
(373, 'file/tmp/63e25b70e3f39', 'Reg Card-1.jfif', '2023-02-07 08:08:48', '2023-02-07 08:08:48', NULL, 1, NULL, NULL),
(374, 'file/tmp/63e25b7b642bc', 'download.jfif', '2023-02-07 08:08:59', '2023-02-07 08:08:59', NULL, 1, NULL, NULL),
(375, 'file/tmp/63e25b7e0c57f', 'marksheet-2.png', '2023-02-07 08:09:02', '2023-02-07 08:09:02', NULL, 1, NULL, NULL),
(376, 'file/tmp/63e25b810ba54', 'Reg Card-2.jfif', '2023-02-07 08:09:05', '2023-02-07 08:09:05', NULL, 1, NULL, NULL),
(377, 'file/tmp/63e25bde443d4', 'download.jfif', '2023-02-07 08:10:38', '2023-02-07 08:10:38', NULL, 1, NULL, NULL),
(378, 'file/tmp/63e25be9a78a7', 'download (1).jfif', '2023-02-07 08:10:49', '2023-02-07 08:10:49', NULL, 1, NULL, NULL),
(379, 'file/tmp/63e25bed448ba', 'marksheet-1.jfif', '2023-02-07 08:10:53', '2023-02-07 08:10:53', NULL, 1, NULL, NULL),
(380, 'file/tmp/63e25bf11a07d', 'Reg Card-1.jfif', '2023-02-07 08:10:57', '2023-02-07 08:10:57', NULL, 1, NULL, NULL),
(381, 'file/tmp/63e25bffa9af1', 'marksheet-2.png', '2023-02-07 08:11:11', '2023-02-07 08:11:11', NULL, 1, NULL, NULL),
(382, 'file/tmp/63e25c08f2384', 'download (1).jfif', '2023-02-07 08:11:21', '2023-02-07 08:11:21', NULL, 1, NULL, NULL),
(383, 'file/tmp/63e25c0c17bff', 'marksheet-1.jfif', '2023-02-07 08:11:24', '2023-02-07 08:11:24', NULL, 1, NULL, NULL),
(384, 'file/tmp/63e25c0f4900c', 'Reg Card-1.jfif', '2023-02-07 08:11:27', '2023-02-07 08:11:27', NULL, 1, NULL, NULL),
(385, 'file/tmp/63e25c5d330b8', 'download.jfif', '2023-02-07 08:12:45', '2023-02-07 08:12:45', NULL, 1, NULL, NULL),
(386, 'file/tmp/63e25c5fddf1f', 'marksheet-2.png', '2023-02-07 08:12:47', '2023-02-07 08:12:47', NULL, 1, NULL, NULL),
(387, 'file/tmp/63e25de6a6768', 'download (1).jfif', '2023-02-07 08:19:18', '2023-02-07 08:19:18', NULL, 1, NULL, NULL),
(388, 'file/tmp/63e25e03cbf06', 'download.jfif', '2023-02-07 08:19:47', '2023-02-07 08:19:47', NULL, 1, NULL, NULL),
(389, 'file/tmp/63e25e0697c45', 'marksheet-1.jfif', '2023-02-07 08:19:50', '2023-02-07 08:19:50', NULL, 1, NULL, NULL),
(390, 'file/tmp/63e25e09b97a5', 'download (1).jfif', '2023-02-07 08:19:53', '2023-02-07 08:19:53', NULL, 1, NULL, NULL),
(391, 'file/tmp/63e25e26e928e', 'marksheet-1.jfif', '2023-02-07 08:20:22', '2023-02-07 08:20:22', NULL, 1, NULL, NULL),
(392, 'file/tmp/63e25e2fe4e2b', 'download (1).jfif', '2023-02-07 08:20:31', '2023-02-07 08:20:31', NULL, 1, NULL, NULL),
(393, 'file/tmp/63e25e32cd97a', 'download.jfif', '2023-02-07 08:20:34', '2023-02-07 08:20:34', NULL, 1, NULL, NULL),
(394, 'file/tmp/63e25e3a0be39', 'marksheet-1.jfif', '2023-02-07 08:20:42', '2023-02-07 08:20:42', NULL, 1, NULL, NULL),
(395, 'file/tmp/63e39f39c8bc0', 'download.jfif', '2023-02-08 07:10:17', '2023-02-08 07:10:17', NULL, 1, NULL, NULL),
(396, 'file/tmp/63e39f86eb081', 'marksheet-1.jfif', '2023-02-08 07:11:34', '2023-02-08 07:11:34', NULL, 1, NULL, NULL),
(397, 'file/tmp/63e3a2e44f12a', 'download.jfif', '2023-02-08 07:25:56', '2023-02-08 07:25:56', NULL, 1, NULL, NULL),
(398, 'file/tmp/63e3a2f02841b', 'marksheet-1.jfif', '2023-02-08 07:26:08', '2023-02-08 07:26:08', NULL, 1, NULL, NULL),
(399, 'file/tmp/63e3a2f2c5aca', 'Reg Card-1.jfif', '2023-02-08 07:26:10', '2023-02-08 07:26:10', NULL, 1, NULL, NULL),
(400, 'file/tmp/63e3a2f59a441', 'Reg Card-2.jfif', '2023-02-08 07:26:13', '2023-02-08 07:26:13', NULL, 1, NULL, NULL),
(401, 'file/tmp/63e3a3037147c', 'marksheet-1.jfif', '2023-02-08 07:26:27', '2023-02-08 07:26:27', NULL, 1, NULL, NULL),
(402, 'file/tmp/63e3a30cb341e', 'marksheet-1.jfif', '2023-02-08 07:26:36', '2023-02-08 07:26:36', NULL, 1, NULL, NULL),
(403, 'file/tmp/63e3a30f17193', 'marksheet-2.png', '2023-02-08 07:26:39', '2023-02-08 07:26:39', NULL, 1, NULL, NULL),
(404, 'file/tmp/63e3a311ce240', 'Reg Card-2.jfif', '2023-02-08 07:26:41', '2023-02-08 07:26:41', NULL, 1, NULL, NULL),
(405, 'file/tmp/63e4d3029a238', 'marksheet-1.jfif', '2023-02-09 05:03:30', '2023-02-09 05:03:30', NULL, 1, NULL, NULL),
(406, 'file/tmp/63e4d65358d73', 'marksheet-2.png', '2023-02-09 05:17:39', '2023-02-09 05:17:39', NULL, 1, NULL, NULL),
(407, 'file/tmp/63e4d960b083d', 'marksheet-1.jfif', '2023-02-09 05:30:40', '2023-02-09 05:30:40', NULL, 1, NULL, NULL),
(408, 'file/tmp/63e4d96e47b8a', 'download (1).jfif', '2023-02-09 05:30:54', '2023-02-09 05:30:54', NULL, 1, NULL, NULL),
(409, 'file/tmp/63e4d97129cea', 'marksheet-1.jfif', '2023-02-09 05:30:57', '2023-02-09 05:30:57', NULL, 1, NULL, NULL),
(410, 'file/tmp/63e4d9f626da4', 'download.jfif', '2023-02-09 05:33:10', '2023-02-09 05:33:10', NULL, 1, NULL, NULL),
(411, 'file/tmp/63e4da98d635f', 'marksheet-2.png', '2023-02-09 05:35:52', '2023-02-09 05:35:52', NULL, 1, NULL, NULL),
(412, 'file/tmp/63e4e1fee417a', 'marksheet-1.jfif', '2023-02-09 06:07:26', '2023-02-09 06:07:26', NULL, 1, NULL, NULL),
(413, 'file/tmp/63e4e20ecc4e1', 'Reg Card-2.jfif', '2023-02-09 06:07:42', '2023-02-09 06:07:42', NULL, 1, NULL, NULL),
(414, 'file/tmp/63e4e21693830', 'Reg Card-1.jfif', '2023-02-09 06:07:50', '2023-02-09 06:07:50', NULL, 1, NULL, NULL),
(415, 'file/tmp/63e4e3b23da23', 'marksheet-1.jfif', '2023-02-09 06:14:42', '2023-02-09 06:14:42', NULL, 1, NULL, NULL),
(416, 'file/tmp/63e4e3caa7aaf', 'marksheet-2.png', '2023-02-09 06:15:06', '2023-02-09 06:15:06', NULL, 1, NULL, NULL),
(417, 'file/tmp/63e4e41ed64ce', 'Reg Card-1.jfif', '2023-02-09 06:16:30', '2023-02-09 06:16:30', NULL, 1, NULL, NULL),
(418, 'file/tmp/63e4e421a8455', 'Reg Card-2.jfif', '2023-02-09 06:16:33', '2023-02-09 06:16:33', NULL, 1, NULL, NULL),
(419, 'file/tmp/63e4e49d09331', 'marksheet-1.jfif', '2023-02-09 06:18:37', '2023-02-09 06:18:37', NULL, 1, NULL, NULL);
INSERT INTO `tmp_files` (`id`, `path`, `filename`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(420, 'file/tmp/63e4e506d4de7', 'Reg Card-1.jfif', '2023-02-09 06:20:22', '2023-02-09 06:20:22', NULL, 1, NULL, NULL),
(421, 'file/tmp/63e4e62d4b1b5', 'Reg Card-1.jfif', '2023-02-09 06:25:17', '2023-02-09 06:25:17', NULL, 1, NULL, NULL),
(422, 'file/tmp/63e4e64e23cc9', 'Reg Card-2.jfif', '2023-02-09 06:25:50', '2023-02-09 06:25:50', NULL, 1, NULL, NULL),
(423, 'file/tmp/63e4e6d8af5bc', 'Reg Card-1.jfif', '2023-02-09 06:28:08', '2023-02-09 06:28:08', NULL, 1, NULL, NULL),
(424, 'file/tmp/63e4e77fdfd5a', 'marksheet-1.jfif', '2023-02-09 06:30:55', '2023-02-09 06:30:55', NULL, 1, NULL, NULL),
(425, 'file/tmp/63e4e9f95d787', 'Reg Card-2.jfif', '2023-02-09 06:41:29', '2023-02-09 06:41:29', NULL, 1, NULL, NULL),
(426, 'file/tmp/63e4ea2a61268', 'Reg Card-2.jfif', '2023-02-09 06:42:18', '2023-02-09 06:42:18', NULL, 1, NULL, NULL),
(427, 'file/tmp/63e4ee4dbf87e', 'Reg Card-1.jfif', '2023-02-09 06:59:57', '2023-02-09 06:59:57', NULL, 1, NULL, NULL),
(428, 'file/tmp/63e6042de4dbf', 'download.jfif', '2023-02-10 02:45:33', '2023-02-10 02:45:33', NULL, 1, NULL, NULL),
(429, 'file/tmp/63e604a97bceb', 'Reg Card-2.jfif', '2023-02-10 02:47:37', '2023-02-10 02:47:37', NULL, 1, NULL, NULL),
(430, 'file/tmp/63e6074768a0b', 'Reg Card-1.jfif', '2023-02-10 02:58:47', '2023-02-10 02:58:47', NULL, 1, NULL, NULL),
(431, 'file/tmp/63e6079e3c232', 'download.jfif', '2023-02-10 03:00:14', '2023-02-10 03:00:14', NULL, 1, NULL, NULL),
(432, 'file/tmp/63e61ac60f4d5', 'download (1).jfif', '2023-02-10 04:21:58', '2023-02-10 04:21:58', NULL, 1, NULL, NULL),
(433, 'file/tmp/63e61ac941b88', 'download.jfif', '2023-02-10 04:22:01', '2023-02-10 04:22:01', NULL, 1, NULL, NULL),
(434, 'file/tmp/63e61accce868', 'marksheet-2.png', '2023-02-10 04:22:04', '2023-02-10 04:22:04', NULL, 1, NULL, NULL),
(435, 'file/tmp/63e61adb1f5c4', 'marksheet-2.png', '2023-02-10 04:22:19', '2023-02-10 04:22:19', NULL, 1, NULL, NULL),
(436, 'file/tmp/63e61ae44d271', 'marksheet-2.png', '2023-02-10 04:22:28', '2023-02-10 04:22:28', NULL, 1, NULL, NULL),
(437, 'file/tmp/63e61ae718f16', 'Reg Card-2.jfif', '2023-02-10 04:22:31', '2023-02-10 04:22:31', NULL, 1, NULL, NULL),
(438, 'file/tmp/63e61aea7ad53', 'marksheet-2.png', '2023-02-10 04:22:34', '2023-02-10 04:22:34', NULL, 1, NULL, NULL),
(439, 'file/tmp/63e61e650b934', 'marksheet-2.png', '2023-02-10 04:37:25', '2023-02-10 04:37:25', NULL, 1, NULL, NULL),
(440, 'file/tmp/63e61e684e4ce', 'Reg Card-2.jfif', '2023-02-10 04:37:28', '2023-02-10 04:37:28', NULL, 1, NULL, NULL),
(441, 'file/tmp/63e61e6daef83', 'Reg Card-1.jfif', '2023-02-10 04:37:33', '2023-02-10 04:37:33', NULL, 1, NULL, NULL),
(442, 'file/tmp/63e61e7a380de', 'Reg Card-1.jfif', '2023-02-10 04:37:46', '2023-02-10 04:37:46', NULL, 1, NULL, NULL),
(443, 'file/tmp/63e61e82b36b1', 'Reg Card-1.jfif', '2023-02-10 04:37:54', '2023-02-10 04:37:54', NULL, 1, NULL, NULL),
(444, 'file/tmp/63e61e862e5c5', 'marksheet-2.png', '2023-02-10 04:37:58', '2023-02-10 04:37:58', NULL, 1, NULL, NULL),
(445, 'file/tmp/63e61e8a388ae', 'download.jfif', '2023-02-10 04:38:02', '2023-02-10 04:38:02', NULL, 1, NULL, NULL),
(446, 'file/tmp/63e61f33081b2', 'marksheet-1.jfif', '2023-02-10 04:40:51', '2023-02-10 04:40:51', NULL, 1, NULL, NULL),
(447, 'file/tmp/63e61f359110c', 'Reg Card-1.jfif', '2023-02-10 04:40:53', '2023-02-10 04:40:53', NULL, 1, NULL, NULL),
(448, 'file/tmp/63e61f391beda', 'download.jfif', '2023-02-10 04:40:57', '2023-02-10 04:40:57', NULL, 1, NULL, NULL),
(449, 'file/tmp/63e61f468bf0c', 'marksheet-2.png', '2023-02-10 04:41:10', '2023-02-10 04:41:10', NULL, 1, NULL, NULL),
(450, 'file/tmp/63e61f5023b6a', 'marksheet-2.png', '2023-02-10 04:41:20', '2023-02-10 04:41:20', NULL, 1, NULL, NULL),
(451, 'file/tmp/63e61f53a74cb', 'Reg Card-2.jfif', '2023-02-10 04:41:23', '2023-02-10 04:41:23', NULL, 1, NULL, NULL),
(452, 'file/tmp/63e61f57051e2', 'download.jfif', '2023-02-10 04:41:27', '2023-02-10 04:41:27', NULL, 1, NULL, NULL),
(453, 'file/tmp/63e61fc7e6c90', 'download.jfif', '2023-02-10 04:43:19', '2023-02-10 04:43:19', NULL, 1, NULL, NULL),
(454, 'file/tmp/63e61fca8b667', 'Reg Card-1.jfif', '2023-02-10 04:43:22', '2023-02-10 04:43:22', NULL, 1, NULL, NULL),
(455, 'file/tmp/63e61fcd6e6e7', 'Reg Card-2.jfif', '2023-02-10 04:43:25', '2023-02-10 04:43:25', NULL, 1, NULL, NULL),
(456, 'file/tmp/63e61fdb52ebd', 'download.jfif', '2023-02-10 04:43:39', '2023-02-10 04:43:39', NULL, 1, NULL, NULL),
(457, 'file/tmp/63e61fe5967b9', 'marksheet-1.jfif', '2023-02-10 04:43:49', '2023-02-10 04:43:49', NULL, 1, NULL, NULL),
(458, 'file/tmp/63e61fe816194', 'Reg Card-2.jfif', '2023-02-10 04:43:52', '2023-02-10 04:43:52', NULL, 1, NULL, NULL),
(459, 'file/tmp/63e61fed35580', 'marksheet-1.jfif', '2023-02-10 04:43:57', '2023-02-10 04:43:57', NULL, 1, NULL, NULL),
(460, 'file/tmp/63e62085750ce', 'marksheet-1.jfif', '2023-02-10 04:46:29', '2023-02-10 04:46:29', NULL, 1, NULL, NULL),
(461, 'file/tmp/63e620886128c', 'Reg Card-1.jfif', '2023-02-10 04:46:32', '2023-02-10 04:46:32', NULL, 1, NULL, NULL),
(462, 'file/tmp/63e6208c4bb76', 'marksheet-2.png', '2023-02-10 04:46:36', '2023-02-10 04:46:36', NULL, 1, NULL, NULL),
(463, 'file/tmp/63e6209c7c0cd', 'marksheet-2.png', '2023-02-10 04:46:52', '2023-02-10 04:46:52', NULL, 1, NULL, NULL),
(464, 'file/tmp/63e620a608a37', 'marksheet-1.jfif', '2023-02-10 04:47:02', '2023-02-10 04:47:02', NULL, 1, NULL, NULL),
(465, 'file/tmp/63e620a921aac', 'Reg Card-2.jfif', '2023-02-10 04:47:05', '2023-02-10 04:47:05', NULL, 1, NULL, NULL),
(466, 'file/tmp/63e620ae8e8f0', 'Reg Card-2.jfif', '2023-02-10 04:47:10', '2023-02-10 04:47:10', NULL, 1, NULL, NULL),
(467, 'file/tmp/63e6225af3070', 'Reg Card-1.jfif', '2023-02-10 04:54:19', '2023-02-10 04:54:19', NULL, 1, NULL, NULL),
(468, 'file/tmp/63e6225d786e7', 'Reg Card-2.jfif', '2023-02-10 04:54:21', '2023-02-10 04:54:21', NULL, 1, NULL, NULL),
(469, 'file/tmp/63e622618ab11', 'marksheet-1.jfif', '2023-02-10 04:54:25', '2023-02-10 04:54:25', NULL, 1, NULL, NULL),
(470, 'file/tmp/63e6226fd6c52', 'download.jfif', '2023-02-10 04:54:39', '2023-02-10 04:54:39', NULL, 1, NULL, NULL),
(471, 'file/tmp/63e622785e867', 'marksheet-2.png', '2023-02-10 04:54:48', '2023-02-10 04:54:48', NULL, 1, NULL, NULL),
(472, 'file/tmp/63e6227b2a427', 'Reg Card-1.jfif', '2023-02-10 04:54:51', '2023-02-10 04:54:51', NULL, 1, NULL, NULL),
(473, 'file/tmp/63e6227e83fc0', 'Reg Card-2.jfif', '2023-02-10 04:54:54', '2023-02-10 04:54:54', NULL, 1, NULL, NULL),
(474, 'file/tmp/63e6273634461', 'download.jfif', '2023-02-10 05:15:02', '2023-02-10 05:15:02', NULL, 1, NULL, NULL),
(475, 'file/tmp/63e6276102dda', 'marksheet-1.jfif', '2023-02-10 05:15:45', '2023-02-10 05:15:45', NULL, 1, NULL, NULL),
(476, 'file/tmp/63e62763af40b', 'marksheet-2.png', '2023-02-10 05:15:47', '2023-02-10 05:15:47', NULL, 1, NULL, NULL),
(477, 'file/tmp/63e6276706b65', 'Reg Card-2.jfif', '2023-02-10 05:15:51', '2023-02-10 05:15:51', NULL, 1, NULL, NULL),
(478, 'file/tmp/63e62777b0522', 'marksheet-1.jfif', '2023-02-10 05:16:07', '2023-02-10 05:16:07', NULL, 1, NULL, NULL),
(479, 'file/tmp/63e62780bed47', 'download.jfif', '2023-02-10 05:16:16', '2023-02-10 05:16:16', NULL, 1, NULL, NULL),
(480, 'file/tmp/63e6278462426', 'marksheet-2.png', '2023-02-10 05:16:20', '2023-02-10 05:16:20', NULL, 1, NULL, NULL),
(481, 'file/tmp/63e62787b0ff1', 'Reg Card-2.jfif', '2023-02-10 05:16:23', '2023-02-10 05:16:23', NULL, 1, NULL, NULL),
(482, 'file/tmp/63e627d027fed', 'marksheet-1.jfif', '2023-02-10 05:17:36', '2023-02-10 05:17:36', NULL, 1, NULL, NULL),
(483, 'file/tmp/63e627d2a3359', 'marksheet-2.png', '2023-02-10 05:17:38', '2023-02-10 05:17:38', NULL, 1, NULL, NULL),
(484, 'file/tmp/63e627d986f50', 'Reg Card-2.jfif', '2023-02-10 05:17:45', '2023-02-10 05:17:45', NULL, 1, NULL, NULL),
(485, 'file/tmp/63e627ebd8305', 'marksheet-1.jfif', '2023-02-10 05:18:03', '2023-02-10 05:18:03', NULL, 1, NULL, NULL),
(486, 'file/tmp/63e627f453a39', 'marksheet-2.png', '2023-02-10 05:18:12', '2023-02-10 05:18:12', NULL, 1, NULL, NULL),
(487, 'file/tmp/63e627f6e7720', 'Reg Card-2.jfif', '2023-02-10 05:18:14', '2023-02-10 05:18:14', NULL, 1, NULL, NULL),
(488, 'file/tmp/63e627f9c0948', 'marksheet-2.png', '2023-02-10 05:18:17', '2023-02-10 05:18:17', NULL, 1, NULL, NULL),
(489, 'file/tmp/63e62cb475cc5', 'download.jfif', '2023-02-10 05:38:28', '2023-02-10 05:38:28', NULL, 1, NULL, NULL),
(490, 'file/tmp/63e62d474ef54', 'download (1).jfif', '2023-02-10 05:40:55', '2023-02-10 05:40:55', NULL, 1, NULL, NULL),
(491, 'file/tmp/63e62d61cae79', 'marksheet-1.jfif', '2023-02-10 05:41:21', '2023-02-10 05:41:21', NULL, 1, NULL, NULL),
(492, 'file/tmp/63e62d64bda5b', 'Reg Card-1.jfif', '2023-02-10 05:41:24', '2023-02-10 05:41:24', NULL, 1, NULL, NULL),
(493, 'file/tmp/63e62d681751b', 'Reg Card-2.jfif', '2023-02-10 05:41:28', '2023-02-10 05:41:28', NULL, 1, NULL, NULL),
(494, 'file/tmp/63e62d7ec5431', 'marksheet-1.jfif', '2023-02-10 05:41:50', '2023-02-10 05:41:50', NULL, 1, NULL, NULL),
(495, 'file/tmp/63e62d815e3b7', 'Reg Card-1.jfif', '2023-02-10 05:41:53', '2023-02-10 05:41:53', NULL, 1, NULL, NULL),
(496, 'file/tmp/63e62d8475010', 'Reg Card-2.jfif', '2023-02-10 05:41:56', '2023-02-10 05:41:56', NULL, 1, NULL, NULL),
(497, 'file/tmp/63e62d99260d5', 'download.jfif', '2023-02-10 05:42:17', '2023-02-10 05:42:17', NULL, 1, NULL, NULL),
(498, 'file/tmp/63e62db0dd72f', 'marksheet-1.jfif', '2023-02-10 05:42:40', '2023-02-10 05:42:40', NULL, 1, NULL, NULL),
(499, 'file/tmp/63e62db41e310', 'Reg Card-1.jfif', '2023-02-10 05:42:44', '2023-02-10 05:42:44', NULL, 1, NULL, NULL),
(500, 'file/tmp/63e62db6ded9f', 'Reg Card-2.jfif', '2023-02-10 05:42:46', '2023-02-10 05:42:46', NULL, 1, NULL, NULL),
(501, 'file/tmp/63e62dcb252db', 'marksheet-1.jfif', '2023-02-10 05:43:07', '2023-02-10 05:43:07', NULL, 1, NULL, NULL),
(502, 'file/tmp/63e62dcdc2bfe', 'Reg Card-1.jfif', '2023-02-10 05:43:09', '2023-02-10 05:43:09', NULL, 1, NULL, NULL),
(503, 'file/tmp/63e62dd0b8c5a', 'Reg Card-2.jfif', '2023-02-10 05:43:12', '2023-02-10 05:43:12', NULL, 1, NULL, NULL),
(504, 'file/tmp/63e62de64fa5c', 'download (1).jfif', '2023-02-10 05:43:34', '2023-02-10 05:43:34', NULL, 1, NULL, NULL),
(505, 'file/tmp/63e62ec0cc9bd', 'download (1).jfif', '2023-02-10 05:47:12', '2023-02-10 05:47:12', NULL, 1, NULL, NULL),
(506, 'file/tmp/63e62f162fb8a', 'download (1).jfif', '2023-02-10 05:48:38', '2023-02-10 05:48:38', NULL, 1, NULL, NULL),
(507, 'file/tmp/63e6302f7d5d7', 'marksheet-1.jfif', '2023-02-10 05:53:19', '2023-02-10 05:53:19', NULL, 1, NULL, NULL),
(508, 'file/tmp/63e630d6014a5', 'download.jfif', '2023-02-10 05:56:06', '2023-02-10 05:56:06', NULL, 1, NULL, NULL),
(509, 'file/tmp/63e630e336264', 'marksheet-1.jfif', '2023-02-10 05:56:19', '2023-02-10 05:56:19', NULL, 1, NULL, NULL),
(510, 'file/tmp/63e630e604eb6', 'marksheet-2.png', '2023-02-10 05:56:22', '2023-02-10 05:56:22', NULL, 1, NULL, NULL),
(511, 'file/tmp/63e630e9af441', 'Reg Card-1.jfif', '2023-02-10 05:56:25', '2023-02-10 05:56:25', NULL, 1, NULL, NULL),
(512, 'file/tmp/63e630fa9b8ae', 'marksheet-1.jfif', '2023-02-10 05:56:42', '2023-02-10 05:56:42', NULL, 1, NULL, NULL),
(513, 'file/tmp/63e6310430cb6', 'marksheet-1.jfif', '2023-02-10 05:56:52', '2023-02-10 05:56:52', NULL, 1, NULL, NULL),
(514, 'file/tmp/63e6310701d18', 'Reg Card-1.jfif', '2023-02-10 05:56:55', '2023-02-10 05:56:55', NULL, 1, NULL, NULL),
(515, 'file/tmp/63e63109d943e', 'Reg Card-2.jfif', '2023-02-10 05:56:57', '2023-02-10 05:56:57', NULL, 1, NULL, NULL),
(516, 'file/tmp/63e63175eeed4', 'marksheet-1.jfif', '2023-02-10 05:58:45', '2023-02-10 05:58:46', NULL, 1, NULL, NULL),
(517, 'file/tmp/63e631e30eb53', 'marksheet-1.jfif', '2023-02-10 06:00:35', '2023-02-10 06:00:35', NULL, 1, NULL, NULL),
(518, 'file/tmp/63e631e5e8785', 'Reg Card-1.jfif', '2023-02-10 06:00:37', '2023-02-10 06:00:37', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role_id`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Super Admin', 1, 'admin@email.com', NULL, '$2y$10$w0f4PKbQxDA2xm9NrsWTVufEVgq0LDCPerhinBKEvRn7ULN3PZM5S', NULL, '2022-09-02 17:58:49', NULL, NULL, NULL, NULL, NULL),
(3, 'AL KAFI SOHAG', 3, 'aksohag@gmail.com', NULL, '$2y$10$Ybgp94ZLAY77nYICWT5m6ek/I4CB0IhzMuWHrz16uchcGAu/xJV0i', NULL, '2022-09-22 08:42:11', '2022-09-22 08:42:11', NULL, 1, NULL, NULL),
(4, 'sakib', 4, 'sakib.euitsols@gmail.com', NULL, '$2y$10$raqZRgB44YXrjg8fyT2uP.GAZViBjccpSLLiU2b7VxdPlndsU5y6W', NULL, '2022-09-26 10:42:14', '2022-09-26 10:42:14', NULL, 1, NULL, NULL),
(5, 'Mr. Robin', 1, 'robin@email.com', NULL, '$2y$10$8Ii8eGz9S0pvrG0TXXz/WuCVBGScKByYFyifviMbkF.Zan4L7aroO', NULL, '2022-10-29 08:21:47', '2022-10-29 08:25:27', NULL, 1, 1, NULL),
(6, 'Fahim Ahmed', 3, 'fahim.euitsols@gmail.com', NULL, '$2y$10$GxuZYAfVzKmUJLpwriADLe0X7cpHxFIcYJaq/Lu6S0yJ.jua4xigq', NULL, '2023-01-10 13:30:53', '2023-01-10 13:43:54', '2023-01-10 13:43:54', 1, NULL, 1),
(7, 'Ahmed Fahim', 4, 'tester@gmail.com', NULL, '$2y$10$lq4VM2.mmhrMgDFGUPIcpebQqt3eLT/sLx7hGnLQKdKywscMFZJL.', NULL, '2023-01-10 14:17:11', '2023-01-10 14:17:11', NULL, 1, NULL, NULL),
(10, 'Shriful', 8, 'shariful@gmail.com', NULL, '$2y$10$OYIMtvOxrqOnL6K7XImQm.tQftSi3ecDxh1YMIN9dzERmeuOHEseO', NULL, '2023-01-28 05:06:06', '2023-01-28 05:06:06', NULL, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_infos`
--
ALTER TABLE `academic_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `academic_infos_student_infos` (`student_infos_id`),
  ADD KEY `academic_infos_exam` (`exam_id`),
  ADD KEY `academic_infos_board` (`board_id`),
  ADD KEY `academic_infos_created` (`created_by`),
  ADD KEY `academic_infos_updated` (`updated_by`),
  ADD KEY `academic_infos_deleted` (`deleted_by`);

--
-- Indexes for table `admitted_std_assigns`
--
ALTER TABLE `admitted_std_assigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admitted_std_assigns_student_infos` (`student_infos_id`),
  ADD KEY `admitted_std_assigns_session` (`session_id`),
  ADD KEY `admitted_std_assigns_semester` (`semester_id`),
  ADD KEY `admitted_std_assigns_group` (`group_id`),
  ADD KEY `admitted_std_assigns_shift` (`shift_id`),
  ADD KEY `admitted_std_assigns_created` (`created_by`),
  ADD KEY `admitted_std_assigns_updated` (`updated_by`),
  ADD KEY `admitted_std_assigns_deleted` (`deleted_by`);

--
-- Indexes for table `asset_base_units`
--
ALTER TABLE `asset_base_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_base_units_created` (`created_by`),
  ADD KEY `asset_base_units_deleted` (`deleted_by`),
  ADD KEY `asset_base_units_updated` (`updated_by`);

--
-- Indexes for table `asset_brands`
--
ALTER TABLE `asset_brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_brands_created` (`created_by`),
  ADD KEY `asset_brands_deleted` (`deleted_by`),
  ADD KEY `asset_brands_updated` (`updated_by`);

--
-- Indexes for table `asset_categories`
--
ALTER TABLE `asset_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_categories_created` (`created_by`),
  ADD KEY `asset_categories_deleted` (`deleted_by`),
  ADD KEY `asset_categories_updated` (`updated_by`);

--
-- Indexes for table `asset_damages`
--
ALTER TABLE `asset_damages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_damages_main_assign_id` (`main_assign_id`),
  ADD KEY `asset_damages_supplier_id` (`supplier_id`),
  ADD KEY `asset_damages_product_id` (`product_id`),
  ADD KEY `asset_damages_created` (`created_by`),
  ADD KEY `asset_damages_deleted` (`deleted_by`),
  ADD KEY `asset_damages_updated` (`updated_by`);

--
-- Indexes for table `asset_units`
--
ALTER TABLE `asset_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_units_base_unit` (`base_unit_id`),
  ADD KEY `asset_units_created` (`created_by`),
  ADD KEY `asset_units_deleted` (`deleted_by`),
  ADD KEY `asset_units_updated` (`updated_by`);

--
-- Indexes for table `assign_books`
--
ALTER TABLE `assign_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assign_books_std_id_foreign` (`std_id`),
  ADD KEY `assign_books_book_id_foreign` (`book_id`),
  ADD KEY `assign_books_created_by_foreign` (`created_by`),
  ADD KEY `assign_books_deleted_by_foreign` (`deleted_by`),
  ADD KEY `assign_books_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `assign_products`
--
ALTER TABLE `assign_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assign_products_department_id` (`department_id`),
  ADD KEY `assign_products_section_id` (`section_id`),
  ADD KEY `assign_products_subsection_id` (`subsection_id`),
  ADD KEY `assign_products_created` (`created_by`),
  ADD KEY `assign_products_deleted` (`deleted_by`),
  ADD KEY `assign_products_updated` (`updated_by`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_session` (`session_id`),
  ADD KEY `attendances_departments` (`departments_id`),
  ADD KEY `attendances_semesters` (`semester_id`),
  ADD KEY `attendances_teachers` (`teacher_id`),
  ADD KEY `attendances_subjects` (`subject_id`),
  ADD KEY `attendances_groups` (`group_id`),
  ADD KEY `attendances_shifts` (`shift_id`),
  ADD KEY `attendances_created` (`created_by`),
  ADD KEY `attendances_updated` (`updated_by`),
  ADD KEY `attendances_deleted` (`deleted_by`);

--
-- Indexes for table `bloodgroups`
--
ALTER TABLE `bloodgroups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bloodgroups_created` (`created_by`),
  ADD KEY `bloodgroups_deleted` (`deleted_by`),
  ADD KEY `bloodgroups_updated` (`updated_by`);

--
-- Indexes for table `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boards_created` (`created_by`),
  ADD KEY `boards_deleted` (`deleted_by`),
  ADD KEY `boards_updated` (`updated_by`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_category` (`category_id`),
  ADD KEY `books_bookshelf` (`bookshelf_id`),
  ADD KEY `books_created` (`created_by`),
  ADD KEY `books_deleted` (`deleted_by`),
  ADD KEY `books_updated` (`updated_by`);

--
-- Indexes for table `bookshelves`
--
ALTER TABLE `bookshelves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookshelves_created` (`created_by`),
  ADD KEY `bookshelves_deleted` (`deleted_by`),
  ADD KEY `bookshelves_updated` (`updated_by`);

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buildings_created` (`created_by`),
  ADD KEY `buildings_deleted` (`deleted_by`),
  ADD KEY `buildings_updated` (`updated_by`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_departments` (`departments_id`),
  ADD KEY `categories_created` (`created_by`),
  ADD KEY `categories_deleted` (`deleted_by`),
  ADD KEY `categories_updated` (`updated_by`);

--
-- Indexes for table `class_contents`
--
ALTER TABLE `class_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_contents_std_attendances` (`std_attendance_id`),
  ADD KEY `class_contents_created` (`created_by`),
  ADD KEY `class_contents_updated` (`updated_by`),
  ADD KEY `class_contents_deleted` (`deleted_by`);

--
-- Indexes for table `class_files`
--
ALTER TABLE `class_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_files_std_attendances` (`std_attendance_id`),
  ADD KEY `class_files_created` (`created_by`),
  ADD KEY `class_files_updated` (`updated_by`),
  ADD KEY `class_files_deleted` (`deleted_by`);

--
-- Indexes for table `credits`
--
ALTER TABLE `credits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `credits_credit_number_unique` (`credit_number`),
  ADD KEY `credits_created` (`created_by`),
  ADD KEY `credits_deleted` (`deleted_by`),
  ADD KEY `credits_updated` (`updated_by`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_created` (`created_by`),
  ADD KEY `departments_updated` (`updated_by`),
  ADD KEY `departments_deleted` (`deleted_by`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designations_created` (`created_by`),
  ADD KEY `designations_deleted` (`deleted_by`),
  ADD KEY `designations_updated` (`updated_by`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_division` (`division_id`),
  ADD KEY `districts_created` (`created_by`),
  ADD KEY `districts_deleted` (`deleted_by`),
  ADD KEY `districts_updated` (`updated_by`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `divisions_created` (`created_by`),
  ADD KEY `divisions_deleted` (`deleted_by`),
  ADD KEY `divisions_updated` (`updated_by`);

--
-- Indexes for table `eadmissions`
--
ALTER TABLE `eadmissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eadmissions_created` (`created_by`),
  ADD KEY `eadmissions_deleted` (`deleted_by`),
  ADD KEY `eadmissions_updated` (`updated_by`);

--
-- Indexes for table `employee_academic_infos`
--
ALTER TABLE `employee_academic_infos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_academic_infos_roll_unique` (`roll`),
  ADD UNIQUE KEY `employee_academic_infos_reg_no_unique` (`reg_no`),
  ADD KEY `employee_academic_infos_employee_infos` (`employee_infos_id`),
  ADD KEY `employee_academic_infos_exam` (`exam_id`),
  ADD KEY `employee_academic_infos_board` (`board_id`),
  ADD KEY `employee_academic_infos_created` (`created_by`),
  ADD KEY `employee_academic_infos_updated` (`updated_by`),
  ADD KEY `employee_academic_infos_deleted` (`deleted_by`);

--
-- Indexes for table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_documents_employee_infos` (`employee_infos_id`),
  ADD KEY `employee_designation` (`designation_id`),
  ADD KEY `employee_documents_created` (`created_by`),
  ADD KEY `employee_documents_updated` (`updated_by`),
  ADD KEY `employee_documents_deleted` (`deleted_by`);

--
-- Indexes for table `employee_experiences`
--
ALTER TABLE `employee_experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_experiences_employee_infos` (`employee_infos_id`),
  ADD KEY `employee_experiences_created` (`created_by`),
  ADD KEY `employee_experiences_updated` (`updated_by`),
  ADD KEY `employee_experiences_deleted` (`deleted_by`);

--
-- Indexes for table `employee_infos`
--
ALTER TABLE `employee_infos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_infos_phone_unique` (`phone`),
  ADD UNIQUE KEY `employee_infos_employee_id_unique` (`employee_id`),
  ADD UNIQUE KEY `employee_infos_email_unique` (`email`),
  ADD UNIQUE KEY `employee_infos_spouse_number_unique` (`spouse_number`),
  ADD KEY `employee_infos_departments` (`departments_id`),
  ADD KEY `employee_infos_bg` (`bg_id`),
  ADD KEY `employee_infos_division` (`division_id`),
  ADD KEY `employee_infos_district` (`district_id`),
  ADD KEY `employee_infos_created` (`created_by`),
  ADD KEY `employee_infos_updated` (`updated_by`),
  ADD KEY `employee_infos_deleted` (`deleted_by`);

--
-- Indexes for table `exam_creates`
--
ALTER TABLE `exam_creates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_creates_search` (`search_id`),
  ADD KEY `exam_creates_type` (`type_id`),
  ADD KEY `exam_creates_created` (`created_by`),
  ADD KEY `exam_creates_deleted` (`deleted_by`),
  ADD KEY `exam_creates_updated` (`updated_by`);

--
-- Indexes for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_searches`
--
ALTER TABLE `exam_searches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_searches_session` (`session_id`),
  ADD KEY `exam_searches_department` (`department_id`),
  ADD KEY `exam_searches_semester` (`semester_id`),
  ADD KEY `exam_searches_created` (`created_by`),
  ADD KEY `exam_searches_updated` (`updated_by`),
  ADD KEY `exam_searches_deleted` (`deleted_by`);

--
-- Indexes for table `exam_shifts`
--
ALTER TABLE `exam_shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_shifts_created` (`created_by`),
  ADD KEY `exam_shifts_deleted` (`deleted_by`),
  ADD KEY `exam_shifts_updated` (`updated_by`);

--
-- Indexes for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_types`
--
ALTER TABLE `exam_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_types_created` (`created_by`),
  ADD KEY `exam_types_deleted` (`deleted_by`),
  ADD KEY `exam_types_updated` (`updated_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `floors`
--
ALTER TABLE `floors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `floors_building` (`building_id`),
  ADD KEY `floors_created` (`created_by`),
  ADD KEY `floors_deleted` (`deleted_by`),
  ADD KEY `floors_updated` (`updated_by`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grades_lettergrades` (`lettergrades_id`),
  ADD KEY `grades_created` (`created_by`),
  ADD KEY `grades_deleted` (`deleted_by`),
  ADD KEY `grades_updated` (`updated_by`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_created` (`created_by`),
  ADD KEY `groups_deleted` (`deleted_by`),
  ADD KEY `groups_updated` (`updated_by`);

--
-- Indexes for table `lettergrades`
--
ALTER TABLE `lettergrades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lettergrades_created` (`created_by`),
  ADD KEY `lettergrades_deleted` (`deleted_by`),
  ADD KEY `lettergrades_updated` (`updated_by`);

--
-- Indexes for table `library_members`
--
ALTER TABLE `library_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `library_members_std` (`std_id`),
  ADD KEY `library_members_teacher` (`teacher_id`),
  ADD KEY `library_members_created` (`created_by`),
  ADD KEY `library_members_deleted` (`deleted_by`),
  ADD KEY `library_members_updated` (`updated_by`);

--
-- Indexes for table `library_students`
--
ALTER TABLE `library_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `library_students_std` (`std_id`),
  ADD KEY `library_students_created` (`created_by`),
  ADD KEY `library_students_deleted` (`deleted_by`),
  ADD KEY `library_students_updated` (`updated_by`);

--
-- Indexes for table `main_assign_products`
--
ALTER TABLE `main_assign_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `main_assign_products_assign_product_id` (`assign_product_id`),
  ADD KEY `main_assign_products_product_id` (`product_id`),
  ADD KEY `main_assign_products_supplier_id` (`supplier_id`),
  ADD KEY `main_assign_products_created` (`created_by`),
  ADD KEY `main_assign_products_deleted` (`deleted_by`),
  ADD KEY `main_assign_products_updated` (`updated_by`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `more_products`
--
ALTER TABLE `more_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `more_products_product` (`product_id`),
  ADD KEY `more_products_supplier` (`supplier_id`),
  ADD KEY `more_products_created` (`created_by`),
  ADD KEY `more_products_deleted` (`deleted_by`),
  ADD KEY `more_products_updated` (`updated_by`);

--
-- Indexes for table `nationalities`
--
ALTER TABLE `nationalities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nationalities_created` (`created_by`),
  ADD KEY `nationalities_deleted` (`deleted_by`),
  ADD KEY `nationalities_updated` (`updated_by`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `permission_user_created` (`created_by`),
  ADD KEY `permission_user_deleted` (`deleted_by`),
  ADD KEY `permission_user_updated` (`updated_by`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_cat` (`cat_id`),
  ADD KEY `products_subcat` (`subcat_id`),
  ADD KEY `products_brand` (`brand_id`),
  ADD KEY `products_unit` (`unit_id`),
  ADD KEY `products_departmetn` (`department_id`),
  ADD KEY `products_created` (`created_by`),
  ADD KEY `products_deleted` (`deleted_by`),
  ADD KEY `products_updated` (`updated_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `roles_user_created` (`created_by`),
  ADD KEY `roles_user_deleted` (`deleted_by`),
  ADD KEY `roles_user_updated` (`updated_by`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_floor` (`floor_id`),
  ADD KEY `rooms_created` (`created_by`),
  ADD KEY `rooms_deleted` (`deleted_by`),
  ADD KEY `rooms_updated` (`updated_by`);

--
-- Indexes for table `routines`
--
ALTER TABLE `routines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `routines_department_id` (`department_id`),
  ADD KEY `routines_semester_id` (`semester_id`),
  ADD KEY `routines_session_id` (`session_id`),
  ADD KEY `routines_group_id` (`group_id`),
  ADD KEY `routines_shift_id` (`shift_id`),
  ADD KEY `routines_assigns_created` (`created_by`),
  ADD KEY `routines_assigns_deleted` (`deleted_by`),
  ADD KEY `routines_assigns_updated` (`updated_by`);

--
-- Indexes for table `routine_dates`
--
ALTER TABLE `routine_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `routine_times_subject` (`subject_id`),
  ADD KEY `routine_times_routine` (`routine_id`),
  ADD KEY `routine_times_assigns_created` (`created_by`),
  ADD KEY `routine_times_assigns_deleted` (`deleted_by`),
  ADD KEY `routine_times_assigns_updated` (`updated_by`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_departmetn` (`department_id`),
  ADD KEY `sections_created` (`created_by`),
  ADD KEY `sections_deleted` (`deleted_by`),
  ADD KEY `sections_updated` (`updated_by`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `semesters_created` (`created_by`),
  ADD KEY `semesters_deleted` (`deleted_by`),
  ADD KEY `semesters_updated` (`updated_by`);

--
-- Indexes for table `semester_durations`
--
ALTER TABLE `semester_durations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `semester_durations_semester` (`semester_id`),
  ADD KEY `semester_durations_session` (`session_id`),
  ADD KEY `semester_durations_created` (`created_by`),
  ADD KEY `semester_durations_deleted` (`deleted_by`),
  ADD KEY `semester_durations_updated` (`updated_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_created` (`created_by`),
  ADD KEY `sessions_deleted` (`deleted_by`),
  ADD KEY `sessions_updated` (`updated_by`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shifts_created` (`created_by`),
  ADD KEY `shifts_deleted` (`deleted_by`),
  ADD KEY `shifts_updated` (`updated_by`);

--
-- Indexes for table `std_attendances`
--
ALTER TABLE `std_attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `std_attendances_student_infos` (`student_infos_id`),
  ADD KEY `std_attendances_attendance` (`attendance_id`),
  ADD KEY `std_attendances_created` (`created_by`),
  ADD KEY `std_attendances_updated` (`updated_by`),
  ADD KEY `std_attendances_deleted` (`deleted_by`);

--
-- Indexes for table `student_infos`
--
ALTER TABLE `student_infos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_infos_phone_unique` (`phone`),
  ADD UNIQUE KEY `student_infos_student_id_unique` (`student_id`),
  ADD UNIQUE KEY `student_infos_email_unique` (`email`),
  ADD KEY `student_infos_departments` (`departments_id`),
  ADD KEY `student_infos_bg` (`bg_id`),
  ADD KEY `student_infos_division` (`division_id`),
  ADD KEY `student_infos_district` (`district_id`),
  ADD KEY `student_infos_created` (`created_by`),
  ADD KEY `student_infos_updated` (`updated_by`),
  ADD KEY `student_infos_deleted` (`deleted_by`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategories_cat` (`cat_id`),
  ADD KEY `subcategories_created` (`created_by`),
  ADD KEY `subcategories_deleted` (`deleted_by`),
  ADD KEY `subcategories_updated` (`updated_by`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_credit` (`credit_id`),
  ADD KEY `subjects_department` (`department_id`),
  ADD KEY `subjects_created` (`created_by`),
  ADD KEY `subjects_deleted` (`deleted_by`),
  ADD KEY `subjects_updated` (`updated_by`);

--
-- Indexes for table `subject_assigns`
--
ALTER TABLE `subject_assigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_assigns_session` (`session_id`),
  ADD KEY `subject_assigns_department` (`department_id`),
  ADD KEY `subject_assigns_subject` (`subject_id`),
  ADD KEY `subject_assigns_semester` (`semester_id`),
  ADD KEY `subject_assigns_created` (`created_by`),
  ADD KEY `subject_assigns_deleted` (`deleted_by`),
  ADD KEY `subject_assigns_updated` (`updated_by`);

--
-- Indexes for table `subsections`
--
ALTER TABLE `subsections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subsections_section` (`section_id`),
  ADD KEY `subsections_created` (`created_by`),
  ADD KEY `subsections_deleted` (`deleted_by`),
  ADD KEY `subsections_updated` (`updated_by`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_created` (`created_by`),
  ADD KEY `suppliers_deleted` (`deleted_by`),
  ADD KEY `suppliers_updated` (`updated_by`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_phone_unique` (`phone`),
  ADD UNIQUE KEY `teachers_email_unique` (`email`),
  ADD UNIQUE KEY `teachers_nid_unique` (`nid`),
  ADD KEY `teachers_departments` (`departments_id`),
  ADD KEY `teachers_divisions` (`divisions_id`),
  ADD KEY `teachers_districts` (`districts_id`),
  ADD KEY `teachers_bloodgroups` (`bloodgroups_id`),
  ADD KEY `teachers_created` (`created_by`),
  ADD KEY `teachers_deleted` (`deleted_by`),
  ADD KEY `teachers_updated` (`updated_by`);

--
-- Indexes for table `teacher_assigns`
--
ALTER TABLE `teacher_assigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_assigns_subject_assign` (`subject_assign_id`),
  ADD KEY `teacher_assigns_shift` (`shift_id`),
  ADD KEY `teacher_assigns_group` (`group_id`),
  ADD KEY `teacher_assigns_created` (`created_by`),
  ADD KEY `teacher_assigns_deleted` (`deleted_by`),
  ADD KEY `teacher_assigns_updated` (`updated_by`);

--
-- Indexes for table `tmp_files`
--
ALTER TABLE `tmp_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tmp_files_created` (`created_by`),
  ADD KEY `tmp_files_deleted` (`deleted_by`),
  ADD KEY `tmp_files_updated` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `user_created` (`created_by`),
  ADD KEY `user_deleted` (`deleted_by`),
  ADD KEY `user_updated` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_infos`
--
ALTER TABLE `academic_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `admitted_std_assigns`
--
ALTER TABLE `admitted_std_assigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `asset_base_units`
--
ALTER TABLE `asset_base_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `asset_brands`
--
ALTER TABLE `asset_brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_categories`
--
ALTER TABLE `asset_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_damages`
--
ALTER TABLE `asset_damages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_units`
--
ALTER TABLE `asset_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assign_books`
--
ALTER TABLE `assign_books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assign_products`
--
ALTER TABLE `assign_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bloodgroups`
--
ALTER TABLE `bloodgroups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `boards`
--
ALTER TABLE `boards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookshelves`
--
ALTER TABLE `bookshelves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `class_contents`
--
ALTER TABLE `class_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `class_files`
--
ALTER TABLE `class_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `credits`
--
ALTER TABLE `credits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `eadmissions`
--
ALTER TABLE `eadmissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee_academic_infos`
--
ALTER TABLE `employee_academic_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `employee_documents`
--
ALTER TABLE `employee_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `employee_experiences`
--
ALTER TABLE `employee_experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `employee_infos`
--
ALTER TABLE `employee_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exam_creates`
--
ALTER TABLE `exam_creates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_searches`
--
ALTER TABLE `exam_searches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exam_shifts`
--
ALTER TABLE `exam_shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exam_types`
--
ALTER TABLE `exam_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floors`
--
ALTER TABLE `floors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lettergrades`
--
ALTER TABLE `lettergrades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `library_members`
--
ALTER TABLE `library_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `library_students`
--
ALTER TABLE `library_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `main_assign_products`
--
ALTER TABLE `main_assign_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `more_products`
--
ALTER TABLE `more_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nationalities`
--
ALTER TABLE `nationalities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `routines`
--
ALTER TABLE `routines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `routine_dates`
--
ALTER TABLE `routine_dates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `semester_durations`
--
ALTER TABLE `semester_durations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `std_attendances`
--
ALTER TABLE `std_attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student_infos`
--
ALTER TABLE `student_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subject_assigns`
--
ALTER TABLE `subject_assigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subsections`
--
ALTER TABLE `subsections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `teacher_assigns`
--
ALTER TABLE `teacher_assigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tmp_files`
--
ALTER TABLE `tmp_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=519;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admitted_std_assigns`
--
ALTER TABLE `admitted_std_assigns`
  ADD CONSTRAINT `admitted_std_assigns_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admitted_std_assigns_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admitted_std_assigns_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admitted_std_assigns_semester` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admitted_std_assigns_session` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admitted_std_assigns_shift` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admitted_std_assigns_student_infos` FOREIGN KEY (`student_infos_id`) REFERENCES `student_infos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admitted_std_assigns_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asset_base_units`
--
ALTER TABLE `asset_base_units`
  ADD CONSTRAINT `asset_base_units_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_base_units_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_base_units_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asset_brands`
--
ALTER TABLE `asset_brands`
  ADD CONSTRAINT `asset_brands_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_brands_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_brands_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asset_categories`
--
ALTER TABLE `asset_categories`
  ADD CONSTRAINT `asset_categories_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_categories_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_categories_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asset_damages`
--
ALTER TABLE `asset_damages`
  ADD CONSTRAINT `asset_damages_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_damages_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_damages_main_assign_id` FOREIGN KEY (`main_assign_id`) REFERENCES `main_assign_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_damages_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_damages_supplier_id` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_damages_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asset_units`
--
ALTER TABLE `asset_units`
  ADD CONSTRAINT `asset_units_base_unit` FOREIGN KEY (`base_unit_id`) REFERENCES `asset_base_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_units_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_units_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_units_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assign_books`
--
ALTER TABLE `assign_books`
  ADD CONSTRAINT `assign_books_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_books_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_books_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_books_std_id_foreign` FOREIGN KEY (`std_id`) REFERENCES `library_members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_books_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assign_products`
--
ALTER TABLE `assign_products`
  ADD CONSTRAINT `assign_products_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_products_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_products_department_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_products_section_id` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_products_subsection_id` FOREIGN KEY (`subsection_id`) REFERENCES `subsections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_products_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_departments` FOREIGN KEY (`departments_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_semesters` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_session` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_shifts` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_subjects` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_teachers` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bloodgroups`
--
ALTER TABLE `bloodgroups`
  ADD CONSTRAINT `bloodgroups_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bloodgroups_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bloodgroups_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `boards`
--
ALTER TABLE `boards`
  ADD CONSTRAINT `boards_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `boards_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `boards_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_bookshelf` FOREIGN KEY (`bookshelf_id`) REFERENCES `bookshelves` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `books_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `books_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `books_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `books_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bookshelves`
--
ALTER TABLE `bookshelves`
  ADD CONSTRAINT `bookshelves_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookshelves_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookshelves_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `buildings`
--
ALTER TABLE `buildings`
  ADD CONSTRAINT `buildings_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buildings_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buildings_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categories_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categories_departments` FOREIGN KEY (`departments_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categories_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class_contents`
--
ALTER TABLE `class_contents`
  ADD CONSTRAINT `class_contents_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_contents_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_contents_std_attendances` FOREIGN KEY (`std_attendance_id`) REFERENCES `std_attendances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_contents_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class_files`
--
ALTER TABLE `class_files`
  ADD CONSTRAINT `class_files_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_files_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_files_std_attendances` FOREIGN KEY (`std_attendance_id`) REFERENCES `std_attendances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_files_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `credits`
--
ALTER TABLE `credits`
  ADD CONSTRAINT `credits_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `credits_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `credits_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `departments_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `departments_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `designations`
--
ALTER TABLE `designations`
  ADD CONSTRAINT `designations_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `designations_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `designations_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `districts_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `districts_division` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `districts_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `divisions`
--
ALTER TABLE `divisions`
  ADD CONSTRAINT `divisions_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `divisions_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `divisions_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eadmissions`
--
ALTER TABLE `eadmissions`
  ADD CONSTRAINT `eadmissions_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eadmissions_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eadmissions_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_academic_infos`
--
ALTER TABLE `employee_academic_infos`
  ADD CONSTRAINT `employee_academic_infos_board` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_academic_infos_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_academic_infos_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_academic_infos_employee_infos` FOREIGN KEY (`employee_infos_id`) REFERENCES `employee_infos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_academic_infos_exam` FOREIGN KEY (`exam_id`) REFERENCES `eadmissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_academic_infos_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD CONSTRAINT `employee_designation` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_documents_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_documents_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_documents_employee_infos` FOREIGN KEY (`employee_infos_id`) REFERENCES `employee_infos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_documents_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_experiences`
--
ALTER TABLE `employee_experiences`
  ADD CONSTRAINT `employee_experiences_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_experiences_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_experiences_employee_infos` FOREIGN KEY (`employee_infos_id`) REFERENCES `employee_infos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_experiences_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_infos`
--
ALTER TABLE `employee_infos`
  ADD CONSTRAINT `employee_infos_bg` FOREIGN KEY (`bg_id`) REFERENCES `bloodgroups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_infos_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_infos_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_infos_departments` FOREIGN KEY (`departments_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_infos_district` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_infos_division` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_infos_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_creates`
--
ALTER TABLE `exam_creates`
  ADD CONSTRAINT `exam_creates_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_creates_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_creates_search` FOREIGN KEY (`search_id`) REFERENCES `exam_searches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_creates_type` FOREIGN KEY (`type_id`) REFERENCES `exam_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_creates_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_searches`
--
ALTER TABLE `exam_searches`
  ADD CONSTRAINT `exam_searches_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_searches_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_searches_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_searches_semester` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_searches_session` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_searches_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_shifts`
--
ALTER TABLE `exam_shifts`
  ADD CONSTRAINT `exam_shifts_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_shifts_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_shifts_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_types`
--
ALTER TABLE `exam_types`
  ADD CONSTRAINT `exam_types_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_types_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_types_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `floors`
--
ALTER TABLE `floors`
  ADD CONSTRAINT `floors_building` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `floors_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `floors_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `floors_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lettergrades`
--
ALTER TABLE `lettergrades`
  ADD CONSTRAINT `lettergrades_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lettergrades_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lettergrades_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `library_members`
--
ALTER TABLE `library_members`
  ADD CONSTRAINT `library_members_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `library_members_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `library_members_std` FOREIGN KEY (`std_id`) REFERENCES `student_infos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `library_members_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `library_members_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `main_assign_products`
--
ALTER TABLE `main_assign_products`
  ADD CONSTRAINT `main_assign_products_assign_product_id` FOREIGN KEY (`assign_product_id`) REFERENCES `assign_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `main_assign_products_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `main_assign_products_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `main_assign_products_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `main_assign_products_supplier_id` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `main_assign_products_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `more_products`
--
ALTER TABLE `more_products`
  ADD CONSTRAINT `more_products_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `more_products_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `more_products_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `more_products_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `more_products_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nationalities`
--
ALTER TABLE `nationalities`
  ADD CONSTRAINT `nationalities_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nationalities_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nationalities_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permission_user_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_user_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_user_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand` FOREIGN KEY (`brand_id`) REFERENCES `asset_brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_cat` FOREIGN KEY (`cat_id`) REFERENCES `asset_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_departmetn` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_subcat` FOREIGN KEY (`subcat_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_unit` FOREIGN KEY (`unit_id`) REFERENCES `asset_units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_user_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `roles_user_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `roles_user_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rooms_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rooms_floor` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rooms_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `routines`
--
ALTER TABLE `routines`
  ADD CONSTRAINT `routines_assigns_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routines_assigns_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routines_assigns_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routines_department_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routines_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routines_semester_id` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routines_session_id` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routines_shift_id` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `routine_dates`
--
ALTER TABLE `routine_dates`
  ADD CONSTRAINT `routine_times_assigns_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routine_times_assigns_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routine_times_assigns_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routine_times_routine` FOREIGN KEY (`routine_id`) REFERENCES `routines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routine_times_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sections_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sections_departmetn` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sections_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `semesters`
--
ALTER TABLE `semesters`
  ADD CONSTRAINT `semesters_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `semesters_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `semesters_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `semester_durations`
--
ALTER TABLE `semester_durations`
  ADD CONSTRAINT `semester_durations_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `semester_durations_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `semester_durations_semester` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `semester_durations_session` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `semester_durations_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sessions_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sessions_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shifts`
--
ALTER TABLE `shifts`
  ADD CONSTRAINT `shifts_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shifts_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shifts_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `std_attendances`
--
ALTER TABLE `std_attendances`
  ADD CONSTRAINT `std_attendances_attendance` FOREIGN KEY (`attendance_id`) REFERENCES `attendances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `std_attendances_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `std_attendances_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `std_attendances_student_infos` FOREIGN KEY (`student_infos_id`) REFERENCES `student_infos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `std_attendances_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_infos`
--
ALTER TABLE `student_infos`
  ADD CONSTRAINT `student_infos_bg` FOREIGN KEY (`bg_id`) REFERENCES `bloodgroups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_infos_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_infos_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_infos_departments` FOREIGN KEY (`departments_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_infos_district` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_infos_division` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_infos_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_cat` FOREIGN KEY (`cat_id`) REFERENCES `asset_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subcategories_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subcategories_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subcategories_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_credit` FOREIGN KEY (`credit_id`) REFERENCES `credits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subsections`
--
ALTER TABLE `subsections`
  ADD CONSTRAINT `subsections_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subsections_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subsections_section` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subsections_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `suppliers_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `suppliers_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teacher_assigns`
--
ALTER TABLE `teacher_assigns`
  ADD CONSTRAINT `teacher_assigns_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_assigns_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_assigns_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_assigns_shift` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_assigns_subject_assign` FOREIGN KEY (`subject_assign_id`) REFERENCES `subject_assigns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_assigns_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tmp_files`
--
ALTER TABLE `tmp_files`
  ADD CONSTRAINT `tmp_files_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tmp_files_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tmp_files_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_created` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_deleted` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_updated` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
