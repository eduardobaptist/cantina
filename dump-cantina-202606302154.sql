/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: cantina
-- ------------------------------------------------------
-- Server version	11.8.6-MariaDB-0+deb13u1 from Debian

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `estoques`
--

DROP TABLE IF EXISTS `estoques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `estoques` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `produto_id` int(11) unsigned NOT NULL,
  `quantidade` int(11) NOT NULL,
  `fornecedor` varchar(255) NOT NULL,
  `observacao` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tipo` varchar(7) DEFAULT NULL COMMENT 'entrada/saida',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estoques`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `estoques` WRITE;
/*!40000 ALTER TABLE `estoques` DISABLE KEYS */;
INSERT INTO `estoques` VALUES
(1,1,5,'eduardo','pra mim sim','2026-05-20 01:00:41','2026-05-20 01:00:41','adicion'),
(2,1,5,'eduardo','abc','2026-05-20 01:04:17','2026-05-20 01:04:17','entrada'),
(3,1,5,'','','2026-05-20 01:06:43','2026-05-20 01:06:43','entrada'),
(4,1,5,'','','2026-05-20 01:07:23','2026-05-20 01:07:23','entrada'),
(5,1,10,'','','2026-05-20 01:10:55','2026-05-20 01:10:55','saida'),
(6,1,10,'','','2026-07-01 00:06:30','2026-07-01 00:06:30','entrada'),
(7,2,10,'','','2026-07-01 00:06:34','2026-07-01 00:06:34','entrada'),
(8,3,10,'','','2026-07-01 00:06:37','2026-07-01 00:06:37','entrada');
/*!40000 ALTER TABLE `estoques` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2026-05-19-225030','App\\Database\\Migrations\\CreateTableEstoque','default','App',1779231826,1),
(2,'2026-05-19-231133','App\\Database\\Migrations\\AddColumnTipoEstoque','default','App',1779232541,2),
(3,'2026-06-02-221656','App\\Database\\Migrations\\CreateTablePedidos','default','App',1780439638,3),
(4,'2026-06-02-221713','App\\Database\\Migrations\\CreateTablePedidoProdutos','default','App',1780439638,3),
(5,'2026-06-30-000000','App\\Database\\Migrations\\AlterUsuariosControleAcesso','default','App',1782860863,4),
(6,'2026-06-30-120000','App\\Database\\Migrations\\AddColumnClientePedidos','default','App',1782865112,5),
(7,'2026-07-01-000000','App\\Database\\Migrations\\AddColumnTotemPedidos','default','App',1782866817,6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `pedido_produtos`
--

DROP TABLE IF EXISTS `pedido_produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedido_produtos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) unsigned NOT NULL,
  `id_produto` int(11) unsigned NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido_produtos`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `pedido_produtos` WRITE;
/*!40000 ALTER TABLE `pedido_produtos` DISABLE KEYS */;
INSERT INTO `pedido_produtos` VALUES
(1,1,31,2,25.90,'2026-06-03 00:01:51','2026-06-03 00:01:51',NULL),
(2,1,31,1,18.50,'2026-06-03 00:01:51','2026-06-03 00:01:51',NULL),
(3,1,31,4,7.00,'2026-06-03 00:01:51','2026-06-03 00:01:51',NULL),
(4,2,2,1,12.00,'2026-06-30 22:20:59','2026-06-30 22:20:59',NULL),
(5,3,1,1,10.00,'2026-06-30 22:22:23','2026-06-30 22:22:23',NULL),
(6,3,2,1,12.00,'2026-06-30 22:22:23','2026-06-30 22:22:23',NULL),
(7,4,2,1,12.00,'2026-06-30 22:39:39','2026-06-30 22:39:39',NULL),
(8,4,1,3,10.00,'2026-06-30 22:39:39','2026-06-30 22:39:39',NULL),
(9,5,2,1,12.00,'2026-06-30 22:40:15','2026-06-30 22:40:15',NULL),
(10,6,1,1,10.00,'2026-06-30 22:49:03','2026-06-30 22:49:03',NULL),
(11,7,2,1,12.00,'2026-07-01 00:11:29','2026-07-01 00:11:29',NULL),
(12,7,1,1,10.00,'2026-07-01 00:11:29','2026-07-01 00:11:29',NULL),
(13,7,3,1,8.00,'2026-07-01 00:11:29','2026-07-01 00:11:29',NULL),
(16,10,2,1,12.00,'2026-07-01 00:21:21','2026-07-01 00:21:21',NULL),
(17,10,1,1,10.00,'2026-07-01 00:21:21','2026-07-01 00:21:21',NULL),
(18,10,3,1,8.00,'2026-07-01 00:21:21','2026-07-01 00:21:21',NULL),
(19,11,3,1,8.00,'2026-07-01 00:22:14','2026-07-01 00:22:14',NULL),
(20,11,2,1,12.00,'2026-07-01 00:22:14','2026-07-01 00:22:14',NULL),
(23,14,3,1,8.00,'2026-07-01 00:38:31','2026-07-01 00:38:31',NULL),
(24,14,2,1,12.00,'2026-07-01 00:38:31','2026-07-01 00:38:31',NULL),
(25,15,3,1,8.00,'2026-07-01 00:38:53','2026-07-01 00:38:53',NULL),
(26,15,2,1,12.00,'2026-07-01 00:38:53','2026-07-01 00:38:53',NULL),
(29,18,3,1,8.00,'2026-07-01 00:49:16','2026-07-01 00:49:16',NULL),
(30,18,2,1,12.00,'2026-07-01 00:49:16','2026-07-01 00:49:16',NULL);
/*!40000 ALTER TABLE `pedido_produtos` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `cliente` varchar(100) DEFAULT NULL,
  `totem` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES
(1,'novo',NULL,NULL,'2026-06-03 00:01:51','2026-06-03 00:01:51',NULL),
(2,'pronto',NULL,NULL,'2026-06-30 22:20:59','2026-06-30 22:36:57',NULL),
(3,'pronto',NULL,NULL,'2026-06-30 22:22:23','2026-06-30 22:36:58',NULL),
(4,'pronto',NULL,NULL,'2026-06-30 22:39:39','2026-06-30 22:48:46',NULL),
(5,'pronto',NULL,NULL,'2026-06-30 22:40:15','2026-06-30 22:48:52',NULL),
(6,'pronto',NULL,NULL,'2026-06-30 22:49:03','2026-06-30 23:13:39',NULL),
(7,'pronto',NULL,NULL,'2026-07-01 00:11:29','2026-07-01 00:21:08',NULL),
(10,'pronto',NULL,NULL,'2026-07-01 00:21:21','2026-07-01 00:22:32',NULL),
(11,'pronto','Eduardo',NULL,'2026-07-01 00:22:14','2026-07-01 00:22:33',NULL),
(14,'aguardando','Eduardo',NULL,'2026-07-01 00:38:31','2026-07-01 00:38:31',NULL),
(15,'aguardando','Eduardo',NULL,'2026-07-01 00:38:53','2026-07-01 00:38:53',NULL),
(18,'aguardando','João','Principal','2026-07-01 00:49:16','2026-07-01 00:49:16',NULL);
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(8,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `disponivel` tinyint(1) NOT NULL,
  `promocao` decimal(5,2) NOT NULL,
  `estoque` int(11) NOT NULL,
  `estoque_limite` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES
(1,'Coxinha',10.00,'2026-05-06 00:20:06','2026-07-01 00:06:30','1778026806_f60ca3357c50c00e3d76.jpg','lanches',1,0.00,5,0),
(2,'Coca-cola',12.00,'2026-05-06 00:45:34','2026-07-01 00:06:34','1778028334_50bcbe6f335e75893989.png','bebidas',1,0.00,10,0),
(3,'Pastel',8.00,'2026-07-01 00:05:04','2026-07-01 00:06:37','1782864304_df48671e0ecb3ca22da7.png','lanches',0,0.00,10,0);
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tipo` varchar(100) DEFAULT 'usuario',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES
(4,'eduardo.34000@aluno.iffar.edu.br','$2y$12$DNhAmqqQXiDHPW3ZioOxluVI28iuo.//nn25euHWMc6OWO9QnZWFa','2026-05-12 22:51:43','2026-05-13 01:11:26','super_admin',1,NULL,'2026-05-13 02:11:15'),
(5,'aristimdudu@gmail.com','$2y$12$cWCWPyNMxF3Szb1pzi..6.eYkfG.WUTWR787ogr0F8jsrnAlG5DGG','2026-05-20 00:11:36','2026-05-20 00:11:36','usuario',1,NULL,NULL),
(6,'aluno@gmail.com','$2y$12$JezAAKpBrE8DZ57baJCEG.xGonUQuFjEiY7urrdTaEfCjRasKYxwq','2026-06-02 22:07:40','2026-06-02 22:07:40','usuario',1,NULL,NULL),
(7,'teste@teste.com','$2y$12$Otv/N8ILttmWXdvkXzq/J.MvtXznyYFo1zVdX2DlGBuJjHT/aSJT2','2026-06-09 22:14:23','2026-06-09 22:14:23','usuario',1,NULL,NULL),
(9,'teste@gmail.com','$2y$12$fqBf0qxoQCAupUfLu3MEu.okM5r4JZKk7OyXYbF.CNA8iszdEb1cu','2026-06-29 19:08:53','2026-06-29 19:08:53','usuario',1,NULL,NULL),
(10,'admin@iffar.edu.br','$2y$12$7IWHBtbMr1ny4H2G1lOBCeyebYgCv0lfbQrWSIoc4ifkKOUw6iM9S','2026-06-30 23:07:45','2026-06-30 23:07:45','super_admin',1,NULL,NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Dumping routines for database 'cantina'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-06-30 21:54:48
