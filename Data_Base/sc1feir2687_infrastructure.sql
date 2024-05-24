-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 24 mai 2024 à 09:57
-- Version du serveur : 10.6.18-MariaDB
-- Version de PHP : 8.1.28

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
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(20) NOT NULL DEFAULT 'user_default',
  `email` varchar(100) NOT NULL,
  `password` varchar(25) NOT NULL,
  `level` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `video_game`
--

CREATE TABLE `video_game` (
  `game_id` int(5) NOT NULL COMMENT 'id du jeu',
  `game_name` varchar(50) NOT NULL COMMENT 'nom du jeu',
  `game_publisher` varchar(50) NOT NULL COMMENT 'dev du jeu',
  `game_note` int(5) NOT NULL COMMENT 'note sur 5',
  `game_evaluation_date` datetime(5) NOT NULL COMMENT 'date d''evaluition',
  `game_image` varchar(100) NOT NULL COMMENT 'image du jeu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `video_game`
--

INSERT INTO `video_game` (`game_id`, `game_name`, `game_publisher`, `game_note`, `game_evaluation_date`, `game_image`) VALUES
(1, 'Nom du Jeu', 'Nom du Développeur', 4, '2024-05-07 10:52:22.00000', 'PJP/image.png'),
(3, 'urban rubelle', 'natou et elouan', 5, '2024-05-07 11:01:35.00000', 'uploads/logo_urban_rumble_DEFINITIF.png'),
(4, 'jeu', 'jessy', 3, '2024-05-14 10:14:36.00000', 'uploads/troll_vite_fais.jpg'),
(5, 'kok', '45', 4, '2024-05-14 11:35:23.00000', 'uploads/vecteezy_logo-de-l-application-spotify-png-icone-spotify-png_18930579.png'),
(6, 'Ours', 'Jessy', 4, '2024-05-16 12:54:16.00000', 'uploads/1.jpg'),
(7, 'test', 'test', 1, '2024-05-16 12:55:54.00000', 'uploads/test.svg'),
(8, 'test', 'test', 1, '2024-05-16 12:56:00.00000', 'uploads/test.svg'),
(9, 'casipo', 'lop', 1, '2024-05-23 11:11:15.00000', 'uploads/Design sans titre (5).png'),
(10, 'casipo', 'lop', 1, '2024-05-23 11:11:15.00000', 'uploads/Design sans titre (5).png'),
(12, 'papap', 'natou et elouan', 1, '2024-05-23 11:20:35.00000', 'uploads/JoCOX301.svg'),
(13, 'casipo', 'lop', 2, '2024-05-23 11:47:15.00000', 'uploads/JoCOX301.svg'),
(14, 'mpl;', '23', 4, '2024-05-23 11:49:08.00000', 'uploads/JoCOX301.svg'),
(15, '', '', 0, '2024-05-23 12:07:31.00000', 'uploads/JoCOX301.svg'),
(16, 'ahhaha', 'kok', 4, '2024-05-23 13:01:15.00000', 'uploads/JoCOX301.svg'),
(17, 'dernier', '45', 3, '2024-05-23 13:01:45.00000', 'uploads/JoCOX301.svg'),
(18, 'casipo', 'zdz', 3, '2024-05-23 13:03:24.00000', 'uploads/JoCOX301.svg'),
(19, 'CIUUUUUUU', 'CIOU', 2, '2024-05-23 13:42:24.00000', 'uploads/150px-Flag_of_Germany.svg.jpg'),
(20, 'rrrrrrrrrrrrr', 'rrrrrrr', 3, '2024-05-23 13:48:42.00000', 'uploads/150px-Flag_of_the_United_States.svg.jpg'),
(21, 'ghfjgj', 'fdsfdsfd', 1, '2024-05-23 13:49:08.00000', 'uploads/150px-Flag_of_Germany.svg.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `video_game`
--
ALTER TABLE `video_game`
  ADD PRIMARY KEY (`game_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `video_game`
--
ALTER TABLE `video_game`
  MODIFY `game_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'id du jeu', AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
