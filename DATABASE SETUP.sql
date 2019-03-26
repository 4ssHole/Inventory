/*
SQLyog Community v13.1.2 (64 bit)
MySQL - 10.1.37-MariaDB : Database - main
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`main` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `main`;

/*Table structure for table `borrowed` */

DROP TABLE IF EXISTS `borrowed`;

CREATE TABLE `borrowed` (
  `borrowid` int(11) NOT NULL AUTO_INCREMENT,
  `itemcode` varchar(15) NOT NULL,
  `UserNumber` int(11) NOT NULL,
  `BorrowDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ReturnDate` datetime DEFAULT NULL,
  `remarks` text,
  `request` enum('pending','approved') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`borrowid`),
  KEY `Item` (`itemcode`),
  KEY `User` (`UserNumber`),
  CONSTRAINT `Item` FOREIGN KEY (`itemcode`) REFERENCES `items` (`itemcode`),
  CONSTRAINT `User` FOREIGN KEY (`UserNumber`) REFERENCES `users` (`UserNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `borrowed` */

insert  into `borrowed`(`borrowid`,`itemcode`,`UserNumber`,`BorrowDate`,`ReturnDate`,`remarks`,`request`) values 
(8,'shs12',1,'2019-03-26 14:44:13',NULL,NULL,'pending'),
(9,'new',1,'2019-03-26 14:50:39',NULL,NULL,'pending'),
(10,'new',1,'2019-03-26 14:50:39',NULL,NULL,'pending'),
(11,'new',1,'2019-03-26 14:50:39',NULL,NULL,'pending'),
(12,'new',1,'2019-03-26 14:50:39',NULL,NULL,'pending');

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `itemcode` varchar(15) NOT NULL,
  `Brand` varchar(15) DEFAULT NULL,
  `Model` varchar(15) DEFAULT NULL,
  `Price` varchar(15) DEFAULT '0',
  `Quantity` int(15) DEFAULT '0',
  `category` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`itemcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `items` */

insert  into `items`(`itemcode`,`Brand`,`Model`,`Price`,`Quantity`,`category`) values 
('agf','','','',0,'12'),
('dsafqwe123','','','',21,''),
('ewqeqqwe','','','',321,''),
('fdsahg','3235','','',3,'2'),
('new','Mexico',' ','545',50,'2'),
('qwd','','','',0,''),
('shs12','Mexico','f3','23',5000,'0'),
('testitem','t','','',80,'0');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `UserNumber` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(15) DEFAULT NULL,
  `Password` varchar(15) DEFAULT NULL,
  `Privilege` enum('admin','user') NOT NULL DEFAULT 'user',
  `FirstName` varchar(15) DEFAULT NULL,
  `LastName` varchar(15) DEFAULT NULL,
  `GradeLevel` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`UserNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`UserNumber`,`UserName`,`Password`,`Privilege`,`FirstName`,`LastName`,`GradeLevel`) values 
(1,'admin','admin','admin','Ass','Saa',NULL),
(2,'test','1','user','test','user',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
