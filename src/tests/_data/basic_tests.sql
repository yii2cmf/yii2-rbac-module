-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-admin
-- Generation Time: Oct 20, 2019 at 09:16 AM
-- Server version: 8.0.13
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `basic_tests`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '2', 1571558835);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'description', NULL, NULL, 1571131033, 1571131056);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `basic_migration`
--

CREATE TABLE `basic_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `basic_migration`
--

INSERT INTO `basic_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1557674993),
('m190508_000001_create_user_table', 1557755286),
('m190508_000002_create_posts_table', 1557755288),
('m190508_000003_create_postmeta_table', 1557755290),
('m190508_000004_create_terms_table', 1557755291),
('m190508_000005_create_termmeta_table', 1557755292),
('m190508_000006_create_term_taxonomy_table', 1557755295),
('m190508_000007_create_term_relationships_table', 1557755297),
('m190524_125327_create_options_table', 1558703120);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) NOT NULL,
  `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1557670474),
('m140506_102106_rbac_init', 1557675414),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1557675414),
('m180523_151638_rbac_updates_indexes_without_prefix', 1557675415);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(200) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'thumbnail_size_w', '150', 'yes'),
(2, 'thumbnail_size_h', '150', 'yes'),
(3, 'medium_size_w', '300', 'yes'),
(4, 'medium_size_h', '300', 'yes'),
(5, 'large_size_w', '1024', 'yes'),
(6, 'large_size_h', '1024', 'yes'),
(7, 'medium_large_size_w', '768', 'yes'),
(8, 'medium_large_size_h', '0', 'yes'),
(9, 'module_admin_template', 'adminlte', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `postmeta`
--

CREATE TABLE `postmeta` (
  `meta_id` int(10) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `meta_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `postmeta`
--

