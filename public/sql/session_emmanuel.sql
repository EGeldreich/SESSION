-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour session_emmanuel
CREATE DATABASE IF NOT EXISTS `session_emmanuel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `session_emmanuel`;

-- Listage de la structure de table session_emmanuel. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session_emmanuel.category : ~6 rows (environ)
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'Front-end'),
	(2, 'Back-end'),
	(3, 'Design'),
	(4, 'Web Development'),
	(5, 'Databases'),
	(6, 'Frameworks');

-- Listage de la structure de table session_emmanuel. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table session_emmanuel.doctrine_migration_versions : ~1 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20250115151456', '2025-01-15 15:15:17', 947);

-- Listage de la structure de table session_emmanuel. formation
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session_emmanuel.formation : ~6 rows (environ)
INSERT INTO `formation` (`id`, `name`) VALUES
	(1, 'Web Development'),
	(2, 'UX Design'),
	(3, 'Front-end Development'),
	(4, 'Back-end Development'),
	(5, 'Full-Stack Development'),
	(6, 'Databases');

-- Listage de la structure de table session_emmanuel. lesson
CREATE TABLE IF NOT EXISTS `lesson` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F87474F312469DE2` (`category_id`),
  CONSTRAINT `FK_F87474F312469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session_emmanuel.lesson : ~14 rows (environ)
INSERT INTO `lesson` (`id`, `category_id`, `name`) VALUES
	(1, 1, 'Introduction to CSS'),
	(2, 1, 'Advanced CSS'),
	(3, 1, 'Introduction to JavaScript'),
	(4, 1, 'Advanced JavaScript'),
	(5, 2, 'Introduction to PHP'),
	(6, 2, 'Node.js for Beginners'),
	(7, 2, 'RESTful API'),
	(8, 3, 'Introduction to UX Design'),
	(9, 3, 'Principles of Responsive Design'),
	(10, 4, 'Introduction to Web Development'),
	(11, 5, 'Basic SQL'),
	(12, 5, 'Database Optimization'),
	(13, 6, 'React for Beginners'),
	(14, 6, 'Introduction to Angular');

-- Listage de la structure de table session_emmanuel. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session_emmanuel.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table session_emmanuel. program
CREATE TABLE IF NOT EXISTS `program` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` int NOT NULL,
  `lesson_id` int NOT NULL,
  `duration` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_92ED7784613FECDF` (`session_id`),
  KEY `IDX_92ED7784CDF80196` (`lesson_id`),
  CONSTRAINT `FK_92ED7784613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_92ED7784CDF80196` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session_emmanuel.program : ~9 rows (environ)
INSERT INTO `program` (`id`, `session_id`, `lesson_id`, `duration`) VALUES
	(1, 1, 1, 1),
	(2, 1, 2, 1),
	(3, 1, 3, 1),
	(4, 2, 8, 1),
	(5, 2, 9, 1),
	(6, 3, 4, 1),
	(7, 3, 5, 1),
	(8, 4, 6, 1),
	(9, 4, 7, 1);

-- Listage de la structure de table session_emmanuel. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `teacher_id` int NOT NULL,
  `formation_id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` int NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D441807E1D` (`teacher_id`),
  KEY `IDX_D044D5D45200282E` (`formation_id`),
  CONSTRAINT `FK_D044D5D441807E1D` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`),
  CONSTRAINT `FK_D044D5D45200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session_emmanuel.session : ~4 rows (environ)
INSERT INTO `session` (`id`, `teacher_id`, `formation_id`, `name`, `place`, `date_start`, `date_end`) VALUES
	(1, 1, 1, 'Web Development 1', 10, '2025-03-01', '2025-03-05'),
	(2, 2, 2, 'UX Design 1', 15, '2025-03-10', '2025-03-15'),
	(3, 3, 3, 'Front-end Development 1', 10, '2025-04-01', '2025-04-10'),
	(4, 4, 4, 'Back-end Development 1', 15, '2025-04-15', '2025-04-20');

-- Listage de la structure de table session_emmanuel. student
CREATE TABLE IF NOT EXISTS `student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_birth` date NOT NULL,
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session_emmanuel.student : ~4 rows (environ)
INSERT INTO `student` (`id`, `name`, `firstname`, `date_birth`, `city`, `email`, `gender`, `phone`) VALUES
	(1, 'Durand', 'Alice', '1995-05-10', 'Paris', 'alice.durand@example.com', 'F', '0123456789'),
	(2, 'Lemoine', 'Paul', '1998-11-22', 'Lyon', 'paul.lemoine@example.com', 'M', '0987654321'),
	(3, 'Dupont', 'Marie', '2000-02-18', 'Marseille', 'marie.dupont@example.com', 'F', '0147258369'),
	(4, 'Martin', 'Louis', '1997-08-30', 'Bordeaux', 'louis.martin@example.com', 'M', '0764839201');

-- Listage de la structure de table session_emmanuel. student_session
CREATE TABLE IF NOT EXISTS `student_session` (
  `student_id` int NOT NULL,
  `session_id` int NOT NULL,
  PRIMARY KEY (`student_id`,`session_id`),
  KEY `IDX_3D72602CCB944F1A` (`student_id`),
  KEY `IDX_3D72602C613FECDF` (`session_id`),
  CONSTRAINT `FK_3D72602C613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_3D72602CCB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session_emmanuel.student_session : ~4 rows (environ)
INSERT INTO `student_session` (`student_id`, `session_id`) VALUES
	(1, 1),
	(2, 2),
	(3, 3),
	(4, 4);

-- Listage de la structure de table session_emmanuel. teacher
CREATE TABLE IF NOT EXISTS `teacher` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session_emmanuel.teacher : ~4 rows (environ)
INSERT INTO `teacher` (`id`, `name`, `firstname`, `email`) VALUES
	(1, 'Dupont', 'Emmanuel', 'emmanuel.dupont@example.com'),
	(2, 'Martin', 'Claire', 'claire.martin@example.com'),
	(3, 'Lemoine', 'Julien', 'julien.lemoine@example.com'),
	(4, 'Durand', 'Sophie', 'sophie.durand@example.com');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
