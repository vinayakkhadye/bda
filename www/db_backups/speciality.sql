-- phpMyAdmin SQL Dump
-- version 4.2.13
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 13, 2015 at 06:15 AM
-- Server version: 5.6.22
-- PHP Version: 5.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bda_vin`
--

-- --------------------------------------------------------

--
-- Table structure for table `speciality`
--

CREATE TABLE IF NOT EXISTS `speciality` (
`id` int(11) NOT NULL COMMENT 'all the specialities like dentist etc',
  `name` varchar(100) COLLATE latin1_danish_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` datetime DEFAULT NULL,
  `sort` smallint(5) NOT NULL DEFAULT '999',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 - freatured'
) ENGINE=MyISAM AUTO_INCREMENT=111 DEFAULT CHARSET=latin1 COLLATE=latin1_danish_ci;

--
-- Dumping data for table `speciality`
--

INSERT INTO `speciality` (`id`, `name`, `status`, `created_on`, `updated_on`, `sort`, `is_featured`) VALUES
(1, 'ENT specialist', 1, '2014-12-12 11:05:04', NULL, 999, 0),
(2, 'general physician', 1, '2014-12-12 11:08:21', NULL, 999, 0),
(3, 'ayurveda', 1, '2014-12-12 11:08:28', NULL, 999, 0),
(4, 'oncologist', 1, '2014-12-12 11:08:30', NULL, 999, 0),
(5, 'general surgeon', 1, '2014-12-12 11:08:30', NULL, 999, 0),
(6, 'urologist', 1, '2014-12-12 11:08:31', NULL, 999, 0),
(7, 'gynaecologist & obstetrician', 1, '2014-12-12 11:08:31', NULL, 999, 0),
(8, 'psychologist', 1, '2014-12-12 11:08:31', NULL, 999, 0),
(9, 'sexologist', 1, '2014-12-12 11:08:31', NULL, 999, 0),
(10, 'diabetologist', 1, '2014-12-12 11:08:31', NULL, 999, 0),
(11, 'orthopedician', 1, '2014-12-12 11:08:32', NULL, 999, 0),
(12, 'pediatrician', 1, '2014-12-12 11:08:33', NULL, 999, 0),
(13, 'wellness', 1, '2014-12-12 11:08:33', NULL, 999, 0),
(14, 'obesity specialist', 1, '2014-12-12 11:08:33', NULL, 999, 0),
(15, 'speech therapist', 1, '2014-12-12 11:08:33', NULL, 999, 0),
(16, 'alternative medicine', 1, '2014-12-12 11:08:33', NULL, 999, 0),
(17, 'homeopath', 1, '2014-12-12 11:08:33', NULL, 999, 0),
(18, 'psychiatrist', 1, '2014-12-12 11:08:34', NULL, 999, 0),
(19, 'neurosurgeon', 1, '2014-12-12 11:08:36', NULL, 999, 0),
(20, 'dermatologist', 1, '2014-12-12 11:08:38', NULL, 999, 0),
(21, 'cosmetologist', 1, '2014-12-12 11:08:38', NULL, 999, 0),
(22, 'hair transplant surgeon', 1, '2014-12-12 11:08:38', NULL, 999, 0),
(23, 'neurologist', 1, '2014-12-12 11:08:39', NULL, 999, 0),
(24, 'cardiologist', 1, '2014-12-12 11:08:39', NULL, 999, 0),
(25, 'dietician', 1, '2014-12-12 11:08:39', NULL, 999, 0),
(26, 'nutritionist', 1, '2014-12-12 11:08:39', NULL, 999, 0),
(27, 'physiotherapist', 1, '2014-12-12 11:08:40', NULL, 999, 0),
(28, 'sports medicine specialist', 1, '2014-12-12 11:08:40', NULL, 999, 0),
(29, 'anaesthesiologist', 1, '2014-12-12 11:08:43', NULL, 999, 0),
(30, 'audiologist', 1, '2014-12-12 11:08:44', NULL, 999, 0),
(31, 'acupuncturist', 1, '2014-12-12 11:08:45', NULL, 999, 0),
(32, 'allergist', 1, '2014-12-12 11:08:46', NULL, 999, 0),
(33, 'immunologist', 1, '2014-12-12 11:08:46', NULL, 999, 0),
(34, 'nephrologist', 1, '2014-12-12 11:08:46', NULL, 999, 0),
(35, 'gastroenterologist', 1, '2014-12-12 11:08:51', NULL, 999, 0),
(36, 'bariatric surgeon', 1, '2014-12-12 11:08:53', NULL, 999, 0),
(37, 'endocrinologist', 1, '2014-12-12 11:09:08', NULL, 999, 0),
(38, 'radiologist', 1, '2014-12-12 11:09:13', NULL, 999, 0),
(39, 'saloon', 1, '2014-12-12 11:09:19', NULL, 999, 0),
(40, 'spa', -1, '2014-12-12 11:09:19', NULL, 999, 0),
(41, 'unani', 1, '2014-12-12 11:09:41', NULL, 999, 0),
(42, 'veterinary physician', 1, '2014-12-12 11:09:47', NULL, 999, 0),
(43, 'dentist', 1, '2014-12-12 11:09:48', NULL, 999, 0),
(44, 'oral surgeon', 1, '2014-12-12 11:09:50', NULL, 999, 0),
(45, 'aesthetic medicine', 1, '2014-12-12 11:09:51', NULL, 999, 0),
(46, 'oral and maxillofacial surgeon', 1, '2014-12-12 11:09:51', NULL, 999, 0),
(47, 'oral medicine and radiology', 1, '2014-12-12 11:09:52', NULL, 999, 0),
(48, 'endodontist', 1, '2014-12-12 11:10:31', NULL, 999, 0),
(49, 'implantologist', 1, '2014-12-12 11:10:32', NULL, 999, 0),
(50, 'aesthetic surgeon', 1, '2014-12-12 11:11:32', NULL, 999, 0),
(51, 'pain medicine', 1, '2014-12-12 11:12:14', NULL, 999, 0),
(52, 'somnologist (Sleep Specialist)', 1, '2014-12-12 11:12:15', NULL, 999, 0),
(53, 'occupational therapist', 1, '2014-12-12 11:12:16', NULL, 999, 0),
(54, 'veterinarian', 1, '2014-12-12 11:12:17', NULL, 999, 0),
(55, 'pulmonologist', 1, '2014-12-12 11:12:19', NULL, 999, 0),
(56, 'venereologist', 1, '2014-12-12 11:12:20', NULL, 999, 0),
(57, 'oral pathologist', 1, '2014-12-12 11:12:21', NULL, 999, 0),
(58, 'ophthalmologist', 1, '2014-12-12 11:14:19', NULL, 999, 0),
(59, 'andrologist', 1, '2014-12-12 11:14:20', NULL, 999, 0),
(60, 'anesthesiologist', 1, '2014-12-12 11:14:20', NULL, 999, 0),
(61, 'sonologist', 1, '2014-12-12 11:14:21', NULL, 999, 0),
(62, 'laparoscopic surgeon', 1, '2014-12-12 11:14:28', NULL, 999, 0),
(63, 'endoscopist', 1, '2014-12-12 11:14:29', NULL, 999, 0),
(64, 'geneticist', 1, '2014-12-12 11:14:29', NULL, 999, 0),
(65, 'infertility specialist', 1, '2014-12-12 11:14:29', NULL, 999, 0),
(66, 'surgical oncologist', 1, '2014-12-12 11:14:29', NULL, 999, 0),
(67, 'colorectal surgeon', 1, '2014-12-12 11:14:33', NULL, 999, 0),
(68, 'yoga', 1, '2014-12-12 11:14:36', NULL, 999, 0),
(69, 'naturopathy', 1, '2014-12-12 11:14:36', NULL, 999, 0),
(70, 'sports nutritionist', 1, '2014-12-12 11:14:43', NULL, 999, 0),
(71, 'geriatrician', 1, '2014-12-12 11:14:43', NULL, 999, 0),
(72, 'hematologist', 1, '2014-12-12 11:14:44', NULL, 999, 0),
(73, 'cosmetic & plastic surgeon', 1, '2014-12-12 11:14:44', NULL, 999, 0),
(74, 'pathologist', 1, '2014-12-12 11:14:47', NULL, 999, 0),
(75, 'pediatric psychiatrist', 1, '2014-12-12 11:14:56', NULL, 999, 0),
(76, 'cosmetic', 1, '2014-12-12 11:15:00', NULL, 999, 0),
(77, 'plastic surgeon', 1, '2014-12-12 11:15:00', NULL, 999, 0),
(78, 'trichologist', 1, '2014-12-12 11:15:09', NULL, 999, 0),
(79, 'rheumatologist', 1, '2014-12-12 11:15:09', NULL, 999, 0),
(80, 'laser surgeon', 1, '2014-12-12 11:15:11', NULL, 999, 0),
(81, 'vascular surgeon', 1, '2014-12-12 11:15:15', NULL, 999, 0),
(82, 'cosmetic dentist', 1, '2014-12-12 11:15:20', NULL, 999, 0),
(83, 'pediatric dentist', 1, '2014-12-12 11:15:20', NULL, 999, 0),
(84, 'orthodontist', 1, '2014-12-12 11:15:20', NULL, 999, 0),
(85, 'cosmetic & aesthetic dentist', 1, '2014-12-12 11:15:21', NULL, 999, 0),
(86, 'periodontist', 1, '2014-12-12 11:15:21', NULL, 999, 0),
(87, 'prosthodontist', 1, '2014-12-12 11:15:21', NULL, 999, 0),
(88, 'oral and maxillofacial', 1, '2014-12-12 11:15:50', NULL, 999, 0),
(89, 'IVF specialist', 1, '2014-12-12 11:15:51', NULL, 999, 0),
(90, 'leprologist', 1, '2014-12-12 11:16:40', NULL, 999, 0),
(91, 'eye surgeon', 1, '2014-12-12 11:16:53', NULL, 999, 0),
(92, 'pediatric ophthalmologist', 1, '2014-12-12 11:16:53', NULL, 999, 0),
(93, 'oculoplastist', 1, '2014-12-12 11:16:57', NULL, 999, 0),
(94, 'hepatologist', 1, '2014-12-12 11:17:00', NULL, 999, 0),
(95, 'piles and fissure specialist', 1, '2014-12-12 11:17:01', NULL, 999, 0),
(96, 'bariatrician', 1, '2014-12-12 11:17:03', NULL, 999, 0),
(97, 'family practice', 1, '2014-12-12 11:17:08', NULL, 999, 0),
(98, 'hysteroscopic surgeon', 1, '2014-12-12 11:17:23', NULL, 999, 0),
(99, 'general practitioner', 1, '2014-12-12 11:17:52', NULL, 999, 0),
(100, 'stress management', 1, '2014-12-12 11:18:00', NULL, 999, 0),
(101, 'optometrist', 1, '2014-12-12 11:18:02', NULL, 999, 0),
(102, 'emergency & critical care', 1, '2014-12-12 11:18:03', NULL, 999, 0),
(103, 'sports medicine', 1, '2014-12-12 11:19:13', NULL, 999, 0),
(104, 'neonatologist', 1, '2014-12-12 11:19:30', NULL, 999, 0),
(105, 'cosmetic/plastic surgeon', 1, '2014-12-12 11:20:01', NULL, 999, 0),
(106, 'spine and pain specialist', 1, '2014-12-12 11:20:20', NULL, 999, 0),
(107, 'surgeon', 1, '2014-12-12 11:20:25', NULL, 999, 0),
(108, 'internal medicine', 1, '2014-12-12 11:21:23', NULL, 999, 0),
(109, 'phlebologist', 1, '2014-12-12 11:21:27', NULL, 999, 0),
(110, 'rehab & physical medicine specialist', 1, '2014-12-12 11:22:01', NULL, 999, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `speciality`
--
ALTER TABLE `speciality`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `unique` (`name`), ADD FULLTEXT KEY `full text` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `speciality`
--
ALTER TABLE `speciality`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'all the specialities like dentist etc',AUTO_INCREMENT=111;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
