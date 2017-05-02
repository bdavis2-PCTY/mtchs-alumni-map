-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2017 at 03:11 PM
-- Server version: 5.5.54-cll
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clonesmt_alumnimap`
--

-- --------------------------------------------------------

--
-- Table structure for table `Alumni`
--

CREATE TABLE `Alumni` (
  `ID` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `GradYear` int(4) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Education` varchar(50) NOT NULL,
  `Job` varchar(150) DEFAULT NULL,
  `Salary` int(11) DEFAULT NULL,
  `Verified` tinyint(1) NOT NULL DEFAULT '0',
  `Printed` tinyint(1) DEFAULT '0',
  `Updated` tinyint(1) NOT NULL DEFAULT '0',
  `New` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Alumni`
--

INSERT INTO `Alumni` (`ID`, `Name`, `GradYear`, `Location`, `Education`, `Job`, `Salary`, `Verified`, `Printed`, `Updated`, `New`) VALUES
(1, 'Kaden Stevens', 2016, '1198', 'No Post-Secondary Training', 'Cashier', 15600, 1, 0, 0, 1),
(2, 'Benjamin Herrmann', 2014, '1228', '1 - 2 Years of College', 'Application Engineering Intern', 35360, 1, 0, 0, 1),
(3, 'Ryan Baird', 2009, '1237', 'Master\'s Degree', 'PhD.  Student / Research Assistant - Compiler Optimization', 23000, 1, 0, 0, 1),
(4, 'Nathan Haddock', 2012, '1210', '3 - 4 Years of College', 'IT Customer Service', 32000, 1, 0, 0, 1),
(5, 'Ben Shilton', 2010, '1214', 'Associate Degree', 'IT Project Manager', 32500, 1, 0, 0, 1),
(6, 'Matt Miller', 2007, '1225', 'Bachelor\'s Degree', '', 0, 1, 0, 0, 1),
(7, 'Brandon Cook', 2012, '1232', 'Bachelor\'s Degree', 'Microbiologist - Research And Development, BioTechnology', 46000, 1, 0, 0, 1),
(8, 'Colin Einfalt', 2014, '1235', '1 - 2 Years of College', 'USCG, Military', 60000, 1, 0, 0, 1),
(9, 'Mac Carrithers', 2014, '1198', 'No Post-Secondary Training', 'Software Engineer', 65000, 1, 0, 0, 1),
(10, 'Alisha Machado-Murray', 2012, '1198', '3 - 4 Years of College', 'Communications Assistant. Still Do Graphic Design On The Side As Contract Work. ', 15000, 1, 0, 0, 1),
(11, 'Isaaaac Mikel!', 2015, '1198', '1 - 2 Years of College', 'Tshirt Design Specialist', 20800, 1, 0, 0, 1),
(12, 'Emily Biancavilla', 2013, '1198', '1 - 2 Years of College', 'Outreach Coordinator', 20800, 1, 0, 0, 1),
(13, 'Spencer Hoyt ', 2015, '1217', '1 - 2 Years of College', 'Auto Body Intern ', 20800, 1, 0, 0, 1),
(14, 'Benjamin Dransfield', 2012, '1227', '3 - 4 Years of College', 'Part-Time Windows Lab Administrator', 22880, 1, 0, 0, 1),
(15, 'Paige Carstensen', 2015, '1198', 'No Post-Secondary Training', 'Teller', 22880, 1, 0, 0, 1),
(16, 'Kira Davis ', 2016, '1198', '1 - 2 Years of College', 'WordPress Support Specialist For BSU', 22880, 1, 0, 1, 0),
(17, 'Parker Parrish', 2016, '1198', '1 - 2 Years of College', 'Electronics Technician & Quality Assurance Trainer', 24960, 1, 0, 0, 1),
(18, 'Jarod Baird', 2016, '1198', 'No Post-Secondary Training', 'Junior Software Engineer', 24960, 1, 0, 0, 1),
(19, 'Quinn Oster ', 2016, '1198', 'No Post-Secondary Training', 'Desktop Technician', 24960, 1, 0, 0, 1),
(20, 'Christianne Durham', 2012, '1229', 'Bachelor\'s Degree', 'Analyst / Programmer Trainee', 24960, 1, 0, 0, 1),
(21, 'Brandon Byerly', 2014, '1198', '1 - 2 Years of College', 'Advertisement Manager', 31200, 1, 0, 0, 1),
(22, 'Patrick Shannon', 2014, '1198', '1 - 2 Years of College', 'Phlebotomist', 33280, 1, 0, 0, 1),
(23, 'Nick Alkire', 2013, '1202', '3 - 4 Years of College', 'Software Developer Intern', 35360, 1, 0, 0, 1),
(24, 'Jack Penick', 2015, '1224', '1 - 2 Years of College', '', 0, 1, 0, 0, 1),
(25, 'Tony Bolen', 2012, '1198', 'Bachelor\'s Degree', 'Field Services Technican', 38376, 1, 0, 0, 1),
(26, 'Andrew Wingfield', 2007, '1198', 'Master\'s Degree', 'Licensed Professional Counselor', 23025, 1, 0, 0, 1),
(27, 'Caleb Lloyd', 2012, '1198', 'Bachelor\'s Degree', 'Support Specialist ', 41600, 1, 0, 0, 1),
(28, 'James Purves', 2009, '1223', '3 - 4 Years of College', 'Retail Owner / Real Estate Professional', 200000, 1, 0, 0, 1),
(29, 'Machaela Sportiello ', 2007, '1203', 'Associate Degree', 'Registered Medical Assistant ', 30000, 1, 0, 0, 1),
(30, 'Justin Garrard', 2012, '1198', '3 - 4 Years of College', 'Software Engineering Intern', 49920, 1, 0, 0, 1),
(31, 'Brendon McCoy', 2013, '1198', '3 - 4 Years of College', 'Software Developer', 56160, 1, 0, 0, 1),
(32, 'Nik Kososik', 2012, '1198', '3 - 4 Years of College', 'Lab Researcher', 37000, 1, 0, 0, 1),
(33, 'Greg Trent ', 2009, '1198', 'Bachelor\'s Degree', 'Sr IT Programmer Analyst ', 62400, 1, 0, 0, 1),
(34, 'Patrick Resler', 2009, '1221', 'Bachelor\'s Degree', 'Naval Aviator', 31000, 1, 0, 0, 1),
(35, 'Nate Jenson', 2016, '1198', 'Industry Certification(s)', 'IT Support Specialist ', 33040, 1, 0, 0, 1),
(36, 'Nate Jenson', 2016, '1198', 'Industry Certification(s)', 'IT Support Specialist', 33044, 1, 0, 0, 1),
(37, 'Timothy Martin', 2012, '1231', 'Bachelor\'s Degree', 'Engineering Techician', 34000, 1, 0, 0, 1),
(38, 'Steven Birkinbine', 2010, '1198', 'Bachelor\'s Degree', 'YouTube Content Creator', 60000, 1, 0, 0, 1),
(39, 'Lee Lovell', 2007, '1213', 'Bachelor\'s Degree', 'Managing Editor', 43000, 1, 0, 0, 1),
(40, 'Victor Haggard ', 2013, '1220', 'Some Post-Graduate Education', 'Navy - Aviation Ordnanceman ', 48000, 1, 0, 0, 1),
(41, 'Whitney Moore', 2010, '1198', '1 - 2 Years of College', 'Food Service Manager', 55000, 1, 0, 0, 1),
(42, 'Robert Pooley III', 2010, '1198', 'Bachelor\'s Degree', 'Programmer', 55000, 1, 0, 0, 1),
(43, 'Austin Miller', 2011, '1198', 'Some Post-Graduate Education', 'Test Engineer ', 65000, 1, 0, 0, 1),
(44, 'Collin Burns', 2009, '1225', 'Bachelor\'s Degree', 'IT Support Engineer', 70000, 1, 0, 0, 1),
(45, 'Alec Richey', 2011, '1204', 'Bachelor\'s Degree', 'Electrical Engineer', 60000, 1, 0, 0, 1),
(46, 'Lucas Obendorf', 2012, '1198', '1 - 2 Years of College', 'Software Developer', 80000, 1, 0, 0, 1),
(47, 'Michae Hance', 2010, '1198', 'Bachelor\'s Degree', 'Software Engineer', 60000, 1, 0, 0, 1),
(48, 'Kyle Dale', 2008, '1198', 'No Post-Secondary Training', 'Site Reliabilty Engineer', 80000, 1, 0, 0, 1),
(49, 'Makena Porter', 2016, '1232', '1 - 2 Years of College', 'Photographer/Business Owner', 39000, 1, 0, 0, 1),
(50, 'Dante\' Aven Nielsen', 2016, '1198', 'No Post-Secondary Training', 'DishWasher', 17680, 1, 0, 0, 1),
(51, 'Brian Guiana', 2016, '1217', 'No Post-Secondary Training', 'ITS 24 Hour Desk Attendant ', 18200, 1, 0, 0, 1),
(52, 'Joshua Fisher', 2009, '1232', '1 - 2 Years of College', 'Automation Engineer', 80000, 1, 0, 0, 1),
(53, 'Emma Obendorf', 2016, '1198', 'No Post-Secondary Training', 'QA ', 19240, 1, 0, 0, 1),
(54, 'Melinda Beuerman', 2015, '1227', '1 - 2 Years of College', 'Retail Customer Service/ Podcaster/ Social Media Marketer', 20800, 1, 0, 0, 1),
(55, 'Matthew Hansen', 2014, '1203', 'No Post-Secondary Training', 'Production Assistant', 21610, 1, 0, 0, 1),
(56, 'Holly Krommenhoek', 2010, '1205', '1 - 2 Years of College', 'Caregiver', 21840, 1, 0, 0, 1),
(57, 'Jamie Lorenzetti', 2012, '1198', 'No Post-Secondary Training', 'Travel Agent', 29120, 1, 0, 0, 1),
(58, 'Ryan Montierth', 2014, '1214', '1 - 2 Years of College', 'Junior Developer', 29120, 1, 0, 0, 1),
(59, 'Michael George', 2014, '1236', '3 - 4 Years of College', 'IT Support (Field Services)', 32676, 1, 0, 0, 1),
(60, 'Ken Box', 2016, '1238', 'Industry Certification(s)', 'IT Help Desk', 31200, 1, 0, 0, 1),
(61, 'Robert Kleffner', 2011, '1230', 'Bachelor\'s Degree', 'Part-time Programmer', 25000, 1, 0, 0, 1),
(62, 'Raistlan H Schade', 2015, '1198', '1 - 2 Years of College', 'Software Developer', 28000, 1, 0, 0, 1),
(63, 'Stephanie Bauman (Beuerman)', 2011, '1208', 'Bachelor\'s Degree', 'Elementary Teacher ', 36000, 1, 0, 0, 1),
(64, 'Seth Johnson', 2014, '1198', '1 - 2 Years of College', 'Automotive Technician', 36000, 1, 0, 0, 1),
(65, 'Mason Mollette', 2014, '1218', '3 - 4 Years of College', 'Maintainance Technician', 43000, 1, 0, 0, 1),
(66, 'Bronson-Lee Drapesa', 2007, '1222', 'Industry Certification(s)', 'University IT Representative', 45000, 1, 0, 0, 1),
(67, 'Breianna McCutchen ', 2016, '1198', 'Bachelor\'s Degree', 'Reconciliation Team Lead ', 46000, 1, 0, 0, 1),
(68, 'Tyler Johnson', 2009, '1223', 'Bachelor\'s Degree', 'Video Producer', 55000, 1, 0, 0, 1),
(69, 'Braeden Lieberman', 2011, '1211', 'Bachelor\'s Degree', 'Electrical Engineer', 64000, 1, 0, 0, 1),
(70, 'Christian McKenna', 2008, '1198', 'No Post-Secondary Training', 'Systems And Applications Administrator III', 69000, 1, 0, 0, 1),
(71, 'Dustin Montierth', 2011, '1198', '1 - 2 Years of College', 'Visual Effects/Cinematographer', 52000, 1, 0, 0, 1),
(72, 'Erik Ersland', 2013, '1201', '3 - 4 Years of College', 'Student', 0, 1, 0, 0, 1),
(73, 'Jessica Mintun', 2009, '1214', 'No Post-Secondary Training', 'Business Owner (jewlery Making And Selling)', 0, 1, 0, 0, 1),
(74, 'James Saccomando', 2015, '1198', '1 - 2 Years of College', '', 0, 1, 0, 0, 1),
(75, 'Andy Lau', 2014, '1198', '3 - 4 Years of College', 'Undergraduate Research Assistant', 0, 1, 0, 0, 1),
(76, 'Alejandro Martinez', 2013, '1198', 'Post-Secondary Certificate', 'Field Service Technician', 0, 1, 0, 0, 1),
(77, 'Christian Neff', 2012, '1223', 'Associate Degree', 'Lab Technician/Sales', 0, 1, 0, 0, 1),
(78, 'Tyler Sheridan ', 2012, '1214', '1 - 2 Years of College', 'Software QA', 0, 1, 0, 0, 1),
(79, 'Jonathan Stefani', 2015, '1198', '1 - 2 Years of College', 'Software Engineering Intern', 0, 1, 0, 0, 1),
(80, 'Rick Anderson', 2010, '1198', '3 - 4 Years of College', 'Web Developer', 0, 1, 0, 0, 1),
(81, 'Gabby Morgan (Wheelerl', 2010, '1198', '1 - 2 Years of College', 'Alaska Airlines Reservations Sales Agent', 0, 1, 0, 0, 1),
(82, 'Ali Breshears (Rotta)', 2009, '1214', 'PhD', 'Idaho Supreme Court Judicial Law Clerk, Attorney', 0, 1, 0, 0, 1),
(83, 'Ryan Cooper', 2009, '1198', 'No Post-Secondary Training', 'Screen Printing Assistant', 0, 1, 0, 0, 1),
(84, 'Tyler Gilbert', 2014, '1198', '3 - 4 Years of College', 'Delivery Driver', 0, 1, 0, 0, 1),
(85, 'Vincent Nguyen ', 2016, '1214', 'Bachelor\'s Degree', 'Prod Support', 0, 1, 0, 0, 1),
(86, 'Nic Ford', 2009, '1239', 'Bachelor\'s Degree', 'Associate Professor Of Web Design And Development', 0, 1, 0, 0, 1),
(87, 'Elizabeth Croft', 2011, '1218', '1 - 2 Years of College', 'Peer Support Specialist', 0, 1, 0, 0, 1),
(88, 'Cameron Terrill', 2016, '1200', 'No Post-Secondary Training', '', 0, 1, 0, 0, 1),
(89, 'Jordyn Bledsoe', 2012, '1234', '1 - 2 Years of College', 'Server', 0, 1, 0, 0, 1),
(90, 'Tyler Bass', 2015, '1199', '1 - 2 Years of College', '', 0, 1, 0, 0, 1),
(91, 'Gabriel Crandall', 2015, '1214', '1 - 2 Years of College', 'Lead Graphic/Web Designer', 0, 1, 0, 0, 1),
(92, 'John Gonzales', 2016, '1214', 'Industry Certification(s)', 'IT Admin', 0, 1, 0, 0, 1),
(93, 'Nicholas Butler', 2014, '1207', '1 - 2 Years of College', 'CTO', 0, 1, 0, 0, 1),
(94, 'Grace Lloyd', 2014, '1198', '1 - 2 Years of College', 'United Airlines - Cargo Agent', 0, 1, 0, 0, 1),
(95, 'Carl Marshall ', 2013, '1233', '3 - 4 Years of College', 'Navy Officer', 0, 1, 0, 0, 1),
(96, 'Justin Wood', 2010, '1214', 'No Post-Secondary Training', 'Network Administrator', 0, 1, 0, 0, 1),
(97, 'Ryan Benson', 2015, '1198', '1 - 2 Years of College', 'WordPress Support Analyst, Marketing Student Worker, Peer Mentor In A Living Learning Community', 0, 1, 0, 0, 1),
(98, 'Dain Chon', 2015, '1198', '1 - 2 Years of College', NULL, 0, 1, 0, 0, 1),
(99, 'Andy Dougherty', 2015, '1203', 'No Post-Secondary Training', '', 0, 1, 0, 0, 1),
(100, 'Valeria Vargas', 2015, '1216', '1 - 2 Years of College', '', 0, 1, 0, 0, 1),
(101, 'Danielle Saxton', 2008, '1198', 'Master\'s Degree', 'Academic Intervensionist', 0, 1, 0, 0, 1),
(102, 'Lowell Beaudoin', 2008, '1218', 'Associate Degree', 'Jr. Field Engineer ', 0, 1, 0, 0, 1),
(103, 'Kyle Resler', 2012, '1215', 'Bachelor\'s Degree', 'Production Manager', 0, 1, 0, 0, 1),
(104, 'James Canning', 2010, '1219', 'Industry Certification(s)', 'Nuclear Electrician', 0, 1, 0, 0, 1),
(105, 'Jordan Poundstone', 2013, '1218', '3 - 4 Years of College', '', 0, 1, 0, 0, 1),
(106, 'Katie Patterson', 2016, '1214', 'No Post-Secondary Training', 'CEO, Self Employed', 0, 1, 0, 0, 1),
(107, 'Kip Bouton', 2007, '1198', '3 - 4 Years of College', 'IT Engineer', 0, 1, 0, 0, 1),
(108, 'Hayden Bailey', 2014, '1198', 'Industry Certification(s)', 'Junior Developer', 0, 1, 0, 0, 1),
(109, 'Kimberly Stockton', 2015, '1198', 'Associate Degree', 'Writing Consultant And Computer Literacy Tutor For College Of Western Idaho', 0, 1, 0, 0, 1),
(110, 'Elizabet Kelly', 2014, '1226', '1 - 2 Years of College', '', 0, 1, 0, 0, 1),
(111, 'Sebastian Nielsen', 2012, '1198', '3 - 4 Years of College', 'Food Service Marketing ', 0, 1, 0, 0, 1),
(112, 'Scott Geleynse', 2008, '1228', 'Some Post-Graduate Education', 'Graduate Research Assistant', 0, 1, 0, 0, 1),
(113, 'Auston Robertson', 2013, '1198', '3 - 4 Years of College', '', 0, 1, 0, 0, 1),
(114, 'Sean Leonard', 2015, '1217', '1 - 2 Years of College', '', 0, 1, 0, 0, 1),
(115, 'Jake Carns', 2013, '1214', '3 - 4 Years of College', 'Full Stack Web Developer And Network Administrator', 0, 1, 0, 0, 1),
(116, 'Robyn Re', 2015, '1198', 'No Post-Secondary Training', 'Server', 0, 1, 0, 0, 1),
(117, 'Gordon Shields', 2015, '1198', '1 - 2 Years of College', 'Computer Support Specialist', 0, 1, 0, 0, 1),
(118, 'Matthew Marchal', 2016, '1214', 'No Post-Secondary Training', 'Developer/Web Designer', 0, 1, 0, 0, 1),
(119, 'Kameron Erb ', 2016, '1198', 'No Post-Secondary Training', '', 0, 1, 0, 0, 1),
(120, 'Taylor SaBell', 2014, '1198', 'No Post-Secondary Training', 'Software Developer', 0, 1, 0, 0, 1),
(121, 'Nicholas Hedges', 2016, '1212', 'Industry Certification(s)', '', 0, 1, 0, 0, 1),
(122, 'Ramona Bodley ', 2013, '1209', '1 - 2 Years of College', 'Naval Aviation Technician ', 0, 1, 0, 0, 1),
(123, 'Samuel McMurdie', 2014, '1198', 'Associate Degree', 'Delivery Driver - Napa Auto Parts', 0, 1, 0, 0, 1),
(124, 'Taylor Jordan', 2009, '1198', 'Bachelor\'s Degree', 'Data Entry', 0, 1, 0, 0, 1),
(125, 'Bailey Croft', 2011, '1218', 'Industry Certification(s)', 'Peer Support Specialist', 0, 1, 0, 0, 1),
(126, 'Ben Harris', 2016, '1198', 'Post-Secondary Certificate', '', 0, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `JobCategories`
--

CREATE TABLE `JobCategories` (
  `1` varchar(100) NOT NULL,
  `2` varchar(100) NOT NULL,
  `3` varchar(100) NOT NULL,
  `4` varchar(100) NOT NULL,
  `5` varchar(100) NOT NULL,
  `6` varchar(100) NOT NULL,
  `7` varchar(100) NOT NULL,
  `8` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `JobCategories`
--

INSERT INTO `JobCategories` (`1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`) VALUES
('Web & Media Design', 'Computer Science & Data', 'Network Systems & Support', 'Electronics & Microcontrollers', 'Electronics & Microcontrollers/Web & Media Design', 'Web & Media Design/Computer Science & Data', 'Computer Science & Data/Network Systems & Support', 'Network Systems & Support/Electronics & Microcontrollers');

-- --------------------------------------------------------

--
-- Table structure for table `JobList`
--

CREATE TABLE `JobList` (
  `ID` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `EdLevel` int(11) NOT NULL,
  `Category` int(11) NOT NULL,
  `Salary` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `MapLocation`
--

CREATE TABLE `MapLocation` (
  `ID` int(11) NOT NULL,
  `Longitude` double NOT NULL,
  `Latitude` double NOT NULL,
  `City` varchar(75) NOT NULL,
  `State` varchar(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MapLocation`
