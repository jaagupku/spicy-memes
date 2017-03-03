-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2017 at 09:17 PM
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

DELIMITER $$
--
-- Procedures
--
CREATE  PROCEDURE `sp_add_comment` (IN `a_meme_id` INT, IN `a_user_id` INT, IN `a_message` TEXT CHARSET utf8)  NO SQL
INSERT INTO `comments` (`Id`, `Meme_Id`, `User_Id`, `Message`, `Date`, `Points`) VALUES (NULL, a_meme_id, a_user_id, a_message, CURRENT_TIMESTAMP, '0')$$

CREATE  PROCEDURE `sp_add_meme` (IN `a_title` VARCHAR(255), IN `a_user_id` INT, IN `a_data_type` ENUM('P','V'), IN `a_data` VARCHAR(100))  MODIFIES SQL DATA
    COMMENT 'adds a new meme'
INSERT INTO `meme` (`Id`, `Title`, `User_Id`, `Data_Type`, `Data`, `Date`, `Up_Points`, `Down_Points`, `hotness`) VALUES (NULL, a_title, a_user_id, a_data_type, a_data, CURRENT_TIMESTAMP, '0', '0', '0')$$

CREATE  PROCEDURE `sp_add_user` (IN `a_user_type` INT(1), IN `a_user_name` VARCHAR(32) CHARSET utf8, IN `a_passwdhash` VARCHAR(255) CHARSET utf8, IN `a_email` VARCHAR(128) CHARSET utf8, IN `a_mobile` VARCHAR(15) CHARSET utf8)  MODIFIES SQL DATA
INSERT INTO `users` (`Id`, `User_Type`, `User_Name`, `Password_Hash`, `Email`, `Creation_Date`, `Last_Login_Time`, `ProfileImg_Id`, `mobile_number`) VALUES (NULL, a_user_type, a_user_name, a_passwdhash, a_email, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 'noprofileimg.jpg', a_mobile)$$

CREATE  PROCEDURE `sp_meme_comments_login` (IN `a_meme_id` INT, IN `a_user_id` INT)  READS SQL DATA
    COMMENT 'shows comments on given meme with given user upvotes'
SELECT Comments.Message, Comments.Date, Comments.Points, comments.User_Id, IF(commentpoints.User_Id=a_user_id,commentpoints.Up_Vote,0) AS vote FROM Comments LEFT JOIN commentpoints ON comments.Id=commentpoints.Comment_Id WHERE Comments.meme_id=a_meme_id GROUP BY comments.Id$$

CREATE  PROCEDURE `sp_update_user_last_login` (IN `a_user_id` INT, IN `a_datetime` DATETIME)  NO SQL
UPDATE users SET users.Last_Login_Time=a_datetime WHERE users.Id=a_user_id$$

CREATE  PROCEDURE `sp_userid_to_username` (IN `a_user_id` INT)  READS SQL DATA
SELECT users.User_Name FROM users WHERE users.Id=a_user_id$$

CREATE  PROCEDURE `sp_username_to_userid` (IN `a_user_name` VARCHAR(32))  READS SQL DATA
SELECT users.Id FROM users WHERE users.User_Name=a_user_name$$

CREATE  PROCEDURE `sp_user_total_memes` (IN `a_user_id` INT)  READS SQL DATA
SELECT COUNT(*) FROM meme WHERE meme.User_Id=a_user_id$$

CREATE  PROCEDURE `sp_vote_comment` (IN `a_comment_id` INT, IN `a_user_id` INT, IN `a_vote` INT)  MODIFIES SQL DATA
    COMMENT 'adds vote to comment'
INSERT INTO `commentpoints` (`Id`, `Comment_Id`, `User_Id`, `Up_Vote`) VALUES (NULL, a_comment_id, a_user_id, a_vote)$$

CREATE  PROCEDURE `sp_vote_meme` (IN `a_meme_id` INT, IN `a_user_id` INT, IN `a_vote` INT)  MODIFIES SQL DATA
INSERT INTO `memepoints` (`Id`, `Meme_Id`, `User_Id`, `Up_Vote`) VALUES (NULL, a_meme_id, a_user_id, a_vote)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `commentpoints`
--

