# Terminoppgave Vg2 //  Utvikles helt til sommer // DB er nederst

**OPPDATERING ETTER 29.05.22**
Jeg hadde slettet databasen min ved et uhell når jeg skulle oppdatere den og merket det ikke før nå, ingen php eller noe annet er endret.


**Prosjektet:** Lage en web applikasjon der man kan dele bilder og spille spill. Nettstedet skal kunne åpnes ved å skrive inn en ip addresse på Kuben.It nettet. På nettleseren skal du kunne logge på en bruker der passordet blir kryptert i databasen. På nettsiden skal du kunne sende melinger til de du vil og se på de nyeste bildene som blir lagt ut.

**Må ha for å sette opp:**
* Mysql
* Php 
* phpmyadmin
* apache2

**Anbefaler å laste ned xampp fordi da lastes alt ned på likt: https://www.apachefriends.org/download.html**

**Sette opp på xampp:**
* Extract alle filene i zip mappen i 'C:\xampp\htdocs\dashboard'
* Åpne opp xampp og kjør apache2 og mysql
* Trykk 'admin' inni action kolonnen i mysql raden
* Dette burde ta deg til en nettside, her trykker du 'sql' i navigasjonsmenyen.
* Skriv inn 'CREATE DATABASE users;' og trykk 'go' nede høyre hjørne.
* Klipp all infirmasjonen i 'users.sql' filen og lim det inn det i den samme 'sql' tabben som i stad og trykk go.
**I noen versioner av mysql må man skrive inn "use users;" før du kopierer og limer inn.**
* For å åpne prosjektet kan du nå skrive 'localhost/2.terminoppgave-main' i skrivefeltet på nettleseren din, merk deg at dette må være URL skrive feltet.


**DB**
-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2022 at 08:28 PM
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
(9, '61a77013f38d12.51685797.png', 'manum01', '2021-12-01 12:52:35'),
(10, '61a771d59d8141.33324905.png', 'manum01', '2021-12-01 13:00:05'),
(22, '622727c4b0ff80.75911104.png', 'dsa', '2022-03-08 09:54:12'),
(23, '62287eb9c6f3d3.12149633.jpg', 'dsa', '2022-03-09 10:17:29'),
(24, '62287f91adb3a1.31668248.jpg', 'dsa', '2022-03-09 10:21:05'),
(25, '62287feb0c5a33.47745858.svg', 'dsa', '2022-03-09 10:22:35'),
(26, '6228a1bea259c2.17001783.jpg', 'dsa', '2022-03-09 12:46:54'),
(27, '6228a1ff42e965.52675174.jpg', 'dsa', '2022-03-09 12:47:59'),
(28, '6228a7f4a4c205.44612288.jpg', 'dsa', '2022-03-09 13:13:24'),
(29, '626258367aee97.05174289.jpg', 'sluttbruker', '2022-04-22 07:24:38'),
(35, '6293dfdb2b9262.71726523.jpg', 'dsa', '2022-05-29 21:04:27');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `contents` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `title`, `contents`) VALUES
(25, 'How Do I Edit My Profile?', 'Click on your the furthest right icon in the navbar and press \"Edit Profile\" *\nTo change your profile picture click on \"choose file\". After choosing your profile picture, click on \"Change\" *\nTo change your username, write your desired username in the field shown on the picture below then press \"Change username\" *\nTo change your password, write your current password on the top input field then repeat your new password twice in the input fields below. '),
(31, 'How Do I Create A Ticket?', 'Click on your profile picture -> Tickets * Click on \"Create a ticket\" * After writing the ticket title and description, click \"Send ticket\" * Your ticket should now show up in your \"Tickets\" feed'),
(32, 'How Do I Upload A Picture?', 'Click on the plus sign inside a square on the top right of your screen * Click \"Select from computer\" * Choose the file you want to upload. Note that only png, jpg and svg files can be uploaded * Click upload on the top right of the modal * The picture is now uploaded and should appear on your profile');

-- --------------------------------------------------------

--
-- Table structure for table `faqpic`
--

