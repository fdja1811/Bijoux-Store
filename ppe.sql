-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 31 mai 2026 à 10:25
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ppe`
--

-- --------------------------------------------------------

--
-- Structure de la table `historique_mdp`
--

DROP TABLE IF EXISTS `historique_mdp`;
CREATE TABLE IF NOT EXISTS `historique_mdp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_changement` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `historique_mdp`
--

INSERT INTO `historique_mdp` (`id`, `id_user`, `mot_de_passe`, `date_changement`) VALUES
(1, 1, 'Azerty@12345', '2025-11-25 13:54:33'),
(2, 1, 'Qsdfghj+0789', '2025-11-25 14:14:47'),
(3, 6, 'Farida@123123', '2025-11-25 14:41:36'),
(4, 9, 'Anne@gmail.com0', '2026-05-30 13:43:22'),
(5, 9, 'Azerty@123', '2026-05-31 10:06:51');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `produit_id` int NOT NULL,
  `quantite` int NOT NULL DEFAULT '1',
  `date_ajout` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `produit_id` (`produit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `user_id`, `produit_id`, `quantite`, `date_ajout`) VALUES
(3, 1, 2, 3, '2025-11-25 12:34:10'),
(4, 1, 1, 1, '2025-11-25 12:18:20'),
(5, 1, 4, 1, '2025-11-25 12:34:14'),
(6, 7, 2, 3, '2026-04-28 13:43:00'),
(7, 7, 4, 1, '2026-04-28 13:42:50'),
(21, 9, 2, 1, '2026-05-31 09:55:35'),
(22, 10, 2, 1, '2026-05-31 10:05:50'),
(23, 10, 4, 1, '2026-05-31 10:05:52');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `produit_id` int NOT NULL AUTO_INCREMENT,
  `nom_produit` varchar(100) NOT NULL,
  `categorie` varchar(20) NOT NULL,
  `prix` decimal(7,2) NOT NULL,
  `quantite` int DEFAULT NULL,
  PRIMARY KEY (`produit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`produit_id`, `nom_produit`, `categorie`, `prix`, `quantite`) VALUES
(1, 'bague1', 'bague', 15.99, 8),
(2, 'bague2', 'bague', 17.00, 8),
(3, 'bague3', 'bague', 15.00, 0),
(4, 'bague4', 'bague', 17.99, 8),
(5, 'bague5', 'bague', 18.99, 8),
(6, 'bague6', 'bague', 16.25, 8),
(7, 'bague7', 'bague', 25.00, 8),
(8, 'bague8', 'bague', 14.45, 8),
(9, 'bague9', 'bague', 16.80, 8),
(10, 'bague10', 'bague', 13.99, 8),
(11, 'boucle1', 'boucle', 11.99, 8),
(12, 'boucle2', 'boucle', 15.99, 8),
(13, 'boucle3', 'boucle', 25.00, 8),
(14, 'boucle4', 'boucle', 19.20, 8),
(15, 'boucle5', 'boucle', 16.99, 8),
(16, 'boucle6', 'boucle', 12.99, 8),
(17, 'boucle7', 'boucle', 14.77, 0),
(18, 'boucle8', 'boucle', 16.99, 8),
(19, 'boucle9', 'boucle', 13.99, 8),
(20, 'boucle10', 'boucle', 18.99, 8),
(21, 'bracelet1', 'bracelet', 99.00, 8),
(22, 'bracelet2', 'bracelet', 77.99, 8),
(23, 'bracelet3', 'bracelet', 79.99, 8),
(24, 'bracelet4', 'bracelet', 100.99, 0),
(25, 'bracelet5', 'bracelet', 95.99, 8),
(26, 'bracelet6', 'bracelet', 111.99, 8),
(27, 'bracelet7', 'bracelet', 89.99, 8),
(28, 'bracelet8', 'bracelet', 112.50, 8),
(29, 'bracelet9', 'bracelet', 99.90, 8),
(30, 'bracelet10', 'bracelet', 89.99, 8),
(31, 'collier1', 'collier', 250.99, 7),
(32, 'collier2', 'collier', 358.99, 8),
(33, 'collier3', 'collier', 250.00, 8),
(34, 'collier4', 'collier', 275.89, 8),
(35, 'collier5', 'collier', 295.00, 8),
(36, 'collier6', 'collier', 145.99, 8),
(37, 'collier7', 'collier', 131.90, 8),
(38, 'collier8', 'collier', 125.00, 8),
(39, 'collier9', 'collier', 125.99, 8),
(40, 'collier10', 'collier', 122.99, 8),
(41, 'parure1', 'parure', 345.50, 2),
(42, 'parure2', 'parure', 420.00, 12),
(43, 'parure3', 'parure', 458.90, 0),
(44, 'parure4', 'parure', 540.00, 10),
(45, 'parure5', 'parure', 483.99, 12),
(46, 'parure6', 'parure', 459.00, 12),
(47, 'parure7', 'parure', 620.99, 12),
(48, 'parure8', 'parure', 473.99, 12),
(49, 'parure9', 'parure', 564.90, 12),
(50, 'parure10', 'parure', 520.99, 12);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse_email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `adresse_email` (`adresse_email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_user`, `nom`, `prenom`, `adresse_email`, `mot_de_passe`) VALUES
(1, 'DJAROUN', 'Farida', 'fdjaroun@transa-visas.com', '$2y$10$ZXokYEiQfLgDC4UBldDSuOPV/Id1rqBPDW.H1ZdYGZX5S9P42.U4a'),
(9, 'smith', 'Anne', 'anne@gmail.com', '$2y$10$NNyBBq7fJ3YzbrZEirRoF.8ZR3o7vtnIDCvri4SRcwL68P6gJS45i'),
(10, 'root', 'root', 'root@gmail.com', '$2y$10$R.G1sHRHYlTT/iiIy3Yex.zSwj9/iz8jLY5T1dp.3L3vfdMMIgMNC');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
