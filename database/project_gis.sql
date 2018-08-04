-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2018 at 07:56 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

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
  `masjid_id` int(11) NOT NULL DEFAULT '0',
  `family_name` varchar(50) NOT NULL,
  `family_status` int(1) NOT NULL DEFAULT '-1' COMMENT '0=kepala keluarga, 1=istri, 2=anak, 3=pembantu',
  `family_status_number` int(2) NOT NULL DEFAULT '0',
  `family_kawin` int(1) NOT NULL DEFAULT '0',
  `family_religion` int(1) NOT NULL COMMENT '1=islam, 2=kristen, 3=katolik, 4=budha, 5=hindu 6=lainnya',
  `family_age` int(3) NOT NULL COMMENT '1) balita  : 0-5  2) kanak- kanak : 5-11 3) remaja awal : 12-16 4) remaja akhir : 17-25 5) dewasa awal : 26-35 6) dewasa akhur : 36-45 7) Lansia Awal : 46-55 8) lansia akhir : 56-65 9) manula  :  > 65',
  `family_gender` int(1) NOT NULL,
  `family_born_place` varchar(10) NOT NULL,
  `family_born_date` date NOT NULL,
  `family_die_date` date DEFAULT '0000-00-00',
  `family_education` int(1) NOT NULL COMMENT '0= Tidak sekolah 1 = SD/MI 2 = SMP/MTS 3 = SMA/MA 4 = SMK 5 = Diploma(D3) 6 = Sarjana(S1) 7 = Magister (S2) 8 = Doktor (S3)',
  `family_salary` int(10) DEFAULT '0',
  `family_blood` varchar(2) NOT NULL,
  `family_donor` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `family`
--

