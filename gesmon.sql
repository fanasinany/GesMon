-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 26 nov. 2020 à 10:03
-- Version du serveur :  10.3.16-MariaDB
-- Version de PHP :  7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gesmon`
--

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE `comptes` (
  `id_comptes` int(11) NOT NULL,
  `nom_prenom` varchar(255) NOT NULL,
  `solde` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`id_comptes`, `nom_prenom`, `solde`) VALUES
(1, 'Tokatrano', 6000);

-- --------------------------------------------------------

--
-- Structure de la table `entree`
--

CREATE TABLE `entree` (
  `id_entree` int(11) NOT NULL,
  `id_comptes` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entree`
--

INSERT INTO `entree` (`id_entree`, `id_comptes`, `description`, `prix`, `date`) VALUES
(1, 1, 'Solde de depart', 9000, '2020-11-26'),
(2, 1, 'Salaire Novembre', 70000, '2020-11-27'),
(3, 1, 'Cadeau', 30000, '2020-11-26');

-- --------------------------------------------------------

--
-- Structure de la table `sortie`
--

CREATE TABLE `sortie` (
  `id_sortie` int(11) NOT NULL,
  `id_comptes` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `prix` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sortie`
--

INSERT INTO `sortie` (`id_sortie`, `id_comptes`, `description`, `prix`, `date`) VALUES
(1, 1, 'Sakafo', 5000, '2020-11-26'),
(2, 1, 'Shoprite', 20000, '2020-11-27'),
(3, 1, 'JIRAMA', 17500, '2020-11-28'),
(4, 1, 'Loyer', 30000, '2020-11-29'),
(5, 1, 'Gaz', 6000, '2020-11-30'),
(6, 1, 'Riz', 500, '2020-11-26'),
(7, 1, 'Ecolage Enfant', 21000, '2020-11-19'),
(8, 1, 'Armoire', 3000, '2020-11-20');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD PRIMARY KEY (`id_comptes`);

--
-- Index pour la table `entree`
--
ALTER TABLE `entree`
  ADD PRIMARY KEY (`id_entree`),
  ADD KEY `id_comptes` (`id_comptes`);

--
-- Index pour la table `sortie`
--
ALTER TABLE `sortie`
  ADD PRIMARY KEY (`id_sortie`),
  ADD KEY `id_comptes` (`id_comptes`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comptes`
--
ALTER TABLE `comptes`
  MODIFY `id_comptes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `entree`
--
ALTER TABLE `entree`
  MODIFY `id_entree` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `sortie`
--
ALTER TABLE `sortie`
  MODIFY `id_sortie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `entree`
--
ALTER TABLE `entree`
  ADD CONSTRAINT `entree_ibfk_1` FOREIGN KEY (`id_comptes`) REFERENCES `comptes` (`id_comptes`);

--
-- Contraintes pour la table `sortie`
--
ALTER TABLE `sortie`
  ADD CONSTRAINT `sortie_ibfk_1` FOREIGN KEY (`id_comptes`) REFERENCES `comptes` (`id_comptes`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
