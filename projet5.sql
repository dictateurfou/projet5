-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 03 oct. 2018 à 15:48
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet5`
--

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL,
  `editedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `image`, `content`, `author`, `createdAt`, `editedAt`) VALUES
(1, 'titre454', 'post/e5a23a6a8afd9c58c46cfba0f09dc2df.jpg', 'Lorem edit ipsum dolor sit amet, consectetur adipiscing elit. Ut commodo metus pulvinar venenatis vestibulum. Quisque vitae purus ac erat convallis pellentesque eget non mi. Nulla tempus quam iaculis mauris mattis, vitae finibus tellus accumsan. Sed augue neque, ultricies id blandit non, consequat in libero. In condimentum efficitur sodales. Pellentesque eleifend blandit lorem, et egestas felis mattis vel. Praesent rhoncus, lacus nec porttitor consequat, nisl lacus elementum sem, a semper felis leo eget est. Nam molestie semper sollicitudin.\r\n\r\nUt metus sem, fringilla nec metus et, ultricies fermentum ex. Proin ornare porta nibh sit amet blandit. Nullam et mauris tristique, venenatis diam a, malesuada nunc. In et arcu a dui mattis feugiat. Vivamus vehicula euismod erat in tempus. Fusce gravida vestibulum egestas. Nam ut elit eget ex placerat aliquet at vel mauris. Vestibulum blandit, nulla nec facilisis feugiat, ex velit tincidunt erat, at porta quam neque eget erat. Sed tellus nulla, dignissim id tortor sit amet, interdum pretium tortor. Integer suscipit diam nec urna vestibulum pellentesque. Donec ac bibendum diam, eu pretium tellus.', 'steven', '2018-09-20 11:24:21', '2018-10-02 10:10:50'),
(4, 'manipulating :before by using predefined CSS attr()', 'post/3d22cf8059968dbb274a33b7a3f0648e.jpg', 'sdoqsgdoqsdpsqdhdp sqffqs', 'test', '2018-09-26 04:09:39', '2018-09-26 04:09:39');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `pass`, `mail`, `avatar`, `role`) VALUES
(1, 'good5', 'cb3b5639a043f55b783e3f8fc58a2f6252db89b390a27c67ba199b6a897d0e30', 'good5@gmail.com', 'avatar/default.png', 0),
(7, 'azdaza', '0b49149b4736098dcabe513e6e88295b4fd3987b54bb3774e3486639745c9fcc', 'azdazzad@gmail.com', 'avatar/default.png', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
