-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 25, 2018 at 06:04 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `daily_report`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_case`
--

CREATE TABLE `t_case` (
  `id_case` varchar(10) NOT NULL,
  `id_report_case` varchar(10) NOT NULL,
  `kronologis` text NOT NULL,
  `status_case` enum('Proses','Acc','','') NOT NULL,
  `tanggal_case` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_validasi` datetime NOT NULL,
  `acc_by` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_case`
--

INSERT INTO `t_case` (`id_case`, `id_report_case`, `kronologis`, `status_case`, `tanggal_case`, `tanggal_validasi`, `acc_by`) VALUES
('C000000001', 'R000000004', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nTest', 'Acc', '2018-07-25 13:57:14', '0000-00-00 00:00:00', 'Asisten Manajer');

-- --------------------------------------------------------

--
-- Table structure for table `t_pesan`
--

CREATE TABLE `t_pesan` (
  `id_pesan` int(11) NOT NULL,
  `tanggal_pesan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pesan` text NOT NULL,
  `user_from` varchar(10) NOT NULL,
  `user_to` varchar(10) NOT NULL,
  `status_pesan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_pesan`
--

INSERT INTO `t_pesan` (`id_pesan`, `tanggal_pesan`, `pesan`, `user_from`, `user_to`, `status_pesan`) VALUES
(1, '2018-07-25 13:51:39', 'Va, tolong cek kode booking ADNGID soalnya ga sama kaya di Queque', 'admin', '131478', 'read'),
(2, '2018-07-25 13:52:25', 'okeeee', '131478', 'admin', 'read'),
(3, '2018-07-25 13:53:48', 'sudah ya bang', '131478', 'admin', 'read'),
(4, '2018-07-25 13:55:32', 'Tq', 'admin', '131478', 'read'),
(5, '2018-07-25 13:55:32', 'Va ini ko rebook kok biayanya ga seusia ya dengan queque', 'admin', '131478', 'read'),
(6, '2018-07-25 13:55:32', 'saya sudah cek', 'admin', '131478', 'read'),
(7, '2018-07-25 13:55:32', 'coba tolong confirm ke customernya', 'admin', '131478', 'read'),
(8, '2018-07-25 13:56:16', 'bentar ya', '131478', 'admin', 'read'),
(9, '2018-07-25 13:56:16', 'customernya ga mau bayar bang', '131478', 'admin', 'read'),
(10, '2018-07-25 13:56:16', 'gimana dong? ', '131478', 'admin', 'read'),
(11, '2018-07-25 13:56:17', 'ywd gua jadiin case aja ya', 'admin', '131478', 'read'),
(12, '2018-07-25 14:00:18', 'okeeee', '131478', 'admin', 'read');

-- --------------------------------------------------------

--
-- Table structure for table `t_report`
--

CREATE TABLE `t_report` (
  `id_report` varchar(10) NOT NULL,
  `kd_booking` varchar(6) NOT NULL,
  `tanggal_report` date NOT NULL,
  `datetime_report` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `klasifikasi` enum('Booking','Rebook','Refund','Other') NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `nip` varchar(10) NOT NULL,
  `status` enum('Proses','Valid','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_report`
--

INSERT INTO `t_report` (`id_report`, `kd_booking`, `tanggal_report`, `datetime_report`, `klasifikasi`, `keterangan`, `nip`, `status`) VALUES
('R000000001', 'SNGIAN', '2018-07-25', '2018-07-25 10:23:16', 'Other', 'Input Email Pessenger', '153150', 'Valid'),
('R000000002', 'ABSGKB', '2018-07-25', '2018-07-25 13:44:46', 'Rebook', '500.000', '153150', 'Valid'),
('R000000003', 'AGBHDA', '2018-07-25', '2018-07-25 13:45:18', 'Booking', '', '153150', 'Valid'),
('R000000004', 'ADBNAI', '2018-07-25', '2018-07-25 13:49:17', 'Booking', '', '131478', 'Valid'),
('R000000005', 'ADNGID', '2018-07-25', '2018-07-25 13:49:21', 'Other', 'Test', '131478', 'Valid'),
('R000000006', 'BAIGBI', '2018-07-25', '2018-07-25 13:49:23', 'Booking', '', '131478', 'Valid');

-- --------------------------------------------------------

--
-- Table structure for table `t_sanksi`
--

