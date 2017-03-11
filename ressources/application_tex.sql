-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 11 Mars 2017 à 18:29
-- Version du serveur :  5.5.42
-- Version de PHP :  7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `application_tex`
--
CREATE DATABASE IF NOT EXISTS `application_tex` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `application_tex`;

-- --------------------------------------------------------

--
-- Structure de la table `adm_default_data`
--

CREATE TABLE IF NOT EXISTS `adm_default_data` (
  `id` int(11) NOT NULL,
  `data_value` varchar(30) NOT NULL,
  `data_reference` varchar(10) DEFAULT NULL,
  `data_type` varchar(10) DEFAULT NULL,
  `data_parameter` varchar(10) DEFAULT NULL,
  `default_data_column_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `adm_default_data`
--

INSERT INTO `adm_default_data` (`id`, `data_value`, `data_reference`, `data_type`, `data_parameter`, `default_data_column_id`) VALUES
(8, 'Commentaire Test', '3', NULL, NULL, 1),
(9, 'DEFAUT_TEST', '3', NULL, NULL, 1),
(15, 'zieozhf', '8', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `adm_ent_etablissement`
--

CREATE TABLE IF NOT EXISTS `adm_ent_etablissement` (
  `id` int(11) NOT NULL,
  `libelle` varchar(40) NOT NULL,
  `libelle_short` varchar(4) NOT NULL,
  `code` varchar(15) DEFAULT NULL,
  `adresse` varchar(150) NOT NULL,
  `code_postal` varchar(5) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  `identifiant` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL,
  `source` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `adm_ent_etablissement`
--

INSERT INTO `adm_ent_etablissement` (`id`, `libelle`, `libelle_short`, `code`, `adresse`, `code_postal`, `ville`, `telephone`, `email`, `date_enregistrement`, `identifiant`, `password`, `source`) VALUES
(1, 'CHU Grenoble', 'CHUG', 'CHUG', 'Boulevard de la Chantourne', '38700', 'La Tronche', '0476767676', 'mail@chug.fr', '2015-12-03 20:11:00', '', '', 1),
(2, 'CHU Voiron', 'CHUV', 'CHUV', '10 Rue des fleurs', '38506', 'Violon', '0475757575', 'mail@chv.fr', '2015-12-03 20:11:41', '', '', 0),
(3, 'CHU Dijon', 'CHUD', 'CHUD', 'rue des pissenlits', '37654', 'Dijon', '1234567898', 'email@test.fr', '2015-12-19 15:43:51', '', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `adm_ent_fonction`
--

CREATE TABLE IF NOT EXISTS `adm_ent_fonction` (
  `id` int(11) NOT NULL,
  `libelle` varchar(30) NOT NULL,
  `libelle_short` varchar(15) NOT NULL,
  `statut` int(11) NOT NULL,
  `image` varchar(30) NOT NULL,
  `controller` varchar(30) NOT NULL,
  `ordre` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `adm_ent_fonction`
--

INSERT INTO `adm_ent_fonction` (`id`, `libelle`, `libelle_short`, `statut`, `image`, `controller`, `ordre`) VALUES
(1, 'horodateur', 'Horodateur', 1, 'image_fonction_1.png', 'horodateur_controller', 1),
(2, 'tracabilite', 'Tracabilité', 1, 'image_fonction_2.png', 'tracabilite_controller', 1);

-- --------------------------------------------------------

--
-- Structure de la table `adm_ent_scaner`
--

CREATE TABLE IF NOT EXISTS `adm_ent_scaner` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `libelle_short` varchar(4) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `adm_ent_scaner`
--

INSERT INTO `adm_ent_scaner` (`id`, `libelle`, `libelle_short`, `image`, `service_id`) VALUES
(3, 'scanTest34', 'SCA1', 'image_scaner_3.png', 1),
(7, 'uhihiu', 'SCA2', 'image_scaner_7.png', 1),
(8, 'Transport', 'SCA3', 'image_scaner_8.png', 1),
(9, 'TransportReception', 'SCA4', 'image_scaner_9.png', 1);

-- --------------------------------------------------------

--
-- Structure de la table `adm_ent_service`
--

CREATE TABLE IF NOT EXISTS `adm_ent_service` (
  `id` int(11) NOT NULL,
  `libelle` varchar(200) NOT NULL,
  `libelle_short` varchar(4) NOT NULL,
  `statut_id` int(11) NOT NULL,
  `service_cible_id` int(11) NOT NULL,
  `code_correspondant` varchar(10) NOT NULL,
  `etablissement_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `adm_ent_service`
--

INSERT INTO `adm_ent_service` (`id`, `libelle`, `libelle_short`, `statut_id`, `service_cible_id`, `code_correspondant`, `etablissement_id`) VALUES
(1, 'Service_grenoble', 'SER1', 1, 0, 'service_g', 1),
(2, 'test_chu', 'SERV', 1, 0, '38000', 1),
(3, 'test_chv', 'SER3', 1, 0, '38506', 2),
(4, 'Pediatrie', 'PED1', 1, 0, 'PEDServ', 2);

-- --------------------------------------------------------

--
-- Structure de la table `adm_ent_user`
--

CREATE TABLE IF NOT EXISTS `adm_ent_user` (
  `id` int(11) NOT NULL,
  `poste` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `statut_id` varchar(20) NOT NULL,
  `image` varchar(20) NOT NULL,
  `avatar` varchar(20) NOT NULL,
  `service_id` int(11) NOT NULL,
  `etablissement_id` int(11) NOT NULL,
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `fonction` varchar(50) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `date_last_connection` datetime DEFAULT NULL,
  `date_last_update_password` datetime DEFAULT NULL,
  `type_compte_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `adm_ent_user`
--

INSERT INTO `adm_ent_user` (`id`, `poste`, `password`, `statut_id`, `image`, `avatar`, `service_id`, `etablissement_id`, `nom`, `prenom`, `fonction`, `email`, `date_last_connection`, `date_last_update_password`, `type_compte_id`) VALUES
(2, 'admin', '$2y$10$lk2CG/EfZ1Zd7XW.9NifGOVBbh.P8HeghAgoJpkFLGu', '1', 'empty_image.png', 'empty_avatar.jpg', 1, 1, NULL, NULL, NULL, 'admin@email.com', '2017-03-05 14:15:26', NULL, 1),
(3, 'TEST', '$2y$05$x5p8cJRT5ekfXl6L4vbf1uBnwIHqaLaF0wQqa0aARiS', '5', 'empty_image.png', 'empty_avatar.jpg', 1, 1, NULL, NULL, NULL, 'test@email.com', '2016-03-06 20:36:57', NULL, 1),
(4, 'test', '$2y$05$iHnmP6bHOy8xqCpQoPedvO0i5ORlI61t/7M6TGHc9bo', '4', 'empty_image.png', 'empty_avatar.jpg', 3, 2, NULL, NULL, NULL, 'email@coucou.com', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `adm_hab_etablissement`
--

CREATE TABLE IF NOT EXISTS `adm_hab_etablissement` (
  `user_id` int(11) NOT NULL,
  `etablissement_id` int(11) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `adm_hab_etablissement`
--

INSERT INTO `adm_hab_etablissement` (`user_id`, `etablissement_id`, `permission`) VALUES
(2, 2, 3),
(2, 1, 3),
(2, 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `adm_hab_fonction`
--

CREATE TABLE IF NOT EXISTS `adm_hab_fonction` (
  `user_id` int(11) NOT NULL,
  `fonction_id` int(11) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `adm_hab_fonction`
--

INSERT INTO `adm_hab_fonction` (`user_id`, `fonction_id`, `permission`) VALUES
(3, 1, 0),
(3, 2, 3),
(4, 2, 3),
(2, 1, 0),
(2, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `adm_hab_scaner`
--

CREATE TABLE IF NOT EXISTS `adm_hab_scaner` (
  `user_id` int(11) NOT NULL,
  `scaner_id` int(11) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `adm_hab_scaner`
--

INSERT INTO `adm_hab_scaner` (`user_id`, `scaner_id`, `permission`) VALUES
(4, 7, 1),
(4, 3, 3),
(2, 8, 3),
(2, 3, 0),
(2, 7, 3),
(2, 9, 3);

-- --------------------------------------------------------

--
-- Structure de la table `adm_hab_service`
--

CREATE TABLE IF NOT EXISTS `adm_hab_service` (
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `adm_hab_service`
--

INSERT INTO `adm_hab_service` (`user_id`, `service_id`, `permission`) VALUES
(2, 1, 3),
(2, 2, 3),
(2, 3, 3),
(2, 4, 3);

-- --------------------------------------------------------

--
-- Structure de la table `fnct_horodateur`
--

CREATE TABLE IF NOT EXISTS `fnct_horodateur` (
  `id` int(11) NOT NULL,
  `numero` varchar(12) NOT NULL,
  `date` datetime NOT NULL,
  `commentaire` varchar(50) NOT NULL,
  `scaner_id` int(11) NOT NULL,
  `prelevement_type_id` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fnct_horodateur`
--

INSERT INTO `fnct_horodateur` (`id`, `numero`, `date`, `commentaire`, `scaner_id`, `prelevement_type_id`) VALUES
(1, '12345678', '2016-01-01 04:10:09', 'Commentaire Test', 3, 1),
(7, '98989898', '2016-01-16 12:06:46', '', 3, 1),
(8, '98989898', '2016-01-16 12:17:35', 'test6565', 8, 1),
(14, '1231231231', '2016-03-03 23:29:11', '', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `fnct_horodateur_commentaire`
--

CREATE TABLE IF NOT EXISTS `fnct_horodateur_commentaire` (
  `com_id` int(11) NOT NULL,
  `com_numero_demande` varchar(10) NOT NULL,
  `com_id_scaner` varchar(3) NOT NULL,
  `com_coursier` varchar(50) DEFAULT NULL,
  `com_secretaire` varchar(50) DEFAULT NULL,
  `com_temperature` varchar(50) DEFAULT NULL,
  `com_examens` varchar(100) DEFAULT NULL,
  `com_commentaire` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `adm_default_data`
--
ALTER TABLE `adm_default_data`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `adm_ent_etablissement`
--
ALTER TABLE `adm_ent_etablissement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `adm_ent_fonction`
--
ALTER TABLE `adm_ent_fonction`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `adm_ent_scaner`
--
ALTER TABLE `adm_ent_scaner`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `adm_ent_service`
--
ALTER TABLE `adm_ent_service`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `adm_ent_user`
--
ALTER TABLE `adm_ent_user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fnct_horodateur`
--
ALTER TABLE `fnct_horodateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fnct_horodateur_commentaire`
--
ALTER TABLE `fnct_horodateur_commentaire`
  ADD PRIMARY KEY (`com_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `adm_default_data`
--
ALTER TABLE `adm_default_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `adm_ent_etablissement`
--
ALTER TABLE `adm_ent_etablissement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `adm_ent_fonction`
--
ALTER TABLE `adm_ent_fonction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `adm_ent_scaner`
--
ALTER TABLE `adm_ent_scaner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `adm_ent_service`
--
ALTER TABLE `adm_ent_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `adm_ent_user`
--
ALTER TABLE `adm_ent_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `fnct_horodateur`
--
ALTER TABLE `fnct_horodateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `fnct_horodateur_commentaire`
--
ALTER TABLE `fnct_horodateur_commentaire`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