INSERT INTO `postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(111, 166, 'menu_item_type', 'post_type'),
(112, 166, 'menu_item_menu_item_parent', '0'),
(113, 166, 'menu_item_object_id', '159'),
(114, 166, 'menu_item_object', 'post'),
(115, 166, 'menu_item_classes', ''),
(121, 168, 'menu_item_type', 'post_type'),
(122, 168, 'menu_item_menu_item_parent', '0'),
(123, 168, 'menu_item_object_id', '159'),
(124, 168, 'menu_item_object', 'post'),
(125, 168, 'menu_item_classes', ''),
(136, 171, 'menu_item_type', 'post_type'),
(137, 171, 'menu_item_menu_item_parent', '168'),
(138, 171, 'menu_item_object_id', '159'),
(139, 171, 'menu_item_object', 'post'),
(140, 171, 'menu_item_classes', ''),
(141, 172, 'menu_item_type', 'post_type'),
(142, 172, 'menu_item_menu_item_parent', '0'),
(143, 172, 'menu_item_object_id', '159'),
(144, 172, 'menu_item_object', 'post'),
(145, 172, 'menu_item_classes', ''),
(146, 173, 'menu_item_type', 'post_type'),
(147, 173, 'menu_item_menu_item_parent', '172'),
(148, 173, 'menu_item_object_id', '159'),
(149, 173, 'menu_item_object', 'post'),
(150, 173, 'menu_item_classes', ''),
(151, 181, 'attached_file', 'modules/basic/uploads/2019/08/slider1.jpg'),
(152, 181, 'attachment_metadata', '{\"width\":1280,\"height\":852,\"file\":\"2019\\/08\\/slider1.jpg\",\"sizes\":{\"thumbnail\":{\"file\":\"slider1-150x150.jpg\",\"width\":\"150\",\"height\":\"150\",\"mime-type\":\"image\\/jpeg\"},\"medium\":{\"file\":\"slider1-300x200.jpg\",\"width\":\"300\",\"height\":200,\"mime-type\":\"image\\/jpeg\"},\"medium_large\":{\"file\":\"slider1-768x511.jpg\",\"width\":\"768\",\"height\":511,\"mime-type\":\"image\\/jpeg\"},\"large\":{\"file\":\"slider1-1024x682.jpg\",\"width\":\"1024\",\"height\":682,\"mime-type\":\"image\\/jpeg\"},\"post-thumbnail\":{\"file\":\"Pexels-photo-1568x948.jpg\",\"width\":1568,\"height\":948,\"mime-type\":\"image\\/jpeg\"}}}'),
(153, 184, 'image_size', 'full'),
(154, 184, 'view_position', 'begin_body_header'),
(155, 184, 'interval', '2000'),
(156, 184, 'indicators', '1'),
(157, 184, 'controls', '1'),
(158, 184, 'carousels_attachments_ids', '188,197,189'),
(159, 185, 'attached_file', 'modules/basic/uploads/2019/08/orig1.jpg'),
(160, 185, 'attachment_metadata', '{\"width\":585,\"height\":340,\"file\":\"2019\\/08\\/orig1.jpg\",\"sizes\":{\"thumbnail\":{\"file\":\"orig1-150x150.jpg\",\"width\":\"150\",\"height\":\"150\",\"mime-type\":\"image\\/jpeg\"},\"medium\":{\"file\":\"orig1-300x174.jpg\",\"width\":\"300\",\"height\":174,\"mime-type\":\"image\\/jpeg\"},\"medium_large\":{\"file\":\"orig1-768x446.jpg\",\"width\":\"768\",\"height\":446,\"mime-type\":\"image\\/jpeg\"},\"large\":{\"file\":\"orig1-1024x595.jpg\",\"width\":\"1024\",\"height\":595,\"mime-type\":\"image\\/jpeg\"},\"post-thumbnail\":{\"file\":\"Pexels-photo-1568x948.jpg\",\"width\":1568,\"height\":948,\"mime-type\":\"image\\/jpeg\"}}}'),
(163, 187, 'menu_item_type', 'post_type'),
(164, 187, 'menu_item_menu_item_parent', '168'),
(165, 187, 'menu_item_object_id', '159'),
(166, 187, 'menu_item_object', 'post'),
(167, 187, 'menu_item_classes', ''),
(170, 189, 'attached_file', 'modules/basic/uploads/2019/08/orig2.jpg'),
(171, 189, 'attachment_metadata', '{\"width\":585,\"height\":340,\"file\":\"2019\\/08\\/orig2.jpg\",\"sizes\":{\"thumbnail\":{\"file\":\"orig2-150x150.jpg\",\"width\":\"150\",\"height\":\"150\",\"mime-type\":\"image\\/jpeg\"},\"medium\":{\"file\":\"orig2-300x174.jpg\",\"width\":\"300\",\"height\":174,\"mime-type\":\"image\\/jpeg\"},\"medium_large\":{\"file\":\"orig2-768x446.jpg\",\"width\":\"768\",\"height\":446,\"mime-type\":\"image\\/jpeg\"},\"large\":{\"file\":\"orig2-1024x595.jpg\",\"width\":\"1024\",\"height\":595,\"mime-type\":\"image\\/jpeg\"}}}'),
(172, 190, 'attached_file', 'modules/basic/uploads/2019/08/iStock-Super-Styer.jpg'),
(173, 190, 'attachment_metadata', '{\"width\":1536,\"height\":1024,\"file\":\"2019\\/08\\/iStock-Super-Styer.jpg\",\"sizes\":{\"thumbnail\":{\"file\":\"iStock-Super-Styer-150x150.jpg\",\"width\":1536,\"height\":1024,\"mime-type\":\"image\\/jpeg\"},\"medium\":{\"file\":\"iStock-Super-Styer-300x200.jpg\",\"width\":1536,\"height\":1024,\"mime-type\":\"image\\/jpeg\"},\"medium_large\":{\"file\":\"iStock-Super-Styer-768x512.jpg\",\"width\":1536,\"height\":1024,\"mime-type\":\"image\\/jpeg\"},\"large\":{\"file\":\"iStock-Super-Styer-1024x683.jpg\",\"width\":1536,\"height\":1024,\"mime-type\":\"image\\/jpeg\"}}}'),
(174, 191, 'attached_file', 'modules/basic/uploads/2019/08/coding1.jpg'),
(175, 191, 'attachment_metadata', '{\"width\":539,\"height\":360,\"file\":\"2019\\/08\\/coding1.jpg\",\"sizes\":{\"thumbnail\":{\"file\":\"coding1-150x150.jpg\",\"width\":539,\"height\":360,\"mime-type\":\"image\\/jpeg\"},\"medium\":{\"file\":\"coding1-300x200.jpg\",\"width\":539,\"height\":360,\"mime-type\":\"image\\/jpeg\"},\"medium_large\":{\"file\":\"coding1-768x513.jpg\",\"width\":539,\"height\":360,\"mime-type\":\"image\\/jpeg\"},\"large\":{\"file\":\"coding1-1024x684.jpg\",\"width\":539,\"height\":360,\"mime-type\":\"image\\/jpeg\"}}}'),
(176, 192, 'attached_file', 'modules/basic/uploads/2019/08/iStock-Super-Styer.jpg'),
(177, 192, 'attachment_metadata', '{\"width\":1536,\"height\":1024,\"file\":\"2019\\/08\\/iStock-Super-Styer.jpg\",\"sizes\":{\"thumbnail\":{\"file\":\"iStock-Super-Styer-150x150.jpg\",\"width\":1536,\"height\":1024,\"mime-type\":\"image\\/jpeg\"},\"medium\":{\"file\":\"iStock-Super-Styer-300x200.jpg\",\"width\":1536,\"height\":1024,\"mime-type\":\"image\\/jpeg\"},\"medium_large\":{\"file\":\"iStock-Super-Styer-768x512.jpg\",\"width\":1536,\"height\":1024,\"mime-type\":\"image\\/jpeg\"},\"large\":{\"file\":\"iStock-Super-Styer-1024x683.jpg\",\"width\":1536,\"height\":1024,\"mime-type\":\"image\\/jpeg\"}}}'),
(180, 195, 'attached_file', 'modules/basic/uploads/2019/08//orig1.jpg'),
(181, 195, 'attachment_metadata', '{\"width\":585,\"height\":340,\"file\":\"2019\\/08\\/\\/orig1.jpg\",\"sizes\":{\"thumbnail\":{\"file\":\"orig1-150x150.jpg\",\"width\":585,\"height\":340,\"mime-type\":\"image\\/jpeg\"},\"medium\":{\"file\":\"orig1-300x174.jpg\",\"width\":585,\"height\":340,\"mime-type\":\"image\\/jpeg\"},\"medium_large\":{\"file\":\"orig1-768x446.jpg\",\"width\":585,\"height\":340,\"mime-type\":\"image\\/jpeg\"},\"large\":{\"file\":\"orig1-1024x595.jpg\",\"width\":585,\"height\":340,\"mime-type\":\"image\\/jpeg\"}}}'),
(182, 196, 'attached_file', 'modules/basic/uploads/2019/08/orig2.jpg'),
(183, 196, 'attachment_metadata', '{\"width\":585,\"height\":340,\"file\":\"2019\\/08\\/orig2.jpg\",\"sizes\":{\"thumbnail\":{\"file\":\"orig2-150x150.jpg\",\"width\":585,\"height\":340,\"mime-type\":\"image\\/jpeg\"},\"medium\":{\"file\":\"orig2-300x174.jpg\",\"width\":585,\"height\":340,\"mime-type\":\"image\\/jpeg\"},\"medium_large\":{\"file\":\"orig2-768x446.jpg\",\"width\":585,\"height\":340,\"mime-type\":\"image\\/jpeg\"},\"large\":{\"file\":\"orig2-1024x595.jpg\",\"width\":585,\"height\":340,\"mime-type\":\"image\\/jpeg\"}}}'),
(184, 197, 'attached_file', 'modules/basic/uploads/2019/08/slider3.jpg'),
(185, 197, 'attachment_metadata', '{\"width\":750,\"height\":500,\"file\":\"2019\\/08\\/slider3.jpg\",\"sizes\":{\"thumbnail\":{\"file\":\"slider3-150x150.jpg\",\"width\":750,\"height\":500,\"mime-type\":\"image\\/jpeg\"},\"medium\":{\"file\":\"slider3-300x200.jpg\",\"width\":750,\"height\":500,\"mime-type\":\"image\\/jpeg\"},\"medium_large\":{\"file\":\"slider3-768x512.jpg\",\"width\":750,\"height\":500,\"mime-type\":\"image\\/jpeg\"},\"large\":{\"file\":\"slider3-1024x683.jpg\",\"width\":750,\"height\":500,\"mime-type\":\"image\\/jpeg\"}}}');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_parent` bigint(20) UNSIGNED DEFAULT NULL,
  `post_author` int(10) UNSIGNED NOT NULL,
  `post_created` datetime NOT NULL,
  `post_updated` datetime DEFAULT NULL,
  `post_content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_title` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_excerpt` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'publish',
  `post_password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `guid` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `comment_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `comment_count` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `post_parent`, `post_author`, `post_created`, `post_updated`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `post_password`, `post_name`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_status`, `comment_count`) VALUES
