-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2022 at 01:09 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `bilder`
--

CREATE TABLE `bilder` (
  `id` int(11) NOT NULL,
  `Path` varchar(255) DEFAULT NULL,
  `brukernavn` varchar(255) DEFAULT NULL,
  `dato` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bilder`
--

INSERT INTO `bilder` (`id`, `Path`, `brukernavn`, `dato`) VALUES
(2, '../delteBilder/61a73573a16be2.99931757.png', 'Srimmy', '2021-12-01 08:42:27'),
(3, '../delteBilder/61a748dcde6682.11947237.png', 'Srimmy', '2021-12-01 10:05:16'),
(4, '../delteBilder/61a76418ae5262.67615612.png', 'Srimmy', '2021-12-01 12:01:28'),
(5, '../delteBilder/61a76430252c62.63702257.png', 'Srimmy', '2021-12-01 12:01:52'),
(6, '../delteBilder/61a765506bfad9.21457357.png', 'Srimmy', '2021-12-01 12:06:40'),
(7, '../delteBilder/61a765e8502ce4.42870200.png', 'Srimmy', '2021-12-01 12:09:12'),
(8, '../delteBilder/61a76623716d00.35186579.png', 'Srimmy', '2021-12-01 12:10:11'),
(9, '../delteBilder/61a77013f38d12.51685797.png', 'manum01', '2021-12-01 12:52:35'),
(10, '../delteBilder/61a771d59d8141.33324905.png', 'manum01', '2021-12-01 13:00:05'),
(11, '../delteBilder/61adc7c540a706.79816951.png', 'Srimmy', '2021-12-06 08:20:21'),
(12, '../delteBilder/61adc8e5949493.02501406.png', 'Srimmy', '2021-12-06 08:25:09'),
(13, '../delteBilder/61adc909960f35.58562584.png', 'Srimmy', '2021-12-06 08:25:45'),
(15, '../delteBilder/61b282c6da2645.80950983.png', 'asd', '2021-12-09 22:27:18'),
(16, '../delteBilder/61b28750397cc3.78660165.png', 'asdf', '2021-12-09 22:46:40'),
(17, '../delteBilder/61b399dd00cf74.42361006.png', 'asd', '2021-12-10 18:18:05'),
(18, '../delteBilder/61b39a6069d0a0.93451213.png', 'asd', '2021-12-10 18:20:16'),
(19, '../delteBilder/61bbb5ea453928.97468745.svg', 'asd', '2021-12-16 21:55:54'),
(20, '../delteBilder/61bc42989ff3f5.10098813.png', 'marie223', '2021-12-17 07:56:08');

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE `following` (
  `id` int(11) NOT NULL,
  `following` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `following`
--

INSERT INTO `following` (`id`, `following`, `username`) VALUES
(22, 'asd', 'titas'),
(23, 'asd', 'titas'),
(24, 'asd', 'titas'),
(25, 'asd', 'titas'),
(26, 'asd', 'titas'),
(27, 'asd', 'asdf'),
(28, 'asd', 'Srimmy'),
(30, 'marie', 'Srimmy'),
(31, 'marie', 'asdf');

-- --------------------------------------------------------

--
-- Stand-in structure for view `followingbilder`
-- (See below for the actual view)
--
CREATE TABLE `followingbilder` (
`following` varchar(255)
,`username` varchar(255)
,`Path` varchar(255)
,`brukernavn` varchar(255)
,`dato` timestamp
,`id` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `highscore`
--

CREATE TABLE `highscore` (
  `id` int(11) NOT NULL,
  `usersID` int(11) DEFAULT NULL,
  `Score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kommentar`
--

CREATE TABLE `kommentar` (
  `id` int(11) NOT NULL,
  `kommentar` varchar(255) DEFAULT NULL,
  `bildeId` int(11) DEFAULT NULL,
  `brukernavn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kommentar`
--

INSERT INTO `kommentar` (`id`, `kommentar`, `bildeId`, `brukernavn`) VALUES
(72, 'hei du er kul', 16, 'asd'),
(73, 'asdasd', 16, 'asd'),
(74, 'asdsad', 16, 'asd'),
(75, 'fyf du er clena', 12, 'asd');

-- --------------------------------------------------------

--
-- Stand-in structure for view `kommentarpåbildet`
-- (See below for the actual view)
--
CREATE TABLE `kommentarpåbildet` (
`kommentar` varchar(255)
,`bildeId` int(11)
,`brukernavn` varchar(255)
,`id` int(11)
,`username` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `liktebilder`
--

CREATE TABLE `liktebilder` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `likedPicId` int(11) DEFAULT NULL,
  `dato` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `liktebilder`
--

INSERT INTO `liktebilder` (`id`, `username`, `likedPicId`, `dato`) VALUES
(1, 'asd', 2, '2021-12-15 15:45:22'),
(2, 'srimmy', 18, '2021-12-15 15:45:22'),
(10, 'asd', 8, '2021-12-16 23:16:10'),
(12, 'asd', 16, '2021-12-16 23:17:11'),
(13, 'asd', 13, '2021-12-16 23:17:14'),
(14, 'marie', 16, '2021-12-17 08:57:06'),
(15, 'asd', 5, '2021-12-17 09:08:42'),
(16, 'asd', 12, '2021-12-17 09:08:45');

-- --------------------------------------------------------

--
-- Stand-in structure for view `liktebilderview`
-- (See below for the actual view)
--
CREATE TABLE `liktebilderview` (
`id` int(11)
,`liker` varchar(255)
,`brukernavn` varchar(255)
,`Path` varchar(255)
,`date` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `highscore` int(11) DEFAULT NULL,
  `profilePicPath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `highscore`, `profilePicPath`) VALUES
