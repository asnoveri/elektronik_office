-- MySQL dump 10.16  Distrib 10.1.44-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: disposisi
-- ------------------------------------------------------
-- Server version	10.1.44-MariaDB-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `absensi`
--

DROP TABLE IF EXISTS `absensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `absensi` (
  `id_absensi` int(123) NOT NULL AUTO_INCREMENT,
  `id` int(123) NOT NULL,
  `tanggal` date NOT NULL,
  `absensi_masuk` time NOT NULL,
  `absensi_keluar` time NOT NULL,
  `ket_keberadaan` varchar(123) NOT NULL,
  `id_jdwlabnsi` int(123) NOT NULL,
  PRIMARY KEY (`id_absensi`),
  KEY `id` (`id`),
  KEY `id_jdwlabsensi` (`id_jdwlabnsi`),
  CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `absensi`
--

LOCK TABLES `absensi` WRITE;
/*!40000 ALTER TABLE `absensi` DISABLE KEYS */;
INSERT INTO `absensi` VALUES (3,58,'2020-05-31','15:22:00','17:42:00','piket kantor',1),(8,27,'2020-05-31','17:57:16','17:59:00','izin (sakit/cuti)',1),(9,12,'2020-05-31','19:35:35','19:36:44','wfh',1),(13,27,'2020-06-01','15:38:46','16:33:38','piket kantor',1),(19,58,'2020-06-01','17:00:39','17:00:43','izin (sakit/cuti)',1),(20,12,'2020-06-01','22:36:50','22:36:52','piket kantor',1),(21,27,'2020-06-02','18:34:07','18:34:12','piket kantor',1),(22,12,'2020-06-02','21:14:32','21:14:33','wfh',1),(23,58,'2020-06-02','21:14:48','21:14:49','piket kantor',1),(73,34,'2020-06-02','07:36:59','17:36:59','wfh',1),(74,12,'2020-06-06','09:29:48','15:29:48','wfh',1),(76,34,'2020-06-06','06:18:41','16:18:41','wfh',1),(85,26,'2020-06-07','00:55:19','11:55:19','wfh',1),(86,12,'2020-06-22','11:26:38','00:00:00','wfh',1),(87,12,'2020-06-25','09:30:24','09:30:52','piket kantor',1),(88,27,'2020-06-25','10:51:24','16:05:34','dl',1);
/*!40000 ALTER TABLE `absensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback_surat`
--

DROP TABLE IF EXISTS `feedback_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback_surat` (
  `id_feedback` int(123) NOT NULL AUTO_INCREMENT,
  `feedback` varchar(123) NOT NULL,
  PRIMARY KEY (`id_feedback`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback_surat`
--

