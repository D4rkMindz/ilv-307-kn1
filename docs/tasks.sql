/*
SQLyog Community v12.4.3 (64 bit)
MySQL - 5.7.19 : Database - ionic
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Data for the table `tasks` */

insert  into `tasks`(`id`,`user_id`,`status_id`,`title`,`description`,`due_date`,`created`,`created_by`,`modified`,`modified_by`,`deleted`,`deleted_by`,`deleted_at`,`resolved`,`resolved_by`) values
(1,2,1,'Test Task','Ein neuer Task','2017-09-22 09:48:04','2017-09-21 09:48:09',1,NULL,NULL,0,NULL,NULL,NULL,NULL),
(1,2,2,'Test Task1','Ein neuer Task','2017-09-22 09:48:04','2017-09-21 09:48:09',1,NULL,NULL,0,NULL,NULL,NULL,NULL),
(1,2,3,'Test Task2','Ein neuer Task','2017-09-22 09:48:04','2017-09-21 09:48:09',1,NULL,NULL,0,NULL,NULL,NULL,NULL),
(1,2,4,'Test Task3','Ein neuer Task','2017-09-22 09:48:04','2017-09-21 09:48:09',1,NULL,NULL,0,NULL,NULL,NULL,NULL),
(1,2,5,'Test Task4','Ein neuer Task','2017-09-22 09:48:04','2017-09-21 09:48:09',1,NULL,NULL,0,NULL,NULL,NULL,NULL),
(1,2,4,'Test Task5','Ein neuer Task','2017-09-22 09:48:04','2017-09-21 09:48:09',1,NULL,NULL,0,NULL,NULL,NULL,NULL),
(1,2,3,'Test Task6','Ein neuer Task','2017-09-22 09:48:04','2017-09-21 09:48:09',1,NULL,NULL,0,NULL,NULL,NULL,NULL),
(1,2,2,'Test Task7','Ein neuer Task','2017-09-22 09:48:04','2017-09-21 09:48:09',1,NULL,NULL,0,NULL,NULL,NULL,NULL),
(1,2,1,'Test Task8','Ein neuer Task','2017-09-22 09:48:04','2017-09-21 09:48:09',1,NULL,NULL,0,NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
