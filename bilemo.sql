-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 05 mars 2019 à 14:50
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
-- Base de données :  `bilemo`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_html_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C744045541DEE7B9` (`token_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `token_id`, `username`, `fullname`, `email`, `avatar_url`, `profile_html_url`) VALUES
(1, 1, 'Bastien', 'Bastien Vacherand', 'coco2053@hotmail.com', 'https://avatars1.githubusercontent.com/u/11075343?v=4', 'https://lh4.googleusercontent.com/-YupipbYx8CQ/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3rehcZPd-yfPWdsAAXUulRL1Wtj_6w/mo/photo.jpg'),
(2, 2, 'Bastien', 'Bastien Vacherand', 'bastienvacherand@gmail.com', 'https://lh4.googleusercontent.com/-T9QNn0BO2NE/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3rdLjWQsHct6tgWWt7psWw17p8HspQ/mo/photo.jpg', ''),
(3, 3, 'Bastien', 'Bastien Vacherand', 'coco2053@gmail.com', 'https://lh4.googleusercontent.com/-cuAzAHcu8Js/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3rexyfp6yw5Z_NeoFw-cvryUd4Myaw/mo/photo.jpg', 'https://plus.google.com/115491882322013390764');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190228192346', '2019-02-28 19:23:53');

-- --------------------------------------------------------

--
-- Structure de la table `phone`
--

DROP TABLE IF EXISTS `phone`;
CREATE TABLE IF NOT EXISTS `phone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_ref` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `memory` smallint(6) NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `phone`
--

INSERT INTO `phone` (`id`, `model_name`, `model_ref`, `memory`, `color`, `price`, `description`) VALUES
(1, 'Apple Iphone 7', 'MGS-2587', 97, 'argent', 387, 'Officiis sed autem ut voluptatem est quod alias iste.'),
(2, 'Apple Iphone 8', 'QTP-2659', 88, 'or', 656, 'Explicabo quia sed ea aperiam unde voluptatem.'),
(3, 'Samsung Galaxy Note 1', 'MG-205', 24, 'vert', 753, 'Et laboriosam dolor odit omnis vel.'),
(4, 'Apple Iphone 7', 'ZTX-5419', 19, 'rouge', 172, 'Nam itaque nesciunt fugit.'),
(5, 'Apple Iphone 4', 'MG-205', 102, 'or', 347, 'Et et cum eius voluptas numquam quam.'),
(6, 'Apple Iphone 7', 'ZTX-5419', 5, 'bleu', 518, 'Et aut laborum cupiditate corporis aliquid aut cumque.'),
(7, 'Samsung Galaxy S7', 'ZTX-5419', 21, 'bleu', 987, 'Rerum autem qui est velit excepturi.'),
(8, 'Nokia Lumia 750', 'QRZ-2751', 123, 'noir', 492, 'Fuga beatae voluptas iure rerum voluptas necessitatibus eius.'),
(9, 'Apple Iphone 4', 'MGS-2587', 33, 'vert', 823, 'Enim molestias in minus.'),
(10, 'Apple Iphone 4', 'QRZ-2751', 94, 'blanc', 696, 'Officiis eos suscipit facilis vel.'),
(11, 'Nokia Lumia 650', 'XC-555', 19, 'argent', 838, 'Quo voluptas totam asperiores ab tenetur voluptatem.'),
(12, 'Nokia Lumia 750', 'QRZ-2751', 88, 'argent', 914, 'Nobis iste accusantium quaerat nostrum voluptas est tenetur sed.'),
(13, 'Xperia M4', 'QTP-2659', 21, 'blanc', 868, 'Eaque nihil aliquid eos fugit natus quaerat quibusdam.'),
(14, 'Samsung Galaxy S5', 'ZTX-5419', 112, 'noir', 548, 'Itaque doloribus qui dicta eligendi quae recusandae.'),
(15, 'Xperia M4', 'QTP-2659', 13, 'rouge', 389, 'Alias quo quis inventore qui ea.'),
(16, 'Samsung Galaxy Note 3', 'ZTX-5419', 116, 'blanc', 849, 'Placeat reprehenderit nesciunt architecto quas.'),
(17, 'Apple Iphone 4', 'ZTX-5419', 49, 'vert', 663, 'Aut velit illo illum sint.'),
(18, 'Samsung Galaxy Note 3', 'QRZ-2751', 8, 'or', 110, 'Neque minus eos fugit nostrum non.'),
(19, 'Apple Iphone 7', 'QTP-2659', 12, 'noir', 982, 'Enim velit qui nam nesciunt non dolore.'),
(20, 'Apple Iphone 4', 'MG-205', 31, 'bleu', 654, 'Eaque pariatur non ea vel omnis rerum explicabo.'),
(21, 'Samsung Galaxy S6', 'MGS-2587', 45, 'rouge', 882, 'Dolorem voluptatem est similique tenetur aut sit aliquam.'),
(22, 'Apple Iphone 8', 'QRZ-2751', 44, 'argent', 431, 'Impedit sint nam perferendis sit.'),
(23, 'Huawei P8', 'GTS-324', 125, 'vert', 781, 'Totam iste perspiciatis harum animi et ad rerum.'),
(24, 'Samsung Galaxy S5', 'QTP-2659', 118, 'or', 747, 'Quod velit velit ut rem repellendus ut sit laudantium.'),
(25, 'Samsung Galaxy S7', 'QRZ-2751', 111, 'rouge', 555, 'Est in reprehenderit reiciendis accusamus.'),
(26, 'Huawei P9', 'MG-205', 66, 'bleu', 530, 'Nostrum doloremque minima aut molestiae sapiente est consequatur.'),
(27, 'Samsung Galaxy Note 1', 'MLT-4125', 74, 'vert', 891, 'Facere dolorum doloremque quasi vero nobis error fuga.'),
(28, 'Apple Iphone 4', 'ZTX-5419', 44, 'noir', 263, 'Ad sunt est impedit itaque.'),
(29, 'Huawei P10', 'QTP-2659', 37, 'vert', 748, 'Asperiores voluptatem magnam nostrum ea corrupti voluptatem molestiae.'),
(30, 'Apple Iphone 8', 'QRZ-2751', 22, 'bleu', 806, 'Nulla voluptatem aperiam ipsa eius repellat.');

