-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: up_db
-- Generation Time: Jun 07, 2019 at 12:42 PM
-- Server version: 10.3.7-MariaDB-1:10.3.7+maria~jessie
-- PHP Version: 7.2.11-3+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `up_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`%` PROCEDURE `PROJECT_STATISTIC_REPORT` (IN `in_project_id` INT(10) UNSIGNED, IN `in_year` CHAR(4), IN `in_month` CHAR(2))  NO SQL
BEGIN

	SELECT SUM(`statistic_value`) AS statistic_value, SUM(`statistic_sent`) AS statistic_sent, SUM(`statistic_unsent`) AS statistic_unsent, SUM(`statistic_failure`) AS statistic_failure FROM `statistics` WHERE project_id = in_project_id AND statistic_month = in_month AND statistic_year = in_year GROUP BY statistic_month;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `UPDATE_DAILY_STATISTIC_DETAIL` (IN `in_project_id` INT(10) UNSIGNED, IN `in_date` CHAR(10) CHARSET utf8, IN `in_status` TINYINT(3) UNSIGNED)  NO SQL
BEGIN
	DECLARE result_in_day INT;
    SELECT COUNT(*) INTO result_in_day
    FROM  campaign_logs as CPL INNER JOIN campaigns as CP ON CPL.campaign_id = CP.campaign_id 
    WHERE DATE_FORMAT(CPL.campaign_log_created_at, '%Y-%m-%d') = in_date AND CP.project_id = in_project_id AND CPL.campaign_log_status = in_status
    GROUP BY CPL.campaign_log_status;
    IF(result_in_day IS NULL) THEN
    	SET result_in_day = 0;
    END IF;
    IF(in_status = 0) THEN
    	UPDATE statistics set `statistic_unsent` = result_in_day WHERE project_id = in_project_id and statistic_day = DAY(in_date) and statistic_month = MONTH(in_date) and statistic_year = YEAR(in_date);
    END IF;
    IF(in_status = 1) THEN
    	UPDATE statistics set `statistic_sent` = result_in_day WHERE project_id = in_project_id and statistic_day = DAY(in_date) and statistic_month = MONTH(in_date) and statistic_year = YEAR(in_date);
    END IF;
    IF(in_status = 2) THEN
    	UPDATE statistics set `statistic_failure` = result_in_day WHERE project_id = in_project_id and statistic_day = DAY(in_date) and statistic_month = MONTH(in_date) and statistic_year = YEAR(in_date);
    END IF;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `UPDATE_DAILY_STATISTIC_TOTAL` (IN `in_project_id` INT(10) UNSIGNED, IN `in_date` CHAR(10))  NO SQL
BEGIN
	DECLARE result_in_day INT;
    DECLARE check_exists_statistic INT;
	SELECT SUM(`action_value`) INTO result_in_day
    FROM actions
    WHERE project_id = in_project_id and DATE_FORMAT(`action_time`,'%Y-%m-%d') = in_date
    GROUP BY DAY(`action_time`);
    IF(result_in_day IS NULL) THEN
    	SET result_in_day = 0;
    END IF;
    SELECT statistic_id INTO check_exists_statistic FROM statistics WHERE project_id = in_project_id and statistic_day = DAY(in_date) and statistic_month = MONTH(in_date) and statistic_year = YEAR(in_date);
    IF(check_exists_statistic IS NULL) THEN
        INSERT INTO statistics(project_id, statistic_day, statistic_month, statistic_year, statistic_value) VALUES(in_project_id, DATE_FORMAT(in_date, '%d'), DATE_FORMAT(in_date, '%m'), DATE_FORMAT(in_date, '%Y'), result_in_day);
    ELSE
        UPDATE statistics set `statistic_value` = result_in_day WHERE project_id = in_project_id and statistic_day = DAY(in_date) and statistic_month = MONTH(in_date) and 	statistic_year = YEAR(in_date);
    END IF;
   
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `action_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã hành động',
  `project_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã dự án',
  `action_time` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian xảy ra',
  `action_value` int(10) UNSIGNED NOT NULL COMMENT 'Giá trị của hành động'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Quản lý hành động';

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `campaign_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã chiến dịch',
  `project_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã dự án',
  `campaign_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tên chiến dịch',
  `campaign_email_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Mã email đại diện gửi',
  `campaign_email_name` varchar(254) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Địa chỉ email đại diện gửi',
  `campaign_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tiêu đề chiến dịch',
  `campaign_content` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nội dung chiến dịch',
  `campaign_attach_file` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `campaign_schedule` datetime NOT NULL COMMENT 'Thời gian gửi',
  `campaign_status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Tình trạng',
  `campaign_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Chiến dịch';

-- --------------------------------------------------------

--
-- Table structure for table `campaign_logs`
--

