-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 26 mai 2024 à 20:48
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sc1feir2687_infrastructure`
--

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
  `game_id` int NOT NULL AUTO_INCREMENT COMMENT 'id du jeu',
  `game_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'nom du jeu',
  `game_publisher` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'dev du jeu',
  `game_note` int NOT NULL COMMENT 'note sur 5',
  `game_evaluation_date` datetime NOT NULL COMMENT 'date d''evaluition',
  `game_image` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'image du jeu',
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `game`
--

INSERT INTO `game` (`game_id`, `game_name`, `game_publisher`, `game_note`, `game_evaluation_date`, `game_image`) VALUES
(15, 'Animal crossing', 'Nintendo', 4, '2024-05-24 21:33:12', 'uploads/animalcrossing.jpg'),
(16, 'MW2', 'Ubisoft', 5, '2024-05-24 21:33:48', 'uploads/callofdutyMW3.jpg'),
(17, 'Gta 5', 'Rockstar', 5, '2024-05-24 21:34:31', 'uploads/gta5.jpg'),
(18, 'Mincraft', 'Mojang', 5, '2024-05-24 21:35:46', 'uploads/mincraft.png'),
(21, 'urban rumble', 'Nathan et Elouan', 5, '2024-05-26 22:42:40', 'uploads/logo_urban_rumble_DEFINITIF.png');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_pseudo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user_default',
  `user_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_level` int NOT NULL DEFAULT '1',
  `user_creation` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
