-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 03 sep. 2021 à 07:14
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
-- Base de données :  `eshop`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id_article` int(5) NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `couleur` varchar(255) NOT NULL,
  `taille` varchar(255) NOT NULL,
  `sexe` enum('m','f') NOT NULL,
  `photo` varchar(255) NOT NULL,
  `prix` double(7,2) NOT NULL,
  `stock` int(4) NOT NULL,
  PRIMARY KEY (`id_article`),
  UNIQUE KEY `reference` (`reference`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `sexe`, `photo`, `prix`, `stock`) VALUES
(2, '100', 'Echarpe', 'Echarpe bleue', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Bleu', 'L', 'm', '100-goods62432939.jpg', 14.00, 100),
(3, '101', 'Echarpe', 'Echarpe blanche', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Blanc', 'L', 'm', '101-goods01428740.jpg', 14.00, 100),
(4, '102', 'Echarpe', 'Echarpe noire', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Noir', 'L', 'f', '102-goods09432939.jpg', 14.00, 100),
(5, '103', 'Echarpe', 'Echarpe grise', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Gris', 'L', 'm', '103-goods03432939.jpg', 14.00, 100),
(6, '200', 'Tshirt', 'Tshirt blanc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Blanc', 'L', 'm', '200-goods00434165.jpg', 11.00, 100),
(7, '201', 'Tshirt', 'Tshirt rose', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Rose', 'L', 'm', '201-goods12427916.jpg', 11.00, 100),
(8, '202', 'Tshirt', 'Tshirt beige', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Beige', 'L', 'f', '202-goods36429012.jpg', 11.00, 100),
(9, '203', 'Tshirt', 'Tshirt bleu', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Bleu', 'L', 'f', '203-goods69429012.jpg', 11.00, 100),
(10, '300', 'Polos', 'Polo blanc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Blanc', 'L', 'f', '300-goods00428060.jpg', 19.00, 100),
(11, '301', 'Polos', 'Polo gris', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Gris', 'L', 'f', '301-goods03428060.jpg', 19.00, 100),
(12, '302', 'Polos', 'Polo rouge', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Rouge', 'M', 'f', '302-goods15428060.jpg', 19.00, 100),
(13, '303', 'Polos', 'Polo vert', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Vert', 'M', 'm', '303-goods59428060.jpg', 19.00, 100),
(14, '400', 'Chemise', 'Chemise blanche', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Blanc', 'M', 'm', '400-goods00433460.jpg', 21.00, 100),
(15, '401', 'Chemise', 'Chemise noire', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Noir', 'M', 'm', '401-goods09433460.jpg', 21.00, 100),
(16, '402', 'Chemise', 'Chemise bleue rayée', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Bleu', 'M', 'f', '402-goods62432260.jpg', 21.00, 100),
(17, '403', 'Chemise', 'Chemise bleue', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Bleu', 'M', 'f', '403-goods67433460.jpg', 21.00, 100),
(19, '501', 'Chaussettes', 'Chaussettes grises', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Gris', 'M', 'f', '501-goods03436952.jpg', 7.00, 100),
(20, '502', 'Chaussettes', 'Chaussettes noires', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Noir', 'L', 'm', '502-goods09436952.jpg', 7.00, 100),
(21, '503', 'Chaussettes', 'Chaussettes bleues', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Bleu', 'L', 'f', '503-goods63436952.jpg', 8.00, 100),
(22, '600', 'Veste', 'Veste grise', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Gris', 'L', 'm', '600-goods03425901.jpg', 56.00, 100),
(23, '601', 'Veste', 'Veste noire', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Noir', 'L', 'm', '601-Goods09425039.jpg', 56.00, 100),
(25, '603', 'Veste', 'Veste bleue', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Bleu', 'L', 'm', '603-goods69425037.jpg', 56.00, 100),
(26, '700', 'Pantalon', 'Pantalon gris', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Gris', 'L', 'f', '700-goods07428909.jpg', 42.00, 100),
(27, '701', 'Pantalon', 'Pantalon noir', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Noir', 'L', 'm', '701-goods09428909.jpg', 42.00, 100),
(28, '702', 'Pantalon', 'Pantalon bleu', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a condimentum diam, ac tincidunt mauris. Cras sodales, augue ut dapibus porttitor, sem nisi faucibus augue, vel venenatis lectus enim id metus.', 'Bleu', 'L', 'm', '702-goods69428908.jpg', 42.00, 100);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(5) NOT NULL AUTO_INCREMENT,
  `id_membre` int(5) DEFAULT NULL,
  `montant` double(7,2) NOT NULL,
  `date` datetime NOT NULL,
  `etat` enum('en cours de traitement','envoyé','livré') NOT NULL DEFAULT 'en cours de traitement',
  PRIMARY KEY (`id_commande`),
  KEY `id_membre` (`id_membre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

DROP TABLE IF EXISTS `details_commande`;
CREATE TABLE IF NOT EXISTS `details_commande` (
  `id_details_commande` int(5) NOT NULL AUTO_INCREMENT,
  `id_commande` int(5) NOT NULL,
  `id_article` int(5) DEFAULT NULL,
  `quantite` int(3) NOT NULL,
  `prix` double(7,2) NOT NULL,
  PRIMARY KEY (`id_details_commande`),
  KEY `id_commande` (`id_commande`),
  KEY `id_article` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(5) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sexe` enum('m','f') NOT NULL,
  `ville` varchar(255) NOT NULL,
  `cp` varchar(5) NOT NULL,
  `adresse` text NOT NULL,
  `statut` int(1) NOT NULL,
  PRIMARY KEY (`id_membre`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `sexe`, `ville`, `cp`, `adresse`, `statut`) VALUES
(3, 'admin', '$2y$10$zxejjUx8z7NDUh9ais6szusJzv5APeLz4CF2M1/3QnmWM/TCpcb2W', 'Quittard', 'Mathieu', 'admin@mail.fr', 'm', 'Paris', '75000', '1 rue du truc.', 2),
(4, 'test', '$2y$10$fo0O7YV9BoM33X0ECjFscuOChPnmf5V3pinUtAHfCyfrbeCiQZbvS', 'Quittard', 'Mathieu', 'test@mail.fr', 'm', 'Paris', '75000', '1 rue du truc.', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD CONSTRAINT `details_commande_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `details_commande_ibfk_2` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