--

INSERT INTO `MapLocation` (`ID`, `Longitude`, `Latitude`, `City`, `State`) VALUES
(1198, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1199, -111.0429339, 45.6769979, 'Bozeman', 'MT'),
(1200, -116.6873596, 43.6629384, 'Caldwell', 'ID'),
(1201, -71.1097335, 42.3736158, 'Cambridge', 'MA'),
(1202, -93.6091064, 41.6005448, 'Des Moines', 'IA'),
(1203, -116.3540138, 43.6954424, 'Eagle', 'ID'),
(1204, -105.2210997, 39.755543, 'Golden', 'CO'),
(1205, -116.9337599, 43.6176584, 'Homedale', 'ID'),
(1247, -111.5583742, 43.7508332, 'Madison', 'ID'),
(1207, -116.4201223, 43.4918307, 'Kuna', 'ID'),
(1208, -111.8507662, 40.3916172, 'Lehi', 'UT'),
(1209, -119.7829107, 36.3007835, 'Lemoore', 'CA'),
(1210, -117.0011889, 46.4004089, 'Lewiston', 'ID'),
(1211, -105.0166498, 39.613321, 'Littleton', 'CO'),
(1212, -111.8338359, 41.7369803, 'Logan', 'UT'),
(1213, -118.2436849, 34.0522342, 'Los Angeles', 'CA'),
(1214, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1215, -89.6384532, 42.6011194, 'Monroe', 'WI'),
(1216, -117.2296717, 33.9424658, 'Moreno Valley', 'CA'),
(1217, -117.0001651, 46.7323875, 'Moscow', 'ID'),
(1218, -116.5634624, 43.5407172, 'Nampa', 'ID'),
(1219, -76.4730122, 37.0870821, 'Newport News', 'VA'),
(1220, -76.2858726, 36.8507689, 'Norfolk', 'Vi'),
(1221, -87.2169149, 30.421309, 'Pensacola', 'FL'),
(1222, -75.1652215, 39.9525839, 'Philadelphia', 'PA'),
(1223, -112.0740373, 33.4483771, 'Phoenix', 'AZ'),
(1224, -79.9958864, 40.4406248, 'Pittsburgh', 'PA'),
(1225, -122.6764816, 45.5230622, 'Portland', 'OR'),
(1226, -112.4685025, 34.5400242, 'Prescott', 'AZ'),
(1227, -111.6585337, 40.2338438, 'Provo', 'UT'),
(1228, -117.1817377, 46.7297771, 'Pullman', 'WA'),
(1229, -77.6109219, 43.16103, 'Rochester', 'NY'),
(1230, -71.1270268, 42.2832142, 'Roslindale', 'MA'),
(1231, -121.4943996, 38.5815719, 'Sacramento', 'CA'),
(1232, -111.8910474, 40.7607793, 'Salt Lake City', 'UT'),
(1233, 129.7151101, 33.1799153, 'Sasebo', 'Ja'),
(1234, -111.9260519, 33.4941704, 'Scottsdale', 'AZ'),
(1235, -122.3320708, 47.6062095, 'Seattle', 'WA'),
(1236, -116.4934631, 43.6921071, 'Star', 'ID'),
(1237, -84.2807329, 30.4382559, 'Tallahassee', 'FL'),
(1238, -114.4608711, 42.5629668, 'Twin Falls', 'ID'),
(1239, -117.0876629, 46.5393291, 'Uniontown', 'WA'),
(1267, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1248, -81.655651, 30.3321838, 'Jacksonville', 'FL'),
(1264, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1263, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1262, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1256, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1257, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1266, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1259, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1260, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1265, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1268, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1269, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1270, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1271, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1272, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1273, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1274, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1275, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1276, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1277, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1278, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1279, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1280, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1281, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1282, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1283, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1284, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1285, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1286, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1287, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1288, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1289, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1290, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1291, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1292, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1293, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1294, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1295, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1296, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1297, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1298, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1299, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1300, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1301, -116.3915131, 43.6121087, 'Meridian', 'ID'),
(1302, -116.2146068, 43.6187102, 'Boise', 'ID'),
(1303, -95.9979883, 41.2523634, 'Omaha', 'NE'),
(1304, -122.403137, 37.7734189, 'test', 'te');

