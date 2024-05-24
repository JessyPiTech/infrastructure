-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 28 mai 2024 à 20:34
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
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `avis_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `user_pseudo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `game_id` int NOT NULL,
  `avis_message` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avis_note` float NOT NULL,
  `avis_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`avis_id`),
  KEY `user_id` (`user_id`),
  KEY `game_id` (`game_id`),
  KEY `user_pseudo` (`user_pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`avis_id`, `user_id`, `user_pseudo`, `game_id`, `avis_message`, `avis_note`, `avis_date`) VALUES
(1, 1, 'jessy', 15, 'Animal Crossing: New Horizons est une escapade charmante et relaxante vers un paradis insulaire. Avec ses personnages adorables et ses nombreuses activités, c\'est un incontournable pour tous les amateurs de jeux de simulation de vie', 4, '2024-05-28 21:49:20'),
(2, 1, 'jessy', 16, 'MW2 offre une expérience de jeu de tir intense et palpitante. Avec des graphismes spectaculaires et un gameplay captivant, c\'est un incontournable pour les fans de jeux d\'action', 5, '2024-05-28 21:50:15'),
(3, 1, 'jessy', 17, 'J\'y est jouer pendant près de 5 ans c\'est un vrai benger ', 5, '2024-05-28 21:51:01'),
(4, 1, 'jessy', 18, 'j\'ai honnetement jamais arreter de jouer c\'est que du kiff se jeu je le conseil pour qui conque', 5, '2024-05-28 21:52:03'),
(5, 1, 'jessy', 20, 'sa ressemblera a super smash brosse une fois en ligne donc trop hat', 1, '2024-05-28 21:52:51'),
(6, 1, 'jessy', 22, 'j\'avoue j\'ai jamais jouer mais de se que j\'ai compris sa a été le meilleur jeu du monde pendant longtemp donc un bon 4', 4.5, '2024-05-28 21:53:44'),
(7, 1, 'jessy', 23, 'je m\'embete vraiment a recree des commantaire la ?\r\nje suis meme pas sur que tu les Vera erwan', 4, '2024-05-28 21:54:48'),
(8, 1, 'jessy', 24, 'par se que je vais rebaise le ripo la mais je sais pas si ta deja clone ou pas ', 1.5, '2024-05-28 21:55:32'),
(9, 1, 'jessy', 25, 'sa ferais que on pas de genre entre 12 et 16 a peu etre un 19 donc en vrai je pense c\'est quand meme bien que je le face', 1.5, '2024-05-28 21:56:52');

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
  `game_id` int NOT NULL AUTO_INCREMENT COMMENT 'id du jeu',
  `game_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'nom du jeu',
  `game_publisher` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'dev du jeu',
  `game_note` float NOT NULL COMMENT 'note sur 5',
  `game_high_score` int NOT NULL,
  `game_image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'image du jeu',
  `game_path` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `game_date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `game_date_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `game`
--

INSERT INTO `game` (`game_id`, `game_name`, `game_publisher`, `game_note`, `game_high_score`, `game_image`, `game_path`, `game_date_create`, `game_date_update`) VALUES
(15, 'Animal crossing', 'Nintendo', 4, 0, 'uploads/animalcrossing.jpg', '', '2024-05-26 12:25:53', '0000-00-00 00:00:00'),
(16, 'MW2', 'Ubisoft', 5, 0, 'uploads/callofdutyMW3.jpg', '', '2024-05-26 12:25:53', '0000-00-00 00:00:00'),
(17, 'Gta 5', 'Rockstar', 5, 0, 'uploads/gta5.jpg', '', '2024-05-26 12:25:53', '0000-00-00 00:00:00'),
(18, 'Mincraft', 'Mojang', 5, 0, 'uploads/mincraft.png', '', '2024-05-26 12:25:53', '2024-05-26 12:27:38'),
(20, 'urban rubelle', 'natou et elouan', 1, 0, 'uploads/logo_urban_rumble_DEFINITIF.png', '', '2024-05-28 14:10:36', NULL),
(22, 'Tetris', 'Electronic Arts', 4.5, 0, 'uploads/390px-The_Tetris_Company_Logo.png', '', '2024-05-28 19:38:37', NULL),
(23, 'Wii Sports', 'Nintendo', 4, 0, 'uploads/Wii_Sports_logopng.png', '', '2024-05-28 19:40:53', NULL),
(24, 'Red Dead Redemption II', 'Rockstar Games', 1.5, 0, 'uploads/th.jpg', '', '2024-05-28 19:42:07', NULL),
(25, 'casipo', 'jessy', 1.5, 0, 'uploads/troll_vite_fais.jpg', '', '2024-05-28 19:43:03', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `score`
--

DROP TABLE IF EXISTS `score`;
CREATE TABLE IF NOT EXISTS `score` (
  `score_id` int NOT NULL AUTO_INCREMENT,
  `score_value` int NOT NULL,
  `user_id` int NOT NULL,
  `game_id` int NOT NULL,
  PRIMARY KEY (`score_id`),
  KEY `user_id` (`user_id`,`game_id`),
  KEY `game_id` (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `user_pseudo`, `user_email`, `user_password`, `user_level`, `user_creation`) VALUES
(1, 'jessy', 'exempla@gmail.com', '$2y$10$6WhhQkaQDJzW5gvbO3RE5e8qdMpf4VQw3uOGJ.MHjea5Nh2/2wk.6', 1, '2024-05-28 21:49:08');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