INSERT INTO `family` (`family_id`, `place_id`, `masjid_id`, `family_name`, `family_status`, `family_status_number`, `family_kawin`, `family_religion`, `family_age`, `family_gender`, `family_born_place`, `family_born_date`, `family_die_date`, `family_education`, `family_salary`, `family_blood`, `family_donor`) VALUES
(1, 2, 1, 'jamaludin 12', 0, -1, 0, 1, 3, 1, 'asdasd', '2002-10-30', '0000-00-00', 4, 123123, '1', 0),
(2, 5, 0, 'rangga satria', 0, 0, 0, 1, 3, 1, '2016-11-30', '2016-11-30', '0000-00-00', 3, 11, '1', 0),
(37, 11, 0, 'asd', 0, 0, 0, 3, 3, 2, 'asd', '2016-10-30', '0000-00-00', 0, 1, '2', 0),
(40, 5, 0, 'satria', 1, 1, 0, 1, 4, 2, '2017-10-30', '2017-10-30', '0000-00-00', 1, 0, '2', 0),
(52, 11, 0, 'asf', 3, 0, 0, 2, 2, 1, 'asd', '2018-02-02', '0000-00-00', 1, 21, '1', 0),
(53, 5, 0, 'asd', 1, 1, 0, 1, 1, 2, '12', '2018-01-01', '0000-00-00', 0, 0, '1', 0),
(54, 5, 3, 'qweqw', 1, 2, 0, 1, 1, 2, 'qwd', '2018-01-01', '0000-00-00', 0, 0, '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `keimanan`
--

CREATE TABLE `keimanan` (
  `keimanan id` int(10) NOT NULL,
  `family_id` int(10) NOT NULL,
  `keimanan_sholat` int(1) NOT NULL DEFAULT '-1' COMMENT '-1=tidak sholat, 1=shalat 5 waktu di masjid, 2=shalat 5 waktu di rumah, 3=sholat kurang dari 5 waktu di masjid, 4=shalat jumat saja,5= shalat hari traya saja',
  `keimanan_mengaji` int(1) NOT NULL DEFAULT '-1' COMMENT '-1= tidak bisa 1=kurang lancar 2=lancar baca 3=hafal quran'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `keimanan`
--

INSERT INTO `keimanan` (`keimanan id`, `family_id`, `keimanan_sholat`, `keimanan_mengaji`) VALUES
(1, 1, 2, 2),
(2, 2, 3, 2),
(3, 3, 2, 2),
(4, 4, 1, 1),
(5, 5, 1, 1),
(6, 6, 1, 1),
(7, 3, 2, 2),
(8, 4, -1, -1),
(9, 5, -1, -1),
(10, 6, -1, -1),
(11, 7, -1, -1),
(12, 8, -1, -1),
(13, 9, -1, -1),
(14, 10, -1, -1),
(15, 11, -1, -1),
(16, 12, -1, -1),
(17, 13, -1, -1),
(18, 14, -1, -1),
(19, 15, -1, -1),
(20, 16, -1, -1),
(21, 17, -1, -1),
(22, 18, -1, -1),
(23, 19, -1, -1),
(24, 20, -1, -1),
(25, 21, -1, -1),
(26, 22, -1, -1),
(27, 23, -1, -1),
(28, 24, -1, -1),
(29, 25, -1, -1),
(30, 26, -1, -1),
(31, 27, -1, -1),
(32, 28, -1, -1),
(33, 29, -1, -1),
(34, 30, -1, 2),
(35, 31, -1, -1),
(36, 32, -1, -1),
(37, 33, -1, -1),
(38, 34, -1, -1),
(39, 35, -1, -1),
(40, 36, 2, 1),
(41, 37, -1, -1),
(42, 38, 2, 2),
(43, 39, -1, -1),
(44, 40, 4, 4),
(45, 41, 1, 1),
(46, 42, -1, -1),
(47, 43, -1, -1),
(48, 44, -1, -1),
(49, 45, -1, -1),
(50, 46, -1, -1),
(51, 47, -1, -1),
(52, 48, -1, -1),
(53, 49, 1, 1),
(54, 50, -1, -1),
(55, 51, -1, -1),
(56, 52, 2, -1),
(57, 52, 0, 0),
(58, 53, -1, -1),
(59, 54, 3, 1),
(60, 55, -1, -1),
(61, 57, -1, -1),
(62, 53, 0, 0),
(63, 54, 3, 1);

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
(3, 12, 'Masjid Baru', 'alsdkja'),
(4, 13, 'Al- ikhlas', 'asdlalaksjd');

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
(1, 1, '2018-04-06', 'Imamin '),
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
-- Table structure for table `masjid_kegiatan`
--

CREATE TABLE `masjid_kegiatan` (
  `kegiatan_id` int(10) NOT NULL,
  `masjid_id` int(10) NOT NULL,
  `kegiatan_date` date NOT NULL,
  `kegiatan_time` time NOT NULL,
  `kegiatan_title` varchar(50) NOT NULL,
  `kegiatan_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `masjid_kegiatan`
--

INSERT INTO `masjid_kegiatan` (`kegiatan_id`, `masjid_id`, `kegiatan_date`, `kegiatan_time`, `kegiatan_title`, `kegiatan_description`) VALUES
(1, 2, '2018-04-27', '15:09:00', 'Kegiatan 1', 'Kegiatannya adalah');

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
(2, 'jamaludin 12', '-7.0578289,110.4262025', 1),
(5, 'rangga', '-7.05642385886491, 110.42509977644352', 1),
(11, 'asd', '-7.0578399837958266, 110.42650525396732', 1),
(12, 'Masjid Baru', '-7.05832977035738, 110.42487447088627', 0),
(13, 'Al- ikhlas', '-7.058084877141398, 110.42651598280338', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(1) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_level` int(1) NOT NULL,
  `masjid_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_username`, `user_password`, `user_level`, `masjid_id`) VALUES
(1, 'Admin', 'admin', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 0, 0),
(2, 'Takmir', 'takmir', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 1, 3),
(4, 'adminqwe', 'qwe', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 1, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `family`
--
ALTER TABLE `family`
  ADD PRIMARY KEY (`family_id`);

--
-- Indexes for table `keimanan`
--
ALTER TABLE `keimanan`
  ADD PRIMARY KEY (`keimanan id`);

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
-- Indexes for table `masjid_kegiatan`
--
ALTER TABLE `masjid_kegiatan`
  ADD PRIMARY KEY (`kegiatan_id`);

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
  MODIFY `family_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `keimanan`
--
ALTER TABLE `keimanan`
  MODIFY `keimanan id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `masjid`
--
ALTER TABLE `masjid`
  MODIFY `masjid_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT for table `masjid_kegiatan`
--
ALTER TABLE `masjid_kegiatan`
  MODIFY `kegiatan_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `place`
--
ALTER TABLE `place`
  MODIFY `place_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