(159, NULL, 1, '2019-06-02 07:07:16', '2019-08-15 11:05:48', '<p><img src=\"../../modules/basic/uploads/2019/08/coding1.jpg\" alt=\"\" width=\"539\" height=\"360\" />Post1.3</p>', 'Post1.3', 'Post1.3', 'publish', '', '', '', 0, 'post', '', '0', 0),
(164, NULL, 1, '2019-06-02 11:37:12', '2019-06-02 11:37:12', 'Post1.4', 'Post1.4', 'Post1.4', 'publish', '', '', '', 0, 'post', '', '0', 0),
(166, NULL, 1, '2019-07-30 08:31:40', '2019-08-01 15:09:19', '', '<span class=\"fa fa-home\"></span> Главная', '', 'publish', '', '', '', 1, 'nav_menu_item', '', 'closed', 0),
(168, NULL, 1, '2019-08-01 14:40:55', '2019-08-01 15:53:41', '', '<span class=\"fa fa-star\"></span> Темы', '', 'publish', '', '', '', 2, 'nav_menu_item', '', 'closed', 0),
(171, 168, 1, '2019-08-01 15:34:07', '2019-08-01 15:34:07', '', 'Веб-разработка', '', 'publish', '', '', '', 2, 'nav_menu_item', '', 'closed', 0),
(172, NULL, 1, '2019-08-01 15:38:56', '2019-08-01 15:39:22', '', '<span class=\"fa fa-code\"></span> Языки', '', 'publish', '', '', '', 2, 'nav_menu_item', '', 'closed', 0),
(173, 172, 1, '2019-08-01 15:44:13', '2019-08-01 15:44:13', '', 'PHP', '', 'publish', '', '', '', 2, 'nav_menu_item', '', 'closed', 0),
(181, NULL, 1, '2019-08-01 18:14:29', '2019-08-15 14:25:33', '', 'slider1', '', 'publish', '', 'slider1', 'modules/basic/uploads/2019/08/slider1.jpg', 1, 'attachment', 'image/jpeg', 'open', 0),
(184, NULL, 1, '2019-08-02 08:13:22', '2019-08-02 08:49:18', '', 'Main', '', 'publish', '', '', '', 0, 'carousels', '', 'open', 0),
(185, NULL, 1, '2019-08-02 08:17:31', '2019-08-15 14:26:56', 'Fusce id justo ac lacus aliquet lobortis...', 'orig1', '', 'publish', '', 'orig1', 'modules/basic/uploads/2019/08/orig1.jpg', 1, 'attachment', 'image/jpeg', 'open', 0),
(187, 168, 1, '2019-08-02 15:20:40', '2019-08-02 15:20:40', '', 'Книги', '', 'publish', '', '', '', 2, 'nav_menu_item', '', 'closed', 0),
(189, NULL, 1, '2019-08-02 16:22:29', '2019-08-15 15:33:11', '', 'orig2', '', 'publish', '', 'orig2', 'modules/basic/uploads/2019/08/orig2.jpg', 3, 'attachment', 'image/jpeg', 'open', 0),
(190, NULL, 1, '2019-08-13 12:40:06', '2019-08-15 14:27:40', '', 'iStock Super Styer.jpg', '', 'publish', '', 'istock-super-styer.jpg', 'modules/basic/uploads/2019/08/iStock-Super-Styer.jpg', 0, 'attachment', 'image/jpeg', 'open', 0),
(191, 164, 1, '2019-08-14 17:58:35', '2019-08-15 15:17:01', '', 'coding1.jpg', '', 'publish', '', 'coding1.jpg', 'modules/basic/uploads/2019/08/coding1.jpg', 0, 'attachment', 'image/jpeg', 'open', 0),
(192, 193, 1, '2019-08-14 18:23:31', '2019-08-15 15:17:41', '', 'iStock Super Styer.jpg', '', 'publish', '', 'istock-super-styer.jpg', 'modules/basic/uploads/2019/08/iStock-Super-Styer.jpg', 0, 'attachment', 'image/jpeg', 'open', 0),
(193, NULL, 1, '2019-08-14 18:23:48', '2019-08-14 18:23:48', '<p><img src=\"../../modules/basic/uploads/2019/08/iStock-Super-Styer.jpg\" alt=\"\" width=\"333\" height=\"222\" /></p>', 'Test1', '', 'publish', '', '', '', 0, 'post', '', '0', 0),
(195, NULL, 1, '2019-08-15 10:29:18', '2019-08-15 10:29:18', '', 'orig1', '', 'publish', '', 'orig1', 'modules/basic/uploads/2019/08//orig1.jpg', 0, 'attachment', 'image/jpeg', 'open', 0),
(196, 159, 1, '2019-08-15 11:05:48', '2019-08-15 14:27:40', '', 'orig2', '', 'inherit', '', 'orig2', 'modules/basic/uploads/2019/08/orig2.jpg', 0, 'attachment', 'image/jpeg', 'open', 0),
(197, NULL, 1, '2019-08-15 15:32:52', '2019-08-15 15:33:08', '', 'slider3', '', 'publish', '', 'slider3', 'modules/basic/uploads/2019/08/slider3.jpg', 2, 'attachment', 'image/jpeg', 'open', 0);