CREATE TABLE `t_sanksi` (
  `id_sanksi` varchar(20) NOT NULL,
  `nip` varchar(10) NOT NULL,
  `jenis_sanksi` enum('SP1','SP2','SP3','') NOT NULL,
  `tanggal_sanksi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan_sanksi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_sanksi`
--

INSERT INTO `t_sanksi` (`id_sanksi`, `nip`, `jenis_sanksi`, `tanggal_sanksi`, `keterangan_sanksi`) VALUES
('S000000001', '131478', 'SP1', '2018-07-25 14:05:04', 'Tidak melakukan konfirmasi kembali kepada customer setelah melakukan Rebook'),
('S000000002', '131929', 'SP3', '2018-07-25 14:06:45', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `nip` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `hak_akses` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` text NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_user` enum('offline','online','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`nip`, `nama`, `jabatan`, `hak_akses`, `password`, `foto`, `register_date`, `status_user`) VALUES
('06142', 'Haviz Indra Maulana', 'Asisten Manajer', 'Asisten Manajer', '8ed1d86e541cf5b1c7adb80e5ee2af87', 'foto_06142.jpg', '2018-07-20 19:04:22', 'offline'),
('123456', 'Tezar Tri Handika', 'Koordinator', 'Koordinator', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 19:04:43', 'offline'),
('131478', 'Eva Tesalonika BR Tarigan', 'Call Center BFF', 'Call Center', 'e2b5c934cf1efb6e6446b95000321f08', '', '2018-07-20 18:55:06', 'offline'),
('131929', 'Siti Koriatun', 'Customer Care', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:57:07', 'offline'),
('135824', 'Ariani Puspasari', 'Call Center', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:51:11', 'offline'),
('142691', 'Herna Indriani Siregar', 'Call Center BFF', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:55:25', 'offline'),
('152227', 'Novi Lestari', 'Customer Care', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:56:30', 'offline'),
('152250', 'Mutiarani', 'Call Center Parcel', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 19:04:04', 'offline'),
('153129', 'Ayu Triwijayanti', 'Special Case', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:52:37', 'offline'),
('153148', 'Maudina', 'Call Center English', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:55:53', 'offline'),
('153150', 'Dewi Dwi Lestari', 'Special Case', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', 'foto_153150.jpeg', '2018-07-20 19:05:32', 'offline'),
('153557', 'Dwi Ariska', 'Call Center Parcel', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:54:00', 'offline'),
('153562', 'Adelia Setia Naibaho', 'Call Center', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:50:11', 'offline'),
('154378', 'Nurul Ki R', 'Call Center English', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:56:14', 'offline'),
('154421', 'Ajeng Putri W', 'Call Center English', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:50:32', 'offline'),
('160101', 'Ariestya Pratiwi', 'Call Center', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:51:34', 'offline'),
('84102871', 'Astri Lesna', 'Special Case', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:52:15', 'offline'),
('84123985', 'Enni Masnerita Hutasoit', 'Call Center Parcel', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:54:33', 'offline'),
('84130008', 'Hesti Kurniawati', 'Customer Care', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-25 13:59:41', 'offline'),
('84130011', 'Reni Widiastuti', 'Customer Care', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:56:51', 'offline'),
('84131175', 'Ade Supriatin Pratiwi', 'Call Center BFF', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:49:51', 'offline'),
('84131178', 'Anita Puspa Dewi', 'Special Case', 'Call Center', '8ed1d86e541cf5b1c7adb80e5ee2af87', '', '2018-07-20 18:50:50', 'offline'),
('admin', 'Administrator', 'Admin', 'Admin', '704b037a97fa9b25522b7c014c300f8a', 'user.jpg', '2018-07-18 04:40:23', 'offline');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_case`
--
ALTER TABLE `t_case`
  ADD PRIMARY KEY (`id_case`),
  ADD KEY `id_report` (`id_report_case`);

--
-- Indexes for table `t_pesan`
--
ALTER TABLE `t_pesan`
  ADD PRIMARY KEY (`id_pesan`),
  ADD KEY `user_from` (`user_from`),
  ADD KEY `user_to` (`user_to`);

--
-- Indexes for table `t_report`
--
ALTER TABLE `t_report`
  ADD PRIMARY KEY (`id_report`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `t_sanksi`
--
ALTER TABLE `t_sanksi`
  ADD PRIMARY KEY (`id_sanksi`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`nip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_pesan`
--
ALTER TABLE `t_pesan`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_case`
--
ALTER TABLE `t_case`
  ADD CONSTRAINT `t_case_ibfk_1` FOREIGN KEY (`id_report_case`) REFERENCES `t_report` (`id_report`) ON UPDATE CASCADE;

--
-- Constraints for table `t_pesan`
--
ALTER TABLE `t_pesan`
  ADD CONSTRAINT `t_pesan_ibfk_1` FOREIGN KEY (`user_from`) REFERENCES `t_user` (`nip`),
  ADD CONSTRAINT `t_pesan_ibfk_2` FOREIGN KEY (`user_to`) REFERENCES `t_user` (`nip`);

--
-- Constraints for table `t_report`
--
ALTER TABLE `t_report`
  ADD CONSTRAINT `t_report_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `t_user` (`nip`);

--
-- Constraints for table `t_sanksi`
--
ALTER TABLE `t_sanksi`
  ADD CONSTRAINT `t_sanksi_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `t_user` (`nip`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
