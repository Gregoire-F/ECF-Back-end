-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mer. 20 mai 2026 à 13:26
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mediatheque`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonne`
--

CREATE TABLE `abonne` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_inscription` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `abonne`
--

INSERT INTO `abonne` (`id`, `nom`, `prenom`, `email`, `date_inscription`) VALUES
(22, 'Dupont', 'Jean-Pierre', 'jean-pierre.dupont@email.com', '2025-11-20'),
(23, 'Martin', 'Marie', 'marie.martin@email.com', '2025-11-20'),
(24, 'Bernard', 'Pierre', 'pierre.bernard@email.com', '2025-11-20'),
(25, 'Dubois', 'Sophie', 'sophie.dubois@email.com', '2025-11-20'),
(26, 'Lefebvre', 'Luc', 'luc.lefebvre@email.com', '2025-11-20');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260520075106', '2026-05-20 07:51:29', 433),
('DoctrineMigrations\\Version20260520081915', '2026-05-20 08:19:27', 55),
('DoctrineMigrations\\Version20260520113402', '2026-05-20 11:34:14', 367);

-- --------------------------------------------------------

--
-- Structure de la table `emprunt`
--

CREATE TABLE `emprunt` (
  `id` int(11) NOT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour_prevue` date NOT NULL,
  `date_retour_effective` date DEFAULT NULL,
  `livre_id` int(11) NOT NULL,
  `abonne_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `emprunt`
--

INSERT INTO `emprunt` (`id`, `date_emprunt`, `date_retour_prevue`, `date_retour_effective`, `livre_id`, `abonne_id`) VALUES
(36, '2026-05-10', '2026-06-03', '2026-05-15', 38, 22),
(37, '2026-05-11', '2026-06-02', '2026-05-16', 39, 23),
(38, '2026-05-12', '2026-06-01', '2026-05-17', 40, 24),
(43, '2026-05-20', '2026-05-21', '2026-05-20', 39, 26);

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

CREATE TABLE `livre` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auteur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_publication` date NOT NULL,
  `disponible` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`id`, `titre`, `auteur`, `isbn`, `date_publication`, `disponible`) VALUES
(38, 'Le Seigneur des Anneaux', 'J.R.R. Tolkien', '978-2-253-04940-5', '1954-07-29', 1),
(39, 'Harry Potter à l\'école des sorciers', 'J.K. Rowling', '978-2-07-061275-8', '1997-06-26', 1),
(40, '1984', 'George Orwell', '978-2-07-036822-8', '1949-06-08', 1),
(41, 'Le Hobbit', 'J.R.R. Tolkien', '978-2-253-04941-2', '1937-09-21', 1),
(42, 'Les Misérables', 'Victor Hugo', '978-2-07-014211-7', '1862-04-16', 1),
(43, 'Le Comte de Monte-Cristo', 'Alexandre Dumas', '978-2-07-036822-9', '1844-08-28', 1),
(44, 'Le Petit Prince', 'Antoine de Saint-Exupéry', '978-2-07-061275-8', '1943-04-06', 1),
(45, 'Don Quichotte', 'Miguel de Cervantes', '978-2-07-036824-2', '1605-01-16', 1),
(46, 'Orgueil et Préjugés', 'Jane Austen', '978-0-14-143951-8', '1813-01-28', 1),
(47, 'Fondation', 'Isaac Asimov', '978-2-07-041573-1', '1951-06-01', 1);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(9, 'admin@biblio.com', '[\"ROLE_ADMIN\"]', '$2y$13$Ts0qHLUUYU/i2fVCN2sEmOkxE9Vu0Qk6FwXOYwWShgEzzE8Bzfsgi'),
(10, 'bibliothecaire@biblio.com', '[\"ROLE_BIBLIOTHECAIRE\"]', '$2y$13$lkSMXOgcYqbo659Mj3s94e2hedXlt1n/FgagmImJ12v9SWFKY31hO');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `abonne`
--
ALTER TABLE `abonne`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_364071D737D925CB` (`livre_id`),
  ADD KEY `IDX_364071D7C325A696` (`abonne_id`);

--
-- Index pour la table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750` (`queue_name`,`available_at`,`delivered_at`,`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `abonne`
--
ALTER TABLE `abonne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `emprunt`
--
ALTER TABLE `emprunt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `livre`
--
ALTER TABLE `livre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD CONSTRAINT `FK_364071D737D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_364071D7C325A696` FOREIGN KEY (`abonne_id`) REFERENCES `abonne` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
