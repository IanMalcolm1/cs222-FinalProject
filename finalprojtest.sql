-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 04, 2022 at 07:40 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalprojtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

DROP TABLE IF EXISTS `exercises`;
CREATE TABLE IF NOT EXISTS `exercises` (
  `type` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `link` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1
PARTITION BY LIST COLUMNS(`type`)
(
PARTITION core VALUES IN ('core') ENGINE=InnoDB,
PARTITION upperbody VALUES IN ('upperbody') ENGINE=InnoDB,
PARTITION legs VALUES IN ('legs') ENGINE=InnoDB
);

--
-- Dumping data for table `exercises`
--

INSERT INTO `exercises` (`type`, `name`, `link`) VALUES
('core', 'plank', 'https://www.verywellfit.com/the-plank-exercise-3120068'),
('core', 'side plank', 'https://www.verywellfit.com/how-to-safely-progress-your-side-plank-exercise-4016853'),
('core', 'mountain climbers', 'https://www.verywellfit.com/mountain-climbers-exercise-3966947'),
('core', 'leg raises/holds', 'https://www.menshealth.com/fitness/a35140310/leg-raises/'),
('core', 'bycicle crunches', 'https://www.verywellfit.com/bicycle-crunch-exercise-3120058'),
('core', 'russian twists', 'https://www.verywellfit.com/bicycle-crunch-exercise-3120058'),
('upperbody', 'pushups', 'https://www.verywellfit.com/the-push-up-exercise-3120574'),
('upperbody', 'diamond pushups', 'https://www.coachmag.co.uk/bodyweight-exercises/7297/how-to-do-a-diamond-push-up'),
('upperbody', 'chinups', 'https://www.healthline.com/health/fitness/pull-up-vs-chin-up#is-one-better'),
('upperbody', 'plank walkouts', 'https://www.menshealth.com/fitness/a33604525/plank-walkout-exercise/'),
('upperbody', 'biceps curls', 'https://www.verywellfit.com/how-to-do-the-biceps-arm-curl-3498604'),
('upperbody', 'bench presses', 'https://www.verywellfit.com/how-to-do-the-bench-press-exercise-3498278'),
('legs', 'squats', 'https://www.runnersworld.com/training/a32256640/how-to-do-a-squat/'),
('legs', 'single-leg deadlifts', 'https://www.verywellfit.com/how-to-do-a-single-leg-deadlift-2084681'),
('legs', 'tuck jumps', 'https://www.masterclass.com/articles/tuck-jump-exercise-guide'),
('legs', 'split squats', 'https://www.coachmag.co.uk/leg-exercises/7016/how-to-do-the-split-squat'),
('legs', 'skipping', 'https://www.crossrope.com/blogs/blog/how-to-jump-rope/'),
('legs', 'running', 'https://www.healthline.com/health/exercise-fitness/proper-running-form#running-form');

-- --------------------------------------------------------

--
-- Table structure for table `fitness_app_users`
--

DROP TABLE IF EXISTS `fitness_app_users`;
CREATE TABLE IF NOT EXISTS `fitness_app_users` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fitness_app_users`
--

INSERT INTO `fitness_app_users` (`account_id`, `name`, `email`, `password`) VALUES
(1, 'Bobo', 'bobobaka@gmail.com', 'test'),
(2, 'test', 'test@test.com', 'test'),
(3, 'idk', 'what', 'I\'m doing'),
(4, 'newUser', 'new@user.com', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `user_prefs`
--

DROP TABLE IF EXISTS `user_prefs`;
CREATE TABLE IF NOT EXISTS `user_prefs` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` tinyint(4) NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_prefs`
--

INSERT INTO `user_prefs` (`account_id`, `theme`) VALUES
(1, 0),
(2, 1),
(3, 0),
(4, 3);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_prefs`
--
ALTER TABLE `user_prefs`
  ADD CONSTRAINT `user_prefs_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `fitness_app_users` (`account_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