-- --------------------------------------------------------

--
-- Table structure for table `UpdatedAlumni`
--

CREATE TABLE `UpdatedAlumni` (
  `ID` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `GradYear` int(4) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Education` varchar(50) NOT NULL,
  `Job` varchar(150) DEFAULT NULL,
  `Salary` int(11) DEFAULT NULL,
  `Verified` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `VerifiedEmail`
--

CREATE TABLE `VerifiedEmail` (
  `Email` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `VerifiedEmail`
--

INSERT INTO `VerifiedEmail` (`Email`) VALUES
('braydon.davis@mtchs.org');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Alumni`
--
ALTER TABLE `Alumni`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `JobList`
--
ALTER TABLE `JobList`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `MapLocation`
--
ALTER TABLE `MapLocation`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UpdatedAlumni`
--
ALTER TABLE `UpdatedAlumni`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `VerifiedEmail`
--
ALTER TABLE `VerifiedEmail`
  ADD PRIMARY KEY (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Alumni`
--
ALTER TABLE `Alumni`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;
--
-- AUTO_INCREMENT for table `JobList`
--
ALTER TABLE `JobList`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `MapLocation`
--
ALTER TABLE `MapLocation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1305;
--
-- AUTO_INCREMENT for table `UpdatedAlumni`
--
ALTER TABLE `UpdatedAlumni`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