-- --------------------------------------------------------

--
-- Structure de la table `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE IF NOT EXISTS `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `token`
--

INSERT INTO `token` (`id`, `token`, `created_at`) VALUES
(1, 'ya29.GlzDBiDG3ABA_BbAuIMNa14HGUUc0vdR1P4fnGXJIZsrgsEPD_Q3tWHk2w_dEx0slHzzvBiPi758IgyZrWQqvyfWgV_REhp3-O_dJ_UprtvnJJDmj2p9Nmb_vuus6w', '2019-03-05 10:04:18'),
(2, 'hrhrhrh', '2019-02-28 19:24:14'),
(3, 'ya29.Glu-BsRFjNyOV0uteyRT4EKZbZG6Bvs20oS-cJ9vK6ok7AzZ77weMwlcVtxPmZqKcAJBhUJLLuTx_gkfizuPJcCi0k42qk6i0kfDMwvXh_4ahKtTBPXemBFI7lkx', '2019-02-28 19:33:04');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registered_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8D93D64919EB6921` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `client_id`, `email`, `password`, `username`, `avatar_image`, `registered_at`) VALUES
(1, 2, 'wziemann@hotmail.com', 'qhvY2Z^@FxLpH>?R4Usi', 'ikoelpin', 'https://lorempixel.com/64/64/?92256', '2018-07-31 02:59:38'),
(2, 2, 'trinity79@fadel.com', '|3a)bQsrunw0{:0&', 'osinski.heath', 'https://lorempixel.com/64/64/?62506', '2018-06-30 13:41:23'),
(3, 1, 'elmira.grant@hotmail.com', '>40G|$7[', 'thayes', 'https://lorempixel.com/64/64/?72926', '2018-11-20 02:16:27'),
(4, 1, 'tremblay.jovani@yahoo.com', 'u<*d,-R', 'boehm.theo', 'https://lorempixel.com/64/64/?29046', '2019-01-27 02:55:55'),
(5, 2, 'alvena.mann@yahoo.com', 'qzXf=6tSGzbOWS%', 'ylesch', 'https://lorempixel.com/64/64/?69741', '2019-01-10 06:44:04'),
(6, 2, 'wiza.asia@gmail.com', 'rK.*2[ZSoAx\\', 'dandre.nienow', 'https://lorempixel.com/64/64/?75339', '2019-01-12 09:52:05'),
(7, 1, 'nakia64@heidenreich.com', 'BugV,{\"_OD', 'buckridge.alvena', 'https://lorempixel.com/64/64/?15766', '2018-08-12 00:38:03'),
(8, 2, 'jaskolski.odell@ruecker.com', 'Vb~6E/`WM', 'torphy.louie', 'https://lorempixel.com/64/64/?52357', '2018-04-01 04:30:17'),
(9, 2, 'michelle.blanda@hotmail.com', 'T!xnR-f&mb', 'coralie24', 'https://lorempixel.com/64/64/?55742', '2018-05-28 19:07:31'),
(10, 1, 'rath.buddy@gmail.com', 'Z#u|Nh*-<L6K$0e,i;)X', 'leda56', 'https://lorempixel.com/64/64/?43105', '2019-02-20 17:02:59'),
(11, 1, 'monroe18@yahoo.com', 'Ir89IUW-\\y/', 'bernhard.thaddeus', 'https://lorempixel.com/64/64/?90534', '2018-05-17 20:00:51'),
(12, 1, 'justyn34@hotmail.com', '\'c$BV:4', 'roberts.myah', 'https://lorempixel.com/64/64/?85860', '2018-12-17 11:18:38'),
(13, 1, 'tyrell84@gibson.info', 'O4D}n*/h\"Ax$P2Y7', 'elsie46', 'https://lorempixel.com/64/64/?11233', '2019-01-21 21:44:45'),
(14, 2, 'judd78@hotmail.com', '@Lf-xh[4Dx4)70xB9ul', 'yschowalter', 'https://lorempixel.com/64/64/?67551', '2018-09-27 06:16:54'),
(15, 1, 'tmueller@hotmail.com', 'e9R6f)0&>\"Ii9Eh%Fzw', 'ben.yost', 'https://lorempixel.com/64/64/?41874', '2018-03-28 21:27:02'),
(16, 2, 'giovani.witting@kilback.com', 'lwCZF#$n]r(->O~}T%{', 'hartmann.katharina', 'https://lorempixel.com/64/64/?84373', '2019-01-20 11:50:57'),
(17, 2, 'torp.janiya@yahoo.com', 'y]Hush/#v$LIL^3I', 'javier95', 'https://lorempixel.com/64/64/?63919', '2018-11-05 03:17:39'),
(18, 2, 'kamryn.franecki@schoen.net', 'ht1WT22kGZ', 'zwiegand', 'https://lorempixel.com/64/64/?62391', '2019-02-09 02:31:07'),
(19, 1, 'kassulke.bailee@auer.info', '8#wE/n4WH\\A;=G<', 'dward', 'https://lorempixel.com/64/64/?13282', '2018-12-01 09:55:26'),
(20, 2, 'stracke.margie@hotmail.com', 'LU\\D7G}FL>sDJI0#', 'erick.schmeler', 'https://lorempixel.com/64/64/?34651', '2018-09-27 08:30:29'),
(21, 1, 'schmeler.ayana@weber.com', 'AQ:}f=qSR', 'edouglas', 'https://lorempixel.com/64/64/?61523', '2018-03-31 07:16:11'),
(22, 1, 'nola97@yahoo.com', 'LmAByi[', 'okey98', 'https://lorempixel.com/64/64/?13997', '2018-05-06 02:19:57'),
(23, 2, 'swift.marisol@yahoo.com', '20NL*ARj/G/b', 'von.susanna', 'https://lorempixel.com/64/64/?74139', '2018-05-23 11:27:29'),
(24, 2, 'zoey.feeney@mcclure.com', 'ai!0DcHvpEiVC', 'goldner.mireya', 'https://lorempixel.com/64/64/?37007', '2018-10-19 04:53:48'),
(25, 1, 'freeman13@gmail.com', '7e\\PzeZTd}>?E-o', 'celine.abbott', 'https://lorempixel.com/64/64/?87994', '2018-10-15 18:07:26'),
(26, 2, 'garrison90@stamm.com', 'h&\"/A;m=', 'dax.zieme', 'https://lorempixel.com/64/64/?37349', '2018-09-04 10:24:14'),
(27, 2, 'ernest.heathcote@balistreri.com', '|)=b7|{{.', 'melany18', 'https://lorempixel.com/64/64/?47021', '2019-02-19 14:07:47'),
(28, 1, 'xander54@medhurst.info', 'XTYFfd', 'myra.von', 'https://lorempixel.com/64/64/?12735', '2018-09-24 07:20:10'),
(29, 1, 'dickens.noble@yahoo.com', 'l)$k@gR#J', 'delilah.erdman', 'https://lorempixel.com/64/64/?88373', '2018-09-05 00:43:44'),
(30, 2, 'madeline50@hotmail.com', ';%{U5#k@?uI[O9', 'qbarrows', 'https://lorempixel.com/64/64/?58685', '2018-05-19 22:26:05'),
(31, 1, 'jules.delannoy@gimenez.fr', NULL, 'aimee21', NULL, '2019-03-01 10:01:02'),
(33, 1, 'truc@bidule.com', NULL, 'richard55', NULL, '2019-03-01 10:01:04'),
(34, 1, 'benoit59@cordier.fr', NULL, 'isabelle.robert', NULL, '2019-03-01 10:05:46'),
(36, 1, 'krobert@jacob.net', NULL, 'hcharrier', NULL, '2019-03-01 10:09:38'),
(38, 1, 'sebastien40@delannoy.fr', NULL, 'nbourgeois', NULL, '2019-03-01 10:14:13'),
(40, 1, 'gfournier@hotmail.fr', NULL, 'susan.lejeune', NULL, '2019-03-01 10:28:21'),
(42, 1, 'roussel.alfred@regnier.fr', NULL, 'tbertin', NULL, '2019-03-01 10:33:30'),
(44, 1, 'anouk.aubry@maury.com', NULL, 'nalexandre', NULL, '2019-03-01 10:37:10'),
(46, 1, 'amelie70@cousin.fr', NULL, 'pauline.vallee', NULL, '2019-03-01 10:41:19'),
(48, 1, 'navarro.margot@free.fr', NULL, 'aurore.seguin', NULL, '2019-03-01 10:43:12'),
(50, 1, 'xwagner@gmail.com', NULL, 'roland.blanchet', NULL, '2019-03-01 10:53:14'),
(52, 1, 'voisin.robert@gmail.com', NULL, 'nchauvet', NULL, '2019-03-01 15:51:10'),
(54, 1, 'duhamel.philippe@tiscali.fr', NULL, 'hoarau.emmanuel', NULL, '2019-03-01 15:52:31'),
(56, 1, 'dupuis.maggie@techer.net', NULL, 'gmuller', NULL, '2019-03-01 16:00:40'),
(58, 1, 'corinne.laurent@hebert.fr', NULL, 'william.raynaud', NULL, '2019-03-01 16:02:42'),
(60, 1, 'perrin.etienne@tiscali.fr', NULL, 'lefevre.thierry', NULL, '2019-03-01 16:17:36'),
(62, 1, 'fleclerc@teixeira.fr', NULL, 'dupuis.odette', NULL, '2019-03-01 16:20:21'),
(63, 1, 'rodrigues.isaac@girard.com', NULL, 'faivre.gabriel', NULL, '2019-03-03 17:11:28');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `FK_C744045541DEE7B9` FOREIGN KEY (`token_id`) REFERENCES `token` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D64919EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
