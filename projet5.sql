-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 19 sep. 2018 à 15:15
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `image`, `content`, `author`, `createdAt`, `editedAt`) VALUES
(1, 'titre', 'photo.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut commodo metus pulvinar venenatis vestibulum. Quisque vitae purus ac erat convallis pellentesque eget non mi. Nulla tempus quam iaculis mauris mattis, vitae finibus tellus accumsan. Sed augue neque, ultricies id blandit non, consequat in libero. In condimentum efficitur sodales. Pellentesque eleifend blandit lorem, et egestas felis mattis vel. Praesent rhoncus, lacus nec porttitor consequat, nisl lacus elementum sem, a semper felis leo eget est. Nam molestie semper sollicitudin.\r\n\r\nUt metus sem, fringilla nec metus et, ultricies fermentum ex. Proin ornare porta nibh sit amet blandit. Nullam et mauris tristique, venenatis diam a, malesuada nunc. In et arcu a dui mattis feugiat. Vivamus vehicula euismod erat in tempus. Fusce gravida vestibulum egestas. Nam ut elit eget ex placerat aliquet at vel mauris. Vestibulum blandit, nulla nec facilisis feugiat, ex velit tincidunt erat, at porta quam neque eget erat. Sed tellus nulla, dignissim id tortor sit amet, interdum pretium tortor. Integer suscipit diam nec urna vestibulum pellentesque. Donec ac bibendum diam, eu pretium tellus.', 'steven', '2018-09-20 11:24:21', '2018-09-27 14:00:00'),
(2, 'super', 'photo.png', 'Verum ad istam omnem orationem brevis est defensio. Nam quoad aetas M. Caeli dare potuit isti suspicioni locum, fuit primum ipsius pudore, deinde etiam patris diligentia disciplinaque munita. Qui ut huic virilem togam deditšnihil dicam hoc loco de me; tantum sit, quantum vos existimatis; hoc dicam, hunc a patre continuo ad me esse deductum; nemo hunc M. Caelium in illo aetatis flore vidit nisi aut cum patre aut mecum aut in M. Crassi castissima domo, cum artibus honestissimis erudiretur.\r\n', 'steven', '2018-09-20 00:00:00', '2018-09-26 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
