-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 20, 2010 at 10:56 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pcrs`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_levels`
--

CREATE TABLE IF NOT EXISTS `access_levels` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `description` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `access_levels`
--

INSERT INTO `access_levels` (`id`, `description`) VALUES
(1, 'Customer'),
(2, 'Employee'),
(3, 'Sales'),
(4, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `business_customers`
--

CREATE TABLE IF NOT EXISTS `business_customers` (
  `customer_id` int(8) unsigned NOT NULL,
  `business_name` varchar(50) NOT NULL,
  `contact_title` char(20) NOT NULL,
  `url` char(20) DEFAULT NULL,
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `business_customers`
--

INSERT INTO `business_customers` (`customer_id`, `business_name`, `contact_title`, `url`) VALUES
(1, 'Google Inc.', 'Liason', 'http://google.com');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` char(15) NOT NULL,
  `last_name` char(20) NOT NULL,
  `email` char(30) NOT NULL,
  `street` varchar(80) NOT NULL,
  `suite` char(8) DEFAULT NULL,
  `city` char(15) NOT NULL,
  `state` char(2) NOT NULL,
  `zipcode` char(6) NOT NULL,
  `type` set('b','i') NOT NULL,
  `status` set('a','i') NOT NULL,
  `last_access` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` char(12) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `street`, `suite`, `city`, `state`, `zipcode`, `type`, `status`, `last_access`, `password`) VALUES
(1, 'John', 'Hancock', 'j.hancock@google.com', '100 North Ave', NULL, 'Chicago', 'IL', '60605', 'b', 'a', '2010-04-20 18:35:10', 'password');

-- --------------------------------------------------------

--
-- Table structure for table `customer_complaints`
--

CREATE TABLE IF NOT EXISTS `customer_complaints` (
  `id` int(8) unsigned NOT NULL,
  `customer_id` int(8) unsigned NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(100) NOT NULL,
  `details` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_complaints`
--


-- --------------------------------------------------------

--
-- Table structure for table `customer_discounts`
--

CREATE TABLE IF NOT EXISTS `customer_discounts` (
  `discount_id` int(8) unsigned NOT NULL,
  `customer_id` int(8) unsigned NOT NULL,
  `employee_id` int(8) unsigned NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`discount_id`,`customer_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_discounts`
--


-- --------------------------------------------------------

--
-- Table structure for table `customer_leads`
--

CREATE TABLE IF NOT EXISTS `customer_leads` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(8) unsigned NOT NULL,
  `customer_id` int(8) unsigned NOT NULL,
  `lead_id` int(8) unsigned NOT NULL,
  `rank` int(1) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `lead_id` (`lead_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `customer_leads`
--


-- --------------------------------------------------------

--
-- Table structure for table `customer_orders`
--

CREATE TABLE IF NOT EXISTS `customer_orders` (
  `id` int(8) unsigned NOT NULL,
  `customer_id` int(8) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `service_id` int(8) unsigned NOT NULL,
  `details` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `service_id` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_orders`
--


-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE IF NOT EXISTS `discounts` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `value` int(3) unsigned NOT NULL,
  `employee_id` int(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `discounts`
--


-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` char(15) NOT NULL,
  `last_name` char(20) NOT NULL,
  `email` char(30) NOT NULL,
  `street` varchar(80) NOT NULL,
  `suite` char(8) DEFAULT NULL,
  `city` char(15) NOT NULL,
  `state` char(2) NOT NULL,
  `zipcode` char(6) NOT NULL,
  `last_access` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` char(12) NOT NULL,
  `access_level` int(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `access_level` (`access_level`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `first_name`, `last_name`, `email`, `street`, `suite`, `city`, `state`, `zipcode`, `last_access`, `password`, `access_level`) VALUES
(1, 'Admini', 'Strator', 'admin@pcrs.com', '3420 S Cottage Grove', '1105', 'Chicago', 'IL', '60616', '2010-04-20 20:28:31', 'password4', 4),
(2, 'Sally', 'Pearson', 'pearson@pcrs.com', '232 Fullerton', '112B', 'Chicago', 'IL', '60632', '2010-04-19 11:20:18', 'password3', 3);

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE IF NOT EXISTS `leads` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `description` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `leads`
--


-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `description` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `services`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `business_customers`
--
ALTER TABLE `business_customers`
  ADD CONSTRAINT `business_customers_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_complaints`
--
ALTER TABLE `customer_complaints`
  ADD CONSTRAINT `customer_complaints_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `customer_discounts`
--
ALTER TABLE `customer_discounts`
  ADD CONSTRAINT `customer_discounts_ibfk_1` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`),
  ADD CONSTRAINT `customer_discounts_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `customer_discounts_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `customer_leads`
--
ALTER TABLE `customer_leads`
  ADD CONSTRAINT `customer_leads_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`),
  ADD CONSTRAINT `customer_leads_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `customer_leads_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `customer_orders`
--
ALTER TABLE `customer_orders`
  ADD CONSTRAINT `customer_orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `customer_orders_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`access_level`) REFERENCES `access_levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
