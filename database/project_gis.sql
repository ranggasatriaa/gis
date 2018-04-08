-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2018 at 03:05 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_gis`
--

-- --------------------------------------------------------

--
-- Table structure for table `family`
--

CREATE TABLE `family` (
  `family_id` int(10) NOT NULL,
  `place_id` int(10) NOT NULL,
  `family_name` varchar(50) NOT NULL,
  `family_status` int(1) NOT NULL COMMENT '0=kepala keluarga, 1=anak pertama, 2=anggota keluarga, 3=pembantu',
  `family_age` int(3) NOT NULL,
  `family_gender` int(1) NOT NULL,
  `family_born_place` varchar(10) NOT NULL,
  `family_born_date` date NOT NULL,
  `family_education` varchar(20) NOT NULL,
  `family_salary` int(10) DEFAULT '0',
  `family_blood` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `family`
--

INSERT INTO `family` (`family_id`, `place_id`, `family_name`, `family_status`, `family_age`, `family_gender`, `family_born_place`, `family_born_date`, `family_education`, `family_salary`, `family_blood`) VALUES
(1, 2, 'jamaludin 12', 0, 2, 1, 'qwd ', '2015-10-30', 'asd', 123123, 'A'),
(2, 3, 'sigit', 0, 20, 1, 'tegal', '1998-04-01', 's2', 1567687, 'O'),
(3, 2, 'asd', 1, 0, 2, 'adws', '2017-10-30', 'asds', 1232, 'B'),
(4, 2, 'asad', 2, 9, 2, 'asdasd', '2009-03-02', 'asd', 123, 'A'),
(5, 2, 'asdlkj', 2, 0, 1, 'asd', '2017-12-31', 'asd', 6, 'A'),
(6, 2, 'asd', 2, 2, 1, 'sdasd', '2015-11-30', 'asd', 1231, 'B'),
(7, 2, 'asdsd', 2, 1, 2, 'asda', '2016-11-30', '12', 123, 'B'),
(8, 2, 'asd', 2, 0, 2, 'asd', '2017-11-30', '123', 3, 'B'),
(9, 3, 'asd', 2, 1, 2, 'asdasd', '2016-10-29', 'asdasd', 3, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `masjid`
--

CREATE TABLE `masjid` (
  `masjid_id` int(10) NOT NULL,
  `place_id` int(10) NOT NULL,
  `masjid_name` varchar(100) NOT NULL,
  `masjid_history` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `masjid`
--

INSERT INTO `masjid` (`masjid_id`, `place_id`, `masjid_name`, `masjid_history`) VALUES
(1, 1, 'al azar', 'history al azar history al azar history al azar history al azar history al azar history al azar history al azar history al azar history al azar history al azar history al azar history al azar history al azar history al azar history al azar history al azar'),
(2, 4, 'masjid Hidayah', 'sejarah ');

-- --------------------------------------------------------

--
-- Table structure for table `masjid_jumat`
--

CREATE TABLE `masjid_jumat` (
  `jumat_id` int(10) NOT NULL,
  `masjid_id` int(10) NOT NULL,
  `jumat_date` date NOT NULL,
  `jumat_imam` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `masjid_jumat`
--

INSERT INTO `masjid_jumat` (`jumat_id`, `masjid_id`, `jumat_date`, `jumat_imam`) VALUES
(1, 1, '2018-04-06', 'Imamin Saya doqw'),
(2, 1, '2018-04-27', 'asdsa');

-- --------------------------------------------------------

--
-- Table structure for table `masjid_kajian`
--

CREATE TABLE `masjid_kajian` (
  `kajian_id` int(10) NOT NULL,
  `masjid_id` int(10) NOT NULL,
  `kajian_date` date NOT NULL,
  `kajian_time` time NOT NULL,
  `kajian_title` varchar(50) NOT NULL,
  `kajian_description` varchar(255) NOT NULL,
  `kajian_speaker` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `masjid_kajian`
--

INSERT INTO `masjid_kajian` (`kajian_id`, `masjid_id`, `kajian_date`, `kajian_time`, `kajian_title`, `kajian_description`, `kajian_speaker`) VALUES
(1, 1, '2018-04-16', '12:30:00', 'pengalaman22', 'pengalaman anda dengan dunia pengalaman anda dengan dunia pengalaman anda dengan dunia pengalaman anda dengan dunia ', 'Ustad saya sendiri'),
(2, 1, '2018-04-19', '08:06:00', 'pengalaman kedua saya semua', 'kedua untuk semua kedua untuk semua kedua untuk semua kedua untuk semua kedua untuk semua kedua untuk semua ', 'saya saja');

-- --------------------------------------------------------

--
-- Table structure for table `place`
--

CREATE TABLE `place` (
  `place_id` int(10) NOT NULL,
  `place_name` varchar(100) NOT NULL,
  `place_location` varchar(100) NOT NULL,
  `place_category` int(1) NOT NULL COMMENT '0=masjid, 1=rumah'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `place`
--

INSERT INTO `place` (`place_id`, `place_name`, `place_location`, `place_category`) VALUES
(1, 'masjid al azar', '-7.058198, 110.426586', 0),
(2, 'rumah 1', '-7.0578289,110.4262025', 1),
(3, 'rumah 2', '-7.058371, 110.426796', 1),
(4, 'masjid Hidayah', '-7.058137, 110.424741', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(1) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_username`, `user_password`) VALUES
(1, 'admin gis', 'admin', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `family`
--
ALTER TABLE `family`
  ADD PRIMARY KEY (`family_id`);

--
-- Indexes for table `masjid`
--
ALTER TABLE `masjid`
  ADD PRIMARY KEY (`masjid_id`);

--
-- Indexes for table `masjid_jumat`
--
ALTER TABLE `masjid_jumat`
  ADD PRIMARY KEY (`jumat_id`);

--
-- Indexes for table `masjid_kajian`
--
ALTER TABLE `masjid_kajian`
  ADD PRIMARY KEY (`kajian_id`);

--
-- Indexes for table `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`place_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `family`
--
ALTER TABLE `family`
  MODIFY `family_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `masjid`
--
ALTER TABLE `masjid`
  MODIFY `masjid_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `masjid_jumat`
--
ALTER TABLE `masjid_jumat`
  MODIFY `jumat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `masjid_kajian`
--
ALTER TABLE `masjid_kajian`
  MODIFY `kajian_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `place`
--
ALTER TABLE `place`
  MODIFY `place_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
