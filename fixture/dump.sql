-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 24 oct. 2020 à 10:53
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `providus_api`
--

-- --------------------------------------------------------

--
-- Structure de la table `lot`
--

CREATE TABLE `lot` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `how_many_items` int(11) NOT NULL,
  `expire_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lot`
--

INSERT INTO `lot` (`id`, `product_id`, `how_many_items`, `expire_at`) VALUES
(1, 1, 12, '2020-10-25 09:28:52'),
(2, 1, 15, '2020-10-28 09:24:57');

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_content`
--

CREATE TABLE `order_content` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_reference_id` int(11) NOT NULL,
  `how_many_items` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`) VALUES
(1, 'Product 001', 'Description', 100),
(2, 'Product 002', 'description', 200),
(3, 'Product 003', 'description 003', 1000);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `lot`
--
ALTER TABLE `lot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B81291B4584665A` (`product_id`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `order_content`
--
ALTER TABLE `order_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8BF99E24584665A` (`product_id`),
  ADD KEY `IDX_8BF99E212854AC3` (`order_reference_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `lot`
--
ALTER TABLE `lot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order_content`
--
ALTER TABLE `order_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lot`
--
ALTER TABLE `lot`
  ADD CONSTRAINT `FK_B81291B4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `order_content`
--
ALTER TABLE `order_content`
  ADD CONSTRAINT `FK_8BF99E212854AC3` FOREIGN KEY (`order_reference_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `FK_8BF99E24584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
