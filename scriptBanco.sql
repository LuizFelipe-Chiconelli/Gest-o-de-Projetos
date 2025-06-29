-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: gestao_projetos
-- ------------------------------------------------------
-- Server version	9.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `aluno`
--

DROP TABLE IF EXISTS `aluno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aluno` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ra` varchar(20) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `curso` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `statusRegistro` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuario_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ra` (`ra`),
  UNIQUE KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `fk_aluno_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluno`
--

LOCK TABLES `aluno` WRITE;
/*!40000 ALTER TABLE `aluno` DISABLE KEYS */;
INSERT INTO `aluno` VALUES (54,'6859f4d0371c5','Aluno 1','Análise e Desenvolvimento de Sistemas','aluno1@gmail.com',1,'2025-06-23 21:44:00','2025-06-23 21:44:00',78);
/*!40000 ALTER TABLE `aluno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entrega`
--

DROP TABLE IF EXISTS `entrega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entrega` (
  `id` int NOT NULL AUTO_INCREMENT,
  `projeto_id` int DEFAULT NULL,
  `descricao` varchar(120) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `arquivo` varchar(120) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_entrega_projeto` (`projeto_id`),
  CONSTRAINT `fk_entrega_projeto` FOREIGN KEY (`projeto_id`) REFERENCES `projeto` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrega`
--

LOCK TABLES `entrega` WRITE;
/*!40000 ALTER TABLE `entrega` DISABLE KEYS */;
/*!40000 ALTER TABLE `entrega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professor`
--

DROP TABLE IF EXISTS `professor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `professor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `especialidade` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `area` varchar(50) DEFAULT NULL,
  `statusRegistro` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuario_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `fk_professor_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professor`
--

LOCK TABLES `professor` WRITE;
/*!40000 ALTER TABLE `professor` DISABLE KEYS */;
INSERT INTO `professor` VALUES (13,'Professor 1','PHP','professor1@gmail.com','Web',1,'2025-06-23 21:44:37','2025-06-23 21:44:37',79);
/*!40000 ALTER TABLE `professor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projeto`
--

DROP TABLE IF EXISTS `projeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projeto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  `resumo` text,
  `inicio` date DEFAULT NULL,
  `previsao_termino` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `professor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_projeto_professor` (`professor_id`),
  CONSTRAINT `fk_projeto_professor` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projeto`
--

LOCK TABLES `projeto` WRITE;
/*!40000 ALTER TABLE `projeto` DISABLE KEYS */;
INSERT INTO `projeto` VALUES (33,'Desenvolver Web Site','Web','....','2025-06-23','2025-07-30','Concluído',13);
/*!40000 ALTER TABLE `projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projeto_aluno`
--

DROP TABLE IF EXISTS `projeto_aluno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projeto_aluno` (
  `projeto_id` int NOT NULL,
  `aluno_id` int NOT NULL,
  `funcao` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`projeto_id`,`aluno_id`),
  KEY `fk_projeto_aluno_aluno` (`aluno_id`),
  CONSTRAINT `fk_projeto_aluno_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_projeto_aluno_projeto` FOREIGN KEY (`projeto_id`) REFERENCES `projeto` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projeto_aluno`
--

LOCK TABLES `projeto_aluno` WRITE;
/*!40000 ALTER TABLE `projeto_aluno` DISABLE KEYS */;
/*!40000 ALTER TABLE `projeto_aluno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reuniao`
--

DROP TABLE IF EXISTS `reuniao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reuniao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `projeto_id` int NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `local` varchar(60) NOT NULL,
  `pauta` varchar(120) NOT NULL,
  `observacoes` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_reuniao_projeto` (`projeto_id`),
  CONSTRAINT `fk_reuniao_projeto` FOREIGN KEY (`projeto_id`) REFERENCES `projeto` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reuniao`
--

LOCK TABLES `reuniao` WRITE;
/*!40000 ALTER TABLE `reuniao` DISABLE KEYS */;
/*!40000 ALTER TABLE `reuniao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel` tinyint DEFAULT NULL,
  `statusRegistro` tinyint DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (57,'admin','admin@gmail.com','$2y$12$KQKoejfLsJz6OWIWoYSbbO/5ulUfulirAuFYTUIXst7lQ3iAG/zxO',11,1),(78,'Aluno 1','aluno1@gmail.com','$2y$12$fVjeO66gbB0b4ebt8AJCFOLEU5uDy7xQu7IWvRwoU0q2/mRMd43JS',31,1),(79,'Professor 1','professor1@gmail.com','$2y$12$5J9uZ4txJpro6sT4ldUj4u5aUkRNoVwsu9TasyRVVJh2vtPh3nmYq',21,1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuariorecuperasenha`
--

DROP TABLE IF EXISTS `usuariorecuperasenha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuariorecuperasenha` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `chave` varchar(255) NOT NULL,
  `statusRegistro` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuariorecuperasenha`
--

LOCK TABLES `usuariorecuperasenha` WRITE;
/*!40000 ALTER TABLE `usuariorecuperasenha` DISABLE KEYS */;
INSERT INTO `usuariorecuperasenha` VALUES (1,67,'ab3a45405eacd778b2cb4a48ef8e26c8927bce79',2,'2025-06-22 19:43:04','2025-06-22 19:46:10'),(2,67,'1aa2ab48f43e3ab32e39f891cbcd78c7a7f224f6',2,'2025-06-22 19:46:57','2025-06-22 19:47:33'),(3,67,'b105acc0056a2c68d3e2eabccff6cb821e124384',2,'2025-06-22 19:50:57','2025-06-22 19:51:20');
/*!40000 ALTER TABLE `usuariorecuperasenha` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-24 13:49:39
