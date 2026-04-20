-- Adminer 4.8.1 MySQL 8.0.29-0ubuntu0.20.04.3 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `budget_layers` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `budget_layers`;

DROP TABLE IF EXISTS `cms_class`;
CREATE TABLE `cms_class` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `date` varchar(40) NOT NULL,
  `time` varchar(40) NOT NULL,
  `order1` varchar(30) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

INSERT INTO `cms_class` (`id`, `class`, `date`, `time`, `order1`) VALUES
(46,	'Travel_Expenses_for_Budget',	'2022-07-09',	'00:33:56',	'1'),
(45,	'Home_Expenses_for_Budget',	'2022-07-09',	'00:30:19',	'1'),
(47,	'Office_Expenses_for_Budget',	'2022-07-09',	'00:34:13',	'1'),
(49,	'Layout',	'2022-07-09',	'12:38:59',	'1'),
(51,	'Layout_2',	'2022-07-09',	'19:08:44',	'1');

DROP TABLE IF EXISTS `cms_config`;
CREATE TABLE `cms_config` (
  `id` varchar(10) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `emailadmin` varchar(255) NOT NULL DEFAULT '',
  `pause` varchar(255) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

INSERT INTO `cms_config` (`id`, `title`, `emailadmin`, `pause`) VALUES
('1',	'Demo - Budget-Layers',	'quartzcms@gmail.com',	'0');

DROP TABLE IF EXISTS `cms_container`;
CREATE TABLE `cms_container` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `id_module` int NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

INSERT INTO `cms_container` (`id`, `name`, `id_module`) VALUES
(10,	'Budget',	62),
(1,	'index',	59);

DROP TABLE IF EXISTS `cms_container_tags`;
CREATE TABLE `cms_container_tags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_index` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `tag` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `order1` varchar(255) NOT NULL,
  `published` int NOT NULL,
  `sub_container` int NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

INSERT INTO `cms_container_tags` (`id`, `id_index`, `name`, `tag`, `order1`, `published`, `sub_container`) VALUES
(60,	10,	'Home',	'Home',	'0',	1,	0),
(34,	1,	'index',	'index',	'',	1,	0),
(35,	1,	'all',	'all',	'',	1,	0),
(62,	10,	'Travel',	'Travel',	'0',	1,	0),
(61,	10,	'Office',	'Office',	'0',	1,	0);

DROP TABLE IF EXISTS `cms_expenses`;
CREATE TABLE `cms_expenses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `class` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `modules` longtext NOT NULL,
  `frequence` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `tag` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `cost` int NOT NULL,
  `order1` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `publish` int NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

INSERT INTO `cms_expenses` (`id`, `title`, `username`, `class`, `modules`, `frequence`, `tag`, `date`, `time`, `cost`, `order1`, `content`, `publish`) VALUES
(74,	'Telephone',	'budgetlayers',	'0',	'{expense{show_title:show_description:show_username:show_time:show_date}}',	'monthly',	'Home:Travel:Office',	'2022-07-10',	'00:31:34',	35,	'1',	'<p>The phone bill paid every month</p>\r\n',	1),
(75,	'Internet',	'budgetlayers',	'0',	'{expense{show_title:show_description:show_username:show_time:show_date}}',	'monthly',	'Home:Travel:Office',	'2022-07-09',	'00:32:41',	95,	'1',	'<p>The internet bill paid every month</p>\r\n',	1),
(76,	'Electricity',	'budgetlayers',	'0',	'{expense{show_title:show_description:show_username:show_time:show_date}}',	'monthly',	'Home:Travel:Office',	'2022-07-09',	'00:33:12',	120,	'1',	'<p>Electricity bill paid every month</p>\r\n',	1),
(77,	'Car',	'budgetlayers',	'Travel_Expenses_for_Budget',	'{expense{show_title:show_description:show_username:show_time:show_date}}',	'monthly',	'',	'2022-07-09',	'00:36:17',	100,	'1',	'Car gas per month',	1),
(78,	'Food',	'budgetlayers',	'Home_Expenses_for_Budget',	'{expense{show_title:show_description:show_username:show_time:show_date}}',	'monthly',	'',	'2022-07-09',	'00:37:36',	300,	'1',	'<p>Grocery store food needed per week</p>\r\n',	1),
(79,	'Appliances',	'budgetlayers',	'Office_Expenses_for_Budget',	'{expense{show_title:show_description:show_username:show_time:show_date}}',	'yearly',	'',	'2022-07-09',	'00:38:17',	200,	'1',	'<p>Appliance to pay per year for the office</p>\r\n',	1),
(90,	'Plane',	'admin',	'Travel_Expenses_for_Budget',	'{expense{show_title:show_description:show_username:show_time:show_date}}',	'monthly',	'',	'2022-07-09',	'18:28:57',	1000,	'1',	'<p>Ticket for plane travel</p>\r\n',	1);

DROP TABLE IF EXISTS `cms_modules`;
CREATE TABLE `cms_modules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `class` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `modules` longtext NOT NULL,
  `order1` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `tag` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `published` varchar(255) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

INSERT INTO `cms_modules` (`id`, `title`, `class`, `modules`, `order1`, `date`, `time`, `tag`, `username`, `published`) VALUES
(127,	'Home Expenses for Budget',	'Home_Expenses_for_Budget',	'{type_expense{class{show_title}:expense{show_title:show_description:show_username:show_time:show_date}}}',	'1',	'2022-07-09',	'00:30:19',	'Home',	'budgetlayers',	'1'),
(128,	'Travel Expenses for Budget',	'Travel_Expenses_for_Budget',	'{type_expense{class{show_title}:expense{show_title:show_description:show_username:show_time:show_date}}}',	'1',	'2022-07-09',	'00:33:56',	'Travel',	'budgetlayers',	'1'),
(129,	'Office Expenses for Budget',	'Office_Expenses_for_Budget',	'{type_expense{class{show_title}:expense{show_title:show_description:show_username:show_time:show_date}}}',	'1',	'2022-07-09',	'00:34:13',	'Office',	'budgetlayers',	'1'),
(62,	'Budget',	'Budget',	'{type_container{class{0}}}',	'1',	'2022-07-10',	'17:21:09',	'index:all',	'budgetlayers',	'1'),
(132,	'Layout',	'Layout',	'{type_plan{class{show_title}:plan{show_title:show_description:show_username:show_time:show_date}}}',	'1',	'2022-07-10',	'17:21:19',	'Home:Travel:Office:all',	'budgetlayers',	'1'),
(134,	'Layout 2',	'Layout_2',	'{type_plan{class{show_title}:plan{show_title:show_description:show_username:show_time:show_date}}}',	'1',	'2022-07-09',	'19:08:44',	'Home',	'admin',	'1');

DROP TABLE IF EXISTS `cms_plans`;
CREATE TABLE `cms_plans` (
  `module_id` int NOT NULL AUTO_INCREMENT,
  `pay` longtext NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

INSERT INTO `cms_plans` (`module_id`, `pay`) VALUES
(132,	'[{\"amount\":\"60000\",\"frequence\":\"yearly\"},{\"amount\":\"95\",\"frequence\":\"monthly\"}]'),
(134,	'[{\"amount\":\"10\",\"frequence\":\"weekly\"}]');

DROP TABLE IF EXISTS `cms_plugins`;
CREATE TABLE `cms_plugins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `default_tag` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `content` longtext NOT NULL,
  `publish` int NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

INSERT INTO `cms_plugins` (`id`, `title`, `date`, `time`, `default_tag`, `content`, `publish`) VALUES
(1,	'plan',	'0000-00-00',	'00:00:00',	'list_plan',	'plan',	1);

DROP TABLE IF EXISTS `cms_template`;
CREATE TABLE `cms_template` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `active` int NOT NULL,
  `admin` int NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

INSERT INTO `cms_template` (`id`, `title`, `description`, `date`, `time`, `active`, `admin`) VALUES
(6,	'default',	'The default template',	'2017-05-27',	'03:48:32',	1,	0),
(5,	'admin',	'The admin template',	'0000-00-00',	'00:00:00',	1,	1);

DROP TABLE IF EXISTS `cms_users`;
CREATE TABLE `cms_users` (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `idm` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `picture` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `level` char(1) NOT NULL DEFAULT '3',
  `gender` varchar(255) NOT NULL DEFAULT '0',
  `ip` varchar(25) NOT NULL DEFAULT '---',
  `city` varchar(255) NOT NULL DEFAULT '--',
  `first_name` varchar(255) NOT NULL DEFAULT '--',
  `last_name` varchar(255) NOT NULL DEFAULT '--',
  `age` varchar(255) NOT NULL DEFAULT '--',
  `about` longtext NOT NULL,
  `articles` varchar(255) NOT NULL DEFAULT '0',
  `country` varchar(255) NOT NULL DEFAULT '--',
  `blocked` char(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

INSERT INTO `cms_users` (`id`, `idm`, `username`, `password`, `email`, `picture`, `level`, `gender`, `ip`, `city`, `first_name`, `last_name`, `age`, `about`, `articles`, `country`, `blocked`) VALUES
(1,	'0',	'admin',	'e10adc3949ba59abbe56e057f20f883e',	'quartzcms@gmail.com',	'000.jpg',	'1',	'1',	'24.203.223.100',	'-',	'-',	'-',	'-',	'-',	'0',	'-',	'0');

-- 2022-07-10 21:30:15