CREATE TABLE `campaign_logs` (
  `campaign_log_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã nhật ký gửi email',
  `campaign_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã chiến dịch',
  `contact_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tên liên hệ muốn gửi email',
  `contact_email` varchar(254) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Địa chỉ email của liên hệ muốn gửi email',
  `contact_gender` tinyint(4) NOT NULL COMMENT 'Giới tính của liên hệ',
  `campaign_log_status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Trạng thái',
  `campaign_log_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã liên hệ',
  `customer_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã khách hàng',
  `contact_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tên liên hệ',
  `contact_email` varchar(254) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Địa chỉ email liên hệ',
  `contact_gender` tinyint(3) UNSIGNED NOT NULL COMMENT 'Giới tính'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liên hệ của khách hàng';

-- --------------------------------------------------------

--
-- Table structure for table `contact_groups`
--

CREATE TABLE `contact_groups` (
  `contact_group_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã nhóm liên hệ',
  `customer_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã khách hàng',
  `contact_group_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tên nhóm liên hệ',
  `contact_group_status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Tình trạng nhóm liên hệ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nhóm liên hệ';

-- --------------------------------------------------------

--
-- Table structure for table `contact_group_details`
--

CREATE TABLE `contact_group_details` (
  `contact_group_detail_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã chi tiết nhóm liên hệ',
  `contact_group_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã nhóm liên hệ',
  `contact_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã liên hệ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Chi tiết từng nhóm liên hệ';

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã khách hàng',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã người dùng',
  `customer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tên khách hàng',
  `customer_gender` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'Giới tính',
  `customer_email` varchar(254) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Email',
  `customer_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Số điện thoại',
  `customer_address` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Địa chỉ',
  `customer_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Khách hàng';

-- --------------------------------------------------------

--
-- Table structure for table `mailing_services`
--

CREATE TABLE `mailing_services` (
  `mailing_service_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã dịch vụ gửi mail',
  `mailing_service_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tên dịch vụ',
  `mailing_service_amount` int(10) UNSIGNED NOT NULL COMMENT 'Số lượng email được gửi trong tháng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Các gói dịch vụ gửi mail';

--
-- Dumping data for table `mailing_services`
--

INSERT INTO `mailing_services` (`mailing_service_id`, `mailing_service_name`, `mailing_service_amount`) VALUES
(1, 'Kim Cương - Diamond', 300000),
(2, 'Bạch Kim - Platinum', 150000),
(3, 'Vàng - Gold', 50000),
(4, 'Bạc - Silver', 10000),
(5, 'Khởi Đầu - Start', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã dự án',
  `customer_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã khách hàng',
  `project_type_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã loại dự án',
  `mailing_service_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã dịch vụ gửi mail',
  `contract_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Mã hợp đồng',
  `project_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tên dự án',
  `project_number_email_remaining` int(10) UNSIGNED NOT NULL COMMENT 'Số email còn lại của dự án theo tháng',
  `project_status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Tình trạng',
  `project_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Dự án';

-- --------------------------------------------------------

--
-- Table structure for table `project_types`
--

CREATE TABLE `project_types` (
  `project_type_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã loại dự án',
  `project_type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Loại dự án';

--
-- Dumping data for table `project_types`
--

INSERT INTO `project_types` (`project_type_id`, `project_type_name`) VALUES
(1, 'Đối tác bên ngoài'),
(2, 'Nội bộ công ty');

-- --------------------------------------------------------

--
-- Table structure for table `statistics`
--

CREATE TABLE `statistics` (
  `statistic_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã thống kê',
  `project_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã dự án',
  `statistic_year` char(4) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Năm thống kê',
  `statistic_month` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tháng thống kê',
  `statistic_day` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ngày thống kê',
  `statistic_value` int(10) UNSIGNED NOT NULL COMMENT 'Thống kê giá trị tổng',
  `statistic_sent` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Thống kê đã gửi',
  `statistic_unsent` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Thống kê chưa gửi',
  `statistic_failure` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Thống kê thất bại'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Thống kê theo dự án';

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `template_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã nội dung mẫu',
  `template_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tên nội dung mẫu',
  `template_content` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nội dung'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nội dung mẫu';

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`template_id`, `template_name`, `template_content`) VALUES
(1, 'Khuyến mãi sản phẩm 70%', '<!doctype html>\r\n<html>\r\n\r\n<head>\r\n  <meta charset=\"utf-8\">\r\n  <meta name=\"viewport\" content=\"width=device-width\">\r\n  <title>Black Friday Deal, 70% OFF for Website Builders, WordPress Plugin, UI Kits, Mockups, Fonts and more...</title>\r\n  <style>\r\n    html,\r\n    body {\r\n      margin: 0 !important;\r\n      padding: 0 !important;\r\n      background-color: #000000 !important;\r\n    }\r\n    @media screen and (max-width: 650px) {\r\n      table[width=\"600\"] {\r\n        width: 90% !important;\r\n      }\r\n      img[src=\"https://send.designmodo.com/upload/templates/template_5a0d9d1d6eb0f/background.gif\"] {\r\n        margin-bottom: 0px !important;\r\n      }\r\n      .title {\r\n        font-size: 32px !important;\r\n      }\r\n      .subtitle {\r\n        font-size: 24px !important;\r\n        line-height: 36px !important;\r\n      }\r\n      .header,\r\n      .footer,\r\n      .footer a {\r\n        line-height: 24px !important;\r\n        font-size: 14px !important;\r\n      }\r\n    }\r\n  </style>\r\n</head>\r\n\r\n<body bgColor=\"#000000\" style=\"background-color:#000000;\">\r\n  <table cellspacing=\"0\" cellpadding=\"0\" width=\"600\" align=\"center\" style=\"margin: 0 auto; background-color: #000000;\" bgcolor=\"#000000\">\r\n    <tbody>\r\n      <tr>\r\n        <td height=\"40\"></td>\r\n      </tr>\r\n      <tr>\r\n        <td class=\"header\" style=\"font-family: Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: normal; color: #f1f1f1; font-size: 16px; line-height: 19px; letter-spacing: -0.5px; text-align: center;\">This email contains many cool images. No images? <a href=\"#\" target=\"_blank\" style=\"color: #fff29c; text-decoration: none;\" rel=\"noopener\">View online</a></td>\r\n      </tr>\r\n      <tr>\r\n        <td height=\"50\"></td>\r\n      </tr>\r\n      <tr>\r\n        <td>\r\n          <a href=\"https://send.designmodo.com/campaigns/MTUxMTQ1Mzk2NTE5NDcxMC41YTE2ZjUwZDNmMWIyQGRlc2lnbm1vZG8uY29t/click/aHR0cHM6Ly9kZXNpZ25tb2RvLmNvbS9ibGFjay1mcmlkYXktMjAxNy8,\" target=\"_blank\" style=\"display: block; margin: 0 auto;\" rel=\"noopener\">\r\n          <img src=\"https://send.designmodo.com/upload/templates/template_5a0d9d1d6eb0f/background.gif\" style=\"display: block; margin-bottom: -50px; margin-left: auto; margin-right: auto; width: 100%; height: auto;\" border=\"0\" /> </a>\r\n        </td>\r\n      </tr>\r\n      <tr>\r\n        <td class=\"title\" style=\"font-family: Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; color: #f1f1f1; font-size: 41px; line-height: 38px; letter-spacing: -0.93px; text-align: center;\">The huge sale is here!</td>\r\n      </tr>\r\n      <tr>\r\n        <td height=\"20\"></td>\r\n      </tr>\r\n      <tr>\r\n        <td class=\"subtitle\" style=\"font-family: Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: 500; color: #f1f1f1; font-size: 28px; line-height: 38px; letter-spacing: -0.93px; text-align: center;\">Buy discounted products from <a href=\"https://send.designmodo.com/campaigns/MTUxMTQ1Mzk2NTE5NDcxMC41YTE2ZjUwZDNmMWIyQGRlc2lnbm1vZG8uY29t/click/aHR0cHM6Ly9kZXNpZ25tb2RvLmNvbS9zaG9wLw,,\" target=\"_blank\" style=\"color: #98b2c9; text-decoration: none;\"\r\n            rel=\"noopener\">Designmodo Shop</a> and <a href=\"https://send.designmodo.com/campaigns/MTUxMTQ1Mzk2NTE5NDcxMC41YTE2ZjUwZDNmMWIyQGRlc2lnbm1vZG8uY29t/click/aHR0cDovL21hcmtldC5kZXNpZ25tb2RvLmNvbS8,\" target=\"_blank\" style=\"color: #fff29c; text-decoration: none;\"\r\n            rel=\"noopener\">Designmodo Market</a>!</td>\r\n      </tr>\r\n      <tr>\r\n        <td height=\"10\"></td>\r\n      </tr>\r\n      <tr>\r\n        <td>\r\n          <a href=\"https://send.designmodo.com/campaigns/MTUxMTQ1Mzk2NTE5NDcxMC41YTE2ZjUwZDNmMWIyQGRlc2lnbm1vZG8uY29t/click/aHR0cHM6Ly9kZXNpZ25tb2RvLmNvbS9ibGFjay1mcmlkYXktMjAxNy8,\" target=\"_blank\" style=\"display: block; text-align: center;\" rel=\"noopener\">\r\n          <img src=\"https://send.designmodo.com/upload/templates/template_5a0d9d1d6eb0f/button.png\" width=\"238\" style=\"display: block; margin: 0 auto;\" /> </a>\r\n        </td>\r\n      </tr>\r\n      <tr>\r\n        <td height=\"30\"></td>\r\n      </tr>\r\n      <tr>\r\n        <td>\r\n          <table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" style=\"margin: 0 auto;\">\r\n            <tbody>\r\n              <tr>\r\n                <td valign=\"middle\">\r\n                  <a href=\"https://send.designmodo.com/campaigns/MTUxMTQ1Mzk2NTE5NDcxMC41YTE2ZjUwZDNmMWIyQGRlc2lnbm1vZG8uY29t/click/aHR0cHM6Ly93d3cuZmFjZWJvb2suY29tL2Rlc2lnbm1vZG8,\" target=\"_blank\" rel=\"noopener\"> <img src=\"https://send.designmodo.com/upload/templates/template_5a0d9d1d6eb0f/facebook.png\" width=\"50\" style=\"display: block;\" border=\"0\" /> </a>\r\n                </td>\r\n                <td valign=\"middle\">\r\n                  <a href=\"https://send.designmodo.com/campaigns/MTUxMTQ1Mzk2NTE5NDcxMC41YTE2ZjUwZDNmMWIyQGRlc2lnbm1vZG8uY29t/click/aHR0cHM6Ly90d2l0dGVyLmNvbS9kZXNpZ25tb2Rv\" target=\"_blank\" rel=\"noopener\"> <img src=\"https://send.designmodo.com/upload/templates/template_5a0d9d1d6eb0f/twitter.png\" width=\"57\" style=\"display: block;\" border=\"0\" /> </a>\r\n                </td>\r\n              </tr>\r\n            </tbody>\r\n          </table>\r\n        </td>\r\n      </tr>\r\n      <tr>\r\n        <td height=\"10\"></td>\r\n      </tr>\r\n      <tr>\r\n        <td class=\"footer\" style=\"font-family: Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: normal; color: #f1f1f1; font-size: 16px; line-height: 19px; letter-spacing: -0.5px; text-align: center;\">Made for you by Designmodo Team. We appreciate You!</td>\r\n      </tr>\r\n      <tr>\r\n        <td height=\"10\"></td>\r\n      </tr>\r\n      <tr>\r\n        <td style=\"text-align: center; color: #f1f1f1;\" class=\"footer\"><a href=\"#\" target=\"_blank\" style=\"font-family: Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: normal; color: #f8ec98; text-decoration: none; font-size: 16px; line-height: 19px; letter-spacing: -0.5px; text-align: center;\"\r\n            rel=\"noopener\">Manage subscription</a>, <a href=\"#\" target=\"_blank\" style=\"font-family: Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: normal; color: #f8ec98; text-decoration: none; font-size: 16px; line-height: 19px; letter-spacing: -0.5px; text-align: center;\"\r\n            rel=\"noopener\">Unsubscribe</a></td>\r\n      </tr>\r\n      <tr>\r\n        <td height=\"40\"></td>\r\n      </tr>\r\n    </tbody>\r\n  </table>\r\n</body>\r\n\r\n</html>'),
(2, 'Khuyến mãi sản phẩm 30%', '<head>\r\n\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">\r\n\r\n  <style type=\"text/css\">\r\n    @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,300);\r\n\r\n    html,\r\n    body {\r\n        margin: 0;\r\n        padding: 0;\r\n        background: #151515;\r\n    }\r\n\r\n    @media screen and (max-width: 770px) {\r\n        table[width=\"712\"],\r\n        table[width=\"620\"] {\r\n            width: 90%;\r\n        }\r\n\r\n        table[width=\"620\"] h2 {\r\n            width: calc(100% - 192px) !important;\r\n        }\r\n    }\r\n\r\n    @media screen and (max-width: 640px) {\r\n        table[width=\"620\"] h2,\r\n        table[width=\"620\"] .logo,\r\n        table[width=\"620\"] .social {\r\n            display: block !important;\r\n            width: 100% !important;\r\n            float: left !important;\r\n            text-align: center !important;\r\n        }\r\n\r\n        table[width=\"620\"] h2 {\r\n            margin: 10px 0 20px !important;\r\n        }\r\n\r\n        table[width=\"620\"] .logo img {\r\n            display: inline-block !important;\r\n        }\r\n\r\n        table[width=\"620\"] .social a {\r\n            display: inline-block !important;\r\n            width: auto !important;\r\n            float: none !important;\r\n        }\r\n\r\n        .bf-text img {\r\n            width: 400px;\r\n        }\r\n\r\n        .bf-deal img {\r\n            width: 180px;\r\n        }\r\n\r\n       	.sale-big-box {\r\n            width: 430px;\r\n       	}\r\n\r\n        .sale-box img {\r\n            width: 200px;\r\n        }\r\n\r\n        .description {\r\n          font-size: 20px !important;\r\n        }\r\n\r\n        td[height=\"70\"] {\r\n            height: 50px !important;\r\n        }\r\n    }\r\n  </style>\r\n\r\n</head>\r\n\r\n<body bgcolor=\"#E9E9E9\">\r\n\r\n  <table cellpadding=\"0\" bgcolor=\"#E9E9E9\" style=\"background:#E9E9E9\" cellspacing=\"0\" border=\"0\" width=\"100%\">\r\n    <tbody>\r\n      <tr>\r\n        <td>\r\n          <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"712\" align=\"center\" style=\"margin:0 auto; background-image: url(https://gallery.mailchimp.com/d7b5474e1bff23f08409d4ba9/images/b5e46e91-9670-4645-9cde-dde98c833bc3.png); background-repeat: no-repeat; background-position: 0 0; background-size: 100% auto\">\r\n\r\n            <!-- ///////// -->\r\n            <tbody>\r\n              <tr>\r\n                <td>\r\n                  <table cellpadding=\"0\" cellspacing=\"0\" width=\"620\" align=\"center\" style=\"margin: 0 auto\">\r\n\r\n                    <tbody>\r\n                      <tr>\r\n                        <td height=\"35\"></td>\r\n                      </tr>\r\n\r\n                      <tr>\r\n                        <td valign=\"middle\">\r\n\r\n                          <a href=\"https://designmodo.com/?utm_source=Designmodo+Newsletter&amp;utm_campaign=7215132ad4-EMAIL_CAMPAIGN_2016_11_28&amp;utm_medium=email&amp;utm_term=0_a2ae53acc1-7215132ad4-45090197&amp;goal=0_a2ae53acc1-7215132ad4-45090197&amp;mc_cid=7215132ad4&amp;mc_eid=e4de43bab3\"\r\n                            class=\"logo\" style=\"display: block; float: left; width: 96px;\" target=\"_blank\">\r\n                            <img width=\"30\" src=\"https://gallery.mailchimp.com/d7b5474e1bff23f08409d4ba9/images/9cb9b654-96a9-4168-8ccf-cfb3589e0aa7.png\" style=\"display: block; padding: 6px 0;\">\r\n                          </a>\r\n\r\n                          <h2 style=\"text-align: center; margin:0; padding: 4px 0; width:428px; font-weight: normal; font-family: Source Sans Pro, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 16px; color: #323232; line-height: 1; float: left;\">\r\n                        This email contains many cool images.\r\n                        <a href=\"#\" style=\"text-decoration: none; margin: 5px 0 0; color: #323232; display: block; width: 100%;\" target=\"_blank\">\r\n                          <strong style=\"font-weight: bold;\">No images?</strong> View online.\r\n                        </a>\r\n                    </h2>\r\n\r\n                          <div class=\"social\" style=\"float: right;\">\r\n                            <a style=\"display: block; float: left; margin: 0 8px 0 0;\" href=\"https://twitter.com/designmodo?utm_source=Designmodo+Newsletter&amp;utm_campaign=7215132ad4-EMAIL_CAMPAIGN_2016_11_28&amp;utm_medium=email&amp;utm_term=0_a2ae53acc1-7215132ad4-45090197&amp;goal=0_a2ae53acc1-7215132ad4-45090197&amp;mc_cid=7215132ad4&amp;mc_eid=e4de43bab3\"\r\n                              target=\"_blank\">\r\n                              <img width=\"40\" style=\"display: block\" src=\"https://gallery.mailchimp.com/d7b5474e1bff23f08409d4ba9/images/8df7e592-372b-4148-9cbd-f8845fadd4ff.png\">\r\n                            </a>\r\n                            <a style=\"display: block; float: left;\" href=\"https://www.facebook.com/designmodo?utm_source=Designmodo+Newsletter&amp;utm_campaign=7215132ad4-EMAIL_CAMPAIGN_2016_11_28&amp;utm_medium=email&amp;utm_term=0_a2ae53acc1-7215132ad4-45090197&amp;goal=0_a2ae53acc1-7215132ad4-45090197&amp;mc_cid=7215132ad4&amp;mc_eid=e4de43bab3\"\r\n                              target=\"_blank\">\r\n                              <img width=\"40\" style=\"display: block\" src=\"https://gallery.mailchimp.com/d7b5474e1bff23f08409d4ba9/images/0f79b732-9b33-49af-bf7d-cd13bfa0c319.png\">\r\n                            </a>\r\n                          </div>\r\n\r\n                        </td>\r\n                      </tr>\r\n\r\n                      <tr>\r\n                        <td height=\"30\"></td>\r\n                      </tr>\r\n\r\n                    </tbody>\r\n                  </table>\r\n                </td>\r\n              </tr>\r\n              <!-- ///////// -->\r\n\r\n              <!-- ///////// -->\r\n              <tr>\r\n                <td>\r\n                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n                    <tbody>\r\n                      <tr style=\"text-align: center\">\r\n                        <td><img src=\"https://gallery.mailchimp.com/d7b5474e1bff23f08409d4ba9/images/ea2f80a0-525f-4e23-8a89-c579dec309b7.png\" style=\"display: inline-block; width: 90%;\"></td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td>\r\n                          <table class=\"stroke_background\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n                            <tbody>\r\n                              <tr>\r\n                                <td height=\"80\"></td>\r\n                              </tr>\r\n                              <tr>\r\n                                <td style=\"text-align: center;\">\r\n                                  <img src=\"https://gallery.mailchimp.com/d7b5474e1bff23f08409d4ba9/images/5cfc1bb3-38f0-4879-b5b8-0ff60852ad8c.png\">\r\n                                </td>\r\n                              </tr>\r\n                              <tr>\r\n                                <td height=\"10\"></td>\r\n                              </tr>\r\n                              <tr>\r\n                                <td style=\"text-align: center;\">\r\n                                  <a href=\"https://designmodo.com/black-friday-2016/?utm_source=Designmodo+Newsletter&amp;utm_campaign=7215132ad4-EMAIL_CAMPAIGN_2016_11_28&amp;utm_medium=email&amp;utm_term=0_a2ae53acc1-7215132ad4-45090197&amp;goal=0_a2ae53acc1-7215132ad4-45090197&amp;mc_cid=7215132ad4&amp;mc_eid=e4de43bab3\"\r\n                                    style=\"display: block; width: 100%;\" class=\"bf-text\" target=\"_blank\">\r\n                                    <img src=\"https://gallery.mailchimp.com/d7b5474e1bff23f08409d4ba9/images/3c655433-7099-43dc-8733-9e43afdfa31b.png\">\r\n                                  </a>\r\n                                </td>\r\n                              </tr>\r\n                              <tr>\r\n                                <td height=\"10\"></td>\r\n                              </tr>\r\n                              <tr>\r\n                                <td style=\"text-align: center\" class=\"bf-deal\">\r\n                                  <a href=\"https://designmodo.com/black-friday-2016/?utm_source=Designmodo+Newsletter&amp;utm_campaign=7215132ad4-EMAIL_CAMPAIGN_2016_11_28&amp;utm_medium=email&amp;utm_term=0_a2ae53acc1-7215132ad4-45090197&amp;goal=0_a2ae53acc1-7215132ad4-45090197&amp;mc_cid=7215132ad4&amp;mc_eid=e4de43bab3\"\r\n                                    target=\"_blank\">\r\n                                    <img src=\"https://gallery.mailchimp.com/d7b5474e1bff23f08409d4ba9/images/680675db-7859-490e-93ce-0ca10455d438.png\">\r\n                                  </a>\r\n                                </td>\r\n                              </tr>\r\n                              <tr>\r\n                                <td height=\"20\"></td>\r\n                              </tr>\r\n                              <tr>\r\n                                <td>\r\n                                  <p class=\"description\" style=\"text-align: center; display: block; margin: 0 auto; max-width: 450px; padding: 0; font-family: Source Sans Pro, Helvetica-Neue, Helvetica, Arial, sans-serif; font-weight: lighter; font-size: 26px; line-height: 30px; color: #323232;\">\r\n                                    Today is your last day to shop the Cyber Monday sale and get <strong>60% off</strong>!\r\n                                    <br><br> Apply coupon code <strong>CYBER</strong> at checkout for your discount.\r\n                                  </p>\r\n                                </td>\r\n                              </tr>\r\n                              <tr>\r\n                                <td height=\"40\"></td>\r\n                              </tr>\r\n                              <tr>\r\n                                <td>\r\n                                  <a href=\"https://designmodo.com/black-friday-2016/?utm_source=Designmodo+Newsletter&amp;utm_campaign=7215132ad4-EMAIL_CAMPAIGN_2016_11_28&amp;utm_medium=email&amp;utm_term=0_a2ae53acc1-7215132ad4-45090197&amp;goal=0_a2ae53acc1-7215132ad4-45090197&amp;mc_cid=7215132ad4&amp;mc_eid=e4de43bab3\"\r\n                                    style=\"display: block; width: 100%; text-align: center;\" target=\"_blank\">\r\n                                    <img src=\"https://gallery.mailchimp.com/d7b5474e1bff23f08409d4ba9/images/689e5d1e-babd-4c69-86da-a140a8b52478.png\" width=\"214\">\r\n                                  </a>\r\n                                </td>\r\n                              </tr>\r\n                              <tr>\r\n                                <td height=\"75\"></td>\r\n                              </tr>\r\n                            </tbody>\r\n                          </table>\r\n                        </td>\r\n                      </tr>\r\n                    </tbody>\r\n                  </table>\r\n                </td>\r\n              </tr>\r\n              <!-- ///////// -->\r\n\r\n              <!-- ///////// -->\r\n              <tr>\r\n                <td>\r\n                  <table cellpadding=\"0\" cellspacing=\"0\" width=\"522\" align=\"center\" bgcolor=\"#E9E9E9\" style=\"margin: 0 auto\" class=\"sale-big-box\">\r\n                    <tbody>\r\n                      <tr style=\"text-align: center;\">\r\n                        <td width=\"250\">\r\n                          <a href=\"https://designmodo.com/black-friday-2016/?utm_source=Designmodo+Newsletter&amp;utm_campaign=7215132ad4-EMAIL_CAMPAIGN_2016_11_28&amp;utm_medium=email&amp;utm_term=0_a2ae53acc1-7215132ad4-45090197&amp;goal=0_a2ae53acc1-7215132ad4-45090197&amp;mc_cid=7215132ad4&amp;mc_eid=e4de43bab3\"\r\n                            style=\"display: block; width: 100%;\" class=\"sale-box\" target=\"_blank\">\r\n                            <img src=\"https://gallery.mailchimp.com/d7b5474e1bff23f08409d4ba9/images/8d3f3262-3dab-4a15-a0d1-27ab90f51a1e.png\">\r\n                          </a>\r\n                        </td>\r\n                        <td width=\"10\"></td>\r\n                        <td width=\"250\">\r\n                          <a href=\"https://designmodo.com/black-friday-2016/?utm_source=Designmodo+Newsletter&amp;utm_campaign=7215132ad4-EMAIL_CAMPAIGN_2016_11_28&amp;utm_medium=email&amp;utm_term=0_a2ae53acc1-7215132ad4-45090197&amp;goal=0_a2ae53acc1-7215132ad4-45090197&amp;mc_cid=7215132ad4&amp;mc_eid=e4de43bab3\"\r\n                            style=\"display: block; width: 100%;\" class=\"sale-box\" target=\"_blank\">\r\n                            <img src=\"https://gallery.mailchimp.com/d7b5474e1bff23f08409d4ba9/images/49f87b71-3cf4-4101-b94b-a4ed18a2bfa2.png\">\r\n                          </a>\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                      <tr style=\"text-align: center;\">\r\n                        <td width=\"250\">\r\n                          <a href=\"https://designmodo.com/black-friday-2016/?utm_source=Designmodo+Newsletter&amp;utm_campaign=7215132ad4-EMAIL_CAMPAIGN_2016_11_28&amp;utm_medium=email&amp;utm_term=0_a2ae53acc1-7215132ad4-45090197&amp;goal=0_a2ae53acc1-7215132ad4-45090197&amp;mc_cid=7215132ad4&amp;mc_eid=e4de43bab3\"\r\n                            style=\"display: block; width: 100%;\" class=\"sale-box\" target=\"_blank\">\r\n                            <img src=\"https://gallery.mailchimp.com/d7b5474e1bff23f08409d4ba9/images/e5dfe78e-60b8-4349-9226-7b4d94a015e3.png\">\r\n                          </a>\r\n                        </td>\r\n                        <td width=\"10\"></td>\r\n                        <td width=\"250\">\r\n                          <a href=\"https://designmodo.com/black-friday-2016/?utm_source=Designmodo+Newsletter&amp;utm_campaign=7215132ad4-EMAIL_CAMPAIGN_2016_11_28&amp;utm_medium=email&amp;utm_term=0_a2ae53acc1-7215132ad4-45090197&amp;goal=0_a2ae53acc1-7215132ad4-45090197&amp;mc_cid=7215132ad4&amp;mc_eid=e4de43bab3\"\r\n                            style=\"display: block; width: 100%;\" class=\"sale-box\" target=\"_blank\">\r\n                            <img src=\"https://gallery.mailchimp.com/d7b5474e1bff23f08409d4ba9/images/dc3d3798-08ac-4a02-abc7-8cc8fa1dbe39.png\">\r\n                          </a>\r\n                        </td>\r\n                      </tr>\r\n                    </tbody>\r\n                  </table>\r\n                </td>\r\n              </tr>\r\n              <!-- ///////// -->\r\n\r\n\r\n              <tr>\r\n                <td height=\"80\"></td>\r\n              </tr>\r\n\r\n              <!-- ///////// -->\r\n              <tr>\r\n                <td>\r\n                  <table class=\"stroke_background\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"text-align:center;\">\r\n                    <tbody>\r\n                      <tr>\r\n                        <td style=\"padding:0 10px;font-family: Source Sans Pro, Helvetica, Arial, sans-serif;font-size: 16px;color: #323232;\">\r\n                          Made for you by <a href=\"https://designmodo.com/?utm_source=Designmodo+Newsletter&amp;utm_campaign=7215132ad4-EMAIL_CAMPAIGN_2016_11_28&amp;utm_medium=email&amp;utm_term=0_a2ae53acc1-7215132ad4-45090197&amp;goal=0_a2ae53acc1-7215132ad4-45090197&amp;mc_cid=7215132ad4&amp;mc_eid=e4de43bab3\"\r\n                            style=\"color: #323232;text-decoration: none;\" target=\"_blank\">Designmodo Team</a>. We appreciate You!\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"3\">\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td style=\"font-family: Source Sans Pro, Helvetica, Arial, sans-serif; font-size: 16px; color: #323232;\">\r\n                          <a style=\"color: #323232\" href=\"#\" target=\"_blank\">Manage subscription</a>, <a href=\"#\" style=\"color: #323232\" target=\"_blank\">Unsubscribe</a>\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"25\">\r\n                        </td>\r\n                      </tr>\r\n                    </tbody>\r\n                  </table>\r\n                </td>\r\n              </tr>\r\n              <!-- ///////// -->\r\n\r\n            </tbody>\r\n          </table>\r\n        </td>\r\n      </tr>\r\n    </tbody>\r\n  </table>\r\n\r\n\r\n</body>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL COMMENT 'Mã người dùng',
  `user_avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Ảnh địa diện',
  `user_full_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Biệt danh',
  `user_name` varchar(254) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tài khoản là email',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Mật khẩu người dùng',
  `user_status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Tình trạng',
  `user_level` tinyint(3) UNSIGNED NOT NULL COMMENT 'Cấp độ',
  `user_token` char(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Người dùng';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_avatar`, `user_full_name`, `user_name`, `password`, `user_status`, `user_level`, `user_token`) VALUES
(1, NULL, 'Administrator', 'admin@alta.com.vn', '$2y$10$LzkJTEPstmRR.EibfFKDv.rgCb6t38q/zYFXO.X0bKotjzuG5lUiO', 1, 2, NULL),
(2, NULL, 'Alta Media - Sale', 'sale@alta.com.vn', '$2y$10$LzkJTEPstmRR.EibfFKDv.rgCb6t38q/zYFXO.X0bKotjzuG5lUiO', 1, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`action_id`),
  ADD KEY `fk_actions_projects` (`project_id`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`campaign_id`),
  ADD KEY `fk_campaigns_projects` (`project_id`);

--
-- Indexes for table `campaign_logs`
--
ALTER TABLE `campaign_logs`
  ADD PRIMARY KEY (`campaign_log_id`),
  ADD KEY `fk_email_logs_campaigns` (`campaign_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `fk_contacts_customers` (`customer_id`);

--
-- Indexes for table `contact_groups`
--
ALTER TABLE `contact_groups`
  ADD PRIMARY KEY (`contact_group_id`),
  ADD KEY `fk_contact_groups_customers` (`customer_id`);

--
-- Indexes for table `contact_group_details`
--
ALTER TABLE `contact_group_details`
  ADD PRIMARY KEY (`contact_group_detail_id`),
  ADD KEY `fk_contact_group_details_contact_groups` (`contact_group_id`),
  ADD KEY `fk_contact_group_details_contacts` (`contact_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `unq_customers_user_id` (`user_id`);

--
-- Indexes for table `mailing_services`
--
ALTER TABLE `mailing_services`
  ADD PRIMARY KEY (`mailing_service_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `fk_projects_customers` (`customer_id`),
  ADD KEY `fk_projects_project_types` (`project_type_id`),
  ADD KEY `fk_projects_mailing_services` (`mailing_service_id`);

--
-- Indexes for table `project_types`
--
ALTER TABLE `project_types`
  ADD PRIMARY KEY (`project_type_id`);

--
-- Indexes for table `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`statistic_id`),
  ADD KEY `fk_statistics_projects` (`project_id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `unq_user_name` (`user_name`),
  ADD UNIQUE KEY `unq_user_token` (`user_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `action_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã hành động';

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `campaign_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã chiến dịch';

--
-- AUTO_INCREMENT for table `campaign_logs`
--
ALTER TABLE `campaign_logs`
  MODIFY `campaign_log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã nhật ký gửi email';

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã liên hệ';

--
-- AUTO_INCREMENT for table `contact_groups`
--
ALTER TABLE `contact_groups`
  MODIFY `contact_group_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã nhóm liên hệ';

--
-- AUTO_INCREMENT for table `contact_group_details`
--
ALTER TABLE `contact_group_details`
  MODIFY `contact_group_detail_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã chi tiết nhóm liên hệ';

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã khách hàng';

--
-- AUTO_INCREMENT for table `mailing_services`
--
ALTER TABLE `mailing_services`
  MODIFY `mailing_service_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã dịch vụ gửi mail', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã dự án';

--
-- AUTO_INCREMENT for table `project_types`
--
ALTER TABLE `project_types`
  MODIFY `project_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã loại dự án', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `statistics`
--
ALTER TABLE `statistics`
  MODIFY `statistic_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã thống kê';

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `template_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã nội dung mẫu', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Mã người dùng', AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `fk_actions_projects` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `fk_campaigns_projects` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `campaign_logs`
--
ALTER TABLE `campaign_logs`
  ADD CONSTRAINT `fk_email_logs_campaigns` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `fk_contacts_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `contact_groups`
--
ALTER TABLE `contact_groups`
  ADD CONSTRAINT `fk_contact_groups_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `contact_group_details`
--
ALTER TABLE `contact_group_details`
  ADD CONSTRAINT `fk_contact_group_details_contact_groups` FOREIGN KEY (`contact_group_id`) REFERENCES `contact_groups` (`contact_group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contact_group_details_contacts` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`contact_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_customers_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_projects_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_projects_mailing_services` FOREIGN KEY (`mailing_service_id`) REFERENCES `mailing_services` (`mailing_service_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_projects_project_types` FOREIGN KEY (`project_type_id`) REFERENCES `project_types` (`project_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `statistics`
--
ALTER TABLE `statistics`
  ADD CONSTRAINT `fk_statistics_projects` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