CREATE TABLE `faqpic` (
  `id` int(11) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `lineNum` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faqpic`
--

INSERT INTO `faqpic` (`id`, `path`, `lineNum`, `title`) VALUES
(21, '624aa5e6ecc822.08198180.png', 0, 'How Do I Edit My Profile?'),
(22, '624aa5e6eda033.29915336.png', 1, 'How Do I Edit My Profile?'),
(23, '624aa5e6ee98f9.75317273.png', 2, 'How Do I Edit My Profile?'),
(24, '624aa5e6f00c37.92998720.png', 3, 'How Do I Edit My Profile?'),
(27, '6262561de7fe49.39783917.png', 0, 'How Do I Create A Ticket?'),
(28, '6262561dea2454.70726412.png', 1, 'How Do I Create A Ticket?'),
(29, '6262561dea9c24.18789462.png', 2, 'How Do I Create A Ticket?'),
(30, '6262561deb0d73.91564934.png', 3, 'How Do I Create A Ticket?'),
(31, '62625a7eb95080.07360423.png', 0, 'How Do I Upload A Picture?'),
(32, '62625a7eba7821.31226065.png', 1, 'How Do I Upload A Picture?'),
(33, '62625a7ebc2633.60734375.png', 2, 'How Do I Upload A Picture?'),
(34, '62625a7ebcaf91.68791898.png', 3, 'How Do I Upload A Picture?'),
(35, '62625a7ebd3fa8.20636509.png', 4, 'How Do I Upload A Picture?');

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
(22, 'veryverycap', 'titas'),
(23, 'veryverycap', 'titas'),
(24, 'veryverycap', 'titas'),
(25, 'veryverycap', 'titas'),
(26, 'veryverycap', 'titas'),
(27, 'veryverycap', 'asdf'),
(28, 'veryverycap', 'Srimmy'),
(30, 'marie', 'Srimmy'),
(31, 'marie', 'asdf'),
(32, 'tigger', 'srimmy1337'),
(45, 'dsa', 'manum01'),
(50, 'dsa', 'asdf'),
(51, 'sluttbruker', 'manum01'),
(52, 'kg', 'manum01'),
(53, 'kg', 'dsa');

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
(75, 'fyf du er clena', 12, 'asd'),
(76, 'deez', 16, 'asd'),
(77, 'asd', 16, 'asd'),
(78, 'haha clean bro', 16, 'dsa'),
(79, 'asd', 16, 'dsa'),
(80, 'haha xDDDDdd', 10, 'sluttbruker'),
(81, 'asd', 10, 'sluttbruker'),
(82, 'fire bildet bro', 28, 'kg'),
(83, 'sdf', 28, 'kg'),
(84, 'sdf', 28, 'kg'),
(85, 'sdf', 28, 'kg'),
(86, 'sdf', 28, 'kg'),
(87, 'du er kul', 24, 'kg'),
(88, 'asd', 10, 'dsa'),
(89, 'asd', 16, 'dsa'),
(90, 'hahah denne komentaren er ny', 10, 'dsa'),
(91, 'haha så kult bror', 28, 'dsa'),
(92, 'haha så kult bror', 28, 'dsa'),
(96, 'asd', 23, 'dsa'),
(97, 'asdasdsadasdsadasdsa', 23, 'dsa');

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
(2, 'srimmy', 18, '2021-12-15 15:45:22'),
(14, 'marie', 16, '2021-12-17 08:57:06'),
(15, 'asd', 5, '2021-12-17 09:08:42'),
(27, 'asd', 6, '2022-02-09 11:19:26'),
(46, 'trigger', 13, '2022-03-04 11:45:06'),
(47, 'trigger', 12, '2022-03-04 11:45:09'),
(56, 'dsa', 16, '2022-04-20 11:58:19'),
(57, 'sluttbruker', 10, '2022-04-25 10:05:07'),
(58, 'sluttbruker', 9, '2022-04-25 10:05:10'),
(59, 'kg', 28, '2022-05-18 13:50:29'),
(63, 'dsa', 10, '2022-05-29 23:04:34'),
(64, 'dsa', 9, '2022-05-29 23:04:36');

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
-- Table structure for table `meldinger`
--

CREATE TABLE `meldinger` (
  `ID` int(11) NOT NULL,
  `fra` varchar(255) DEFAULT NULL,
  `til` varchar(255) DEFAULT NULL,
  `melding` varchar(255) NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roleprivileges`
--

CREATE TABLE `roleprivileges` (
  `id` int(11) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `privileges` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roleprivileges`
--

INSERT INTO `roleprivileges` (`id`, `role`, `privileges`) VALUES
(1, 'admin', 'answerTicket'),
(2, 'support', 'answerTicket');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'support');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `answerer` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `keyword`, `description`, `user`, `answerer`, `status`, `priority`, `created_at`) VALUES
(25, 'passord change', 'me wanted to change mitt passord but me cannot do, how', 'sluttbruker', NULL, 'solved', NULL, '2022-05-20 11:07:22'),
(26, 'finnes ingen saker', 'trenger en sak, takk\r\n', 'dsa', NULL, 'open', NULL, '2022-05-23 22:46:11');

-- --------------------------------------------------------

--
-- Table structure for table `ticketreply`
--

CREATE TABLE `ticketreply` (
  `id` int(11) NOT NULL,
  `ticketid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `reply` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticketreply`
--

INSERT INTO `ticketreply` (`id`, `ticketid`, `username`, `created_at`, `reply`) VALUES
(35, 20, 'dsa', '2022-03-31 09:21:40', 'dsjfsadjølg'),
(36, 25, 'dsa', '2022-05-20 11:12:01', 'Hey sluttbruker,\r\nThanks for contacting us today!\r\nTo change your password please read http://localhost/dashboard/terminoppgave/root/php/costumerSupport/faqArticle.php?title=How-Do-I-Edit-My-Profile?\r\nHope this helps!\r\nKindest regards.\r\ndsa'),
(37, 25, 'sluttbruker', '2022-05-20 11:12:59', 'thanks\r\n'),
(38, 25, 'sluttbruker', '2022-05-20 11:13:20', 'jaljkdsaf');

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
  `profilePicPath` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `highscore`, `profilePicPath`, `role`) VALUES
(1, 'srmmy1337', '$2y$10$AjBHdLonl5OggvVKIbTdAebrcdOHvbXZMoCs4xBC5FFHsAhCan9.i', '2021-11-03 09:20:02', 39750, '61b1bc3f85ad38.36016963.png', NULL),
(2, 'manum01', '$2y$10$B/849KoUmeoALkIK4rkCfONpSVgNJZJ7JKpaSA5hgste1uUzrlb8O', '2021-11-05 09:39:16', 78950, '61a5faa15d7c15.30102361.png', NULL),
(3, 'tias', '$2y$10$D9ZC955qXQg0tHr6K8l2AuO5h3Ux4YmTRBki.vwY5XnmfieNfvumC', '2021-12-07 13:21:04', 1, 'standard.svg', NULL),
(5, 'titas2', 'test', '2021-12-08 09:54:14', 84350, '61b08e396ddad0.00592595.jpg', NULL),
(6, 'capper', '$2y$10$7RThBSZyHUCekUdgKyMH3.EoccMztlnV0VcLSaPJsRjAH9j5wkXEK', '2021-12-08 13:33:24', 3100, '61b23ecc348098.67711806.png', NULL),
(7, 'baddy', '$2y$10$.0x3ql1o8D17A3OAZ9qw0u.jnG4WQE6M5sOFweImNLe45selXIGoy', '2021-12-09 19:02:34', NULL, 'standard.svg', NULL),
(8, 'baldy123', '$2y$10$uTE.H3J7HwZnbvLvlaLloOnw5TmCDD0yoE4a0zylQDZxTSaUu6.O6', '2021-12-09 19:44:23', NULL, '61b251f631a8d8.20045275.png', NULL),
(9, 'srimmy6', '$2y$10$oz93g1j2x/V7R4s1T92wj.yq2sCb0D7EfqlehLV7Ysn.XttX/aqGa', '2021-12-09 21:51:46', NULL, '61b278771e9eb5.85788051.png', NULL),
(10, 'asd', '$2y$10$4FGeIiRdhWJYEaOqwXJtDugOFSwcLT.VoU0kbmEQSKEaSY.VJh8PS', '2021-12-09 23:19:28', 44400, '620625143ae655.11853187.png', NULL),
(11, 'asdf', '$2y$10$veuWkewOMM4K371qSGQfWuyRndFXfatWoha5TX45r6LuFzSWJPhrW', '2021-12-09 23:37:42', NULL, 'standard.svg', NULL),
(12, 'marie', '$2y$10$LYcD4f79e77gK.DspLpBlOljwFMOLIkO2Lg7.ZRe4ziWWX9o3HMfe', '2021-12-17 08:52:26', 12600, '61bc425f841e15.57863148.png', NULL),
(13, 'test', '$2y$10$j10MmS/W1Hv8RS3.as2Qq.GQhpR5vq.zZQvRBiq0AAooCAQKLuSGG', '2022-01-21 10:19:49', NULL, 'standard.svg', NULL),
(14, 'tester123', '$2y$10$UpC2O5KEgVTjT9Agr.rGe.tvnbO6dNnDxUfVC01J1jeH93UHmuYRa', '2022-01-21 11:15:15', NULL, 'standard.svg', NULL),
(15, 'biggy', '$2y$10$6vuqyJxW0UWYGhnamvwfr.49D2JvsMFLJcVAinGx1RnoHWKGChhVi', '2022-03-02 11:28:59', NULL, 'standard.svg', NULL),
(16, 'trigger', '$2y$10$RsNA410bPOyYKJ2iOEUTWeWjKqKLjmDkDl2.rsT35cpp5ZrvdS3Pa', '2022-03-04 10:32:58', NULL, '6221ee05227826.51234342.svg', NULL),
(19, 'dsa', '$2y$10$gcVIlkYl4Pk3ZXV6BwhPSutH8tl8jXgiigC0ou7areoxrOBiWfE8m', '2022-03-08 10:37:36', 157300, '6293df9061bdd0.48422578.jpg', 'admin'),
(20, 'bigmanum01fan', '$2y$10$43GlhNX/dqq1UuZwLTHC9eLEv9b9jvjv7F/268Yr2qc4YE6zqJp4O', '2022-03-15 10:36:27', NULL, 'standard.svg', NULL),
(21, 'test1', '$2y$10$d/Z6hAbWjuUEocA9mWubhO/1UezwEMmGQRvfaWUsWfyc7ivaSxqFO', '2022-03-18 11:41:04', NULL, 'standard.svg', 'support'),
(22, 'eo', '$2y$10$O/INr7wYrSiipu0BsIccV.SZ/nKiKpbXzYEV2OlK699LmVG7SlUqe', '2022-03-21 15:25:55', NULL, 'standard.svg', NULL),
(23, 'sluttbruker', '$2y$10$Nshr3apjDscsVYOcmmc96uXS1aJjqr/1eaJzl9fZZTRurFgQM7y8O', '2022-03-28 09:44:44', 14950, '6269105cd93ab5.38357157.png', NULL),
(24, 'manum010101', '$2y$10$79JyRGWCsdflXZVL0ctgu.UjCTc2PfLqs2icEzo6lms6tBcNyuiUC', '2022-04-29 10:46:27', NULL, '../profilbilder/standard.svg', NULL),
(25, 'kg', '$2y$10$p2q6AqmZdsC6g2mzxap.2uqLGPhKkmDDsTl/QY3voMpRJBYFP03/2', '2022-05-18 13:49:17', NULL, '../profilbilder/standard.svg', NULL);

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
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqpic`
--
ALTER TABLE `faqpic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `meldinger`
--
ALTER TABLE `meldinger`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `roleprivileges`
--
ALTER TABLE `roleprivileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticketreply`
--
ALTER TABLE `ticketreply`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `faqpic`
--
ALTER TABLE `faqpic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `following`
--
ALTER TABLE `following`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `kommentar`
--
ALTER TABLE `kommentar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `liktebilder`
--
ALTER TABLE `liktebilder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `meldinger`
--
ALTER TABLE `meldinger`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roleprivileges`
--
ALTER TABLE `roleprivileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `ticketreply`
--
ALTER TABLE `ticketreply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
