-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2023 at 12:33 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `denebconst`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`) VALUES
(12, 'root', 'root@gmail.com', '$2y$10$MK56xgiG9YtdVID4m2Dlsedaoa.EdFB6.ag69mG5WAxjEggwuO3Oy');

-- --------------------------------------------------------

--
-- Table structure for table `client_email`
--

CREATE TABLE `client_email` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_email`
--

INSERT INTO `client_email` (`id`, `name`, `email`, `message`) VALUES
(12, 'test', 'test@gmail.com', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt architecto quisquam autem adipisci impedit quas repellat earum doloremque atque, libero debitis veniam beatae dolores laudantium. Earum fugiat totam expedita facilis ducimus explicabo laboriosam cum voluptas impedit aut, dolore nam molestias repudiandae inventore aspernatur laborum. Deserunt recusandae illum expedita molestias dolores non laborum beatae vitae ex ducimus voluptate culpa nesciunt cumque velit, in rem excepturi vero quod blanditiis ullam laudantium voluptatum error ipsum. Ut commodi atque porro rerum nulla. Explicabo error iste consequatur ut omnis excepturi enim asperiores quis, amet odio commodi illo aspernatur ad officiis ea eum consequuntur facere. Expedita consequatur voluptatum, aut assumenda reprehenderit magni itaque deserunt neque incidunt autem, quis, doloremque quia esse rem? Eaque dolores iusto officia non beatae. Nihil nesciunt perferendis in unde quibusdam repudiandae sequi totam, reprehenderit hic non incidunt nobis ullam recusandae qui consectetur ut animi quo distinctio saepe alias tempora earum laborum! Magnam illo nesciunt rem asperiores maiores libero quo nam necessitatibus neque? Laudantium, incidunt! Quaerat velit ipsa vero, a in temporibus delectus optio neque dicta, quibusdam nemo esse perspiciatis quos veniam, iusto dolores quam deserunt? Consequuntur labore aspernatur temporibus consectetur. Ratione consequatur iusto saepe magni. Animi quae deleniti neque velit, cum repellat.'),
(13, 'Sohag', 'sohag@gmail.com', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt architecto quisquam autem adipisci impedit quas repellat earum doloremque atque, libero debitis veniam beatae dolores laudantium. Earum fugiat totam expedita facilis ducimus explicabo laboriosam cum voluptas impedit aut, dolore nam molestias repudiandae inventore aspernatur laborum. Deserunt recusandae illum expedita molestias dolores non laborum beatae vitae ex ducimus voluptate culpa nesciunt cumque velit, in rem excepturi vero quod blanditiis ullam laudantium voluptatum error ipsum. Ut commodi atque porro rerum nulla. Explicabo error iste consequatur ut omnis excepturi enim asperiores quis, amet odio commodi illo aspernatur ad officiis ea eum consequuntur facere. Expedita consequatur voluptatum, aut assumenda reprehenderit magni itaque deserunt neque incidunt autem, quis, doloremque quia esse rem? Eaque dolores iusto officia non beatae. Nihil nesciunt perferendis in unde quibusdam repudiandae sequi totam, reprehenderit hic non incidunt nobis ullam recusandae qui consectetur ut animi quo distinctio saepe alias tempora earum laborum! Magnam illo nesciunt rem asperiores maiores libero quo nam necessitatibus neque? Laudantium, incidunt! Quaerat velit ipsa vero, a in temporibus delectus optio neque dicta, quibusdam nemo esse perspiciatis quos veniam, iusto dolores quam deserunt? Consequuntur labore aspernatur temporibus consectetur. Ratione consequatur iusto saepe magni. Animi quae deleniti neque velit, cum repellat.');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_email` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `project_id`, `client_name`, `client_email`, `comment`, `time`) VALUES
(4, 20, 'sohag', 'sohag@gmail.com', 'nice', '2023-09-15 20:50:27'),
(5, 22, 'sohag', 'sohag@gmail.com', 'nice\r\n', '2023-09-16 20:22:06');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `comment_count` int(11) DEFAULT 0,
  `project_type` varchar(50) DEFAULT NULL,
  `project_status` varchar(50) DEFAULT 'In Progress'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `image1`, `image2`, `image3`, `comment_count`, `project_type`, `project_status`) VALUES
(20, 'project2', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt architecto quisquam autem adipisci impedit quas repellat earum doloremque atque, libero debitis veniam beatae dolores laudantium. Earum fugiat totam expedita facilis ducimus explicabo laboriosam cum voluptas impedit aut, dolore nam molestias repudiandae inventore aspernatur laborum. Deserunt recusandae illum expedita molestias dolores non laborum beatae vitae ex ducimus voluptate culpa nesciunt cumque velit, in rem excepturi vero quod blanditiis ullam laudantium voluptatum error ipsum. Ut commodi atque porro rerum nulla. Explicabo error iste consequatur ut omnis excepturi enim asperiores quis, amet odio commodi illo aspernatur ad officiis ea eum consequuntur facere. Expedita consequatur voluptatum, aut assumenda reprehenderit magni itaque deserunt neque incidunt autem, quis, doloremque quia esse rem? Eaque dolores iusto officia non beatae. Nihil nesciunt perferendis in unde quibusdam repudiandae sequi totam, reprehenderit hic non incidunt nobis ullam recusandae qui consectetur ut animi quo distinctio saepe alias tempora earum laborum! Magnam illo nesciunt rem asperiores maiores libero quo nam necessitatibus neque? Laudantium, incidunt! Quaerat velit ipsa vero, a in temporibus delectus optio neque dicta, quibusdam nemo esse perspiciatis quos veniam, iusto dolores quam deserunt? Consequuntur labore aspernatur temporibus consectetur. Ratione consequatur iusto saepe magni. Animi quae deleniti neque velit, cum repellat.', '4.jpeg', '5.png', '6.jpeg', 0, NULL, 'In Progress'),
(21, 'project3', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt architecto quisquam autem adipisci impedit quas repellat earum doloremque atque, libero debitis veniam beatae dolores laudantium. Earum fugiat totam expedita facilis ducimus explicabo laboriosam cum voluptas impedit aut, dolore nam molestias repudiandae inventore aspernatur laborum. Deserunt recusandae illum expedita molestias dolores non laborum beatae vitae ex ducimus voluptate culpa nesciunt cumque velit, in rem excepturi vero quod blanditiis ullam laudantium voluptatum error ipsum. Ut commodi atque porro rerum nulla. Explicabo error iste consequatur ut omnis excepturi enim asperiores quis, amet odio commodi illo aspernatur ad officiis ea eum consequuntur facere. Expedita consequatur voluptatum, aut assumenda reprehenderit magni itaque deserunt neque incidunt autem, quis, doloremque quia esse rem? Eaque dolores iusto officia non beatae. Nihil nesciunt perferendis in unde quibusdam repudiandae sequi totam, reprehenderit hic non incidunt nobis ullam recusandae qui consectetur ut animi quo distinctio saepe alias tempora earum laborum! Magnam illo nesciunt rem asperiores maiores libero quo nam necessitatibus neque? Laudantium, incidunt! Quaerat velit ipsa vero, a in temporibus delectus optio neque dicta, quibusdam nemo esse perspiciatis quos veniam, iusto dolores quam deserunt? Consequuntur labore aspernatur temporibus consectetur. Ratione consequatur iusto saepe magni. Animi quae deleniti neque velit, cum repellat.', '1.jpeg', '2.jpeg', '3.jpeg', 0, NULL, 'In Progress'),
(22, 'project3', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt architecto quisquam autem adipisci impedit quas repellat earum doloremque atque, libero debitis veniam beatae dolores laudantium. Earum fugiat totam expedita facilis ducimus explicabo laboriosam cum voluptas impedit aut, dolore nam molestias repudiandae inventore aspernatur laborum. Deserunt recusandae illum expedita molestias dolores non laborum beatae vitae ex ducimus voluptate culpa nesciunt cumque velit, in rem excepturi vero quod blanditiis ullam laudantium voluptatum error ipsum. Ut commodi atque porro rerum nulla. Explicabo error iste consequatur ut omnis excepturi enim asperiores quis, amet odio commodi illo aspernatur ad officiis ea eum consequuntur facere. Expedita consequatur voluptatum, aut assumenda reprehenderit magni itaque deserunt neque incidunt autem, quis, doloremque quia esse rem? Eaque dolores iusto officia non beatae. Nihil nesciunt perferendis in unde quibusdam repudiandae sequi totam, reprehenderit hic non incidunt nobis ullam recusandae qui consectetur ut animi quo distinctio saepe alias tempora earum laborum! Magnam illo nesciunt rem asperiores maiores libero quo nam necessitatibus neque? Laudantium, incidunt! Quaerat velit ipsa vero, a in temporibus delectus optio neque dicta, quibusdam nemo esse perspiciatis quos veniam, iusto dolores quam deserunt? Consequuntur labore aspernatur temporibus consectetur. Ratione consequatur iusto saepe magni. Animi quae deleniti neque velit, cum repellat.', '4.jpeg', '5.png', '6.jpeg', 0, NULL, 'In Progress'),
(24, 'project5', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt architecto quisquam autem adipisci impedit quas repellat earum doloremque atque, libero debitis veniam beatae dolores laudantium. Earum fugiat totam expedita facilis ducimus explicabo laboriosam cum voluptas impedit aut, dolore nam molestias repudiandae inventore aspernatur laborum. Deserunt recusandae illum expedita molestias dolores non laborum beatae vitae ex ducimus voluptate culpa nesciunt cumque velit, in rem excepturi vero quod blanditiis ullam laudantium voluptatum error ipsum. Ut commodi atque porro rerum nulla. Explicabo error iste consequatur ut omnis excepturi enim asperiores quis, amet odio commodi illo aspernatur ad officiis ea eum consequuntur facere. Expedita consequatur voluptatum, aut assumenda reprehenderit magni itaque deserunt neque incidunt autem, quis, doloremque quia esse rem? Eaque dolores iusto officia non beatae. Nihil nesciunt perferendis in unde quibusdam repudiandae sequi totam, reprehenderit hic non incidunt nobis ullam recusandae qui consectetur ut animi quo distinctio saepe alias tempora earum laborum! Magnam illo nesciunt rem asperiores maiores libero quo nam necessitatibus neque? Laudantium, incidunt! Quaerat velit ipsa vero, a in temporibus delectus optio neque dicta, quibusdam nemo esse perspiciatis quos veniam, iusto dolores quam deserunt? Consequuntur labore aspernatur temporibus consectetur. Ratione consequatur iusto saepe magni. Animi quae deleniti neque velit, cum repellat.', '4.jpeg', '5.png', '6.jpeg', 0, NULL, 'In Progress');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `reply` text NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `comment_id`, `client_name`, `reply`, `time`) VALUES
(4, 4, 'admin', 'tnx', '2023-09-15 20:50:39'),
(5, 5, 'sohag', 'wow', '2023-09-16 20:22:22');

-- --------------------------------------------------------

--
-- Table structure for table `subscribe_email`
--

CREATE TABLE `subscribe_email` (
  `id` int(30) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribe_email`
--

INSERT INTO `subscribe_email` (`id`, `email`) VALUES
(4, 'testting@gmail.com'),
(5, 'test@gmail.com'),
(6, 'efa@gmail.com'),
(7, 'ehan@gmail.com'),
(10, 'ok@gmial.com'),
(11, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `client_email`
--
ALTER TABLE `client_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `subscribe_email`
--
ALTER TABLE `subscribe_email`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `client_email`
--
ALTER TABLE `client_email`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subscribe_email`
--
ALTER TABLE `subscribe_email`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
