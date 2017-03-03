-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2017 at 03:51 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spicymemes`
--

--
-- Dumping data for table `commentpoints`
--

INSERT INTO `commentpoints` (`Id`, `Comment_Id`, `User_Id`, `Up_Vote`) VALUES
(1, 1, 1, 1),
(3, 4, 1, 1),
(4, 2, 2, 1),
(5, 2, 1, 1);

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Id`, `Meme_Id`, `User_Id`, `Message`, `Date`, `Points`) VALUES
(1, 1, 1, 'Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1Some copypasta 1', '2017-02-27 18:32:48', 0),
(2, 1, 1, 'this is shiet', '2017-02-27 18:32:48', 2),
(3, 1, 2, 'WEll this is 3rd one', '2017-02-27 18:32:48', 0),
(4, 2, 1, 'great meme xd', '2017-02-27 18:32:48', 1),
(5, 2, 1, 'COPY PAGPAGPAJKDFPGJAPERJGPAJERGT', '2017-02-27 18:32:48', 0),
(6, 4, 2, 'This is very spicy, top quality meme!', '2017-03-03 16:41:24', 0);

--
-- Dumping data for table `meme`
--

INSERT INTO `meme` (`Id`, `Title`, `User_Id`, `Data_Type`, `Data`, `Date`, `Up_Points`, `Down_Points`, `hotness`) VALUES
(1, 'Spicy new memes', 1, 'P', 'default.jpg', '2017-02-27 18:31:12', 1, -2, 0),
(2, 'Meme nr 2', 1, 'V', '1G9AW2aCQ_M', '2017-02-27 18:31:12', 2, 0, 0),
(3, 'Testuser2 meme', 2, 'P', 'test.jpg', '2017-02-28 00:21:42', 1, 0, 0),
(4, 'Meme nr 3 teste meme', 3, 'P', 'J1ukCf6_aok3qz.jpg', '2017-03-03 15:06:15', 3, 0, 4.5),
(5, 'Vide test meme2', 2, 'V', 'J48dqyz_C6s', '2017-03-03 15:06:15', 1, -1, 0.115385);

--
-- Dumping data for table `memepoints`
--

INSERT INTO `memepoints` (`Id`, `Meme_Id`, `User_Id`, `Up_Vote`) VALUES
(14, 1, 1, 1),
(15, 1, 2, -1),
(16, 1, 3, -1),
(17, 2, 1, 1),
(18, 2, 3, 1),
(19, 3, 1, 1),
(20, 4, 1, 1),
(21, 4, 2, 1),
(22, 4, 3, 1),
(23, 5, 1, 1),
(24, 5, 2, -1);

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`Id`, `Meme_Id`, `Date`, `Type`, `Data`) VALUES
(2, 1, '2017-03-03 16:39:22', 1, NULL),
(3, 1, '2017-03-03 16:39:22', 2, NULL);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `User_Type`, `User_Name`, `Password_Hash`, `salt`, `Email`, `Creation_Date`, `Last_Login_Time`, `ProfileImg_Id`, `mobile_number`) VALUES
(1, 0, 'test', '$5$$sljnGYK4EExoItGYm2l5Wqg0JwDfZE4.67vp/tIXZk6', '$5$', 'randoom@email.pirate', '2017-02-27 18:29:17', '2017-02-27 18:29:17', 'noprofileimg.jpg', NULL),
(2, 0, 'test1', '$5$$sljnGYK4EExoItGYm2l5Wqg0JwDfZE4.67vp/tIXZk6', '$5$', 'test.test@test.test', '2017-02-28 00:18:49', '2017-02-28 00:18:49', 'noprofileimg.jpg', NULL),
(3, 0, 'test2', '$5$$sljnGYK4EExoItGYm2l5Wqg0JwDfZE4.67vp/tIXZk6', '$5$', 'test.31test@test.test', '2017-02-28 00:18:49', '2017-02-28 00:18:49', 'noprofileimg.jpg', NULL);

-- --------------------------------------------------------

--
-- Structure for view `v_comments`
--
DROP TABLE IF EXISTS `v_comments`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_comments`  AS  select `comments`.`Id` AS `Id`,`comments`.`Meme_Id` AS `Meme_Id`,`comments`.`User_Id` AS `User_Id`,`users`.`User_Name` AS `User_Name`,`comments`.`Message` AS `Message` from (`comments` join `users` on((`comments`.`User_Id` = `users`.`Id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_hot_memes`
--
DROP TABLE IF EXISTS `v_hot_memes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_hot_memes`  AS  select `meme`.`Id` AS `Id`,`meme`.`Title` AS `Title`,`meme`.`User_Id` AS `User_Id`,`users`.`User_Name` AS `User_Name`,`meme`.`Data_Type` AS `Data_Type`,`meme`.`Data` AS `Data`,`meme`.`Date` AS `Date`,(`meme`.`Up_Points` + `meme`.`Down_Points`) AS `Points` from (`meme` join `users` on((`meme`.`User_Id` = `users`.`Id`))) order by `meme`.`hotness` desc ;

-- --------------------------------------------------------

--
-- Structure for view `v_new_memes`
--
DROP TABLE IF EXISTS `v_new_memes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_new_memes`  AS  select `meme`.`Id` AS `Id`,`meme`.`Title` AS `Title`,`meme`.`User_Id` AS `User_Id`,`users`.`User_Name` AS `User_Name`,`meme`.`Data_Type` AS `Data_Type`,`meme`.`Data` AS `Data`,`meme`.`Date` AS `Date`,(`meme`.`Up_Points` + `meme`.`Down_Points`) AS `Points` from (`meme` join `users` on((`meme`.`User_Id` = `users`.`Id`))) order by `meme`.`Date` desc ;

-- --------------------------------------------------------

--
-- Structure for view `v_top_memes`
--
DROP TABLE IF EXISTS `v_top_memes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_top_memes`  AS  select `meme`.`Id` AS `Id`,`meme`.`Title` AS `Title`,`meme`.`User_Id` AS `User_Id`,`users`.`User_Name` AS `User_Name`,`meme`.`Data_Type` AS `Data_Type`,`meme`.`Data` AS `Data`,(`meme`.`Up_Points` + `meme`.`Down_Points`) AS `Points` from (`meme` join `users` on((`meme`.`User_Id` = `users`.`Id`))) order by (`meme`.`Up_Points` + `meme`.`Down_Points`) desc ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