(1, 'Srimmy', '$2y$10$AjBHdLonl5OggvVKIbTdAebrcdOHvbXZMoCs4xBC5FFHsAhCan9.i', '2021-11-03 09:20:02', 39750, '../profilbilder/61b1bc3f85ad38.36016963.png'),
(2, 'manum01', '$2y$10$B/849KoUmeoALkIK4rkCfONpSVgNJZJ7JKpaSA5hgste1uUzrlb8O', '2021-11-05 09:39:16', 78950, '../profilbilder/61a5faa15d7c15.30102361.png'),
(3, 'tias', '$2y$10$D9ZC955qXQg0tHr6K8l2AuO5h3Ux4YmTRBki.vwY5XnmfieNfvumC', '2021-12-07 13:21:04', 1, '../profilbilder/standard.svg'),
(5, 'titas2', 'test', '2021-12-08 09:54:14', 84350, '../profilbilder/61b08e396ddad0.00592595.jpg'),
(6, 'capper', '$2y$10$7RThBSZyHUCekUdgKyMH3.EoccMztlnV0VcLSaPJsRjAH9j5wkXEK', '2021-12-08 13:33:24', 3100, '../profilbilder/61b23ecc348098.67711806.png'),
(7, 'baddy', '$2y$10$.0x3ql1o8D17A3OAZ9qw0u.jnG4WQE6M5sOFweImNLe45selXIGoy', '2021-12-09 19:02:34', NULL, '../profilbilder/standard.svg'),
(8, 'baldy123', '$2y$10$uTE.H3J7HwZnbvLvlaLloOnw5TmCDD0yoE4a0zylQDZxTSaUu6.O6', '2021-12-09 19:44:23', NULL, '../profilbilder/61b251f631a8d8.20045275.png'),
(9, 'srimmy6', '$2y$10$oz93g1j2x/V7R4s1T92wj.yq2sCb0D7EfqlehLV7Ysn.XttX/aqGa', '2021-12-09 21:51:46', NULL, '../profilbilder/61b278771e9eb5.85788051.png'),
(10, 'asd', '$2y$10$3gOA/kb4TRL9oz5kOharhua5HT5ro/EczgOjzHNl78R4tRVpG.MUm', '2021-12-09 23:19:28', NULL, '../profilbilder/61bb8cc86e54f8.00728056.svg'),
(11, 'asdf', '$2y$10$veuWkewOMM4K371qSGQfWuyRndFXfatWoha5TX45r6LuFzSWJPhrW', '2021-12-09 23:37:42', NULL, '../profilbilder/standard.svg'),
(12, 'marie', '$2y$10$LYcD4f79e77gK.DspLpBlOljwFMOLIkO2Lg7.ZRe4ziWWX9o3HMfe', '2021-12-17 08:52:26', 12600, '../profilbilder/61bc425f841e15.57863148.png');

-- --------------------------------------------------------

--
-- Structure for view `followingbilder`
--
DROP TABLE IF EXISTS `followingbilder`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `followingbilder`  AS SELECT `following`.`following` AS `following`, `following`.`username` AS `username`, `bilder`.`Path` AS `Path`, `bilder`.`brukernavn` AS `brukernavn`, `bilder`.`dato` AS `dato`, `bilder`.`id` AS `id` FROM (`following` join `bilder` on(`following`.`username` = `bilder`.`brukernavn`)) ORDER BY `bilder`.`dato` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `kommentarpåbildet`
--
DROP TABLE IF EXISTS `kommentarpåbildet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `kommentarpåbildet`  AS SELECT `kommentar`.`kommentar` AS `kommentar`, `kommentar`.`bildeId` AS `bildeId`, `kommentar`.`brukernavn` AS `brukernavn`, `bilder`.`id` AS `id`, `bilder`.`brukernavn` AS `username` FROM (`kommentar` join `bilder` on(`kommentar`.`bildeId` = `bilder`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `liktebilderview`
--
DROP TABLE IF EXISTS `liktebilderview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `liktebilderview`  AS SELECT `bilder`.`id` AS `id`, `liktebilder`.`username` AS `liker`, `bilder`.`brukernavn` AS `brukernavn`, `bilder`.`Path` AS `Path`, `liktebilder`.`dato` AS `date` FROM (`liktebilder` join `bilder` on(`liktebilder`.`likedPicId` = `bilder`.`id`)) WHERE `liktebilder`.`likedPicId` = `bilder`.`id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bilder`
--
ALTER TABLE `bilder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brukernavn` (`brukernavn`);

--
-- Indexes for table `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `highscore`
--
ALTER TABLE `highscore`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersID` (`usersID`);

--
-- Indexes for table `kommentar`
--
ALTER TABLE `kommentar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `liktebilder`
--
ALTER TABLE `liktebilder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bilder`
--
ALTER TABLE `bilder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `following`
--
ALTER TABLE `following`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `highscore`
--
ALTER TABLE `highscore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kommentar`
--
ALTER TABLE `kommentar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `liktebilder`
--
ALTER TABLE `liktebilder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `highscore`
--
ALTER TABLE `highscore`
  ADD CONSTRAINT `highscore_ibfk_1` FOREIGN KEY (`usersID`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
