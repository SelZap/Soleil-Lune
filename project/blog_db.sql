-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2025 at 08:02 PM
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
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'juju', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),
(2, 'Zapatero', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(3, 'Admin2', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),
(4, 'ProfDipay_Admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

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
(4, 1, 1, 5, 'the8', 'example text', '2025-01-24');

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
(8, 6, 1, 1);

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
(8, 2, 'Zapatero', 'New Music from Jeonghan (Seventeen ) collaboration with Omoinotoke - Better Half ', 'On Monday, January 27 at 6:00 PM (KST), SEVENTEEN JEONGHAN’s “Better Half (feat. Omoinotake)” was released. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam scelerisque ultricies libero, in sollicitudin magna dictum non. Sed lectus enim, rutrum quis eros nec, accumsan ullamcorper massa. Nam et odio id neque luctus ultricies eget id eros. Praesent ac scelerisque tellus. Quisque sollicitudin, enim sit amet euismod fringilla, ipsum augue aliquet erat, eget ullamcorper lorem augue vitae lectus. Cras eu nibh eu magna facilisis laoreet eu at turpis. Phasellus porta, felis at luctus volutpat, massa mauris finibus ante, quis finibus libero tortor quis odio. Sed laoreet, eros eget vulputate porttitor, massa eros suscipit ligula, nec aliquam sapien neque eget risus.\r\n\r\nNulla convallis odio metus, molestie tincidunt nibh imperdiet vel. Sed aliquet nisi lorem, et cursus lorem commodo et. Aenean eu sapien finibus enim vestibulum consectetur. Donec at tortor metus. Donec aliquam porttitor scelerisque. Vivamus id faucibus lectus. Mauris ut molestie nisi. Donec aliquam lorem et est interdum placerat. Cras aliquet lectus et tellus tempus scelerisque.\r\n', 'music', 'Screenshot 2025-02-03 001048.png', '2025-02-03', 'active');

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
(7, 'SirDipay_User', 'user123@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