CREATE TABLE `commentpoints` (
  `Id` int(11) NOT NULL,
  `Comment_Id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Up_Vote` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Triggers `commentpoints`
--
DELIMITER $$
CREATE TRIGGER `tg_add_commentvote` BEFORE INSERT ON `commentpoints` FOR EACH ROW BEGIN
	IF (NEW.Up_Vote > 1) THEN
    	SET NEW.Up_Vote:=1;
    ELSEIF (NEW.Up_Vote < -1) THEN
    	SET NEW.Up_Vote:=-1;
    ELSE
    	SIGNAL SQLSTATE '45000';
    END IF;
	UPDATE comments
     	SET comments.Points=comments.Points+NEW.Up_Vote
   		WHERE id = NEW.comment_Id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_remove_commentvote` AFTER DELETE ON `commentpoints` FOR EACH ROW UPDATE comments
     SET comments.Points=comments.Points-OLD.Up_Vote
   WHERE id = OLD.comment_Id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Id` int(11) NOT NULL,
  `Meme_Id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Message` text CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `Date` datetime DEFAULT CURRENT_TIMESTAMP,
  `Points` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `meme`
--

CREATE TABLE `meme` (
  `Id` int(11) NOT NULL,
  `Title` varchar(255) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Data_Type` enum('P','V') COLLATE utf8_bin NOT NULL COMMENT '''P'' for picture in cloudinary, ''V'' for youtube video id',
  `Data` varchar(100) COLLATE utf8_bin NOT NULL,
  `Date` datetime DEFAULT CURRENT_TIMESTAMP,
  `Up_Points` int(11) NOT NULL DEFAULT '0',
  `Down_Points` int(11) NOT NULL DEFAULT '0',
  `hotness` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `memepoints`
--

CREATE TABLE `memepoints` (
  `Id` int(11) NOT NULL,
  `Meme_Id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Up_Vote` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Triggers `memepoints`
--
DELIMITER $$
CREATE TRIGGER `tg_add_memevote` BEFORE INSERT ON `memepoints` FOR EACH ROW BEGIN
	IF (NEW.Up_Vote > 0) THEN
    	SET NEW.Up_Vote:=1;
        UPDATE meme
     		SET meme.Up_Points:=meme.Up_Points+NEW.Up_Vote
   				WHERE id = NEW.meme_Id;
    ELSEIF (NEW.Up_Vote < 0) THEN
    	SET NEW.Up_Vote:=-1;
        UPDATE meme
     		SET meme.Down_Points:=meme.Down_Points+NEW.Up_Vote
   				WHERE id = NEW.meme_Id;
    ELSE
    	SIGNAL SQLSTATE '45000';
    END IF;
    
    
	UPDATE meme SET meme.hotness:=IF(TIMESTAMPDIFF(HOUR, meme.Date, CURRENT_TIMESTAMP)<72,IF(NEW.Up_Vote=1,meme.hotness+(72-TIMESTAMPDIFF(HOUR, meme.Date, CURRENT_TIMESTAMP))/48,meme.hotness-(72-TIMESTAMPDIFF(HOUR, meme.Date, CURRENT_TIMESTAMP))/52),0) WHERE meme.Id=NEW.meme_Id; 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_remove_memevote` AFTER DELETE ON `memepoints` FOR EACH ROW BEGIN
	IF (OLD.Up_Vote=1) THEN
        UPDATE meme
     		SET meme.Up_Points=meme.Up_Points-OLD.Up_Vote
   				WHERE id = OLD.meme_Id;
    ELSEIF (OLD.Up_Vote=-1) THEN
        UPDATE meme
     		SET meme.Down_Points=meme.Down_Points-OLD.Up_Vote
   				WHERE id = OLD.meme_Id;
    END IF;
    UPDATE meme SET meme.hotness:=IF(TIMESTAMPDIFF(HOUR, meme.Date, CURRENT_TIMESTAMP)<72,IF(OLD.Up_Vote=1,meme.hotness-(72-TIMESTAMPDIFF(HOUR, meme.Date, CURRENT_TIMESTAMP))/48,meme.hotness+(72-TIMESTAMPDIFF(HOUR, meme.Date, CURRENT_TIMESTAMP))/52),0) WHERE meme.Id=OLD.meme_Id; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `Id` int(11) NOT NULL,
  `Meme_Id` int(11) NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Type` int(11) NOT NULL,
  `Data` tinytext COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `User_Type` int(1) NOT NULL DEFAULT '0' COMMENT '0 means ordinary user, 1 is admin',
  `User_Name` varchar(32) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `Password_Hash` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'default test user password "test" http://php.net/manual/en/function.password-hash.php , current test passwords are made with crypt()',
  `Email` varchar(128) COLLATE utf8_bin NOT NULL,
  `Creation_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Last_Login_Time` datetime DEFAULT CURRENT_TIMESTAMP,
  `ProfileImg_Id` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT 'noprofileimg.jpg',
  `mobile_number` varchar(15) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_comments`
-- (See below for the actual view)
--
CREATE TABLE `v_comments` (
`Id` int(11)
,`Meme_Id` int(11)
,`User_Id` int(11)
,`User_Name` varchar(32)
,`Message` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_hot_memes`
-- (See below for the actual view)
--
CREATE TABLE `v_hot_memes` (
`Id` int(11)
,`Title` varchar(255)
,`User_Id` int(11)
,`User_Name` varchar(32)
,`Data_Type` enum('P','V')
,`Data` varchar(100)
,`Date` datetime
,`Points` bigint(12)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_new_memes`
-- (See below for the actual view)
--
CREATE TABLE `v_new_memes` (
`Id` int(11)
,`Title` varchar(255)
,`User_Id` int(11)
,`User_Name` varchar(32)
,`Data_Type` enum('P','V')
,`Data` varchar(100)
,`Date` datetime
,`Points` bigint(12)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_top_memes`
-- (See below for the actual view)
--
CREATE TABLE `v_top_memes` (
`Id` int(11)
,`Title` varchar(255)
,`User_Id` int(11)
,`User_Name` varchar(32)
,`Data_Type` enum('P','V')
,`Data` varchar(100)
,`Points` bigint(12)
);

-- --------------------------------------------------------

--
-- Structure for view `v_comments`
--
DROP TABLE IF EXISTS `v_comments`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_comments`  AS  select `comments`.`Id` AS `Id`,`comments`.`Meme_Id` AS `Meme_Id`,`comments`.`User_Id` AS `User_Id`,`users`.`User_Name` AS `User_Name`,`comments`.`Message` AS `Message` from (`comments` join `users` on((`comments`.`User_Id` = `users`.`Id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_hot_memes`
--
DROP TABLE IF EXISTS `v_hot_memes`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_hot_memes`  AS  select `meme`.`Id` AS `Id`,`meme`.`Title` AS `Title`,`meme`.`User_Id` AS `User_Id`,`users`.`User_Name` AS `User_Name`,`meme`.`Data_Type` AS `Data_Type`,`meme`.`Data` AS `Data`,`meme`.`Date` AS `Date`,(`meme`.`Up_Points` + `meme`.`Down_Points`) AS `Points` from (`meme` join `users` on((`meme`.`User_Id` = `users`.`Id`))) order by `meme`.`hotness` desc ;

-- --------------------------------------------------------

--
-- Structure for view `v_new_memes`
--
DROP TABLE IF EXISTS `v_new_memes`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_new_memes`  AS  select `meme`.`Id` AS `Id`,`meme`.`Title` AS `Title`,`meme`.`User_Id` AS `User_Id`,`users`.`User_Name` AS `User_Name`,`meme`.`Data_Type` AS `Data_Type`,`meme`.`Data` AS `Data`,`meme`.`Date` AS `Date`,(`meme`.`Up_Points` + `meme`.`Down_Points`) AS `Points` from (`meme` join `users` on((`meme`.`User_Id` = `users`.`Id`))) order by `meme`.`Date` desc ;

-- --------------------------------------------------------

--
-- Structure for view `v_top_memes`
--
DROP TABLE IF EXISTS `v_top_memes`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_top_memes`  AS  select `meme`.`Id` AS `Id`,`meme`.`Title` AS `Title`,`meme`.`User_Id` AS `User_Id`,`users`.`User_Name` AS `User_Name`,`meme`.`Data_Type` AS `Data_Type`,`meme`.`Data` AS `Data`,(`meme`.`Up_Points` + `meme`.`Down_Points`) AS `Points` from (`meme` join `users` on((`meme`.`User_Id` = `users`.`Id`))) order by (`meme`.`Up_Points` + `meme`.`Down_Points`) desc ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commentpoints`
--
ALTER TABLE `commentpoints`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `uc_commentuservote` (`Comment_Id`,`User_Id`),
  ADD KEY `User_Id` (`User_Id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Meme_Id` (`Meme_Id`),
  ADD KEY `User_Id` (`User_Id`);

--
-- Indexes for table `meme`
--
ALTER TABLE `meme`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `User_Id` (`User_Id`);

--
-- Indexes for table `memepoints`
--
ALTER TABLE `memepoints`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `uc_memeuservote` (`Meme_Id`,`User_Id`),
  ADD KEY `User_Id` (`User_Id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Meme_Id` (`Meme_Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `User_Name` (`User_Name`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commentpoints`
--
ALTER TABLE `commentpoints`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `meme`
--
ALTER TABLE `meme`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `memepoints`
--
ALTER TABLE `memepoints`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `commentpoints`
--
ALTER TABLE `commentpoints`
  ADD CONSTRAINT `commentpoints_ibfk_1` FOREIGN KEY (`Comment_Id`) REFERENCES `comments` (`Id`),
  ADD CONSTRAINT `commentpoints_ibfk_2` FOREIGN KEY (`User_Id`) REFERENCES `users` (`Id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`Meme_Id`) REFERENCES `meme` (`Id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`User_Id`) REFERENCES `users` (`Id`);

--
-- Constraints for table `meme`
--
ALTER TABLE `meme`
  ADD CONSTRAINT `meme_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `users` (`Id`);

--
-- Constraints for table `memepoints`
--
ALTER TABLE `memepoints`
  ADD CONSTRAINT `memepoints_ibfk_1` FOREIGN KEY (`Meme_Id`) REFERENCES `meme` (`Id`),
  ADD CONSTRAINT `memepoints_ibfk_2` FOREIGN KEY (`User_Id`) REFERENCES `users` (`Id`);

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`Meme_Id`) REFERENCES `meme` (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
