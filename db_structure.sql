/*
SQLyog Ultimate v9.02 
MySQL - 5.5.8 : Database - adtaiesec
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`adtaiesec` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `adtaiesec`;

/*Table structure for table `adt_icx_gcdp` */

CREATE TABLE `adt_icx_gcdp` (
  `id` varchar(30) NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '  ',
  `formMAId` varchar(25) DEFAULT ' ',
  `formMAName` varchar(200) DEFAULT ' ',
  `type` varchar(45) DEFAULT ' ',
  `status` varchar(45) DEFAULT ' ',
  `dtRA` date DEFAULT NULL,
  `dtMA` date DEFAULT NULL,
  `dtRE` date DEFAULT NULL,
  `dtEND` date DEFAULT NULL,
  `contract` varchar(3) DEFAULT ' ',
  `san` varchar(3) DEFAULT ' ',
  `can` varchar(3) DEFAULT ' ',
  `rne` varchar(3) DEFAULT ' ',
  `tr_checklist` varchar(3) DEFAULT NULL,
  `fu_1st` varchar(3) DEFAULT ' ',
  `fu_3rd` varchar(3) DEFAULT NULL,
  `visita_fechamento` varchar(3) DEFAULT ' ',
  `clID` int(11) DEFAULT NULL,
  `periodId` int(11) NOT NULL,
  `formId` int(30) DEFAULT NULL,
  `version` int(11) DEFAULT '0',
  `comment_contract` varchar(200) DEFAULT NULL,
  `comment_san` varchar(200) DEFAULT NULL,
  `comment_can` varchar(200) DEFAULT NULL,
  `comment_rne` varchar(200) DEFAULT NULL,
  `comment_tr_checklist` varchar(200) DEFAULT NULL,
  `comment_fu_1st` varchar(200) DEFAULT NULL,
  `comment_fu_3rd` varchar(200) DEFAULT NULL,
  `comment_visita_fechamento` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`,`periodId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='	';

/*Table structure for table `adt_icx_gip` */

CREATE TABLE `adt_icx_gip` (
  `id` varchar(30) NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '  ',
  `formMAId` varchar(25) DEFAULT ' ',
  `formMAName` varchar(200) DEFAULT ' ',
  `type` varchar(45) DEFAULT ' ',
  `status` varchar(45) DEFAULT ' ',
  `dtRA` date DEFAULT NULL,
  `dtMA` date DEFAULT NULL,
  `dtRE` date DEFAULT NULL,
  `dtEND` date DEFAULT NULL,
  `contract` varchar(3) DEFAULT ' ',
  `san` varchar(3) DEFAULT ' ',
  `can` varchar(3) DEFAULT ' ',
  `rne` varchar(3) DEFAULT ' ',
  `tr_checklist` varchar(3) DEFAULT ' ',
  `fu_1st_week` varchar(3) DEFAULT ' ',
  `fu_1st_month` varchar(3) DEFAULT ' ',
  `fu_plus_45` varchar(3) DEFAULT ' ',
  `fu_plus_90` varchar(3) DEFAULT ' ',
  `fu_plus_135` varchar(3) DEFAULT ' ',
  `fu_plus_180` varchar(3) DEFAULT ' ',
  `fu_plus_225` varchar(3) DEFAULT ' ',
  `fu_plus_270` varchar(3) DEFAULT ' ',
  `fu_plus_315` varchar(3) DEFAULT ' ',
  `fu_plus_360` varchar(3) DEFAULT ' ',
  `visita_fechamento` varchar(3) DEFAULT ' ',
  `clID` int(11) DEFAULT NULL,
  `periodId` int(11) NOT NULL,
  `formId` int(30) DEFAULT NULL,
  `version` int(11) DEFAULT '0',
  `comment_contract` varchar(200) DEFAULT NULL,
  `comment_san` varchar(200) DEFAULT NULL,
  `comment_can` varchar(200) DEFAULT NULL,
  `comment_rne` varchar(200) DEFAULT NULL,
  `comment_tr_checklist` varchar(200) DEFAULT NULL,
  `comment_fu_1st_week` varchar(200) DEFAULT NULL,
  `comment_fu_1st_month` varchar(200) DEFAULT NULL,
  `comment_fu_plus_45` varchar(200) DEFAULT NULL,
  `comment_fu_plus_90` varchar(200) DEFAULT NULL,
  `comment_fu_plus_135` varchar(200) DEFAULT NULL,
  `comment_fu_plus_180` varchar(200) DEFAULT NULL,
  `comment_fu_plus_225` varchar(200) DEFAULT NULL,
  `comment_fu_plus_270` varchar(200) DEFAULT NULL,
  `comment_fu_plus_315` varchar(200) DEFAULT NULL,
  `comment_fu_plus_360` varchar(200) DEFAULT NULL,
  `comment_visita_fechamento` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`,`periodId`),
  KEY `formMA_idx` (`formMAId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='	';

/*Table structure for table `adt_ogx_gcdp` */

CREATE TABLE `adt_ogx_gcdp` (
  `id` varchar(30) NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '  ',
  `formMAId` varchar(25) DEFAULT ' ',
  `formMAName` varchar(200) DEFAULT ' ',
  `type` varchar(45) DEFAULT ' ',
  `status` varchar(45) DEFAULT ' ',
  `dtRA` date DEFAULT NULL,
  `dtMA` date DEFAULT NULL,
  `dtRE` date DEFAULT NULL,
  `dtEND` date DEFAULT NULL,
  `contract` varchar(3) DEFAULT ' ',
  `san` varchar(3) DEFAULT ' ',
  `can` varchar(3) DEFAULT ' ',
  `ep_checklist` varchar(3) DEFAULT ' ',
  `fu_1st` varchar(3) DEFAULT ' ',
  `fu_3rd` varchar(3) DEFAULT ' ',
  `clID` int(11) DEFAULT NULL,
  `periodId` int(11) NOT NULL,
  `formId` int(30) DEFAULT NULL,
  `version` int(11) DEFAULT '0',
  `comment_contract` varchar(200) DEFAULT ' ',
  `comment_san` varchar(200) DEFAULT ' ',
  `comment_can` varchar(200) DEFAULT ' ',
  `comment_rne` varchar(200) DEFAULT ' ',
  `comment_ep_checklist` varchar(200) DEFAULT ' ',
  `comment_fu_1st` varchar(200) DEFAULT ' ',
  `comment_fu_3rd` varchar(200) DEFAULT ' ',
  PRIMARY KEY (`id`,`periodId`),
  KEY `formMA_idx` (`formMAId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='	';

/*Table structure for table `adt_ogx_gip` */

CREATE TABLE `adt_ogx_gip` (
  `id` varchar(30) NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '  ',
  `formMAId` varchar(25) DEFAULT ' ',
  `formMAName` varchar(200) DEFAULT ' ',
  `type` varchar(45) DEFAULT ' ',
  `status` varchar(45) DEFAULT ' ',
  `dtRA` date DEFAULT NULL,
  `dtMA` date DEFAULT NULL,
  `dtRE` date DEFAULT NULL,
  `dtEND` date DEFAULT NULL,
  `contract` varchar(3) DEFAULT ' ',
  `san` varchar(3) DEFAULT ' ',
  `can` varchar(3) DEFAULT ' ',
  `ep_checklist` varchar(3) DEFAULT NULL,
  `fu_1st_week` varchar(3) DEFAULT ' ',
  `fu_1st_month` varchar(3) DEFAULT NULL,
  `fu_plus_45` varchar(3) DEFAULT NULL,
  `fu_plus_90` varchar(3) DEFAULT NULL,
  `fu_plus_135` varchar(3) DEFAULT NULL,
  `fu_plus_180` varchar(3) DEFAULT NULL,
  `fu_plus_225` varchar(3) DEFAULT NULL,
  `fu_plus_270` varchar(3) DEFAULT NULL,
  `fu_plus_315` varchar(3) DEFAULT NULL,
  `fu_plus_360` varchar(3) DEFAULT NULL,
  `clID` int(11) DEFAULT NULL,
  `periodId` int(11) NOT NULL,
  `formId` int(30) DEFAULT NULL,
  `version` int(11) DEFAULT '0',
  `comment_contract` varchar(200) DEFAULT NULL,
  `comment_san` varchar(200) DEFAULT NULL,
  `comment_can` varchar(200) DEFAULT NULL,
  `comment_ep_checklist` varchar(200) DEFAULT NULL,
  `comment_fu_1st_week` varchar(200) DEFAULT NULL,
  `comment_fu_1st_month` varchar(200) DEFAULT NULL,
  `comment_fu_plus_45` varchar(200) DEFAULT NULL,
  `comment_fu_plus_90` varchar(200) DEFAULT NULL,
  `comment_fu_plus_135` varchar(200) DEFAULT NULL,
  `comment_fu_plus_180` varchar(200) DEFAULT NULL,
  `comment_fu_plus_225` varchar(200) DEFAULT NULL,
  `comment_fu_plus_270` varchar(200) DEFAULT NULL,
  `comment_fu_plus_315` varchar(200) DEFAULT NULL,
  `comment_fu_plus_360` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`,`periodId`),
  KEY `formMA_idx` (`formMAId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='	';

/*Table structure for table `cl` */

CREATE TABLE `cl` (
  `clID` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`clID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `conclusao` */

CREATE TABLE `conclusao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clId` int(11) DEFAULT NULL,
  `periodId` int(11) DEFAULT NULL,
  `conclusao` varchar(2000) DEFAULT NULL,
  `melhoria` varchar(2000) DEFAULT NULL,
  `atencao` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

/*Table structure for table `doc_status` */

CREATE TABLE `doc_status` (
  `id` int(11) NOT NULL,
  `color` varchar(10) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `doc_type` */

CREATE TABLE `doc_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Table structure for table `form_history` */

CREATE TABLE `form_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form` varchar(30) DEFAULT NULL,
  `doc` varchar(50) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `periodId` int(11) DEFAULT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57830 DEFAULT CHARSET=utf8;

/*Table structure for table `legal` */

CREATE TABLE `legal` (
  `clID` int(11) DEFAULT NULL,
  `legalID` int(11) DEFAULT NULL,
  `status` varchar(3) DEFAULT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `periodId` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `legal_history` */

CREATE TABLE `legal_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `legalId` int(30) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `clId` int(11) DEFAULT NULL,
  `periodId` int(11) DEFAULT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8050 DEFAULT CHARSET=utf8;

/*Table structure for table `legal_item` */

CREATE TABLE `legal_item` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='	';

/*Table structure for table `login` */

CREATE TABLE `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `clId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=817 DEFAULT CHARSET=utf8;

/*Table structure for table `login_history` */

CREATE TABLE `login_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loginId` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11076 DEFAULT CHARSET=utf8;

/*Table structure for table `period` */

CREATE TABLE `period` (
  `id` int(11) NOT NULL,
  `period` varchar(10) NOT NULL,
  `from` date NOT NULL,
  `to` date DEFAULT NULL,
  `isMonthly` int(11) DEFAULT '1',
  `active` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `term` */

CREATE TABLE `term` (
  `name` varchar(200) NOT NULL,
  `status` varchar(3) DEFAULT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clId` int(3) DEFAULT NULL,
  `periodId` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20705 DEFAULT CHARSET=utf8;

/*Table structure for table `term_history` */

CREATE TABLE `term_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `clId` int(11) DEFAULT NULL,
  `periodId` int(11) DEFAULT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11010 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
