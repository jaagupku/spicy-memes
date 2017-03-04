-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2017 at 02:41 PM
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
(6, 4, 2, 'This is very spicy, top quality meme!', '2017-03-03 16:41:24', 0),
(7, 4, 1, ' tere', '2017-03-04 13:37:56', 0),
(8, 4, 1, ' tere', '2017-03-04 13:38:45', 0),
(9, 4, 1, ' my name is bob\r\n', '2017-03-04 13:38:50', 0),
(10, 4, 1, ' tere', '2017-03-04 13:41:23', 0),
(11, 4, 1, ' tere', '2017-03-04 13:41:28', 0),
(12, 2, 1, ' What is the point of this?', '2017-03-04 13:41:58', 0),
(13, 2, 1, ' Weird stuff <h1>Needs escaping</h1>', '2017-03-04 13:42:17', 0),
(14, 2, 1, ' cool \'', '2017-03-04 13:42:30', 0),
(15, 4, 1, ' &lt;h1&gt;test&lt;/h1&gt;', '2017-03-04 13:44:52', 0),
(16, 4, 1, ' ;', '2017-03-04 13:45:06', 0),
(17, 5, 1, ' ok\r\n', '2017-03-04 13:46:59', 0),
(18, 5, 1, ' ok\r\n', '2017-03-04 13:47:11', 0),
(19, 4, 2, ' i am test1\r\n', '2017-03-04 14:00:38', 0);

--
-- Dumping data for table `meme`
--

INSERT INTO `meme` (`Id`, `Title`, `User_Id`, `Data_Type`, `Data`, `Date`, `Up_Points`, `Down_Points`, `hotness`) VALUES
(1, 'Spicy new memes', 1, 'P', 'sample.jpg', '2017-02-27 18:31:12', 1, -2, 0),
(2, 'Meme nr 2', 1, 'V', '1G9AW2aCQ_M', '2017-02-27 18:31:12', 2, 0, 0),
(3, 'Testuser2 meme', 2, 'P', 'test1.jpg', '2017-02-28 00:21:42', 1, 0, 0),
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

INSERT INTO `users` (`Id`, `User_Type`, `User_Name`, `Password_Hash`, `Email`, `Creation_Date`, `Last_Login_Time`, `ProfileImg_Id`, `mobile_number`) VALUES
(1, 0, 'test', '$5$$sljnGYK4EExoItGYm2l5Wqg0JwDfZE4.67vp/tIXZk6', 'randoom@email.pirate', '2017-02-27 18:29:17', '2017-02-27 18:29:17', 'noprofileimg.jpg', NULL),
(2, 0, 'test1', '$5$$sljnGYK4EExoItGYm2l5Wqg0JwDfZE4.67vp/tIXZk6', 'test.test@test.test', '2017-02-28 00:18:49', '2017-02-28 00:18:49', 'noprofileimg.jpg', NULL),
(3, 0, 'test2', '$5$$sljnGYK4EExoItGYm2l5Wqg0JwDfZE4.67vp/tIXZk6', 'test.31test@test.test', '2017-02-28 00:18:49', '2017-02-28 00:18:49', 'noprofileimg.jpg', NULL),
(4, 0, 'jaagup', '$2y$10$UGv4a2/xq8LQmNzQF5zb0OJ.IAJ.Xed4hksHxdCM1VmTAd9cnqCpS', 'tere.tere@tere.tere', '2017-03-03 19:35:21', '2017-03-03 19:35:21', 'noprofileimg.jpg', '1234567'),
(5, 0, 'tere', '$2y$10$uTFznvP2etJw/MLwNL8v1e23FZYVv44iBFN7xvqfe0nTRJkYdWTF.', 'tere.terte@tere.tere', '2017-03-03 21:22:25', '2017-03-03 21:22:25', 'noprofileimg.jpg', '1234567'),
(6, 0, 'tere1', '$2y$10$/ZZAHErj0ouljg3qbpNzjOKUsCWBTpwaEhc3RmGhCgT1mO2Sg5u5C', 'tere.tttere@tere.tere', '2017-03-03 21:23:21', '2017-03-03 21:23:21', 'noprofileimg.jpg', '1234567');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