LOCK TABLES `feedback_surat` WRITE;
/*!40000 ALTER TABLE `feedback_surat` DISABLE KEYS */;
INSERT INTO `feedback_surat` VALUES (1,'Di Teruskan'),(2,'Di Terima'),(7,'Di Setujui'),(8,'Di Proses'),(9,'Di Tolak');
/*!40000 ALTER TABLE `feedback_surat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jabatan`
--

DROP TABLE IF EXISTS `jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jabatan` (
  `id_jabatan` int(123) NOT NULL AUTO_INCREMENT,
  `id_peguna` int(123) NOT NULL,
  `id_unitkerja` int(123) NOT NULL,
  `nama_jabatan` int(123) DEFAULT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id_jabatan`),
  KEY `id_peguna` (`id_peguna`),
  KEY `id_unitkerja` (`id_unitkerja`),
  KEY `nama_jabatan` (`nama_jabatan`),
  CONSTRAINT `jabatan_ibfk_2` FOREIGN KEY (`id_unitkerja`) REFERENCES `unit_kerja` (`id_unitkerja`),
  CONSTRAINT `jabatan_ibfk_3` FOREIGN KEY (`nama_jabatan`) REFERENCES `unit_kerja` (`id_unitkerja`) ON DELETE NO ACTION,
  CONSTRAINT `jabatan_ibfk_4` FOREIGN KEY (`id_peguna`) REFERENCES `peguna` (`id_penguna`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jabatan`
--

LOCK TABLES `jabatan` WRITE;
/*!40000 ALTER TABLE `jabatan` DISABLE KEYS */;
INSERT INTO `jabatan` VALUES (18,106,14,15,1),(22,103,2,46,0),(110,135,11,38,1),(113,135,3,19,0),(117,140,4,23,1),(119,142,11,39,1),(121,144,2,NULL,0),(122,145,1,1,1),(125,152,2,NULL,1),(126,153,2,46,1),(127,154,1,1,0),(128,155,14,16,1),(129,157,11,39,1),(130,157,4,22,1),(131,158,2,NULL,1),(132,159,2,NULL,1),(133,135,5,26,1);
/*!40000 ALTER TABLE `jabatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jadwal_absensi`
--

DROP TABLE IF EXISTS `jadwal_absensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jadwal_absensi` (
  `id_jdwlabnsi` int(123) NOT NULL AUTO_INCREMENT,
  `tipejadwal` varchar(123) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  PRIMARY KEY (`id_jdwlabnsi`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal_absensi`
--

LOCK TABLES `jadwal_absensi` WRITE;
/*!40000 ALTER TABLE `jadwal_absensi` DISABLE KEYS */;
INSERT INTO `jadwal_absensi` VALUES (1,'sk-normal','07:30:00','16:00:00'),(2,'jmt-normal','07:30:00','16:30:00');
/*!40000 ALTER TABLE `jadwal_absensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `log_id` int(123) NOT NULL AUTO_INCREMENT,
  `tanggal` int(123) NOT NULL,
  `aksi` varchar(123) NOT NULL,
  `keterangan` varchar(123) NOT NULL,
  `ip` varchar(123) NOT NULL,
  `tipe_login` int(123) NOT NULL,
  `id_user` int(123) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=435 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (288,1590922636,'Absensi','Ambil Absen Masuk','::1',2,27,1),(289,1590922740,'Absensi','Ambil Absen Pulang','::1',2,27,1),(290,1590924435,'Logout','Logou Sistem','::1',2,27,1),(291,1590924444,'Login','Login Sistem','::1',1,12,1),(292,1590924450,'Logout','Logou Sistem','::1',1,12,1),(293,1590924534,'Login','Login Sistem','::1',1,12,1),(294,1590924543,'Logout','Logou Sistem','::1',1,12,1),(295,1590924561,'Login','Login Sistem','::1',7,12,1),(296,1590926731,'Login','Login Sistem','::1',1,12,1),(297,1590928021,'Logout','Logou Sistem','::1',1,12,1),(298,1590928030,'Login','Login Sistem','::1',2,27,1),(299,1590928418,'Logout','Logou Sistem','::1',2,27,1),(300,1590928429,'Login','Login Sistem','::1',2,27,1),(301,1590928443,'Logout','Logou Sistem','::1',2,27,1),(302,1590928528,'Login','Login Sistem','::1',2,12,1),(303,1590928535,'Absensi','Ambil Absen Masuk','::1',2,12,1),(304,1590928604,'Absensi','Ambil Absen Pulang','::1',2,12,1),(305,1590940138,'Logout','Logou Sistem','::1',7,12,1),(306,1590994187,'Login','Login Sistem','::1',7,12,1),(307,1590995725,'Login','Login Sistem','::1',2,27,1),(308,1590995730,'Absensi','Ambil Absen Masuk','::1',2,27,1),(309,1590995868,'Logout','Logou Sistem','::1',2,27,1),(310,1590995874,'Login','Login Sistem','::1',2,58,1),(311,1590995878,'Absensi','Ambil Absen Masuk','::1',2,58,1),(312,1590996160,'Absensi','Ambil Absen Masuk','::1',2,58,1),(313,1590996291,'Login','Login Sistem','::1',7,12,1),(314,1591000708,'Logout','Logou Sistem','::1',2,58,1),(315,1591000721,'Login','Login Sistem','::1',2,27,1),(316,1591000726,'Absensi','Ambil Absen Masuk','::1',2,27,1),(317,1591002340,'Login','Login Sistem','::1',2,27,1),(318,1591003837,'Login','Login Sistem','::1',2,27,1),(319,1591004018,'Absensi','Ambil Absen Pulang','::1',2,27,1),(320,1591004686,'Login','Login Sistem','::1',2,58,1),(321,1591004798,'Absensi','Ambil Absen Masuk','::1',2,58,1),(322,1591004989,'Absensi','Ambil Absen Masuk','::1',2,58,1),(323,1591005053,'Absensi','Ambil Absen Masuk','::1',2,58,1),(324,1591005206,'Absensi','Ambil Absen Masuk','::1',2,58,1),(325,1591005291,'Absensi','Ambil Absen Masuk','::1',2,58,1),(326,1591005639,'Absensi','Ambil Absen Masuk','::1',2,58,1),(327,1591005643,'Absensi','Ambil Absen Pulang','::1',2,58,1),(328,1591025779,'Login','Login Sistem','::1',1,12,1),(329,1591025790,'Logout','Logou Sistem','::1',1,12,1),(330,1591025804,'Login','Login Sistem','::1',2,12,1),(331,1591025810,'Absensi','Ambil Absen Masuk','::1',2,12,1),(332,1591025812,'Absensi','Ambil Absen Pulang','::1',2,12,1),(333,1591083015,'Login','Login Sistem','::1',7,12,1),(334,1591083645,'Logout','Logou Sistem','::1',7,12,1),(335,1591083778,'Login','Login Sistem','::1',1,12,1),(336,1591085583,'Logout','Logou Sistem','::1',1,12,1),(337,1591085602,'Login','Login Sistem','::1',7,12,1),(338,1591097625,'Login','Login Sistem','::1',1,12,1),(339,1591097637,'Logout','Logou Sistem','::1',1,12,1),(340,1591097644,'Login','Login Sistem','::1',2,27,1),(341,1591097647,'Absensi','Ambil Absen Masuk','::1',2,27,1),(342,1591097652,'Absensi','Ambil Absen Pulang','::1',2,27,1),(343,1591097658,'Logout','Logou Sistem','::1',2,27,1),(344,1591097670,'Login','Login Sistem','::1',7,12,1),(345,1591107268,'Login','Login Sistem','::1',2,12,1),(346,1591107272,'Absensi','Ambil Absen Masuk','::1',2,12,1),(347,1591107273,'Absensi','Ambil Absen Pulang','::1',2,12,1),(348,1591107276,'Logout','Logou Sistem','::1',2,12,1),(349,1591107284,'Login','Login Sistem','::1',2,58,1),(350,1591107288,'Absensi','Ambil Absen Masuk','::1',2,58,1),(351,1591107289,'Absensi','Ambil Absen Pulang','::1',2,58,1),(352,1591166000,'Login','Login Sistem','::1',7,12,1),(353,1591166378,'Login','Login Sistem','::1',1,12,1),(354,1591167702,'Login','Login Sistem','::1',7,12,1),(355,1591170268,'Login','Login Sistem','::1',1,12,1),(356,1591170380,'Logout','Logou Sistem','::1',1,12,1),(357,1591170386,'Login','Login Sistem','::1',7,12,1),(358,1591170426,'Login','Login Sistem','::1',7,12,1),(359,1591172168,'Login','Login Sistem','::1',1,12,1),(360,1591456720,'Login','Login Sistem','::1',1,12,1),(361,1591457288,'Logout','Logou Sistem','::1',1,12,1),(362,1591457295,'Login','Login Sistem','::1',7,12,1),(363,1591458007,'Login','Login Sistem','::1',7,12,1),(364,1591458089,'Login','Login Sistem','::1',7,12,1),(365,1591458353,'Logout','Logou Sistem','::1',7,12,1),(366,1591458360,'Login','Login Sistem','::1',1,12,1),(367,1591458912,'Logout','Logou Sistem','::1',1,12,1),(368,1591458919,'Login','Login Sistem','::1',7,12,1),(369,1591464485,'Login','Login Sistem','::1',1,12,1),(370,1591471074,'Logout','Logou Sistem','::1',7,12,1),(371,1591471087,'Login','Login Sistem','::1',1,12,1),(372,1591530310,'Login','Login Sistem','::1',7,12,1),(373,1591530474,'Logout','Logou Sistem','::1',7,12,1),(374,1591530480,'Login','Login Sistem','::1',1,12,1),(375,1591530632,'Logout','Logou Sistem','::1',1,12,1),(376,1591530643,'Login','Login Sistem','::1',7,12,1),(377,1591531979,'Login','Login Sistem','::1',7,12,1),(378,1591532905,'Login','Login Sistem','::1',7,12,1),(379,1591543807,'Logout','Logou Sistem','::1',7,12,1),(380,1591797857,'Login','Login Sistem','::1',7,12,1),(381,1591798235,'Login','Login Sistem','::1',7,12,1),(382,1592052926,'Login','Login Sistem','::1',7,12,1),(383,1592075844,'Logout','Logou Sistem','::1',7,12,1),(384,1592075861,'Login','Login Sistem','::1',1,12,1),(385,1592075865,'Logout','Logou Sistem','::1',1,12,1),(386,1592075877,'Login','Login Sistem','::1',7,12,1),(387,1592075899,'Logout','Logou Sistem','::1',7,12,1),(388,1592075986,'Login','Login Sistem','::1',7,12,1),(389,1592075986,'Login','Login Sistem','::1',7,12,1),(390,1592075990,'Logout','Logou Sistem','::1',7,12,1),(391,1592075999,'Login','Login Sistem','::1',1,12,1),(392,1592076002,'Logout','Logou Sistem','::1',1,12,1),(393,1592076009,'Login','Login Sistem','::1',7,12,1),(394,1592140041,'Login','Login Sistem','::1',7,12,1),(395,1592799662,'Login','Login Sistem','::1',7,12,1),(396,1592799791,'Logout','Logou Sistem','::1',7,12,1),(397,1592799803,'Login','Login Sistem','::1',1,12,1),(398,1592799960,'Logout','Logou Sistem','::1',1,12,1),(399,1592799973,'Login','Login Sistem','::1',3,12,1),(400,1592799983,'Logout','Logou Sistem','::1',3,12,1),(401,1592799992,'Login','Login Sistem','::1',2,12,1),(402,1592799998,'Absensi','Ambil Absen Masuk','::1',2,12,1),(403,1592800212,'Logout','Logou Sistem','::1',2,12,1),(404,1592800228,'Login','Login Sistem','::1',7,12,1),(405,1593052196,'Login','Login Sistem','::1',2,12,1),(406,1593052206,'Login','Login Sistem','::1',7,12,1),(407,1593052224,'Absensi','Ambil Absen Masuk','::1',2,12,1),(408,1593052252,'Absensi','Ambil Absen Pulang','::1',2,12,1),(409,1593052797,'Logout','Logou Sistem','::1',7,12,1),(410,1593052851,'Login','Login Sistem','::1',1,12,1),(411,1593052851,'Login','Login Sistem','::1',1,12,1),(412,1593055041,'Logout','Logou Sistem','::1',1,12,1),(413,1593055586,'Login','Login Sistem','::1',7,12,1),(414,1593057057,'Logout','Logou Sistem','::1',2,12,1),(415,1593057069,'Login','Login Sistem','::1',2,27,1),(416,1593057084,'Absensi','Ambil Absen Masuk','::1',2,27,1),(417,1593059100,'Logout','Logou Sistem','::1',7,12,1),(418,1593059113,'Login','Login Sistem','::1',2,12,1),(419,1593059443,'Login','Login Sistem','::1',2,12,1),(420,1593059932,'Login','Login Sistem','::1',7,12,1),(421,1593060517,'Login','Login Sistem','::1',7,12,1),(422,1593065870,'Login','Login Sistem','::1',2,27,1),(423,1593070683,'Login','Login Sistem','::1',7,12,1),(424,1593071458,'Login','Login Sistem','::1',7,12,1),(425,1593072658,'Logout','Logou Sistem','::1',2,12,1),(426,1593072678,'Login','Login Sistem','::1',2,27,1),(427,1593072938,'Logout','Logou Sistem','::1',2,27,1),(428,1593072989,'Login','Login Sistem','::1',2,12,1),(429,1593075906,'Logout','Logou Sistem','::1',2,12,1),(430,1593075921,'Login','Login Sistem','::1',2,27,1),(431,1593075934,'Absensi','Ambil Absen Pulang','::1',2,27,1),(432,1593075975,'Logout','Logou Sistem','::1',2,27,1),(433,1593135056,'Login','Login Sistem','::1',1,12,1),(434,1593137235,'Login','Login Sistem','::1',1,12,1);
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id_menu` int(123) NOT NULL AUTO_INCREMENT,
  `menu` varchar(123) NOT NULL,
  `ctrl_menu` varchar(123) NOT NULL,
  `call_child` varchar(123) NOT NULL,
  `posisi` varchar(123) NOT NULL,
  `is_active` varchar(123) NOT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (5,'Kelola Menu','Menu_Managemen','menumaneg','7','1'),(6,'Kelola User','User_Managemen','usermaneg','3','1'),(8,'Kelola Admin','Managemen_Admin','addadmin','2','1'),(9,'Kelola Surat','Managemen_Surat','srtmsk','1','1'),(10,'Disposis Surat','User','disposisisrt','5','1'),(11,'Pengajuan Disposisi Surat keluar','Pengajuan_Disposisi_Surat_keluar','psk','6','1'),(12,'Absensi','Absensi','lapabsnsi','4','1');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peguna`
--

DROP TABLE IF EXISTS `peguna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peguna` (
  `id_penguna` int(123) NOT NULL AUTO_INCREMENT,
  `id` int(123) NOT NULL,
  `role_id` int(123) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id_penguna`),
  KEY `id` (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `peguna_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `peguna_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role_user` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peguna`
--

LOCK TABLES `peguna` WRITE;
/*!40000 ALTER TABLE `peguna` DISABLE KEYS */;
INSERT INTO `peguna` VALUES (102,27,7,1),(103,26,6,0),(106,33,5,1),(135,34,3,1),(140,27,3,1),(142,57,3,1),(144,27,6,0),(145,26,4,1),(146,27,1,0),(150,57,1,1),(151,12,1,1),(152,12,2,1),(153,12,6,1),(154,12,4,0),(155,12,5,1),(156,12,7,1),(157,12,3,1),(158,27,2,1),(159,58,2,1);
/*!40000 ALTER TABLE `peguna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `role_id` int(123) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(123) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,'admin'),(2,'Sekretaris'),(3,'Pegawai'),(4,'Direktur'),(5,'Wakil Direktur'),(6,'adum'),(7,'admin kepegawaian');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_menu`
--

DROP TABLE IF EXISTS `sub_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_menu` (
  `id_submenu` int(123) NOT NULL AUTO_INCREMENT,
  `id_menu` int(123) NOT NULL,
  `title` varchar(123) NOT NULL,
  `url` varchar(123) NOT NULL,
  `icon` varchar(123) NOT NULL,
  `is_active_sub` int(11) NOT NULL,
  `posisi_sub` varchar(123) NOT NULL,
  PRIMARY KEY (`id_submenu`),
  KEY `id_menu` (`id_menu`),
  CONSTRAINT `sub_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_menu`
--

LOCK TABLES `sub_menu` WRITE;
/*!40000 ALTER TABLE `sub_menu` DISABLE KEYS */;
INSERT INTO `sub_menu` VALUES (7,5,'List Sub Menu','Menu_Managemen/list_sub_menu','fa fa-bars',1,'2'),(11,5,'List Menu','Menu_Managemen/','fa fa-bars',1,'1'),(16,6,'List User','User_Managemen/','fa fa-users',1,'1'),(17,6,'Import User','User_Managemen/import_user','fa fa-users',0,'2'),(20,5,'Role Menu Akses','Menu_Managemen/acces_user','fa fa-users',1,'3'),(21,8,'Admin Sistem','Managemen_Admin/','fa fa-users',1,'1'),(22,6,'Jabatan Pegawai','User_Managemen/jabatan','fa fa-users',0,'3'),(23,9,'Surat Masuk','Managemen_Surat/','fa fa-envelope',1,'1'),(25,9,'Kelola Alur Surat','Managemen_Surat/kelola_alur_srt','fa fa-file',0,'2'),(26,9,'Surat Keluar','Managemen_Surat/srt_keluar','fa fa-envelope',1,'2'),(27,10,'List Surat Masuk','User/list_srt_msk_user','fa fa-envelope',1,'1'),(29,10,'List Arsip Surat Masuk','User/arsip_srt_masuk','fa fa-envelope',1,'2'),(31,11,'Ajukan Surat','User/surat_keluar','fa fa-envelope',1,'1'),(33,6,'Sekretaris','User_Managemen/list_op','fa fa-users',1,'2'),(34,6,'Direktur','User_Managemen/listdirektur','fa fa-users',0,'3'),(35,6,'Wakil Direktur','User_Managemen/listwadir','fa fa-users',0,'4'),(36,6,'Adum','User_Managemen/Adum','fa fa-users',0,'5'),(37,8,'Admin Kepegawaiaan','Managemen_Admin/admn_kep','fa fa-users',1,'4'),(38,6,'List Penjabat','User_Managemen/penjabat','fa fa-users',1,'3'),(39,6,'List Pegawai','User_Managemen/list_pegawai','fa fa-users',1,'5'),(40,12,'Laporan Absensi','Absensi/','fas fa-clipboard-list',1,'1');
/*!40000 ALTER TABLE `sub_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat_keluar`
--

DROP TABLE IF EXISTS `surat_keluar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surat_keluar` (
  `id_surat_keluar` int(123) NOT NULL AUTO_INCREMENT,
  `tgl_surat_keluar` date NOT NULL,
  `no_surat_keluar` varchar(123) NOT NULL,
  `sifat_surat` varchar(123) NOT NULL,
  `file_surat` varchar(123) NOT NULL,
  `asal_surat` varchar(123) NOT NULL,
  `perihal` varchar(123) NOT NULL,
  `id_feedback` int(123) NOT NULL,
  `bg_porgres` varchar(123) NOT NULL,
  `id_feedback1` int(123) NOT NULL,
  `yang_mendisposisi` int(123) NOT NULL,
  PRIMARY KEY (`id_surat_keluar`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat_keluar`
--

LOCK TABLES `surat_keluar` WRITE;
/*!40000 ALTER TABLE `surat_keluar` DISABLE KEYS */;
INSERT INTO `surat_keluar` VALUES (1,'2020-03-10','213212','Biasa','asno2pdf_(1)1.pdf','16','Bootstrap Tutorial\r\nBootstrap is the most popular HTML, CSS, and JS framework for developing responsive, mobile-first proje',2,'success',0,0),(2,'2020-03-09','srkeluar','Biasa','suratsehat.pdf','16','sda',2,'success',0,0),(3,'2020-03-12','Surat 09009','Penting','cv(asnoveri1).pdf','16','Surat Untuk Mengikuti Kegiatan Training Pemograman Php  Depaok Jawabarat',2,'success',0,0),(4,'2020-03-11','SSD','Rahasia','tofel.jpg','16','asdasdasdfasc',2,'success',7,14),(7,'0000-00-00','as','Biasa','cv(asno)-dikonversi4.pdf','16','asdas',2,'success',9,14),(8,'0000-00-00','drftghjk','Rahasia','cv_asno_english.pdf','16','gggvgv',2,'success',7,1),(9,'0000-00-00','NO/srt','Rahasia','cv_asno_english1.pdf','16','SK MUTASI',2,'success',7,1),(10,'0000-00-00','srkeluar','Rahasia','bebasnarkoba.jpg','1','asdas',8,'info',0,0),(11,'2020-03-19','as','Rahasia','asno2pdf_(1)2.pdf','1','sdfsd',8,'info',0,0);
/*!40000 ALTER TABLE `surat_keluar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat_keluar_diter`
--

DROP TABLE IF EXISTS `surat_keluar_diter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surat_keluar_diter` (
  `id_terus_srt_keluar` int(123) NOT NULL AUTO_INCREMENT,
  `id_surat_keluar` int(123) NOT NULL,
  `di_teruskan_ke_srt_klr` int(123) NOT NULL,
  `id_feedback_terSrtKlr` int(123) NOT NULL,
  `bg_porgres_srt_keluar` varchar(123) NOT NULL,
  `kondisi_surat_keluar` varchar(123) NOT NULL,
  PRIMARY KEY (`id_terus_srt_keluar`),
  KEY `id_surat_keluar` (`id_surat_keluar`),
  CONSTRAINT `surat_keluar_diter_ibfk_1` FOREIGN KEY (`id_surat_keluar`) REFERENCES `surat_keluar` (`id_surat_keluar`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat_keluar_diter`
--

LOCK TABLES `surat_keluar_diter` WRITE;
/*!40000 ALTER TABLE `surat_keluar_diter` DISABLE KEYS */;
INSERT INTO `surat_keluar_diter` VALUES (1,1,0,2,'success',''),(2,2,0,2,'success',''),(3,3,0,2,'success',''),(4,4,0,2,'success',''),(5,4,1,2,'success',''),(6,3,1,2,'success',''),(7,2,1,2,'success',''),(8,1,1,2,'success',''),(10,7,0,2,'success',''),(11,4,14,2,'success',''),(12,7,14,2,'success',''),(13,8,0,2,'success',''),(14,8,1,2,'success',''),(15,9,0,2,'success',''),(16,9,1,2,'success',''),(17,10,0,2,'success',''),(18,11,0,2,'success','');
/*!40000 ALTER TABLE `surat_keluar_diter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat_masuk`
--

DROP TABLE IF EXISTS `surat_masuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surat_masuk` (
  `id_surat_masuk` int(123) NOT NULL AUTO_INCREMENT,
  `tgl_surat_masuk` date NOT NULL,
  `no_surat` varchar(123) NOT NULL,
  `sifat_surat` varchar(123) NOT NULL,
  `file_surat` varchar(123) NOT NULL,
  `asal_surat` varchar(123) NOT NULL,
  `perihal` varchar(500) NOT NULL,
  `tipe_surat` varchar(123) NOT NULL,
  PRIMARY KEY (`id_surat_masuk`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat_masuk`
--

LOCK TABLES `surat_masuk` WRITE;
/*!40000 ALTER TABLE `surat_masuk` DISABLE KEYS */;
INSERT INTO `surat_masuk` VALUES (45,'2020-02-08','NO/09090sadcn','Segera','RENCANA_KEGIATAN_POLTEKKES_KEMENKES_RIAU_TAHUN_201917.pdf','Kemendikbud','asdasas','Surat Masuk'),(47,'2020-02-16','sasa1222','Biasa','cv(asno)-dikonversi1.pdf','sasa','sdfsd','Surat Masuk'),(48,'2020-02-19','trs31','Rahasia','cv(asno)-dikonversi2.pdf','Sumbar','For 50 years, WWF has been protecting the future of nature. ','Surat Masuk'),(49,'2020-02-19','EW12','Biasa','Lamaran_Kerja-dikonversi_ibra_nizam-dikonversi.pdf','Kepri','\r\nFor 50 years, WWF has been protecting the future of nature. ','Surat Masuk'),(50,'2020-02-26','12A4d/LK','Biasa','cv(asno)-dikonversi3.pdf','Kemendikbud','Untuk Mengkuti Pelatihan Manajemen Perkantoran','Surat Masuk'),(51,'2020-02-26','202P/09ANB','Segera','Lamaran_Kerja-_mega_central,_ibra_nizam-dikonversi.pdf','pemprov riau','Himbauan Kegiatan K3 di Lingkungan Instansi','Surat Masuk'),(52,'0000-00-00','asdfghj','Rahasia','akatalahir.pdf','afsdgsdf','safdsgfdsg','Surat Masuk'),(53,'0000-00-00','234','Pilih Sifat Surat','akatalahir1.pdf','pemprov riau','saas','Surat Masuk'),(54,'2020-03-27','234','Penting','asno2pdf_(1)3.pdf','sasa','asd','Surat Masuk');
/*!40000 ALTER TABLE `surat_masuk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat_masuk_diter`
--

DROP TABLE IF EXISTS `surat_masuk_diter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surat_masuk_diter` (
  `id_terus` int(123) NOT NULL AUTO_INCREMENT,
  `id_surat_masuk` int(123) NOT NULL,
  `di_teruskan_ke` int(123) NOT NULL,
  `di_kirimkan_oleh` int(123) NOT NULL,
  `id_feedback` int(123) NOT NULL,
  `bg_porgres` varchar(123) NOT NULL,
  `instruksi` varchar(200) NOT NULL,
  `kondisi_surat` varchar(123) NOT NULL,
  PRIMARY KEY (`id_terus`),
  KEY `id_surat_masuk` (`id_surat_masuk`),
  CONSTRAINT `surat_masuk_diter_ibfk_1` FOREIGN KEY (`id_surat_masuk`) REFERENCES `surat_masuk` (`id_surat_masuk`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat_masuk_diter`
--

LOCK TABLES `surat_masuk_diter` WRITE;
/*!40000 ALTER TABLE `surat_masuk_diter` DISABLE KEYS */;
INSERT INTO `surat_masuk_diter` VALUES (2,45,14,0,2,'success','','Di Arsipkan'),(14,47,14,0,2,'success','','Di Arsipkan'),(16,48,14,0,2,'success','','Di Arsipkan'),(23,48,1,14,2,'success','',''),(26,48,4,1,2,'success','Tolong Di Teruskan Kepada Setiap Ka unit Yang bersangkutan',''),(27,48,16,4,2,'success','Diharapkan kepada penjabat / KA. unit yang bersangkutan untuk mengkitu pelatihan pada itu','Di Arsipkan'),(28,50,1,0,2,'success','','Di Arsipkan'),(29,50,4,1,2,'success','Agar Mengikuti Kegiatan Hal tersebut',''),(30,50,16,1,2,'success','Agar Mengikuti Kegiatan Hal tersebut','Di Arsipkan'),(31,51,16,0,2,'success','','Di Arsipkan'),(32,51,16,4,2,'success','Himbauan Kegiatan K3 Di Lingkungan Instansi','Di Arsipkan'),(33,47,4,14,2,'success','Himbauan Kegiatan K3 Di Lingkungan Instansi',''),(34,47,16,14,2,'success','Himbauan Kegiatan K3 Di Lingkungan Instansi','Di Arsipkan'),(35,47,14,4,2,'success','Himbauan Kegiatan K3 Di Lingkungan Instansi',''),(36,47,16,4,2,'success','Himbauan Kegiatan K3 Di Lingkungan Instansi','Di Arsipkan'),(37,52,14,0,2,'success','',''),(38,52,1,14,2,'success','Mohon Disposisi',''),(39,52,16,1,2,'success','Diperintahkan Berangkat ka unit it',''),(40,52,4,1,2,'success','asdfhgfdsads',''),(41,53,14,0,1,'primary','',''),(42,54,14,0,2,'success','',''),(43,48,28,1,1,'primary','','');
/*!40000 ALTER TABLE `surat_masuk_diter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_kerja`
--

DROP TABLE IF EXISTS `unit_kerja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_kerja` (
  `id_unitkerja` int(123) NOT NULL AUTO_INCREMENT,
  `unitkerja` varchar(123) NOT NULL,
  `parent_unit` int(123) NOT NULL,
  PRIMARY KEY (`id_unitkerja`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_kerja`
--

LOCK TABLES `unit_kerja` WRITE;
/*!40000 ALTER TABLE `unit_kerja` DISABLE KEYS */;
INSERT INTO `unit_kerja` VALUES (1,'Direktur',0),(2,'Subbag ADUM',0),(3,'Subbag ADAK',0),(4,'Jurusan Keperawatan',0),(5,'Jurusan Kebidanan',0),(6,'Jurusan Gizi',0),(7,'Pusat PPM',0),(8,'Pusat Mutu & PP',0),(9,'Unit Laboratorium',0),(10,'Unit Pustaka',0),(11,'Unit Komputer',0),(12,'Unit Bahasa',0),(13,'Prodi DIII Rengat',0),(14,'Wadir',0),(15,'Wadir1',14),(16,'Wadir2',14),(17,'Wadir3',14),(18,'Staf Subbag ADUM',2),(19,'Ka. Subbag ADAK',3),(20,'Staf Subbag ADAK',3),(21,'Dosen Jurusan Keperawatan',4),(22,'Staf Jurusan Keperawatan',4),(23,'Ketua Jurusan Keperawatan',4),(24,'Staf Jurusan Kebidanan',5),(25,'Dosen Jurusan Kebidanan',5),(26,'Ketua Jurusan Kebidanan',5),(27,'Staf Jurusan Gizi',6),(28,'Dosen Jurusan Gizi',6),(29,'Ketua Jurusan Gizi',6),(30,'Staf Pusat PPM',7),(31,'Kepala Pusat PPM',7),(32,'Staf Pusat Mutu & PP ',8),(33,'Kepala Pusat Mutu & PP',8),(34,'Staf Unit Laboratorium',9),(35,'Kepala Unit Laboratorium',9),(36,'Staf Unit Pustaka',10),(37,'Kepala Unit Pustaka',10),(38,'Kepala Unit Komputer',11),(39,'Staf Unit Komputer',11),(40,'Kepala Unit Bahasa',12),(41,'Staf Unit Bahasa',12),(42,'Staf Prodi DIII Rengat',13),(43,'Dosen Prodi DIII Rengat',13),(44,'Ketua Jurusan Prodi DIII Rengat',13),(46,'KA. Subbag Adum',2);
/*!40000 ALTER TABLE `unit_kerja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(123) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(123) NOT NULL,
  `nip` int(19) NOT NULL,
  `user_name` varchar(123) NOT NULL,
  `email` varchar(123) NOT NULL,
  `is_active` int(123) NOT NULL,
  `image` varchar(123) NOT NULL,
  `pass` varchar(123) NOT NULL,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (12,'Asno Veri',2147483647,'asno','asnoveri15@gmail.com',1,'default.png','$2y$10$Nc0OZ0qtClWf9UwDucEs4esOgI.4J.FEJcXkjLIrTISTWdPip7pUO',1579428763),(26,'Husnan. SKp. M.K',2147483647,'husnan','direktur@pkr.ac.id',1,'img_avatar5.png','$2y$10$XMRVYLhTAVrcj02Vf6VjHeteIx9pw0fP0PkWWdluW4tyBIMbrqNbm',1579428763),(27,'Adit',2147483647,'aditThe','aditoperator@gmail.com',1,'default.png','$2y$10$Nb9rjqluETZNIqLa/xTnpeHKVk.TYRQok7Hz18kIbqQvlyioAl3kO',1579435710),(33,'Wakil Direktur 1',1900909101,'wadir','wadir1@pkr.ac.id',1,'default.png','$2y$10$5vyhiz6YkAY9S5Ng5f/NsuBOeJuXgeMugwob3hQ6e22DfJ36lJJs6',1582383127),(34,'Al Kahfi Budiyarman',2147483647,'kahfi','veri@gmail.com',1,'default.png','$2y$10$cwy22NRtMB.jpCnmy73rw.dKpblDEU4MQSeBsKZ7rTTBdm/g3ltHy',1582383332),(57,'Rozy Farmaduha',2147483647,'rozy','rozy@pkr.ac.id',1,'default.png','$2y$10$mSmbtL6.BCfnqC3QkY2Vm.am4i35MVQClK9sImHItcVw3NZbk7ELe',1588084871),(58,'Nikma Ayuni',2147483647,'ayu','ayu@mail.com',1,'default.png','$2y$10$LoNloib7p3xV0I8oxpmHj.673Jul0L3.o3I9GzhYJS1avkzkNwvS.',1590058908),(63,'NAZIF',2147483647,'nazif','nazif@gmail.com',1,'default.png','$2y$10$gMkYIbDRB2Q.riwJI6aLIOOvgMEJO4Y1c/39WecpkHeWbgTdvxByO',1593136615);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_acess_menu`
--

DROP TABLE IF EXISTS `user_acess_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_acess_menu` (
  `id_acess` int(123) NOT NULL AUTO_INCREMENT,
  `role_id` int(123) NOT NULL,
  `id_menu` int(123) NOT NULL,
  PRIMARY KEY (`id_acess`),
  KEY `id_menu` (`id_menu`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_acess_menu_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role_user` (`role_id`),
  CONSTRAINT `user_acess_menu_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_acess_menu`
--

LOCK TABLES `user_acess_menu` WRITE;
/*!40000 ALTER TABLE `user_acess_menu` DISABLE KEYS */;
INSERT INTO `user_acess_menu` VALUES (12,1,5),(21,2,6),(35,4,9),(45,6,10),(46,3,10),(49,1,6),(53,1,8),(54,1,12),(55,7,12);
/*!40000 ALTER TABLE `user_acess_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'disposisi'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-06-26  9:53:01
