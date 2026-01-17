-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 17, 2026 at 07:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Crissel Zapatero', 'Admin_Crissel Zapatero_001', 'b6c528ef9aa643b168fd0b18d9dfd28b48061eb8', '2026-01-15 07:11:06');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_conversations`
--

CREATE TABLE `chatbot_conversations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(100) NOT NULL,
  `user_message` text NOT NULL,
  `bot_response` text NOT NULL,
  `response_type` enum('menu','rule','default') DEFAULT 'rule',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatbot_conversations`
--

INSERT INTO `chatbot_conversations` (`id`, `user_id`, `session_id`, `user_message`, `bot_response`, `response_type`, `created_at`) VALUES
(1, NULL, 'chat_69633405a00714.18280597', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 05:24:21'),
(2, NULL, 'chat_69633405a00714.18280597', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 05:24:29'),
(3, NULL, 'chat_69633405a00714.18280597', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 05:24:36'),
(4, NULL, 'chat_69633405a00714.18280597', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 05:24:41'),
(5, NULL, 'chat_69633405a00714.18280597', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 05:24:56'),
(6, NULL, 'chat_69633405a00714.18280597', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 05:38:06'),
(7, NULL, 'chat_69633405a00714.18280597', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 05:38:10'),
(8, NULL, 'chat_69633405a00714.18280597', '[MENU:Personalize Account]', 'You can personalize your account in the profile button. There, you will see a pen-like button next to your profile picture where you can change your profile picture.', 'menu', '2026-01-11 05:38:19'),
(9, NULL, 'chat_69633405a00714.18280597', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 05:38:23'),
(10, NULL, 'chat_69633405a00714.18280597', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 05:38:28'),
(11, NULL, 'chat_69633405a00714.18280597', '[MENU:Post Format]', 'You can post images (jpeg, jpg, png) and videos (mp4) with description. However, there is a maximum of 5 images or 5 videos per post.', 'menu', '2026-01-11 05:38:32'),
(12, NULL, 'chat_69633405a00714.18280597', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 05:38:34'),
(13, NULL, 'chat_69633405a00714.18280597', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 05:39:37'),
(14, NULL, 'chat_69633405a00714.18280597', 'how do I personalize my account', 'Hmm, I\'m not quite sure about that!  Could you rephrase your question?', 'default', '2026-01-11 05:39:50'),
(15, NULL, 'chat_69633405a00714.18280597', 'change profile picture', 'Hmm, I\'m not quite sure about that!  Could you rephrase your question?', 'default', '2026-01-11 05:40:01'),
(16, NULL, 'chat_69633405a00714.18280597', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 05:40:08'),
(17, NULL, 'chat_69633405a00714.18280597', 'how do i personalize my account', 'Hmm, I\'m not quite sure about that!  Could you rephrase your question?', 'default', '2026-01-11 05:40:18'),
(18, NULL, 'chat_69633405a00714.18280597', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 05:40:23'),
(19, NULL, 'chat_69633405a00714.18280597', '[MENU:Delete Post]', 'You can delete your post by clicking your post and selecting delete.', 'menu', '2026-01-11 05:40:26'),
(20, NULL, 'chat_69633405a00714.18280597', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 05:40:30'),
(21, NULL, 'chat_69633405a00714.18280597', '[MENU:📝 Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 05:40:46'),
(22, NULL, 'chat_69633405a00714.18280597', 'what can I post', 'Hmm, I\'m not quite sure about that!  Could you rephrase your question?', 'default', '2026-01-11 05:40:50'),
(23, NULL, 'chat_69633405a00714.18280597', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 05:57:49'),
(24, NULL, 'chat_69633405a00714.18280597', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 05:57:51'),
(25, NULL, 'chat_69633405a00714.18280597', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 05:57:57'),
(26, NULL, 'chat_69633405a00714.18280597', 'hello', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant! How can I help you today?', 'rule', '2026-01-11 05:58:02'),
(27, NULL, 'chat_69633405a00714.18280597', 'hi', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant! How can I help you today?', 'rule', '2026-01-11 05:58:04'),
(28, NULL, 'chat_69633405a00714.18280597', 'bonjour', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant! How can I help you today?', 'rule', '2026-01-11 05:58:09'),
(29, NULL, 'chat_69633405a00714.18280597', 'goodbye', 'Au revoir!  Feel free to come back anytime you need help. Have a wonderful day!', 'rule', '2026-01-11 05:58:12'),
(30, NULL, 'chat_69633405a00714.18280597', 'thank you', 'You\'re very welcome!  I\'m always here to help!', 'rule', '2026-01-11 05:58:16'),
(31, NULL, 'chat_69633405a00714.18280597', 'can i ask something', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant! How can I help you today?', 'rule', '2026-01-11 05:59:20'),
(32, NULL, 'chat_69633405a00714.18280597', 'how do i personalize my account', 'You can personalize your account in the profile button. There, you will see a pen-like button next to your profile picture where you can change your profile picture.', 'rule', '2026-01-11 05:59:37'),
(33, NULL, 'chat_69633405a00714.18280597', 'change profile picture', 'You can personalize your account in the profile button. There, you will see a pen-like button next to your profile picture where you can change your profile picture.', 'rule', '2026-01-11 05:59:49'),
(34, NULL, 'chat_69633405a00714.18280597', 'what can i post', 'You can post images (jpeg, jpg, png) and videos (mp4) with description. However, there is a maximum of 5 images or 5 videos per post.', 'rule', '2026-01-11 05:59:55'),
(35, NULL, 'chat_69633405a00714.18280597', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 06:00:10'),
(36, NULL, 'chat_69633405a00714.18280597', 'comment rules', 'Hurtful, harmful, and swearing are STRICTLY not allowed! Please follow the rules in keeping a safe environment for each users.', 'rule', '2026-01-11 06:00:21'),
(37, NULL, 'chat_69633405a00714.18280597', '[MENU:Reporting Comments]', 'You can report any comment you believe breaks our rules, and our moderation team will review it carefully and take action if needed.', 'menu', '2026-01-11 06:00:28'),
(38, NULL, 'chat_69633405a00714.18280597', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 06:00:31'),
(39, NULL, 'chat_69633405a00714.18280597', '[MENU: Warnings & Bans]', 'Ok! Let\'s talk about Warnings & Bans', 'menu', '2026-01-11 06:00:35'),
(40, NULL, 'chat_69635c22b916c2.98203925', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 08:15:30'),
(41, NULL, 'chat_69635c22b916c2.98203925', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 08:16:03'),
(42, NULL, 'chat_69635c22b916c2.98203925', '[MENU:Business Account]', 'Users can post contents of their business but unfortunately, Soleil | Lune does not have a direct message feature. Instead, business owners who post contents of their store can include their whatsapp or viber account to continue the sales talk.', 'menu', '2026-01-11 08:16:45'),
(43, NULL, 'chat_69635c22b916c2.98203925', 'ban', 'Soleil | Lune does not support a mute feature. Warnings are only sent to the user and will result in content removal. Being warned 4 times will result in a ban.', 'rule', '2026-01-11 08:17:43'),
(44, NULL, 'chat_69635c22b916c2.98203925', '[MENU:Appeals & Disputes]', 'You can appeal for a warning or report upon receiving the warning in your email. You can reply to the email with your appeal with an explanation.', 'menu', '2026-01-11 08:17:59'),
(45, NULL, 'chat_69635c22b916c2.98203925', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 08:18:08'),
(46, NULL, 'chat_69635c22b916c2.98203925', '[MENU: Find People]', 'Ok! Let\'s talk about Finding People', 'menu', '2026-01-11 08:18:10'),
(47, NULL, 'chat_69635c22b916c2.98203925', 'account', 'Hmm, I\'m not quite sure about that!  Could you rephrase your question?\n\nOr select a topic below:', 'default', '2026-01-11 08:18:15'),
(48, NULL, 'chat_69635c22b916c2.98203925', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 08:18:24'),
(49, NULL, 'chat_69635c22b916c2.98203925', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 08:42:29'),
(50, NULL, 'chat_69635c22b916c2.98203925', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 08:42:37'),
(51, NULL, 'chat_69635c22b916c2.98203925', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 08:42:43'),
(52, NULL, 'chat_69635c22b916c2.98203925', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 08:42:52'),
(53, NULL, 'chat_69635c22b916c2.98203925', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 08:49:22'),
(54, NULL, 'chat_69635c22b916c2.98203925', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 08:49:28'),
(55, NULL, 'chat_69635c22b916c2.98203925', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 08:49:33'),
(56, NULL, 'chat_69635c22b916c2.98203925', '[MENU:Personalize Account]', 'You can personalize your account in the profile button. There, you will see a pen-like button next to your profile picture where you can change your profile picture.', 'menu', '2026-01-11 08:49:50'),
(57, NULL, 'chat_69635c22b916c2.98203925', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 08:49:55'),
(58, NULL, 'chat_69635c22b916c2.98203925', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 08:50:19'),
(59, NULL, 'chat_69635c22b916c2.98203925', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 08:55:30'),
(60, NULL, 'chat_69635c22b916c2.98203925', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 08:55:35'),
(61, NULL, 'chat_69635c22b916c2.98203925', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 08:57:29'),
(62, NULL, 'chat_69635c22b916c2.98203925', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 08:57:36'),
(63, NULL, 'chat_69635c22b916c2.98203925', '[MENU:Post Limit]', 'You can post as much as you like!', 'menu', '2026-01-11 08:57:41'),
(64, NULL, 'chat_69635c22b916c2.98203925', '[MENU:Choosing Category]', 'You can choose a category from the category selection that will be presented to you upon post creation.', 'menu', '2026-01-11 08:57:49'),
(65, NULL, 'chat_69635c22b916c2.98203925', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 08:58:05'),
(66, NULL, 'chat_69635c22b916c2.98203925', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 09:00:28'),
(67, NULL, 'chat_69635c22b916c2.98203925', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 09:00:32'),
(68, NULL, 'chat_69635c22b916c2.98203925', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 09:00:40'),
(69, NULL, 'chat_69635c22b916c2.98203925', '[MENU:Post Format]', 'You can post images (jpeg, jpg, png) and videos (mp4) with description. However, there is a maximum of 5 images or 5 videos per post.', 'menu', '2026-01-11 09:00:44'),
(70, NULL, 'chat_69635c22b916c2.98203925', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 09:00:57'),
(71, NULL, 'chat_69635c22b916c2.98203925', '[MENU: Warnings & Bans]', 'Ok! Let\'s talk about Warnings & Bans', 'menu', '2026-01-11 09:01:03'),
(72, NULL, 'chat_69635c22b916c2.98203925', '[MENU:Appeals & Disputes]', 'You can appeal for a warning or report upon receiving the warning in your email. You can reply to the email with your appeal with an explanation.', 'menu', '2026-01-11 09:01:11'),
(73, NULL, 'chat_696390dd473f27.10390698', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 12:00:29'),
(74, NULL, 'chat_696390dd473f27.10390698', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 12:00:35'),
(75, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:14:17'),
(76, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Find People]', 'Ok! Let\'s talk about Finding People', 'menu', '2026-01-11 13:14:24'),
(77, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Search People]', 'You can find new people, content creators, and business owners in the search button at the home page.', 'menu', '2026-01-11 13:14:30'),
(78, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:18:04'),
(79, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 13:18:09'),
(80, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Business Account]', 'Users can post contents of their business but unfortunately, Soleil | Lune does not have a direct message feature. Instead, business owners who post contents of their store can include their whatsapp or viber account to continue the sales talk.', 'menu', '2026-01-11 13:18:14'),
(81, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:19:21'),
(82, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 13:19:24'),
(83, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:19:51'),
(84, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 13:19:54'),
(85, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Post Format]', 'You can post images (jpeg, jpg, png) and videos (mp4) with description. However, there is a maximum of 5 images or 5 videos per post.', 'menu', '2026-01-11 13:20:03'),
(86, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:20:10'),
(87, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:20:30'),
(88, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 13:20:33'),
(89, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Post Limit]', 'You can post as much as you like!', 'menu', '2026-01-11 13:20:36'),
(90, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Post Limit]', 'You can post as much as you like!', 'menu', '2026-01-11 13:20:42'),
(91, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:25:16'),
(92, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 13:25:19'),
(93, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Business Account]', 'Users can post contents of their business but unfortunately, Soleil | Lune does not have a direct message feature. Instead, business owners who post contents of their store can include their whatsapp or viber account to continue the sales talk.', 'menu', '2026-01-11 13:25:23'),
(94, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Business Account]', 'Users can post contents of their business but unfortunately, Soleil | Lune does not have a direct message feature. Instead, business owners who post contents of their store can include their whatsapp or viber account to continue the sales talk.', 'menu', '2026-01-11 13:25:28'),
(95, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:27:57'),
(96, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 13:28:02'),
(97, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Post Limit]', 'You can post as much as you like!', 'menu', '2026-01-11 13:28:06'),
(98, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 13:28:10'),
(99, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:30:57'),
(100, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 13:31:00'),
(101, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Business Account]', 'Users can post contents of their business but unfortunately, Soleil | Lune does not have a direct message feature. Instead, business owners who post contents of their store can include their whatsapp or viber account to continue the sales talk.', 'menu', '2026-01-11 13:31:04'),
(102, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 13:31:07'),
(103, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:33:19'),
(104, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 13:33:21'),
(105, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Choosing Category]', 'You can choose a category from the category selection that will be presented to you upon post creation.', 'menu', '2026-01-11 13:33:25'),
(106, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Post Rules]', 'Ok! Let\'s talk about Post Rules', 'menu', '2026-01-11 13:33:29'),
(107, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:34:52'),
(108, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 13:34:55'),
(109, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Business Account]', 'Users can post contents of their business but unfortunately, Soleil | Lune does not have a direct message feature. Instead, business owners who post contents of their store can include their whatsapp or viber account to continue the sales talk.', 'menu', '2026-01-11 13:34:57'),
(110, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 13:35:01'),
(111, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:35:31'),
(112, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Comment Rules]', 'Ok! Let\'s talk about Comment Rules', 'menu', '2026-01-11 13:35:39'),
(113, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Reporting Comments]', 'You can report any comment you believe breaks our rules, and our moderation team will review it carefully and take action if needed.', 'menu', '2026-01-11 13:35:43'),
(114, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Comment Rules]', 'Ok! Let\'s talk about Comment Rules', 'menu', '2026-01-11 13:35:47'),
(115, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Comment Guidelines]', 'Hurtful, harmful, and swearing are STRICTLY not allowed! Please follow the rules in keeping a safe environment for each users.', 'menu', '2026-01-11 13:35:52'),
(116, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:36:18'),
(117, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:43:54'),
(118, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 13:43:59'),
(119, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Business Account]', 'Users can post contents of their business but unfortunately, Soleil | Lune does not have a direct message feature. Instead, business owners who post contents of their store can include their whatsapp or viber account to continue the sales talk.', 'menu', '2026-01-11 13:44:03'),
(120, NULL, 'chat_6963a229ad5708.51425008', '[MENU: Account & Profile]', 'Ok! Let\'s talk about Account & Profile', 'menu', '2026-01-11 13:44:09'),
(121, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:53:37'),
(122, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Post Rules]', 'What would you like to know about posting?', 'menu', '2026-01-11 13:53:41'),
(123, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Content Removal]', 'Content that violates our guidelines will be removed. This includes hate speech, spam, harassment, and inappropriate content. Our anti-hate system helps keep the community safe.', 'menu', '2026-01-11 13:53:45'),
(124, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Post Rules]', 'What would you like to know about posting?', 'menu', '2026-01-11 13:53:48'),
(125, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Post Format]', 'Posts should include a clear title and content. You can also add images to make your post more engaging. Keep your posts respectful and relevant to the community.', 'menu', '2026-01-11 13:53:58'),
(126, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Post Rules]', 'What would you like to know about posting?', 'menu', '2026-01-11 13:54:04'),
(127, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:54:35'),
(128, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:55:13'),
(129, NULL, 'chat_6963a229ad5708.51425008', 'warning', 'On Soleil | Lune, you can receive up to three warnings and each one is sent to your email with a chance to appeal by replying, but a fourth violation will result in a ban.', 'rule', '2026-01-11 13:55:19'),
(130, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Ban Duration]', 'Ban durations vary based on the severity of the violation. First offenses may result in temporary bans, while repeat violations can lead to permanent bans.', 'menu', '2026-01-11 13:55:27'),
(131, NULL, 'chat_6963a229ad5708.51425008', '[INIT]', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 13:55:31'),
(132, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Post Rules]', 'What would you like to know about posting?', 'menu', '2026-01-11 13:55:38'),
(133, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Choosing Category]', 'You can choose a category from the category selection that will be presented to you upon post creation. Categories include travels, education, fashion, entertainment, gaming, music, and more.', 'menu', '2026-01-11 13:55:47'),
(134, NULL, 'chat_6963a229ad5708.51425008', '[MENU:Post Rules]', 'What would you like to know about posting?', 'menu', '2026-01-11 13:55:51'),
(135, NULL, 'chat_6963d097d16c48.40512295', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-11 16:32:23'),
(136, NULL, 'chat_6963d097d16c48.40512295', 'hello', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant! How can I help you today?', 'rule', '2026-01-11 16:32:35'),
(137, NULL, 'chat_6963d097d16c48.40512295', 'thank you', 'You\'re very welcome!  I\'m always here to help!', 'rule', '2026-01-11 16:32:40'),
(138, NULL, 'chat_6964e805cb7487.71955605', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-12 12:24:37'),
(139, NULL, 'chat_6964e805cb7487.71955605', '[MENU:Account & Profile]', 'What would you like to know about accounts and profiles?', 'menu', '2026-01-12 12:24:45'),
(140, NULL, 'chat_6964e805cb7487.71955605', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-12 12:24:49'),
(141, NULL, 'chat_6964e805cb7487.71955605', '[MENU:Comment Rules]', 'What would you like to know about commenting?', 'menu', '2026-01-12 12:32:49'),
(142, NULL, 'chat_6964e805cb7487.71955605', '[MENU:How to Comment]', 'To comment on a post, you need to be logged in. Navigate to any post and scroll down to the comment section. Type your comment and click \"Add Comment\".', 'menu', '2026-01-12 12:32:56'),
(143, NULL, 'chat_6964e805cb7487.71955605', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-12 12:33:00'),
(144, 8, 'chat_6964e805cb7487.71955605', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-12 12:53:13'),
(145, 8, 'chat_6964e805cb7487.71955605', '[MENU:Account & Profile]', 'What would you like to know about accounts and profiles?', 'menu', '2026-01-12 12:59:12'),
(146, 8, 'chat_6964e805cb7487.71955605', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-12 13:04:39'),
(147, 8, 'chat_6964e805cb7487.71955605', '[MENU:Find People]', 'What would you like to know about finding people?', 'menu', '2026-01-12 13:06:34'),
(148, 8, 'chat_6964e805cb7487.71955605', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-12 13:07:05'),
(149, 8, 'chat_6964e805cb7487.71955605', '[MENU:Account & Profile]', 'What would you like to know about accounts and profiles?', 'menu', '2026-01-12 13:12:09'),
(150, 8, 'chat_6964e805cb7487.71955605', '[MENU:Personalize Account]', 'You can personalize your account by updating your profile information, changing your display name, and customizing your preferences in the profile settings.', 'menu', '2026-01-12 13:12:13'),
(151, 8, 'chat_6964e805cb7487.71955605', '[MENU:Account & Profile]', 'What would you like to know about accounts and profiles?', 'menu', '2026-01-12 13:12:35'),
(152, 8, 'chat_6964e805cb7487.71955605', '[MENU:Business Account]', 'Users can post contents of their business but unfortunately, Soleil|Lune does not have a direct message feature. Instead, business owners who post contents of their store can include their whatsapp or viber account to continue the sales talk.', 'menu', '2026-01-12 13:12:44'),
(153, 8, 'chat_6964e805cb7487.71955605', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-12 13:12:53'),
(154, 8, 'chat_6964e805cb7487.71955605', 'hello', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant! How can I help you today?', 'rule', '2026-01-12 13:13:47'),
(155, 8, 'chat_6964e805cb7487.71955605', 'personaluze customize', 'You can personalize your account in the profile button. There, you will see a pen-like button next to your profile picture where you can change your profile picture.', 'rule', '2026-01-12 13:14:30'),
(156, 8, 'chat_6964e805cb7487.71955605', 'post format how to post', 'You can post images (jpeg, jpg, png) and videos (mp4) with description. However, there is a maximum of 5 images or 5 videos per post.', 'rule', '2026-01-12 13:15:35'),
(157, 8, 'chat_6964e805cb7487.71955605', 'menu', 'Hmm, I\'m not quite sure about that! Could you rephrase your question?\n\nOr select a topic below:', 'default', '2026-01-12 13:16:11'),
(158, 8, 'chat_6964e805cb7487.71955605', 'can i go back to the menu', 'Hmm, I\'m not quite sure about that! Could you rephrase your question?\n\nOr select a topic below:', 'default', '2026-01-12 13:16:31'),
(159, 8, 'chat_696884d1ba8bb7.97405995', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-15 06:10:25'),
(160, 8, 'chat_6968dec98c8497.85825932', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-15 12:34:17'),
(161, 8, 'chat_6968dec98c8497.85825932', '[MENU:Comment Rules]', 'What would you like to know about commenting?', 'menu', '2026-01-15 12:34:21'),
(162, 8, 'chat_6968dec98c8497.85825932', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-15 12:34:26'),
(163, NULL, 'chat_696baa60589e25.42285117', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-17 15:27:28'),
(164, NULL, 'chat_696baa60589e25.42285117', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-17 16:24:57'),
(165, NULL, 'chat_696baa60589e25.42285117', '[MENU:Account & Profile]', 'What would you like to know about accounts and profiles?', 'menu', '2026-01-17 16:25:00'),
(166, NULL, 'chat_696baa60589e25.42285117', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-17 16:28:32'),
(167, NULL, 'chat_696baa60589e25.42285117', '[MENU:Account & Profile]', 'What would you like to know about accounts and profiles?', 'menu', '2026-01-17 16:28:35'),
(168, NULL, 'chat_696baa60589e25.42285117', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-17 16:28:42'),
(169, NULL, 'chat_696bd0da087b56.96755467', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-17 18:11:38'),
(170, NULL, 'chat_696bd0da087b56.96755467', '[MENU:Platform Support]', 'Get help with technical issues and platform features.', 'menu', '2026-01-17 18:11:41'),
(171, NULL, 'chat_696bd0da087b56.96755467', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-17 18:11:49'),
(172, NULL, 'chat_696bd0da087b56.96755467', '[MENU:Post Rules]', 'What would you like to know about posting?', 'menu', '2026-01-17 18:11:54'),
(173, NULL, 'chat_696bd0da087b56.96755467', '[MENU:Create & Edit]', 'Learn how to draft, format, publish, and manage your blog posts.', 'menu', '2026-01-17 18:12:00'),
(174, NULL, 'chat_696bd0da087b56.96755467', '[MENU:Post Rules]', 'What would you like to know about posting?', 'menu', '2026-01-17 18:12:09'),
(175, NULL, 'chat_696bd0da087b56.96755467', '[INIT]', 'Bonjour! I\'m Ami, your friendly Soleil|Lune assistant!\n\nHow can I help you today?', 'menu', '2026-01-17 18:12:12'),
(176, NULL, 'chat_696bd0da087b56.96755467', '[MENU:Find People]', 'What would you like to know about finding people?', 'menu', '2026-01-17 18:12:21'),
(177, NULL, 'chat_696bd0da087b56.96755467', '[MENU:Network & Feed]', 'Learn how to follow users and view your personalized feed.', 'menu', '2026-01-17 18:12:26');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_menu`
--

CREATE TABLE `chatbot_menu` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `button_text` varchar(100) NOT NULL,
  `response_text` text NOT NULL,
  `has_children` tinyint(1) DEFAULT 0,
  `link_url` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatbot_menu`
--

INSERT INTO `chatbot_menu` (`id`, `parent_id`, `button_text`, `response_text`, `has_children`, `link_url`, `display_order`, `created_at`) VALUES
(1, NULL, 'Account & Profile', 'What would you like to know about accounts and profiles?', 1, NULL, 1, '2026-01-11 13:52:56'),
(2, NULL, 'Post Rules', 'What would you like to know about posting?', 1, NULL, 2, '2026-01-11 13:52:56'),
(3, NULL, 'Comment Rules', 'What would you like to know about commenting?', 1, NULL, 3, '2026-01-11 13:52:56'),
(4, NULL, 'Warnings & Bans', 'What would you like to know about warnings and bans?', 1, NULL, 4, '2026-01-11 13:52:56'),
(5, NULL, 'Find People', 'What would you like to know about finding people?', 1, NULL, 5, '2026-01-11 13:52:56'),
(6, 1, 'Personalize Account', 'You can personalize your account by updating your profile information, changing your display name, and customizing your preferences in the profile settings.', 0, '/Soleil-Lune/public/profile.php', 1, '2026-01-11 13:53:02'),
(7, 1, 'Business Account', 'Users can post contents of their business but unfortunately, Soleil|Lune does not have a direct message feature. Instead, business owners who post contents of their store can include their whatsapp or viber account to continue the sales talk.', 0, NULL, 2, '2026-01-11 13:53:02'),
(8, 2, 'Post Format', 'Posts should include a clear title and content. You can also add images to make your post more engaging. Keep your posts respectful and relevant to the community.', 0, NULL, 1, '2026-01-11 13:53:07'),
(9, 2, 'Choosing Category', 'You can choose a category from the category selection that will be presented to you upon post creation. Categories include travels, education, fashion, entertainment, gaming, music, and more.', 0, '/Soleil-Lune/public/categories.php', 2, '2026-01-11 13:53:07'),
(10, 2, 'Post Limit', 'You can post as much as you like! There is no daily limit on how many posts you can create. Just make sure each post follows our community guidelines.', 0, NULL, 3, '2026-01-11 13:53:07'),
(11, 2, 'Delete Post', 'To delete your post, go to your post page and click the delete button. Note that only admins can delete posts. Regular users can report posts that violate guidelines.', 0, NULL, 4, '2026-01-11 13:53:07'),
(12, 2, 'Content Removal', 'Content that violates our guidelines will be removed. This includes hate speech, spam, harassment, and inappropriate content. Our anti-hate system helps keep the community safe.', 0, NULL, 5, '2026-01-11 13:53:07'),
(13, 3, 'How to Comment', 'To comment on a post, you need to be logged in. Navigate to any post and scroll down to the comment section. Type your comment and click \"Add Comment\".', 0, '/Soleil-Lune/public/auth.php?action=login', 1, '2026-01-11 13:53:10'),
(14, 3, 'Comment Guidelines', 'Comments should be respectful and relevant to the post. Hate speech, spam, and harassment are not allowed. Keep discussions constructive and friendly.', 0, NULL, 2, '2026-01-11 13:53:10'),
(15, 3, 'Delete Comment', 'You can delete your own comments by clicking the delete button next to your comment. You cannot delete other users comments unless you are an admin.', 0, NULL, 3, '2026-01-11 13:53:10'),
(16, 4, 'Why Get Warned', 'You may receive a warning for violating community guidelines, posting inappropriate content, harassment, or spam. Warnings are meant to help you understand the rules.', 0, NULL, 1, '2026-01-11 13:53:13'),
(17, 4, 'Ban Duration', 'Ban durations vary based on the severity of the violation. First offenses may result in temporary bans, while repeat violations can lead to permanent bans.', 0, NULL, 2, '2026-01-11 13:53:13'),
(18, 4, 'Appeal Process', 'If you believe you were banned unfairly, you can contact the administrators to appeal your ban. Provide clear reasoning and evidence to support your appeal.', 0, NULL, 3, '2026-01-11 13:53:13'),
(19, 5, 'Search Users', 'You can find people by using the search feature. Search for users by their name or browse through recent posts to discover content creators.', 0, NULL, 1, '2026-01-11 13:53:16'),
(20, 5, 'View Authors', 'Check out all content creators on our Authors page. You can see their post count, likes, and comments, then view all their posts.', 0, '/Soleil-Lune/public/authors.php', 2, '2026-01-11 13:53:16'),
(21, 5, 'Follow Users', 'While we dont have a direct follow feature yet, you can bookmark your favorite authors by visiting their profile pages regularly or searching for their names.', 0, NULL, 3, '2026-01-11 13:53:16'),
(22, 1, 'Account Setup', 'Guides for signing up, logging in, and password recovery.', 0, '/Soleil-Lune/public/profile.php', 3, '2026-01-17 16:28:09'),
(23, 1, 'Profile Management', 'Manage your username, bio, and account visibility settings', 0, NULL, 4, '2026-01-17 16:28:09'),
(24, 2, 'Create & Edit', 'Learn how to draft, format, publish, and manage your blog posts.', 0, NULL, 6, '2026-01-17 16:28:13'),
(25, 2, 'Post Interaction', 'Information on liking, sharing, and engaging with content.', 0, NULL, 7, '2026-01-17 16:28:13'),
(26, 3, 'How to Comment', 'Instructions on posting, editing, and removing comments on blogs.', 0, NULL, 4, '2026-01-17 16:28:16'),
(27, 4, 'Community Guidelines', 'Read about prohibited content, safety rules, and acceptable behavior.', 0, NULL, 4, '2026-01-17 16:28:21'),
(28, 4, 'Report & Appeal', 'Tools for reporting violations and appealing moderation decisions.', 0, NULL, 5, '2026-01-17 16:28:21'),
(29, 5, 'Search & Discovery', 'Find new content via search, trending lists, and categories.', 0, NULL, 4, '2026-01-17 16:28:24'),
(30, 5, 'Network & Feed', 'Learn how to follow users and view your personalized feed.', 0, NULL, 5, '2026-01-17 16:28:24'),
(31, 1, 'Data Privacy', 'Your personal information and content are protected in accordance with our privacy policy. Personal data is securely stored and handled according to platform security standards to prevent unauthorized access.', 0, NULL, 5, '2026-01-17 18:10:35'),
(32, 1, 'Profile Visibility', 'You can manage your profile visibility by updating your profile information and choosing what details to display publicly through your account settings.', 0, '/Soleil-Lune/public/profile.php', 6, '2026-01-17 18:10:35'),
(33, 2, 'Content Visibility', 'Published posts are publicly viewable unless removed for moderation reasons. Posts are shown based on recent activity and engagement.', 0, NULL, 8, '2026-01-17 18:10:39'),
(34, 2, 'Post Ownership', 'You retain ownership of your content, while Soleil|Lune ensures safe sharing. Reposting content is allowed only if proper credit is given and it doesn\'t violate copyright or platform rules.', 0, NULL, 9, '2026-01-17 18:10:39'),
(35, 3, 'Language Rules', 'Avoid profanity, slurs, or any content that may harm the community. All language must be appropriate and community-friendly.', 0, NULL, 4, '2026-01-17 18:10:42'),
(36, 3, 'Community Standards', 'Adhere to community standards to maintain a safe and positive environment. Feedback should focus on the content and be polite and constructive.', 0, NULL, 5, '2026-01-17 18:10:42'),
(37, 4, 'Moderation Process', 'Moderators carefully review flagged content to ensure rules are followed. Comments with multiple reports are reviewed by moderators to determine if they violate community standards.', 0, NULL, 6, '2026-01-17 18:10:45'),
(38, 4, 'Temporary Restrictions', 'Certain actions, like posting or commenting, may be limited for a period. Restriction duration depends on the violation severity and will be communicated to you via email.', 0, NULL, 7, '2026-01-17 18:10:45'),
(39, 4, 'Moderation Process', 'Moderators carefully review flagged content to ensure rules are followed. Comments with multiple reports are reviewed by moderators to determine if they violate community standards.', 0, NULL, 6, '2026-01-17 18:10:52'),
(40, 4, 'Temporary Restrictions', 'Certain actions, like posting or commenting, may be limited for a period. Restriction duration depends on the violation severity and will be communicated to you via email.', 0, NULL, 7, '2026-01-17 18:10:52'),
(41, NULL, 'Platform Support', 'Get help with technical issues and platform features.', 1, NULL, 6, '2026-01-17 18:10:55'),
(42, 31, 'Supported Devices', 'Soleil|Lune works on desktop browsers and mobile devices with a responsive interface. The platform is optimized for mobile and desktop browsers.', 0, NULL, 1, '2026-01-17 18:10:59'),
(43, 31, 'Maintenance & Downtime', 'Scheduled maintenance may temporarily make some features unavailable. We notify users of planned downtime in advance.', 0, NULL, 2, '2026-01-17 18:10:59'),
(44, 31, 'Contact Support', 'Use the Help section or the contact form to reach support for any issues you\'re experiencing.', 0, NULL, 3, '2026-01-17 18:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_rules`
--

CREATE TABLE `chatbot_rules` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `keywords` text NOT NULL,
  `response_text` text NOT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `priority` int(11) DEFAULT 5,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatbot_rules`
--

INSERT INTO `chatbot_rules` (`id`, `menu_id`, `keywords`, `response_text`, `button_text`, `button_link`, `priority`, `created_at`) VALUES
(1, NULL, 'block|blocking|block user|block someone|unblock', 'You can block users by going to their account and pressing the three dots next to their user name where you can choose to block or report them.', NULL, NULL, 7, '2026-01-11 05:48:57'),
(2, NULL, 'rules broken|what rules|which rule|violated rules|broke rules', 'If you broke the rules, your account will be sent a warning and the content removed. Each user has 3 maximum warnings; the 4th violation results in an account ban.', NULL, NULL, 8, '2026-01-11 05:48:57'),
(3, NULL, 'hello|hi|hey|bonjour|hola|greetings|good morning|good afternoon|good evening', 'Bonjour!  I\'m Ami, your friendly Soleil|Lune assistant! How can I help you today?', NULL, NULL, 10, '2026-01-11 05:54:17'),
(4, NULL, 'bye|goodbye|see you|au revoir|cya|later|gotta go|exit', 'Au revoir!  Feel free to come back anytime you need help. Have a wonderful day!', NULL, NULL, 10, '2026-01-11 05:54:17'),
(5, NULL, 'thanks|thank you|merci|thx|ty|appreciate|grateful', 'You\'re very welcome!  I\'m always here to help!', NULL, NULL, 10, '2026-01-11 05:54:17'),
(6, 1, 'personalize|customize|change profile|edit profile|update profile|profile picture', 'You can personalize your account in the profile button. There, you will see a pen-like button next to your profile picture where you can change your profile picture.', 'Update Profile', '/Soleil-Lune/public/profile.php', 8, '2026-01-11 05:54:20'),
(7, 1, 'business|business account|sell|selling|store|shop', 'Users can post contents of their business but unfortunately, Soleil | Lune does not have a direct message feature. Instead, business owners can include their whatsapp or viber account.', 'Create Post', '/Soleil-Lune/public/posts.php', 7, '2026-01-11 05:54:20'),
(8, 2, 'post format|how to post|posting|upload|what can i post|post type', 'You can post images (jpeg, jpg, png) and videos (mp4) with description. However, there is a maximum of 5 images or 5 videos per post.', 'Create Post', '/Soleil-Lune/public/posts.php', 7, '2026-01-11 05:54:22'),
(9, 2, 'category|categories|tag|tags|choose category|select category', 'You can choose a category from the category selection that will be presented to you upon post creation.', 'View Categories', '/Soleil-Lune/public/categories.php', 7, '2026-01-11 05:54:22'),
(10, 2, 'post limit|how many posts|post maximum|posting limit|limit post', 'You can post as much as you like!', 'Start Posting', '/Soleil-Lune/public/posts.php', 7, '2026-01-11 05:54:22'),
(11, 2, 'delete post|remove post|delete my post|how to delete', 'You can delete your post by clicking your post and selecting delete.', 'View My Posts', '/Soleil-Lune/public/profile.php', 7, '2026-01-11 05:54:22'),
(12, 2, 'post removed|why removed|why was my post removed|post deleted', 'Your post must\'ve violated our strict rules for keeping Soleil | Lune safe and hate post/comments free.', NULL, NULL, 8, '2026-01-11 05:54:22'),
(13, 2, 'content removal|remove content|deleted content|removed post', 'Contents that violate the rules and regulation of Soleil | Lune will receive a warning and the content will automatically be removed.', NULL, NULL, 8, '2026-01-11 05:54:22'),
(14, 3, 'comment rules|commenting rules|comment guidelines|can i swear|profanity', 'Hurtful, harmful, and swearing are STRICTLY not allowed! Please follow the rules in keeping a safe environment for each users.', NULL, NULL, 9, '2026-01-11 05:54:26'),
(15, 3, 'report|reporting|how to report|report post|report comment|flag', 'You can report any post or comment you believe breaks our rules, and our moderation team will review it carefully and take action if needed.', NULL, NULL, 8, '2026-01-11 05:54:26'),
(16, 3, 'comment removed|why removed comment|why was my comment removed|comment deleted', 'Your comment must\'ve violated our strict rules for keeping Soleil | Lune safe and hate post/comments free.', NULL, NULL, 8, '2026-01-11 05:54:26'),
(17, 4, 'warning|warnings|strikes|how many warnings|three strikes', 'On Soleil | Lune, you can receive up to three warnings and each one is sent to your email with a chance to appeal by replying, but a fourth violation will result in a ban.', NULL, NULL, 9, '2026-01-11 05:54:29'),
(18, 4, 'appeal|dispute|contest warning|disagree|unfair|challenge warning', 'You can appeal for a warning or report upon receiving the warning in your email. You can reply to the email with your appeal with an explanation.', NULL, NULL, 8, '2026-01-11 05:54:29'),
(19, 4, 'warning reset|warnings reset|do warnings reset|clear warnings|expire', 'Each user has 3 maximum warnings and the 4th will result in an account ban. Warnings, however, are reset every 6 months.', NULL, NULL, 8, '2026-01-11 05:54:29'),
(20, 4, 'permanent ban|perma ban|forever ban|permanently banned|banned forever', 'A permanent ban means your account has been permanently removed for repeated or severe rule violations.', NULL, NULL, 9, '2026-01-11 05:54:29'),
(21, 4, 'banned|new account|create account|banned account|make new|after ban', 'Banned users are not allowed to create new accounts, and any attempts to do so may result in immediate removal.', NULL, NULL, 8, '2026-01-11 05:54:29'),
(22, 4, 'hate speech|criticism|difference|confused|what is hate speech|vs criticism', 'Hate speech attacks or uses derogatory language. Criticism expresses disapproval based on perceived faults. Share your thoughts in a nice way on Soleil | Lune.', NULL, NULL, 9, '2026-01-11 05:54:29'),
(23, 4, 'mute|muted|get muted|warning mute|ban|automatic ban', 'Soleil | Lune does not support a mute feature. Warnings are only sent to the user and will result in content removal. Being warned 4 times will result in a ban.', NULL, NULL, 8, '2026-01-11 05:54:29'),
(24, 4, 'restricted|restriction|account restricted|limited|temporarily limited', 'If your account is restricted, certain actions are temporarily limited due to a rule violation. You\'ll receive an email explaining what happened and how to appeal.', NULL, NULL, 8, '2026-01-11 05:54:29'),
(25, 4, 'view content|suspended|restricted|can i view|still see|while suspended', 'Yes, you can still view content while your account is suspended or restricted, but actions like posting or commenting may be temporarily disabled.', NULL, NULL, 7, '2026-01-11 05:54:29'),
(26, 5, 'find people|search people|find users|discover|content creators', 'You can find new people, content creators, and business owners in the search button at the home page.', 'Search Now', '/Soleil-Lune/public/posts.php', 7, '2026-01-11 05:54:35'),
(27, 5, 'trending|trends|popular|latest|whats hot|whats new', 'You can access the latest trends and posts in the sidebar at the homepage.', 'Go to Home', '/Soleil-Lune/public/index.php', 7, '2026-01-11 05:54:35'),
(28, NULL, 'block|blocking|block user|block someone|unblock', 'You can block users by going to their account and pressing the three dots next to their user name where you can choose to block or report them.', NULL, NULL, 7, '2026-01-11 05:54:41'),
(29, NULL, 'rules broken|what rules|which rule|violated rules|broke rules', 'If you broke the rules, your account will be sent a warning and the content removed. Each user has 3 maximum warnings; the 4th violation results in an account ban.', NULL, NULL, 8, '2026-01-11 05:54:41'),
(30, 1, 'privacy|personal info|safe|data protection', 'Personal data is protected according to the platform\'s privacy policy. User data is securely stored and handled according to platform security standards to prevent unauthorized access.', NULL, NULL, 8, '2026-01-17 18:11:05'),
(31, 1, 'account status|standing|check account', 'Your account status reflects past moderation actions and adherence to rules. You can view your account standing in your profile settings.', 'View Profile', '/Soleil-Lune/public/profile.php', 7, '2026-01-17 18:11:05'),
(32, 1, 'saved posts|private|bookmarks', 'No, saved posts are private and only visible to you.', NULL, NULL, 7, '2026-01-17 18:11:05'),
(33, 1, 'notifications|alerts|system alert', 'You can manage alerts in your account settings or mute specific posts.', 'Account Settings', '/Soleil-Lune/public/profile.php', 7, '2026-01-17 18:11:05'),
(34, 1, 'account responsibility|responsible|liability', 'Yes, users are responsible for all content they post.', NULL, NULL, 8, '2026-01-17 18:11:05'),
(35, 1, 'sign up|create account|register|new account', 'Click \"Sign Up\", enter your email, username, and password, then verify your email to create your account.', 'Sign Up', '/Soleil-Lune/public/auth.php?action=register', 8, '2026-01-17 18:11:05'),
(36, 1, 'forgot password|reset password|password recovery', 'Click \"Forgot Password?\" on the login page, enter your email, and follow the reset link we send you.', 'Reset Password', '/Soleil-Lune/public/auth.php?action=login', 8, '2026-01-17 18:11:05'),
(37, 1, 'change username|username|handle|display name', 'Yes, go to account settings and update your profile information. Note that this will change your profile URL.', 'Edit Profile', '/Soleil-Lune/public/profile.php', 7, '2026-01-17 18:11:05'),
(38, 1, 'cost|free|price|subscription', 'Yes, Soleil|Lune is completely free! You can post, comment, like, and explore all features at no cost.', NULL, NULL, 9, '2026-01-17 18:11:05'),
(39, 1, 'inactive account|unused|dormant', 'Inactive accounts remain accessible, but certain features may be limited until you log in again to confirm activity.', NULL, NULL, 7, '2026-01-17 18:11:05'),
(40, 1, 'deactivate|temporary|disable account', 'Temporary deactivation is not available, but you may stop using your account at any time without losing your data.', NULL, NULL, 7, '2026-01-17 18:11:05'),
(41, 1, 'visibility|profile|who can see', 'You can manage your profile visibility by updating your profile information and choosing what details to display publicly through your account settings.', 'Profile Settings', '/Soleil-Lune/public/profile.php', 7, '2026-01-17 18:11:05'),
(42, 2, 'who can see|visibility|public|private posts', 'Published posts are publicly visible unless removed for moderation.', NULL, NULL, 7, '2026-01-17 18:11:10'),
(43, 2, 'trending|popular|hot posts', 'Trending posts are based on recent interactions and user engagement.', 'View Trending', '/Soleil-Lune/public/index.php', 7, '2026-01-17 18:11:10'),
(44, 2, 'ownership|copyright|my content|intellectual property', 'You retain ownership of your content, while Soleil|Lune ensures safe sharing.', NULL, NULL, 8, '2026-01-17 18:11:10'),
(45, 2, 'draft|save|unpublished', 'Yes, click \"Save as Draft\" instead of \"Publish.\" Find it later in your dashboard under \"My Posts.\"', 'My Posts', '/Soleil-Lune/public/profile.php', 7, '2026-01-17 18:11:10'),
(46, 2, 'post order|recent|feed|timeline', 'Posts are shown based on recent activity and engagement.', NULL, NULL, 6, '2026-01-17 18:11:10'),
(47, 2, 'allowed topics|prohibited|banned content', 'Posts that promote harm, discrimination, or violate community standards are not allowed and may be removed.', NULL, NULL, 9, '2026-01-17 18:11:10'),
(48, 2, 'edit post|modify|update post', 'Yes, posts can be edited after publishing unless they are locked due to moderation review. Go to \"My Posts\", find your post, and click \"Edit\".', 'My Posts', '/Soleil-Lune/public/profile.php', 7, '2026-01-17 18:11:10'),
(49, 2, 'repost|copied content|share|republish', 'Reposting content is allowed only if proper credit is given and the content does not violate copyright or platform rules.', NULL, NULL, 8, '2026-01-17 18:11:10'),
(50, 2, 'images|photos|media|video|upload', 'Yes! You can upload images/videos and add keywords in the tags field when creating a post.', 'Create Post', '/Soleil-Lune/public/posts.php', 7, '2026-01-17 18:11:10'),
(51, 2, 'like|heart|favorite|save post', 'Click the heart icon to like a post. You can view your liked posts in your profile.', NULL, NULL, 7, '2026-01-17 18:11:10'),
(52, 3, 'language|appropriate|clean|suitable', 'All comments must be respectful and free from harmful or offensive language.', NULL, NULL, 9, '2026-01-17 18:11:14'),
(53, 3, 'feedback|constructive|criticism|advice', 'Feedback should focus on the content and be polite and constructive.', NULL, NULL, 8, '2026-01-17 18:11:14'),
(54, 3, 'swearing|curse|profanity|offensive', 'No, all language must be appropriate and community-friendly.', NULL, NULL, 9, '2026-01-17 18:11:14'),
(55, 3, 'emoji|slang|casual|informal', 'Emojis and casual language are allowed as long as comments remain respectful and appropriate.', NULL, NULL, 6, '2026-01-17 18:11:14'),
(56, 3, 'disable comments|turn off|prevent comments', 'Comments may be limited or disabled on certain posts to maintain respectful discussions.', NULL, NULL, 7, '2026-01-17 18:11:14'),
(57, 3, 'argument|conflict|fight|hostile', 'If discussions become hostile or disruptive, moderators may remove comments or limit further replies to maintain a respectful environment.', NULL, NULL, 8, '2026-01-17 18:11:14'),
(58, 3, 'edit comment|modify comment|change comment', 'Yes, click the three dots next to your comment and select \"Edit\" or \"Delete\".', NULL, NULL, 7, '2026-01-17 18:11:14'),
(59, 4, 'moderation|review|flagged|reported content', 'Moderators carefully review flagged content to ensure rules are followed. Usually takes 24-48 hours, with urgent safety issues prioritized.', NULL, NULL, 8, '2026-01-17 18:11:17'),
(60, 4, 'penalty|consequences|punishment', 'You may receive warnings, and repeated violations can result in temporary restrictions.', NULL, NULL, 8, '2026-01-17 18:11:17'),
(61, 4, 'temporary restriction|limited|suspended', 'Certain actions, like posting or commenting, may be limited for a period. Restriction duration depends on the violation severity.', NULL, NULL, 8, '2026-01-17 18:11:17'),
(62, 4, 'anonymous|privacy|confidential|reporter', 'Reports are anonymous and the identity of the reporter is never revealed.', NULL, NULL, 8, '2026-01-17 18:11:17'),
(63, 4, 'multiple reports|many reports|flagged multiple', 'Comments with multiple reports are reviewed by moderators to determine if they violate community standards.', NULL, NULL, 8, '2026-01-17 18:11:17'),
(64, 4, 'immediate ban|instant ban|no warning', 'Severe violations may result in immediate account bans without prior warnings.', NULL, NULL, 9, '2026-01-17 18:11:17'),
(65, 4, 'duration|how long|restriction length', 'Restriction duration depends on the violation severity and will be communicated to you via email.', NULL, NULL, 7, '2026-01-17 18:11:17'),
(66, 4, 'warning visibility|impact|affect', 'Receiving warnings may affect your account standing and could limit certain interactions temporarily.', NULL, NULL, 7, '2026-01-17 18:11:17'),
(67, 4, 'harassment|bully|abuse|threatening', 'You can report the user through their profile or content, and block them by visiting their profile and selecting \"Block\".', NULL, NULL, 9, '2026-01-17 18:11:17'),
(68, 5, 'search users|find profile|discover people', 'You can search for users using their username or by exploring posts and author profiles.', 'Search', '/Soleil-Lune/public/authors.php', 7, '2026-01-17 18:11:21'),
(69, 5, 'cannot find|missing user|user not found', 'The user may have changed their username, deactivated their account, or restricted visibility.', NULL, NULL, 7, '2026-01-17 18:11:21'),
(70, 5, 'follow|save|track users|subscribe', 'You can keep track of users by interacting with their posts and visiting their profiles anytime.', 'View Authors', '/Soleil-Lune/public/authors.php', 7, '2026-01-17 18:11:21'),
(71, 5, 'feed|following|timeline|homepage', 'Check your feed on the homepage to see posts from people you follow and trending content.', 'Go to Home', '/Soleil-Lune/public/index.php', 7, '2026-01-17 18:11:21'),
(72, 5, 'filter|sort|browse|category', 'Yes, click on any category like Travel, Education, or Entertainment to see posts from that topic.', 'View Categories', '/Soleil-Lune/public/categories.php', 7, '2026-01-17 18:11:21'),
(73, NULL, 'devices|mobile|phone|tablet|desktop', 'Yes, the platform is optimized for mobile and desktop browsers. Soleil|Lune works on all modern devices.', NULL, NULL, 7, '2026-01-17 18:11:24'),
(74, NULL, 'maintenance|downtime|unavailable|offline', 'Scheduled maintenance may temporarily make some features unavailable. We notify users of planned downtime in advance.', NULL, NULL, 7, '2026-01-17 18:11:24'),
(75, NULL, 'help|support|contact|assistance', 'Use the Help section or contact support for any issues you\'re experiencing with the platform.', NULL, NULL, 8, '2026-01-17 18:11:24');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(100) NOT NULL,
  `post_id` int(100) NOT NULL,
  `admin_id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `admin_id`, `user_id`, `user_name`, `comment`, `date`) VALUES
(4, 1, 1, 5, 'the8', 'example text', '2025-01-24'),
(7, 5, 1, 8, 'Crissel Ann G. Zapat', 'awsome really, cool', '2026-01-09'),
(8, 8, 2, 8, 'Sel Zap', 'My new comment', '2026-01-12'),
(9, 1, 1, 8, 'Sel Zap', 'new comment', '2026-01-15'),
(14, 10, 8, 8, 'Sel Zap', 'new comment', '2026-01-15');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `admin_id` int(100) NOT NULL,
  `post_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `admin_id`, `post_id`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 2),
(3, 3, 1, 1),
(4, 4, 1, 2),
(5, 4, 1, 4),
(6, 5, 1, 2),
(7, 5, 1, 4),
(8, 6, 1, 1),
(10, 8, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(100) NOT NULL,
  `admin_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `admin_id`, `name`, `title`, `content`, `category`, `image`, `date`, `status`) VALUES
(1, 1, 'admin', 'Example #1', 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'education', '74a983161dc40b6f3e51f95165d9c81d.jpg', '2025-01-18', 'active'),
(2, 1, 'admin_1', 'Travels to boracay', 'Lorem ipsum odor amet, consectetuer adipiscing elit. Urna nunc vestibulum netus; tristique aptent facilisis. Auctor pellentesque maximus enim lobortis curabitur fermentum. Nascetur cubilia ultrices augue lacus tortor sagittis nam. Tempor urna ut eros nam laoreet eu aenean justo. Augue leo scelerisque dapibus sem risus odio. Mauris proin massa vestibulum condimentum sapien; mollis congue. Ullamcorper blandit curae nascetur in suscipit maecenas pharetra.\r\n\r\nTincidunt aptent morbi at ipsum duis fermentum. Himenaeos eros feugiat sed placerat ad libero. Orci lacinia platea accumsan ut; ridiculus sapien ornare. Quis elit facilisis habitant ornare mus. Odio id praesent congue proin leo orci ut. Dignissim luctus rutrum magna; auctor ullamcorper ultricies volutpat.\r\n\r\nPer dolor magna curabitur, rhoncus fringilla pulvinar. Id facilisi ad eget platea ut aenean vulputate habitasse suspendisse. Nec integer ultricies dictum cursus cubilia fusce magna in non. Justo lobortis natoque vitae sit placerat maecenas ultrices nulla nec. Turpis taciti orci vivamus vitae blandit luctus eu urna. Velit lectus eget sodales torquent eleifend; litora faucibus tristique.\r\n\r\nVenenatis tortor nullam mus eleifend porta facilisis cursus. Duis laoreet varius suscipit lectus aliquet urna gravida. Lacinia risus blandit cubilia nisi eleifend nostra. Ut per lacinia risus tellus viverra maximus ultrices. Lobortis fames platea libero per interdum donec gravida. Etiam taciti platea ligula convallis facilisi nunc donec litora. Semper orci id ante vestibulum integer enim.\r\n\r\nTorquent litora sed feugiat suspendisse nostra facilisi. Amet id velit integer augue quisque neque quam at. Congue rhoncus feugiat rutrum dignissim maecenas aptent ante molestie. Aliquam sem imperdiet platea tincidunt ornare urna montes tempor. Mus at ridiculus egestas luctus blandit facilisi. Arcu hac porttitor ipsum nascetur justo vel conubia facilisis. Aeuismod morbi; montes donec torquent ex.\r\n\r\nSemper quam lacinia phasellus ut donec ullamcorper. Proin ultrices mi ad etiam eu himenaeos. Natoque condimentum sem potenti mi eget. Vehicula placerat faucibus orci blandit convallis, cursus pretium tempus. Scelerisque eros lacinia euismod id sapien eros lectus eros tristique. Ac donec curabitur cubilia mollis auctor metus. Nostra risus mattis mollis sollicitudin dictumst imperdiet et. Urna eros imperdiet interdum cras mauris penatibus orci.\r\n\r\nCongue vulputate semper himenaeos parturient etiam cubilia interdum ligula. Sollicitudin donec eu torquent interdum sem gravida vehicula vulputate. Nulla luctus mus rhoncus vivamus enim. Tellus facilisi eleifend dapibus a curae finibus montes. Feugiat eleifend hac mus platea erat augue. Orci hac arcu ligula tristique rutrum nunc convallis. Dis nisi tempor elit facilisi vehicula dapibus quisque quam.\r\n\r\nSapien egestas justo maximus tortor libero. Cubilia dictumst consectetur dui cubilia ad enim bibendum neque. Dictum malesuada dapibus facilisi ridiculus purus luctus fusce. Sociosqu integer mus ac; maecenas cras tincidunt sagittis. Nulla felis varius class felis dapibus litora adipiscing? Vulputate etiam luctus maecenas efficitur litora gravida sem vivamus. Consectetur ornare felis enim ridiculus tempor ad consectetur gravida bibendum. Lectus vitae senectus ultricies luctus nisl parturient vestibulum litora. Nisi egestas sodales maximus consequat consequat aenean bibendum eu. Hac finibus magna laoreet lacinia, eros porta tincidunt.\r\n\r\nNon porta amet parturient; cubilia aliquam pharetra. Fusce interdum justo; tellus augue cras nisl. Fringilla eu nunc pellentesque nisi volutpat mauris mattis dictumst. Litora pretium aenean vulputate blandit parturient enim. Euismod posuere tempus non nascetur mi tellus cubilia. Suspendisse quisque integer viverra urna urna integer primis.\r\n\r\nEleifend porta tortor natoque facilisi at; convallis tincidunt. Pulvinar eget ridiculus, urna porttitor ultricies semper ut. Faucibus netus tempor natoque fermentum pulvinar mus. Venenatis bibendum ac in sociosqu nisl commodo sapien nunc. Sem id nisl integer; egestas neque finibus. Ex tincidunt justo eget gravida semper imperdiet sollicitudin natoque. Eget lorem eros fusce natoque vitae. Urna venenatis convallis class ligula molestie mauris inceptos bibendum. Efficitur dis facilisi porta curae placerat vestibulum platea tortor? Convallis molestie natoque pulvinar purus amet.', 'travels', '20230809_072518.jpg', '2025-01-18', 'active'),
(3, 2, 'crissel', 'Domo crochet', 'Lorem ipsum odor amet, consectetuer adipiscing elit. Natoque sit eget ligula litora purus ligula lacinia libero sociosqu. Iaculis platea viverra neque eros at lobortis nostra? Nostra iaculis tincidunt ultrices in cubilia penatibus. Luctus tempus sapien leo lorem suspendisse cursus per sociosqu posuere. Facilisi amet magna arcu ligula praesent fringilla bibendum suscipit. Iaculis mi penatibus non vestibulum mollis felis. Venenatis dis nisl parturient arcu natoque. Lacus tempus consectetur cursus proin porta nam.\r\n\r\nNetus vulputate curabitur phasellus etiam praesent accumsan parturient fusce. Nunc erat parturient consectetur maximus tellus auctor aliquet hac. Penatibus enim nisl dui cursus, feugiat turpis vestibulum quisque efficitur. Pretium nibh iaculis dapibus scelerisque habitasse orci posuere risus. Mollis ut litora; ac lectus cras ante. Lectus tincidunt litora eget pellentesque tincidunt risus pharetra dui. Eros libero aenean venenatis at nostra. In consectetur pharetra morbi nullam blandit proin molestie ante. Nec facilisis nam diam leo iaculis.\r\n\r\nViverra ligula varius potenti; tempus lacinia vestibulum. Habitant tellus magnis vestibulum commodo cubilia nulla, semper etiam. Quis dui neque tempus eleifend urna sollicitudin. Fames per phasellus, vulputate montes euismod massa parturient pretium elit. Ad velit integer iaculis nullam; cursus orci. Morbi netus est luctus hendrerit, placerat semper mattis amet duis. Porttitor elit eu ac ex torquent at nisi pretium justo. Leo torquent vivamus egestas potenti penatibus eros.', 'fashion,style,shopping', '9b77df6aab00697373f7ca1b5cee65cc.jpg', '2025-01-18', 'active'),
(4, 1, 'juju', 'Concerts', 'Lorem ipsum odor amet, consectetuer adipiscing elit. Est in cras ac leo primis in. Auctor tellus magna placerat sollicitudin faucibus fermentum ad. Tellus arcu at morbi vel maximus tempus. Neque mus odio donec integer faucibus tellus eu. Velit phasellus nisl id felis dis aliquet netus suspendisse. Phasellus natoque consequat mi praesent cubilia tempor.\r\n\r\nBlandit pretium habitasse arcu rhoncus, proin interdum. Eu dignissim lacus lacus congue felis rhoncus. Justo risus fusce pharetra arcu diam eleifend massa interdum. Sem dui sed porta porttitor vitae blandit. Rhoncus justo sodales sollicitudin etiam velit vel. Imperdiet odio augue; augue et volutpat ridiculus. Lacinia purus pulvinar at proin ultrices dictum molestie eleifend. Lacinia diam lectus praesent in laoreet elit dui eget risus.\r\n\r\nOdio sodales tempor consequat semper sit dui. Nisi porttitor mus enim inceptos taciti eros ornare duis. Aliquet at himenaeos elementum scelerisque; condimentum tortor. Inceptos conubia sociosqu metus fames suspendisse. Neque iaculis mauris diam scelerisque a natoque facilisis. Parturient donec dictum vestibulum, ultricies fermentum lacinia vehicula. Nostra vitae urna potenti vel ad. Varius urna risus primis iaculis fusce lacinia. Aliquam cras ultricies blandit sed; senectus blandit senectus.', 'life lately', 'f94c4d4cbea7512a5658b5109bc93a8c.jpg', '2025-01-18', 'active'),
(5, 1, 'juju', 'Recent movie I saw! ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus iaculis sit amet est non scelerisque. Nunc hendrerit orci ac dictum lobortis. In nec rutrum quam, a cursus diam. Quisque consequat magna vitae mattis vehicula. Nullam lacinia condimentum velit, id hendrerit ex accumsan et. Praesent a nisl et quam accumsan aliquam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis vulputate mi libero, vel sagittis tortor interdum sed. Morbi eleifend laoreet tristique. Sed vestibulum massa ut quam interdum, sed fringilla quam volutpat.\r\n\r\nCras tempus accumsan ligula non feugiat. Nam sagittis at nibh vel suscipit. Ut vestibulum dictum magna, ac suscipit libero. Praesent auctor lacinia arcu et scelerisque. Vestibulum euismod semper sem id viverra. Vivamus libero nunc, luctus in efficitur id, placerat id libero. In facilisis nisi quis sollicitudin porta.\r\n\r\nSed id erat vitae erat rhoncus volutpat. Mauris convallis cursus purus, et posuere libero tristique ut. Cras vulputate sollicitudin pellentesque. Fusce pretium maximus ante a fermentum. Nullam nunc turpis, posuere et ante in, placerat posuere velit. Proin neque leo, faucibus et tempus feugiat, porta id risus. Curabitur mollis interdum ligula, hendrerit efficitur elit hendrerit vel. Curabitur vehicula sagittis ante, quis mattis felis faucibus venenatis. Duis nec mi arcu. In vulputate risus non bibendum sagittis. Sed aliquet imperdiet ultricies. Phasellus id tortor imperdiet, ornare quam non, aliquam erat.', 'entertainment', '', '2025-01-31', 'active'),
(6, 1, 'juju', 'Thrifting areas in cubao :D', 'Suspendisse at ex et nulla posuere maximus. Cras lorem lacus, sollicitudin quis pretium eget, semper id ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed iaculis ac ante vitae suscipit. Morbi sed aliquet arcu. Fusce faucibus, enim id luctus vehicula, nunc neque dictum eros, id venenatis justo metus sit amet augue. Sed venenatis velit eu lacus tristique, nec posuere lacus imperdiet. Suspendisse consectetur ligula aliquam lorem mollis efficitur.\r\n\r\nDonec nec turpis eu sapien tristique convallis vitae at quam. Nunc tortor purus, sodales eu neque luctus, ultricies tincidunt nisl. Nunc sed elit et odio elementum vulputate. Quisque pulvinar lorem a diam imperdiet porttitor. Pellentesque ut vehicula diam. Cras ut molestie tellus. Quisque nec augue imperdiet, pharetra sem vitae, rutrum augue. Donec lobortis, lectus ac gravida laoreet, eros odio dictum libero, nec convallis magna mi eget felis. Aenean cursus felis nec enim finibus volutpat. Donec malesuada, arcu in pellentesque imperdiet, justo urna molestie orci, ac faucibus nulla ante eget urna. Integer sollicitudin, sem non tempor elementum, erat ante blandit nulla, et maximus lectus eros eu metus. Pellentesque sodales magna leo. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 'fashion,style,shopping', '', '2025-01-31', 'active'),
(7, 1, 'juju', 'new games to play!', 'Suspendisse at ex et nulla posuere maximus. Cras lorem lacus, sollicitudin quis pretium eget, semper id ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed iaculis ac ante vitae suscipit. Morbi sed aliquet arcu. Fusce faucibus, enim id luctus vehicula, nunc neque dictum eros, id venenatis justo metus sit amet augue. Sed venenatis velit eu lacus tristique, nec posuere lacus imperdiet. Suspendisse consectetur ligula aliquam lorem mollis efficitur.\r\n\r\nDonec nec turpis eu sapien tristique convallis vitae at quam. Nunc tortor purus, sodales eu neque luctus, ultricies tincidunt nisl. Nunc sed elit et odio elementum vulputate. Quisque pulvinar lorem a diam imperdiet porttitor. Pellentesque ut vehicula diam. Cras ut molestie tellus. Quisque nec augue imperdiet, pharetra sem vitae, rutrum augue. Donec lobortis, lectus ac gravida laoreet, eros odio dictum libero, nec convallis magna mi eget felis. Aenean cursus felis nec enim finibus volutpat. Donec malesuada, arcu in pellentesque imperdiet, justo urna molestie orci, ac faucibus nulla ante eget urna. Integer sollicitudin, sem non tempor elementum, erat ante blandit nulla, et maximus lectus eros eu metus. Pellentesque sodales magna leo. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 'gaming', '', '2025-01-31', 'active'),
(8, 2, 'Zapatero', 'New Music from Jeonghan (Seventeen ) collaboration with Omoinotoke - Better Half ', 'On Monday, January 27 at 6:00 PM (KST), SEVENTEEN JEONGHAN’s “Better Half (feat. Omoinotake)” was released. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam scelerisque ultricies libero, in sollicitudin magna dictum non. Sed lectus enim, rutrum quis eros nec, accumsan ullamcorper massa. Nam et odio id neque luctus ultricies eget id eros. Praesent ac scelerisque tellus. Quisque sollicitudin, enim sit amet euismod fringilla, ipsum augue aliquet erat, eget ullamcorper lorem augue vitae lectus. Cras eu nibh eu magna facilisis laoreet eu at turpis. Phasellus porta, felis at luctus volutpat, massa mauris finibus ante, quis finibus libero tortor quis odio. Sed laoreet, eros eget vulputate porttitor, massa eros suscipit ligula, nec aliquam sapien neque eget risus.\r\n\r\nNulla convallis odio metus, molestie tincidunt nibh imperdiet vel. Sed aliquet nisi lorem, et cursus lorem commodo et. Aenean eu sapien finibus enim vestibulum consectetur. Donec at tortor metus. Donec aliquam porttitor scelerisque. Vivamus id faucibus lectus. Mauris ut molestie nisi. Donec aliquam lorem et est interdum placerat. Cras aliquet lectus et tellus tempus scelerisque.\r\n', 'music', 'Screenshot 2025-02-03 001048.png', '2025-02-03', 'active'),
(10, 8, 'Sel Zap', 'This is a test for Create function for posts', 'Testing for post creation ', 'gaming', 'img_6968833561f6d6.61699894.png', '2026-01-15', 'active'),
(12, 8, 'Sel Zap', 'New post', 'awesome new post!', 'education', 'img_6968896c0cad27.44715024.png', '2026-01-15', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'juju', 'djesmariegrace@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(2, 'mary doe', 'johndoe@gmail.com', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),
(3, 'theo', '123@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(4, 'popo', '1234@gmail.com', '58d8ca33f677bbdf998ad98bad6a3c780707dced'),
(5, 'the8', 'xu@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(6, 'kathy', 'jes123@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(7, 'SirDipay_User', 'user123@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(8, 'Sel Zap', 'crizathekrule@gmail.com', '82170f525c314ca7cf3ff5d0286ce1b899d3b95e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `chatbot_conversations`
--
ALTER TABLE `chatbot_conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_session` (`session_id`);

--
-- Indexes for table `chatbot_menu`
--
ALTER TABLE `chatbot_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_parent` (`parent_id`);

--
-- Indexes for table `chatbot_rules`
--
ALTER TABLE `chatbot_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_menu` (`menu_id`),
  ADD KEY `idx_priority` (`priority`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chatbot_conversations`
--
ALTER TABLE `chatbot_conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `chatbot_menu`
--
ALTER TABLE `chatbot_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `chatbot_rules`
--
ALTER TABLE `chatbot_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chatbot_conversations`
--
ALTER TABLE `chatbot_conversations`
  ADD CONSTRAINT `chatbot_conversations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `chatbot_menu`
--
ALTER TABLE `chatbot_menu`
  ADD CONSTRAINT `chatbot_menu_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `chatbot_menu` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chatbot_rules`
--
ALTER TABLE `chatbot_rules`
  ADD CONSTRAINT `chatbot_rules_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `chatbot_menu` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
