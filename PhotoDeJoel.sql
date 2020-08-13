-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.6.48 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour photodejoel
CREATE DATABASE IF NOT EXISTS `photodejoel` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `photodejoel`;

-- Listage de la structure de la table photodejoel. actualite
CREATE TABLE IF NOT EXISTS `actualite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table photodejoel.actualite : ~3 rows (environ)
/*!40000 ALTER TABLE `actualite` DISABLE KEYS */;
INSERT INTO `actualite` (`id`, `categorie`, `titre`, `date_creation`, `contenu`, `position`) VALUES
	(1, 'test', 'test', '2020-08-12 19:40:00', 'test', 0),
	(2, 'test2', 'test2', '2020-08-13 13:40:08', 'test2Edit', 2),
	(3, 'test3', 'test3', '2020-08-13 11:59:02', 'test3', 1);
/*!40000 ALTER TABLE `actualite` ENABLE KEYS */;

-- Listage de la structure de la table photodejoel. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table photodejoel.doctrine_migration_versions : ~1 rows (environ)
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20200720141255', '2020-08-03 15:10:10', 129);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;

-- Listage de la structure de la table photodejoel. expo
CREATE TABLE IF NOT EXISTS `expo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `date_event` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table photodejoel.expo : ~2 rows (environ)
/*!40000 ALTER TABLE `expo` DISABLE KEYS */;
INSERT INTO `expo` (`id`, `titre`, `lieu`, `date_creation`, `contenu`, `position`, `date_event`) VALUES
	(1, 'test', 'test', '2020-08-13 13:27:21', 'test', 1, '2015-01-01 00:00:00'),
	(2, 'test', 'test', '2020-08-13 13:27:56', 'test', 0, '2015-01-01 00:00:00');
/*!40000 ALTER TABLE `expo` ENABLE KEYS */;

-- Listage de la structure de la table photodejoel. general
CREATE TABLE IF NOT EXISTS `general` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre_du_site_header` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texte_header` longtext COLLATE utf8mb4_unicode_ci,
  `mot_page_accueil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_accueil_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_footer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table photodejoel.general : ~1 rows (environ)
/*!40000 ALTER TABLE `general` DISABLE KEYS */;
INSERT INTO `general` (`id`, `titre_du_site_header`, `texte_header`, `mot_page_accueil`, `photo_accueil_path`, `text_footer`) VALUES
	(1, 'Titre du site', 'Texte en-tête', 'Texte page d\'accueil', 'general/home-5f2975afd1789.jpeg', 'Text pied de page');
/*!40000 ALTER TABLE `general` ENABLE KEYS */;

-- Listage de la structure de la table photodejoel. lien
CREATE TABLE IF NOT EXISTS `lien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lien` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table photodejoel.lien : ~0 rows (environ)
/*!40000 ALTER TABLE `lien` DISABLE KEYS */;
/*!40000 ALTER TABLE `lien` ENABLE KEYS */;

-- Listage de la structure de la table photodejoel. photo
CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_categorie_id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifs` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  KEY `IDX_14B78418339EEE3E` (`photo_categorie_id`),
  CONSTRAINT `FK_14B78418339EEE3E` FOREIGN KEY (`photo_categorie_id`) REFERENCES `photo_categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table photodejoel.photo : ~5 rows (environ)
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;
INSERT INTO `photo` (`id`, `photo_categorie_id`, `titre`, `path`, `exifs`) VALUES
	(1, 1, 'TestEdit', '/photo/Titre Catégorie/photo/test-5f29773cb50de.jpeg', 'a:0:{}'),
	(4, 1, 'testExif', '/photo/Titre Catégorie/photo/testexif-5f29b425ca6a1.jpeg', 'a:5:{s:5:"Model";s:20:"Canon EOS 7D Mark II";s:12:"ExposureTime";s:5:"1/200";s:7:"FNumber";s:4:"28/5";s:15:"ISOSpeedRatings";i:640;s:11:"FocalLength";s:5:"250/1";}'),
	(5, 1, 'Test', '/photo/Titre Catégorie/photo/test-5f3169f441b39.jpeg', 'a:5:{s:5:"Model";s:20:"Canon EOS 7D Mark II";s:12:"ExposureTime";s:5:"1/800";s:7:"FNumber";s:5:"63/10";s:15:"ISOSpeedRatings";i:640;s:11:"FocalLength";s:5:"600/1";}'),
	(6, 1, 'test', '/photo/Titre Catégorie/photo/test-5f316f1fc3ac5.jpeg', 'a:5:{s:5:"Model";s:20:"Canon EOS 7D Mark II";s:12:"ExposureTime";s:4:"1/80";s:7:"FNumber";s:5:"71/10";s:15:"ISOSpeedRatings";i:800;s:11:"FocalLength";s:5:"105/1";}'),
	(7, 1, 'test', '/photo/Titre Catégorie/photo/test-5f316fdf9a6ad.jpeg', 'a:5:{s:5:"Model";s:20:"Canon EOS 7D Mark II";s:12:"ExposureTime";s:4:"1/80";s:7:"FNumber";s:5:"71/10";s:15:"ISOSpeedRatings";i:800;s:11:"FocalLength";s:5:"105/1";}');
/*!40000 ALTER TABLE `photo` ENABLE KEYS */;

-- Listage de la structure de la table photodejoel. photo_categorie
CREATE TABLE IF NOT EXISTS `photo_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_cover_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table photodejoel.photo_categorie : ~3 rows (environ)
/*!40000 ALTER TABLE `photo_categorie` DISABLE KEYS */;
INSERT INTO `photo_categorie` (`id`, `titre`, `photo_cover_path`) VALUES
	(1, 'Titre Catégorie', '/photo/Titre/cover/titre-5f282a27ceb14.jpeg'),
	(2, 'Titre Catégorie2', '/photo/Titre Catégorie2/cover/titrecategorie2-5f2842dc1a7d2.jpeg'),
	(3, 'Test', NULL);
/*!40000 ALTER TABLE `photo_categorie` ENABLE KEYS */;

-- Listage de la structure de la table photodejoel. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table photodejoel.user : ~0 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