-- --------------------------------------------------------

--
-- Table structure for table `termmeta`
--

CREATE TABLE `termmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `meta_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `termmeta`
--

INSERT INTO `termmeta` (`meta_id`, `term_id`, `meta_key`, `meta_value`) VALUES
(1, 41, 'menu_type', 'main-menu');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID категории, метки, ссылки',
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Название категории, метки, ссылки (Имя)',
  `slug` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Ярлык категории, метки, ссылки',
  `term_group` bigint(10) DEFAULT '0' COMMENT 'Группа категорий, меток, ссылок.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(2, 'Казахстан', 'kazakhstan', 0),
(5, 'Россия', 'russiya', 0),
(6, 'Москва', 'moskow', 0),
(36, 'ЖанаОзен', 'zhanaozen', 0),
(37, 'Новости Казахстана', 'novosti-kazakhstana', 0),
(39, 'Новости мира', 'novosti-mira123', 0),
(40, 'test teg1', 'test-teg-1', 0),
(41, 'Main Menu', 'main-menu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `terms_translation`
--

CREATE TABLE `terms_translation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL COMMENT 'fk to terms',
  `language_id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `slug` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Тестовая таблица перевода';

-- --------------------------------------------------------

--
-- Table structure for table `term_relationships`
--

CREATE TABLE `term_relationships` (
  `post_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Relation to posts table',
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `term_relationships`
--

INSERT INTO `term_relationships` (`post_id`, `term_taxonomy_id`, `term_order`) VALUES
(159, 2, 0),
(166, 20, 0),
(168, 20, 0),
(171, 20, 0),
(172, 20, 0),
(173, 20, 0),
(187, 20, 0),
(193, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `term_taxonomy`
--

CREATE TABLE `term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL COMMENT 'fk to terms ',
  `taxonomy` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Имя таксономии, к которой относится терм',
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `parent_term_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Родительский терм (если такой есть) для определенного терма, когда таксономия является иерархической',
  `count` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Количество записей с термом'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `term_taxonomy`
--

INSERT INTO `term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent_term_id`, `count`) VALUES
(2, 2, 'category', '', NULL, 0),
(5, 5, 'category', '', NULL, 0),
(6, 6, 'category', '', 5, 0),
(16, 36, 'post_tag', '1', 5, 0),
(17, 37, 'category', '', NULL, 0),
(18, 39, 'category', '', NULL, 0),
(19, 40, 'post_tag', '', NULL, 0),
(20, 41, 'nav_menu', '', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `patronymic` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `patronymic`, `login`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'root_test', 'root_test', 'root_test', 'root_test', '', '$2y$13$4XiX/n66mZ0U.SNoAugXW.R1hnCKcF4UOs0vSUH.AfBuyG8EFqoMe', '', 'root@gmail.com', 10, '2019-05-13 13:48:06', '2019-05-13 13:48:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `basic_migration`
--
ALTER TABLE `basic_migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `idx-option-name` (`option_name`);

--
-- Indexes for table `postmeta`
--
ALTER TABLE `postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `idx-post-id` (`post_id`),
  ADD KEY `idx-meta-key` (`meta_key`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-post-name` (`post_name`),
  ADD KEY `idx-post-parent` (`post_parent`),
  ADD KEY `idx-post-author` (`post_author`);

--
-- Indexes for table `termmeta`
--
ALTER TABLE `termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `idx-termmeta_term_id` (`term_id`),
  ADD KEY `idx-termmeta_meta_key` (`meta_key`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `idx-terms-name` (`name`),
  ADD KEY `idx-terms-slug` (`slug`);

--
-- Indexes for table `terms_translation`
--
ALTER TABLE `terms_translation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `term_id` (`term_id`);

--
-- Indexes for table `term_relationships`
--
ALTER TABLE `term_relationships`
  ADD PRIMARY KEY (`post_id`,`term_taxonomy_id`),
  ADD KEY `idx-term-relationships_post-id` (`post_id`),
  ADD KEY `idx-term-relationships_term-taxonomy-id` (`term_taxonomy_id`);

--
-- Indexes for table `term_taxonomy`
--
ALTER TABLE `term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `idx-term-taxonomy_term-id` (`term_id`),
  ADD KEY `idx-term-taxonomy_taxonomy` (`taxonomy`),
  ADD KEY `fk-term-taxonomy_parent` (`parent_term_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`) USING BTREE,
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `postmeta`
--
ALTER TABLE `postmeta`
  MODIFY `meta_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `termmeta`
--
ALTER TABLE `termmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID категории, метки, ссылки', AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `terms_translation`
--
ALTER TABLE `terms_translation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `term_taxonomy`
--
ALTER TABLE `term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `postmeta`
--
ALTER TABLE `postmeta`
  ADD CONSTRAINT `fk-post-id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk-post-author` FOREIGN KEY (`post_author`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-post-parent` FOREIGN KEY (`post_parent`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `termmeta`
--
ALTER TABLE `termmeta`
  ADD CONSTRAINT `fk-termmeta-term-id` FOREIGN KEY (`term_id`) REFERENCES `terms` (`term_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `terms_translation`
--
ALTER TABLE `terms_translation`
  ADD CONSTRAINT `terms_translation_ibfk_1` FOREIGN KEY (`term_id`) REFERENCES `terms` (`term_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `term_relationships`
--
ALTER TABLE `term_relationships`
  ADD CONSTRAINT `fk-term-relationships_post-id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-term-relationships_term-taxonomy-id` FOREIGN KEY (`term_taxonomy_id`) REFERENCES `term_taxonomy` (`term_taxonomy_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `term_taxonomy`
--
ALTER TABLE `term_taxonomy`
  ADD CONSTRAINT `fk-term-taxonomy_parent` FOREIGN KEY (`parent_term_id`) REFERENCES `terms` (`term_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-term_taxonomy_term-id` FOREIGN KEY (`term_id`) REFERENCES `terms` (`term_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
