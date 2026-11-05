-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: db_desa_cigagade
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Kabar Desa','kabar-desa','2026-10-05 02:42:33','2026-10-05 02:42:33'),(2,'Pemerintahan & Pelayanan','pemerintahan-pelayanan','2026-10-05 02:42:33','2026-10-05 02:42:33'),(3,'Pembangunan & Infrastruktur','pembangunan-infrastruktur','2026-10-05 02:42:33','2026-10-05 02:42:33'),(4,'Sosial & Kemasyarakatan','sosial-kemasyarakatan','2026-10-05 02:42:33','2026-10-05 02:42:33'),(5,'Ekonomi & UMKM','ekonomi-umkm','2026-10-05 02:42:33','2026-10-05 02:42:33'),(6,'Pertanian & Ketahanan Pangan','pertanian-ketahanan-pangan','2026-10-05 02:42:33','2026-10-05 02:42:33'),(7,'Prestasi','prestasi','2026-10-05 02:42:33','2026-10-05 02:42:33'),(8,'Pengumuman','pengumuman','2026-10-05 02:42:33','2026-10-05 02:42:33'),(9,'Karang Taruna','kegiatan-ukm','2026-10-05 02:42:33','2026-10-05 02:42:33'),(10,'TP-PKK Desa','prestasi-ukm','2026-10-05 02:42:33','2026-10-05 02:42:33'),(11,'BPD & LPMD','kegiatan-himpunan','2026-10-05 02:42:33','2026-10-05 02:42:33'),(12,'Kelompok Tani & Linmas','prestasi-himpunan','2026-10-05 02:42:33','2026-10-05 02:42:33'),(13,'Pertanian & Irigasi','karir-pengembangan-diri','2026-10-05 02:42:33','2026-10-05 02:42:33'),(14,'Inovasi & BUMDes','riset-inovasi','2026-10-05 02:42:33','2026-10-05 02:42:33'),(15,'Seni, Budaya & Wisata','hiburan','2026-10-05 02:42:33','2026-10-05 02:42:33'),(16,'Layanan & Kesehatan Warga','institusional','2026-10-05 02:42:33','2026-10-05 02:42:33'),(17,'Pendidikan & Sekolah','pendidikan-sekolah','2026-11-05 13:00:00','2026-11-05 13:00:00');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` VALUES (1,'Gotong Royong Normalisasi Saluran Irigasi Sungai Cipancar','gallery/galeri-irigasi.jpg','2026-10-05 04:35:38','2026-10-05 08:06:14'),(2,'Panen Raya Padi Organik Kelompok Tani Desa Cigagade','gallery/galeri-panen.jpg','2026-10-05 04:35:38','2026-10-05 08:06:14'),(3,'Pelayanan Administrasi Kependudukan Terpadu di Kantor Desa','gallery/galeri-pelayanan.jpg','2026-10-05 04:35:38','2026-10-05 08:06:14'),(4,'Kegiatan Pembinaan Posyandu dan Pemeriksaan Balita Sehat','gallery/galeri-posyandu.jpg','2026-10-05 04:35:38','2026-10-05 08:06:14'),(5,'Gelar Produk Kerajinan dan Olahan Pangan BUMDes Gagade Mandiri','gallery/galeri-bumdes.jpg','2026-10-05 04:35:38','2026-10-05 08:06:14'),(6,'Musyawarah Perencanaan Pembangunan Desa (Musrenbangdes) Cigagade','gallery-images/musyawarah-perencanaan-pembangunan-desa-musrenbangdes-cigagade-1792985198.png','2026-10-05 10:16:54','2026-10-26 03:26:38'),(7,'Semarak Turnamen Sepak Bola Kemerdekaan Antar-Kedusunan','gallery/galeri-sepakbola.jpg','2026-10-05 10:16:54','2026-10-05 10:16:54'),(8,'Ziarah Budaya & Pelestarian Situs Makam Keramat Sunan Cibalampu','gallery/galeri-wisata-religi.jpg','2026-10-05 10:16:54','2026-10-05 10:16:54'),(9,'Aksi Resik Desa & Gotong Royong Penataan Saluran Pemukiman','gallery/galeri-kerja-bakti.jpg','2026-10-05 10:16:54','2026-10-05 10:16:54'),(10,'Penyaluran Bantuan Langsung Tunai (BLT) Dana Desa Bagi Warga Rentan','gallery/galeri-blt.jpg','2026-10-05 10:16:54','2026-10-05 10:16:54'),(11,'Penerimaan Piagam Apresiasi Desa Berdaya Tingkat Kabupaten Garut','gallery/galeri-penghargaan.jpg','2026-10-05 10:16:54','2026-10-05 10:16:54'),(12,'Sosialisasi Sadar Pajak PBB dan Peningkatan PADes Cigagade','gallery/galeri-pajak.jpg','2026-10-05 10:16:54','2026-10-05 10:16:54');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hero_slides`
--

DROP TABLE IF EXISTS `hero_slides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hero_slides` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL DEFAULT 'post',
  `post_id` bigint(20) unsigned DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hero_slides`
--

LOCK TABLES `hero_slides` WRITE;
/*!40000 ALTER TABLE `hero_slides` DISABLE KEYS */;
INSERT INTO `hero_slides` VALUES (1,'image',NULL,NULL,'Selamat Datang di Portal Resmi Desa Cigagade','post-images/panen_padi_sawah_1791185600507.jpg',1,1,'2026-10-05 02:42:33','2026-10-05 07:37:54'),(2,'image',NULL,NULL,'Transparansi Pelayanan dan Pembangunan Desa Berkelanjutan','post-images/pelayanan_surat_desa_1791185676779.jpg',1,2,'2026-10-05 02:42:33','2026-10-05 07:37:54'),(3,'image',NULL,NULL,'Gotong Royong Membangun Pertanian dan UMKM Cigagade','post-images/kerja_bakti_desa_1791185759696.jpg',1,3,'2026-10-05 02:42:33','2026-10-05 07:37:54');
/*!40000 ALTER TABLE `hero_slides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `infografis`
--

DROP TABLE IF EXISTS `infografis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `infografis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL DEFAULT 'summary',
  `key` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `value_alt` text DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT 'emerald',
  `order_index` int(11) NOT NULL DEFAULT 0,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `infografis_category_index` (`category`),
  KEY `infografis_key_index` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `infografis`
--

LOCK TABLES `infografis` WRITE;
/*!40000 ALTER TABLE `infografis` DISABLE KEYS */;
INSERT INTO `infografis` VALUES (1,'penduduk','summary','total_penduduk','TOTAL PENDUDUK','1048',NULL,'Jiwa','fas fa-users','emerald',1,NULL,'2026-10-05 07:10:29','2026-10-05 07:22:19'),(2,'penduduk','summary','total_kk','KEPALA KELUARGA','307',NULL,'Jiwa','fas fa-house-user','blue',2,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(3,'penduduk','summary','perempuan','PEREMPUAN','520',NULL,'Jiwa','fas fa-person-dress','pink',3,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(4,'penduduk','summary','laki_laki','LAKI-LAKI','528',NULL,'Jiwa','fas fa-person','teal',4,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(5,'penduduk','piramida','age_0_4','0-4','13','19','Jiwa',NULL,'teal',1,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(6,'penduduk','piramida','age_5_9','5-9','62','55','Jiwa',NULL,'teal',2,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(7,'penduduk','piramida','age_10_14','10-14','59','56','Jiwa',NULL,'teal',3,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(8,'penduduk','piramida','age_15_19','15-19','40','51','Jiwa',NULL,'teal',4,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(9,'penduduk','piramida','age_20_24','20-24','47','46','Jiwa',NULL,'teal',5,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(10,'penduduk','piramida','age_25_29','25-29','63','47','Jiwa',NULL,'teal',6,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(11,'penduduk','piramida','age_30_34','30-34','43','40','Jiwa',NULL,'teal',7,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(12,'penduduk','piramida','age_35_39','35-39','42','36','Jiwa',NULL,'teal',8,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(13,'penduduk','piramida','age_40_44','40-44','30','30','Jiwa',NULL,'teal',9,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(14,'penduduk','piramida','age_45_49','45-49','25','29','Jiwa',NULL,'teal',10,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(15,'penduduk','piramida','age_50_54','50-54','28','24','Jiwa',NULL,'teal',11,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(16,'penduduk','piramida','age_55_59','55-59','23','30','Jiwa',NULL,'teal',12,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(17,'penduduk','piramida','age_60_64','60-64','16','12','Jiwa',NULL,'teal',13,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(18,'penduduk','piramida','age_65_69','65-69','13','19','Jiwa',NULL,'teal',14,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(19,'penduduk','piramida','age_70_74','70-74','7','7','Jiwa',NULL,'teal',15,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(20,'penduduk','piramida','age_75_79','75-79','8','8','Jiwa',NULL,'teal',16,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(21,'penduduk','piramida','age_80_84','80-84','3','7','Jiwa',NULL,'teal',17,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(22,'penduduk','piramida','age_85_plus','85+','6','4','Jiwa',NULL,'teal',18,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(23,'penduduk','pendidikan','pendidikan_1','Belum / Tidak Sekolah','142',NULL,'Jiwa',NULL,'emerald',1,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(24,'penduduk','pendidikan','pendidikan_2','Tamat SD / Sederajat','388',NULL,'Jiwa',NULL,'emerald',2,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(25,'penduduk','pendidikan','pendidikan_3','Tamat SMP / Sederajat','245',NULL,'Jiwa',NULL,'emerald',3,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(26,'penduduk','pendidikan','pendidikan_4','Tamat SMA / SMK','215',NULL,'Jiwa',NULL,'emerald',4,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(27,'penduduk','pendidikan','pendidikan_5','Diploma / Sarjana (D3/S1/S2)','58',NULL,'Jiwa',NULL,'emerald',5,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(28,'penduduk','pekerjaan','pekerjaan_1','Petani / Perkebunan','380',NULL,'Jiwa',NULL,'emerald',1,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(29,'penduduk','pekerjaan','pekerjaan_2','Wiraswasta / Pedagang','195',NULL,'Jiwa',NULL,'emerald',2,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(30,'penduduk','pekerjaan','pekerjaan_3','Buruh Harian / Tani','160',NULL,'Jiwa',NULL,'emerald',3,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(31,'penduduk','pekerjaan','pekerjaan_4','Karyawan Swasta','112',NULL,'Jiwa',NULL,'emerald',4,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(32,'penduduk','pekerjaan','pekerjaan_5','PNS / TNI / POLRI','18',NULL,'Jiwa',NULL,'emerald',5,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(33,'penduduk','pekerjaan','pekerjaan_6','Ibu Rumah Tangga','105',NULL,'Jiwa',NULL,'emerald',6,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(34,'penduduk','pekerjaan','pekerjaan_7','Pelajar / Mahasiswa','78',NULL,'Jiwa',NULL,'emerald',7,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(35,'penduduk','dusun','dusun_1','Dusun I Cigagade (RW 01, RW 02)','365','108 KK','Jiwa',NULL,'emerald',1,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(36,'penduduk','dusun','dusun_2','Dusun II Cigagade (RW 03, RW 04)','355','102 KK','Jiwa',NULL,'emerald',2,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(37,'penduduk','dusun','dusun_3','Dusun III Cigagade (RW 05, RW 06)','328','97 KK','Jiwa',NULL,'emerald',3,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(38,'apbdes','summary','apbdes_tahun','TAHUN ANGGARAN','2024 / 2025',NULL,'','fas fa-calendar','blue',1,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(39,'apbdes','summary','apbdes_pendapatan','PENDAPATAN DESA','1845620000',NULL,'Rp','fas fa-hand-holding-dollar','emerald',2,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(40,'apbdes','summary','apbdes_belanja','BELANJA DESA','1812350000',NULL,'Rp','fas fa-money-bill-transfer','rose',3,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(41,'apbdes','summary','apbdes_pembiayaan','PEMBIAYAAN NETTO','35000000',NULL,'Rp','fas fa-vault','amber',4,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(42,'apbdes','rincian','belanja_1','Bidang Pelaksanaan Pembangunan Desa','785450000','43.3%','Rp',NULL,'emerald',1,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(43,'apbdes','rincian','belanja_2','Bidang Penyelenggaraan Pemerintahan Desa','540200000','29.8%','Rp',NULL,'emerald',2,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(44,'apbdes','rincian','belanja_3','Bidang Pemberdayaan Masyarakat','240900000','13.3%','Rp',NULL,'emerald',3,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(45,'apbdes','rincian','belanja_4','Bidang Pembinaan Kemasyarakatan','145800000','8.1%','Rp',NULL,'emerald',4,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(46,'apbdes','rincian','belanja_5','Bidang Penanggulangan Bencana & Darurat','100000000','5.5%','Rp',NULL,'emerald',5,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(47,'stunting','summary','total_balita','TOTAL BALITA DITIMBANG','94',NULL,'Balita','fas fa-baby','blue',1,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(48,'stunting','summary','balita_normal','BALITA GIZI BAIK / NORMAL','88',NULL,'Balita','fas fa-heart-pulse','emerald',2,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(49,'stunting','summary','berisiko_stunting','BERISIKO STUNTING','6',NULL,'Balita','fas fa-triangle-exclamation','amber',3,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(50,'stunting','summary','penerima_pmt','PENERIMA PMT RUTIN','6',NULL,'Balita','fas fa-bowl-food','teal',4,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(51,'stunting','rincian','posyandu_1','Posyandu Mawar 1 (Dusun I)','26','1 Balita Perlu Perhatian PMT','Balita Terdata',NULL,'emerald',1,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(52,'stunting','rincian','posyandu_2','Posyandu Melati 2 (Dusun II)','24','2 Balita Perlu Perhatian PMT','Balita Terdata',NULL,'emerald',2,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(53,'stunting','rincian','posyandu_3','Posyandu Anggrek 3 (Dusun III)','22','2 Balita Perlu Perhatian PMT','Balita Terdata',NULL,'emerald',3,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(54,'stunting','rincian','posyandu_4','Posyandu Cempaka 4 (Dusun III)','22','1 Balita Perlu Perhatian PMT','Balita Terdata',NULL,'emerald',4,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(55,'bansos','summary','total_kpm','TOTAL KPM TERIMA BANSOS','382',NULL,'KPM','fas fa-hand-holding-heart','indigo',1,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(56,'bansos','summary','pkh','PROGRAM KELUARGA HARAPAN (PKH)','112',NULL,'KPM','fas fa-people-roof','blue',2,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(57,'bansos','summary','bpnt','BPNT / SEMBAKO','146',NULL,'KPM','fas fa-basket-shopping','emerald',3,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(58,'bansos','summary','blt_dd','BLT DANA DESA','48',NULL,'KPM','fas fa-money-check-dollar','amber',4,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(59,'bansos','summary','beras_cpp','CADANGAN PANGAN (CPP)','275',NULL,'KPM','fas fa-wheat-awn','teal',5,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(60,'idm','summary','skor_idm','SKOR IDM DESA','0.7682',NULL,'','fas fa-award','emerald',1,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(61,'idm','summary','status_idm','STATUS KEMAJUAN DESA','DESA MAJU',NULL,'','fas fa-crown','amber',2,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(62,'idm','summary','target_idm','TARGET TAHUN BERIKUTNYA','DESA MANDIRI',NULL,'','fas fa-flag-checkered','blue',3,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(63,'idm','summary','iks','INDEKS KETAHANAN SOSIAL (IKS)','0.8120',NULL,'Poin','fas fa-user-shield','teal',4,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(64,'idm','summary','ike','INDEKS KETAHANAN EKONOMI (IKE)','0.7150',NULL,'Poin','fas fa-chart-line','indigo',5,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(65,'idm','summary','ikl','INDEKS KETAHANAN LINGKUNGAN (IKL)','0.7775',NULL,'Poin','fas fa-leaf','emerald',6,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(66,'sdgs','summary','skor_sdgs_total','SKOR SDGs DESA CIGAGADE','66.85',NULL,'/ 100','fas fa-trophy','emerald',1,NULL,'2026-10-05 07:10:29','2026-10-05 07:10:29'),(67,'sdgs','tujuan','sdgs_goal_1','1. Desa Tanpa Kemiskinan','68.4',NULL,'/ 100',NULL,'rose',1,'{\"goal_number\":1}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(68,'sdgs','tujuan','sdgs_goal_2','2. Desa Tanpa Kelaparan','72.5',NULL,'/ 100',NULL,'amber',2,'{\"goal_number\":2}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(69,'sdgs','tujuan','sdgs_goal_3','3. Desa Sehat dan Sejahtera','82.1',NULL,'/ 100',NULL,'emerald',3,'{\"goal_number\":3}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(70,'sdgs','tujuan','sdgs_goal_4','4. Pendidikan Desa Berkualitas','74.0',NULL,'/ 100',NULL,'red',4,'{\"goal_number\":4}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(71,'sdgs','tujuan','sdgs_goal_5','5. Keterlibatan Perempuan Desa','70.2',NULL,'/ 100',NULL,'orange',5,'{\"goal_number\":5}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(72,'sdgs','tujuan','sdgs_goal_6','6. Desa Layak Air Bersih dan Sanitasi','85.6',NULL,'/ 100',NULL,'cyan',6,'{\"goal_number\":6}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(73,'sdgs','tujuan','sdgs_goal_7','7. Desa Berenergi Bersih dan Terbarukan','58.0',NULL,'/ 100',NULL,'yellow',7,'{\"goal_number\":7}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(74,'sdgs','tujuan','sdgs_goal_8','8. Pertumbuhan Ekonomi Desa Merata','64.5',NULL,'/ 100',NULL,'red',8,'{\"goal_number\":8}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(75,'sdgs','tujuan','sdgs_goal_9','9. Infrastruktur dan Inovasi Desa Sesuai Kebutuhan','71.3',NULL,'/ 100',NULL,'orange',9,'{\"goal_number\":9}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(76,'sdgs','tujuan','sdgs_goal_10','10. Desa Tanpa Kesenjangan','66.0',NULL,'/ 100',NULL,'pink',10,'{\"goal_number\":10}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(77,'sdgs','tujuan','sdgs_goal_11','11. Kawasan Pemukiman Desa Aman dan Nyaman','75.8',NULL,'/ 100',NULL,'amber',11,'{\"goal_number\":11}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(78,'sdgs','tujuan','sdgs_goal_12','12. Konsumsi dan Produksi Desa Sadar Lingkungan','62.4',NULL,'/ 100',NULL,'green',12,'{\"goal_number\":12}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(79,'sdgs','tujuan','sdgs_goal_13','13. Tanggap Perubahan Iklim','56.0',NULL,'/ 100',NULL,'emerald',13,'{\"goal_number\":13}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(80,'sdgs','tujuan','sdgs_goal_14','14. Peduli Lingkungan Laut','0.0',NULL,'/ 100',NULL,'blue',14,'{\"goal_number\":14}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(81,'sdgs','tujuan','sdgs_goal_15','15. Peduli Lingkungan Darat','70.5',NULL,'/ 100',NULL,'lime',15,'{\"goal_number\":15}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(82,'sdgs','tujuan','sdgs_goal_16','16. Desa Damai Berkeadilan','80.0',NULL,'/ 100',NULL,'sky',16,'{\"goal_number\":16}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(83,'sdgs','tujuan','sdgs_goal_17','17. Kemitraan untuk Pembangunan Desa','73.2',NULL,'/ 100',NULL,'indigo',17,'{\"goal_number\":17}','2026-10-05 07:10:29','2026-10-05 07:10:29'),(84,'sdgs','tujuan','sdgs_goal_18','18. Kelembagaan Desa Dinamis & Budaya Adaptif','84.0',NULL,'/ 100',NULL,'teal',18,'{\"goal_number\":18}','2026-10-05 07:10:29','2026-10-05 07:10:29');
/*!40000 ALTER TABLE `infografis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instagram_reels`
--

DROP TABLE IF EXISTS `instagram_reels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instagram_reels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `instagram_url` varchar(255) NOT NULL,
  `reel_id` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instagram_reels`
--

LOCK TABLES `instagram_reels` WRITE;
/*!40000 ALTER TABLE `instagram_reels` DISABLE KEYS */;
/*!40000 ALTER TABLE `instagram_reels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `landscape_banners`
--

DROP TABLE IF EXISTS `landscape_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `landscape_banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `target` varchar(255) NOT NULL DEFAULT '_self',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `landscape_banners`
--

LOCK TABLES `landscape_banners` WRITE;
/*!40000 ALTER TABLE `landscape_banners` DISABLE KEYS */;
INSERT INTO `landscape_banners` VALUES (1,'Dukung UMKM Desa: Jelajahi Aneka Camilan & Kerajinan Tangan Khas Cigagade','landscape-banners/banner-umkm-bumdes.jpg','/umkm','_self',1,1,'2026-10-05 10:49:26','2026-10-05 10:50:53'),(2,'Destinasi Wisata Sejarah & Religi Makam Keramat Sunan Cibalampu Cigagade','landscape-banners/banner-wisata-cibalampu.jpg','/berita','_self',1,2,'2026-10-05 10:49:26','2026-10-05 10:49:26'),(3,'Pelayanan Publik & Administrasi Kependudukan Warga Cepat dan Ramah di Balai Desa','landscape-banners/banner-layanan-desa.jpg','/infografis','_self',1,3,'2026-10-05 10:49:26','2026-10-05 10:49:26');
/*!40000 ALTER TABLE `landscape_banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('image','social') NOT NULL DEFAULT 'image',
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `platform` enum('instagram','tiktok','youtube','other') DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_10_24_072331_add_role_to_users_table',1),(5,'2025_10_24_072638_create_categories_table',1),(6,'2025_10_24_072648_create_posts_table',1),(7,'2025_10_24_153018_create_settings_table',1),(8,'2025_10_24_153922_create_ministries_table',1),(9,'2025_10_24_154347_create_partners_table',1),(10,'2025_10_24_154733_create_galleries_table',1),(11,'2026_07_28_154807_create_hero_slides_table',1),(12,'2026_07_28_225833_add_published_at_to_posts_table',1),(13,'2026_07_29_231134_create_media_table',1),(14,'2026_07_29_231149_create_videos_table',1),(15,'2026_08_02_231258_add_views_to_posts_table',1),(16,'2026_08_03_002156_add_english_fields_to_posts_table',1),(17,'2026_08_03_215441_create_instagram_reels_table',1),(18,'2026_10_05_100000_create_visitor_logs_table',2),(19,'2026_10_05_120000_create_umkms_table',3),(20,'2026_10_05_140000_create_infografis_table',4),(21,'2026_10_05_160000_create_running_texts_table',5),(22,'2026_10_05_174438_create_landscape_banners_table',6),(23,'2026_10_26_100000_add_rw_to_users_and_posts_tables',7),(24,'2026_10_28_090000_create_surat_requests_table',8),(25,'2026_10_28_100000_create_pengaduans_table',9),(26,'2026_11_01_120000_add_status_and_validation_to_posts_table',10),(27,'2026_11_05_100000_update_pengaduans_is_public_default_to_false',11),(28,'2026_11_05_120000_clean_empty_content_en_in_posts',12),(29,'2026_11_05_130000_add_pendidikan_dan_sekolah_category',13);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ministries`
--

DROP TABLE IF EXISTS `ministries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ministries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ministries`
--

LOCK TABLES `ministries` WRITE;
/*!40000 ALTER TABLE `ministries` DISABLE KEYS */;
INSERT INTO `ministries` VALUES (1,'Devi Fahruroji - Kepala Desa Cigagade','Memimpin penyelenggaraan pemerintahan desa, pembinaan kemasyarakatan, pembangunan, dan pemberdayaan warga Desa Cigagade.','ministry-images/kades-devi-fahruroji.jpg','2026-10-05 02:42:33','2026-10-05 08:06:14'),(2,'Sekretaris Desa (Sekdes)','Membantu Kepala Desa dalam bidang administrasi pemerintahan, ketatausahaan, keuangan, dan penyusunan kebijakan peraturan desa.','ministry-images/sekdes.jpg','2026-10-05 02:42:33','2026-10-05 08:06:14'),(3,'Kaur Keuangan & Pendapatan','Mengelola ketatausahaan keuangan desa, penatausahaan APBDes, dan pelaporan pertanggungjawaban realisasi anggaran.','ministry-images/kaur-keuangan.jpg','2026-10-05 02:42:33','2026-10-05 08:06:14'),(4,'Kaur Tata Usaha & Umum','Membantu urusan ketatausahaan, korespondensi dinas, pengarsipan, inventaris kekayaan desa, serta pelayanan administrasi umum.','ministry-images/kaur-tu.jpg','2026-10-05 02:42:33','2026-10-05 08:06:14'),(5,'Kasi Pelayanan & Kesejahteraan','Melaksanakan penyuluhan dan motivasi terhadap hak dan kewajiban masyarakat, pelayanan sosial, posyandu, dan keagamaan.','ministry-images/kasi-pelayanan.jpg','2026-10-05 02:42:33','2026-10-05 08:06:14'),(6,'Kasi Pemerintahan & Keamanan','Menyusun rancangan regulasi desa, pembinaan ketenteraman dan ketertiban masyarakat, serta kependudukan.','ministry-images/kasi-pemerintahan.png','2026-10-05 02:42:33','2026-10-05 08:06:14');
/*!40000 ALTER TABLE `ministries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partners`
--

LOCK TABLES `partners` WRITE;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` VALUES (1,'Pemerintah Kabupaten Garut','logos/default-partner.png','kerjasama','2026-10-05 02:42:33','2026-10-05 02:42:33'),(2,'Kantor Kecamatan Balubur Limbangan','logos/default-partner.png','kerjasama','2026-10-05 02:42:33','2026-10-05 02:42:33'),(3,'UPT Puskesmas Balubur Limbangan','logos/default-partner.png','kerjasama','2026-10-05 02:42:33','2026-10-05 02:42:33'),(4,'Polsek & Koramil Balubur Limbangan','logos/default-partner.png','kerjasama','2026-10-05 02:42:33','2026-10-05 02:42:33'),(5,'BUMDes Gagade Mandiri','logos/default-partner.png','media_partner','2026-10-05 02:42:33','2026-10-05 02:42:33'),(6,'Bank BJB Garut / Unit Limbangan','logos/default-partner.png','media_partner','2026-10-05 02:42:33','2026-10-05 02:42:33'),(7,'Gapoktan Sari Tani Cigagade','logos/default-partner.png','media_partner','2026-10-05 02:42:33','2026-10-05 02:42:33');
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengaduans`
--

DROP TABLE IF EXISTS `pengaduans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengaduans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_tiket` varchar(255) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `is_anonim` tinyint(1) NOT NULL DEFAULT 0,
  `kontak` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) NOT NULL DEFAULT 'Lainnya',
  `judul` varchar(255) NOT NULL,
  `isi_pengaduan` text NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `status` enum('menunggu','diproses','selesai','ditolak') NOT NULL DEFAULT 'menunggu',
  `tanggapan` text DEFAULT NULL,
  `tanggapan_at` timestamp NULL DEFAULT NULL,
  `tanggapan_oleh` varchar(255) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengaduans_kode_tiket_unique` (`kode_tiket`),
  KEY `pengaduans_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaduans`
--

LOCK TABLES `pengaduans` WRITE;
/*!40000 ALTER TABLE `pengaduans` DISABLE KEYS */;
INSERT INTO `pengaduans` VALUES (1,'PGD-20261025-A101','Ahmad Hidayat',0,'081234567890','Infrastruktur & Jalan','Lampu Penerangan Jalan Mati di Dekat Jembatan RW 03','Mohon bantuan dari pihak Pemdes Cigagade untuk mengecek lampu jalan PJU di tikungan dekat jembatan RW 03 yang sudah mati sejak seminggu lalu. Kondisi jalan cukup gelap saat malam hari dan rawan bagi pengendara motor.','Jalan Dusun 2, Dekat Jembatan RW 03',NULL,'selesai','Terima kasih atas laporannya Pak Ahmad. Tim teknis Pemdes Cigagade bersama pengurus RW 03 telah mengganti bohlam PJU dan sambungan kabel yang putus pada tanggal 26 Oktober 2026. Lampu saat ini sudah berfungsi normal kembali.','2026-10-26 02:50:48','Kepala Seksi Pelayanan & Kesra',1,NULL,'2026-10-25 02:50:48','2026-10-28 02:50:48'),(2,'PGD-20261026-B204',NULL,1,NULL,'Kebersihan & Lingkungan','Tumpukan Sampah Liar di Pinggir Selokan Perbatasan RW 05','Ada oknum yang membuang sampah rumah tangga dalam kantong plastik di pinggir selokan irigasi RT 02 RW 05. Mengingat musim hujan sudah mulai datang, dikhawatirkan menyumbat aliran air dan menyebabkan genangan.','Pinggir Saluran Irigasi RT 02 / RW 05',NULL,'diproses','Laporan telah kami terima dan dikoordinasikan dengan Ketua RW 05. Jadwal kerja bakti pembersihan selokan akan diadakan bersama warga setempat pada hari Minggu besok, serta akan dipasang plang larangan buang sampah.','2026-10-27 02:50:48','Pemerintah Desa Cigagade',1,NULL,'2026-10-26 02:50:48','2026-10-28 02:50:48'),(3,'PGD-20261027-C309','Ibu Nenden Kurniasih',0,'082198765432','Pelayanan Desa','Apresiasi dan Usulan Jam Layanan Tambahan di Kantor Desa','Pelayanan pembuatan surat di kantor desa sangat ramah dan cepat, apalagi sekarang sudah ada layanan surat online KKN. Kalau bisa diusulkan agar hari Sabtu tetap dibuka piket pelayanan setengah hari untuk warga yang bekerja di luar kota saat hari kerja biasa. Nuhun.','Kantor Pelayanan Desa Cigagade',NULL,'selesai','Hatur nuhun Ibu Nenden atas apresiasi dan masukannya. Usulan layanan piket akhir pekan sedang dikaji bersama BPD agar warga Cigagade yang beraktivitas di luar kota tetap terlayani dengan optimal.','2026-10-27 16:50:48','Sekretaris Desa Cigagade',1,NULL,'2026-10-27 02:50:48','2026-10-28 02:50:48'),(4,'PGD-20261028-D412','Dadan Ramdani',0,'085712344321','Infrastruktur & Jalan','Jalan Berlubang di Dekat Lapangan Voli RW 01','Ada lubang aspal yang cukup dalam di dekat lapangan voli RW 01 arah Dusun 1. Bila malam hari dan hujan sering tergenang air sehingga tidak terlihat pengendara motor. Mohon dapat ditambal sementara dengan sirtu atau semen.','Akses Jalan Lapangan RW 01',NULL,'menunggu',NULL,NULL,NULL,0,NULL,'2026-10-28 00:50:48','2026-10-28 02:50:48');
/*!40000 ALTER TABLE `pengaduans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `rw` tinyint(3) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `slug_en` varchar(255) DEFAULT NULL,
  `excerpt` text NOT NULL,
  `excerpt_en` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `content_en` longtext DEFAULT NULL,
  `views` bigint(20) unsigned NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('published','pending','rejected') NOT NULL DEFAULT 'published',
  `rejection_note` text DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `validated_by` bigint(20) unsigned DEFAULT NULL,
  `validated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  UNIQUE KEY `posts_slug_en_unique` (`slug_en`),
  KEY `posts_user_id_foreign` (`user_id`),
  KEY `posts_category_id_foreign` (`category_id`),
  KEY `posts_rw_index` (`rw`),
  KEY `posts_validated_by_foreign` (`validated_by`),
  KEY `posts_status_index` (`status`),
  CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `posts_validated_by_foreign` FOREIGN KEY (`validated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,1,NULL,'Musrenbangdes Cigagade: Tetapkan Skala Prioritas Infrastruktur Jalan Usaha Tani dan Saluran Irigasi','Cigagade Village Musrenbang: Setting Priorities for Agricultural Road and Irrigation Infrastructure','musrenbangdes-cigagade-infrastruktur-irigasi','cigagade-village-musrenbang-infrastructure','Pemerintah Desa Cigagade bersama BPD dan tokoh masyarakat menggelar Musyawarah Perencanaan Pembangunan Desa guna mematangkan usulan pembangunan tahun anggaran mendatang.','Cigagade Village Government together with BPD and community leaders held a Village Development Planning Meeting to finalize development proposals for the upcoming fiscal year.','<p>Pemerintah Desa Cigagade, Kecamatan Balubur Limbangan, Kabupaten Garut, sukses menyelenggarakan Musyawarah Perencanaan Pembangunan Desa (Musrenbangdes) yang dihadiri oleh Kepala Desa, jajaran BPD, LPMD, Ketua RT/RW, tokoh agama, tokoh pemuda Karang Taruna, serta pendamping desa.</p><p>Fokus utama usulan pembangunan mencakup pengerasan jalan usaha tani, normalisasi saluran irigasi dari aliran Sungai Cipancar, serta penguatan pos pelayanan terpadu (Posyandu) demi menunjang kenyamanan dan produktivitas warga.</p>','<p>The Cigagade Village Government successfully held the Village Development Planning Meeting (Musrenbangdes) attended by the Village Head, Village Consultative Body (BPD), and community representatives.</p><p>Key priorities include farm road improvements, Cipancar river irrigation maintenance, and community healthcare facilities.</p>',8,'post-images/musrenbang_desa_cigagade_1791185531630.jpg','published',NULL,'2026-10-01 02:42:33','2026-10-05 02:42:33','2026-10-26 00:58:07',NULL,NULL),(2,1,2,NULL,'Penyaluran Bantuan Langsung Tunai Dana Desa (BLT-DD) Berjalan Tertib dan Transparan di Aula Desa','Distribution of Direct Cash Assistance (BLT-DD) Conducted Orderly and Transparently at the Village Hall','penyaluran-blt-dana-desa-cigagade','distribution-of-direct-cash-assistance-cigagade','Sebanyak puluhan Keluarga Penerima Manfaat (KPM) di Desa Cigagade menerima penyaluran BLT-DD dengan pendampingan aparat desa dan Babinsa.','Dozens of Beneficiary Families in Cigagade Village received village fund cash assistance accompanied by village officials and local security officers.','<p>Pemerintah Desa Cigagade menyalurkan Bantuan Langsung Tunai Dana Desa (BLT-DD) kepada Keluarga Penerima Manfaat (KPM) bertempat di Aula Kantor Desa Cigagade. Penyaluran ini merupakan wujud nyata kepedulian pemerintah dalam menjaga ketahanan ekonomi warga pra-sejahtera.</p><p>Kepala Desa menegaskan bahwa seluruh proses seleksi penerima manfaat dilakukan melalui musyawarah desa khusus (Musdessus) sehingga dipastikan tepat sasaran dan transparan.</p>','<p>Cigagade Village Government disbursed Direct Cash Assistance from the Village Fund (BLT-DD) to eligible beneficiary families in the village hall with full transparency and verified criteria.</p>',2,'post-images/penyaluran_blt_desa_1791185559676.jpg','published',NULL,'2026-09-16 02:42:33','2026-10-05 02:42:33','2026-10-28 07:27:27',NULL,NULL),(3,1,6,NULL,'Sinergi Petani Cigagade: Normalisasi Saluran Irigasi Cipancar Sambut Musim Tanam Rendeng','Synergy of Cigagade Farmers: Normalizing Cipancar Irrigation in Preparation for Planting Season','normalisasi-irigasi-cipancar-petani-cigagade','normalizing-cipancar-irrigation-cigagade-farmers','Puluhan petani bersama warga bergotong royong membersihkan sedimentasi di sepanjang aliran sungai Cipancar untuk menjamin pasokan air sawah.','Dozens of farmers and locals worked together to clean sedimentation along the Cipancar river stream to ensure sufficient irrigation for paddy fields.','<p>Semangat gotong royong warga Desa Cigagade tercermin kuat dalam kegiatan normalisasi saluran irigasi tersier yang memanfaatkan debit air Sungai Cipancar. Kegiatan yang dikoordinatori oleh Gabungan Kelompok Tani (Gapoktan) bersama aparatur desa ini bertujuan mengoptimalkan pengairan pada ratusan hektar lahan persawahan produktif.</p>','<p>The collaborative spirit of Cigagade residents is shown in the communal work cleaning irrigation canals sourced from the Cipancar river to support local agriculture.</p>',1,'post-images/irigasi_petani_desa_1791185578269.jpg','published',NULL,'2026-09-17 02:42:33','2026-10-05 02:42:33','2026-10-26 03:20:21',NULL,NULL),(4,1,5,NULL,'Geliat UMKM Pangan Olahan Khas Cigagade Siap Perluas Pasar Kabupaten Garut','Cigagade Culinary MSMEs Ready to Expand Market Across Garut Regency','geliat-umkm-pangan-khas-cigagade','cigagade-culinary-msmes-expansion-garut','Para pelaku usaha mikro di Desa Cigagade yang memproduksi rengginang, keripik, dan olahan hasil bumi mendapatkan pelatihan kemasan dan legalitas usaha.','Micro-business actors in Cigagade producing traditional snacks and farm-produce items received packaging and business licensing training.','<p>Desa Cigagade memiliki beragam potensi produk olahan makanan tradisional khas Sunda. Melalui kolaborasi antara BUMDes Gagade Mandiri dan Pemerintah Desa, para pelaku UMKM didorong untuk meningkatkan mutu kemasan, izin P-IRT, serta pemasaran digital agar mampu bersaing di pasar modern.</p>','<p>Cigagade Village boasts traditional culinary potential. Through village government mentoring and BUMDes collaboration, local MSMEs are upgraded with modern packaging and digital branding.</p>',0,'post-images/olahan_pangan_desa_1791185790046.jpg','published',NULL,'2026-10-01 02:42:33','2026-10-05 02:42:33','2026-10-05 07:37:54',NULL,NULL),(5,1,9,NULL,'Turnamen Sepak Bola Karang Taruna Karya Muda Cigagade Gelorakan Semangat Sportivitas Generasi Muda','Karya Muda Youth Organization Football Tournament Fosters Sportsmanship in Cigagade','turnamen-sepak-bola-karang-taruna-cigagade','youth-organization-football-tournament-cigagade','Karang Taruna Desa Cigagade menggelar turnamen antar-kedusunan untuk memupuk persaudaraan dan menjaring bibit atlet muda berprestasi.','The Cigagade Youth Organization held an inter-hamlet football tournament to foster brotherhood and discover young sports talents.','<p>Pekan olahraga pemuda yang diinisiasi oleh Karang Taruna Desa Cigagade berlangsung meriah di lapangan desa. Kegiatan ini menjadi magnet hiburan positif bagi warga sekaligus mempererat silaturahmi antar-kampung di wilayah Desa Cigagade.</p>','<p>The youth sports week initiated by Karang Taruna in Cigagade Village brought together hundreds of residents in an atmosphere of healthy competition and camaraderie.</p>',0,'post-images/sepakbola_desa_1791185647940.jpg','published',NULL,'2026-09-21 02:42:33','2026-10-05 02:42:33','2026-10-05 07:37:54',NULL,NULL),(6,1,10,NULL,'TP-PKK Desa Cigagade Raih Penghargaan Pengelolaan Administrasi Posyandu Terbaik di Balubur Limbangan','Cigagade Village Family Welfare Movement (PKK) Wins Best Posyandu Administration Award','tp-pkk-cigagade-raih-penghargaan-posyandu','cigagade-pkk-wins-posyandu-award','Dedikasi kader PKK Desa Cigagade dalam pendataan gizi anak dan penimbangan balita membuahkan apresiasi tingkat kecamatan.','Dedication of Cigagade village healthcare volunteers in child nutrition tracking gained kecamatan-level appreciation.','<p>Tim Penggerak Pemberdayaan dan Kesejahteraan Keluarga (TP-PKK) Desa Cigagade menorehkan prestasi membanggakan dengan meraih predikat terbaik dalam pembinaan administrasi posyandu dan pemantauan tumbuh kembang balita se-Kecamatan Balubur Limbangan.</p>','<p>The Family Welfare Empowerment team (TP-PKK) of Cigagade Village achieved top recognition for outstanding posyandu management and child nutrition monitoring in the subdistrict.</p>',0,'post-images/posyandu_pkk_desa_1791185623334.jpg','published',NULL,'2026-09-25 02:42:33','2026-10-05 02:42:33','2026-10-05 07:37:54',NULL,NULL),(7,1,11,NULL,'BPD dan Pemerintah Desa Cigagade Tetapkan Peraturan Desa tentang Ketertiban Umum dan Lingkungan Hidup','BPD and Village Government Enact Village Regulation on Public Order and Environmental Protection','bpd-tetapkan-perdes-ketertiban-lingkungan','bpd-enacts-village-regulation-environmental-order','Rapat paripurna BPD Desa Cigagade menyepakati Perdes baru demi menciptakan lingkungan yang tertib, bersih, dan asri.','The plenary session of Cigagade Village Consultative Body agreed on a new local regulation for a clean and orderly environment.','<p>Badan Permusyawaratan Desa (BPD) bersama Kepala Desa Cigagade secara resmi mengesahkan Peraturan Desa tentang Penyelenggaraan Ketertiban Umum, Pengelolaan Sampah, serta Pelestarian Lingkungan Hidup di wilayah desa.</p>','<p>The Village Consultative Body (BPD) and Village Head of Cigagade formally ratified village regulations covering public order, waste disposal, and environmental conservation.</p>',0,'post-images/musrenbang_desa_cigagade_1791185531630.jpg','published',NULL,'2026-09-20 02:42:33','2026-10-05 02:42:33','2026-10-05 07:37:54',NULL,NULL),(8,1,12,NULL,'Kelompok Tani Desa Cigagade Catatkan Hasil Panen Padi Unggul 7,2 Ton per Hektar','Cigagade Farmers Group Achieves Superior Rice Harvest of 7.2 Tons per Hectare','panen-padi-unggul-kelompok-tani-cigagade','superior-rice-harvest-cigagade-farmers-group','Penerapan pola tanam modern dan pemupukan berimbang berhasil meningkatkan produktivitas panen padi petani Cigagade.','Modern farming methods and balanced fertilization boosted the rice productivity of Cigagade farmers.','<p>Kelompok Tani Desa Cigagade berhasil membukukan produktivitas panen padi mencapai 7,2 ton gabah kering panen per hektar pada musim tanam kali ini. Hasil ini melampaui rata-rata wilayah kecamatan dan membuktikan potensi agraris Desa Cigagade.</p>','<p>The Cigagade Village Farmers Group achieved an impressive yield of 7.2 tons per hectare, surpassing district averages and showcasing local agricultural prowess.</p>',0,'post-images/panen_padi_sawah_1791185600507.jpg','published',NULL,'2026-09-29 02:42:33','2026-10-05 02:42:33','2026-10-05 07:37:54',NULL,NULL),(9,1,13,NULL,'Panduan Pola Tanam Terpadu dan Pemupukan Organik Ramah Lingkungan untuk Petani Desa','Integrated Planting and Eco-Friendly Organic Fertilization Guide for Village Farmers','panduan-pola-tanam-organik-petani-cigagade','integrated-organic-planting-guide-cigagade','Artikel edukatif mengenai teknik pengolahan tanah sawah dan pemanfaatan kompos jerami untuk menekan biaya produksi pertanian.','Educational article on soil management and compost utilization to minimize agricultural production costs.','<p>Untuk menjaga kesuburan tanah di sepanjang daerah aliran sungai Cipancar, petani Desa Cigagade diajak menerapkan prinsip pertanian berkelanjutan dengan memadukan pupuk organik dan pengelolaan air yang terukur.</p>','<p>Sustainable agricultural practices combining organic compost and water conservation to maintain soil fertility along the Cipancar basin.</p>',0,'post-images/irigasi_petani_desa_1791185578269.jpg','published',NULL,'2026-09-29 02:42:33','2026-10-05 02:42:33','2026-10-05 07:37:54',NULL,NULL),(10,1,14,NULL,'Inovasi Digitalisasi Pelayanan Desa: Permohonan Surat Keterangan Warga Kini Lebih Cepat','Village Public Service Digitalization: Faster Online Administrative Certificate Requests','digitalisasi-pelayanan-surat-desa-cigagade','digitalization-village-certificate-services-cigagade','Pelajari kemudahan mengurus Surat Keterangan Usaha (SKU), Domisili, dan Pengantar SKCK melalui website resmi Desa Cigagade.','Learn how to easily request business certificates, residency proof, and police record letters online via Cigagade Village portal.','<p>Kini warga Desa Cigagade tidak perlu menunggu lama untuk mengurus berkas permohonan surat keterangan. Melalui sistem pelayanan digital desa, warga dapat mengajukan data secara online dan mengambil surat yang telah ditandatangani di kantor desa.</p>','<p>Residents of Cigagade Village can now enjoy seamless online certificate applications, saving time and simplifying administrative procedures.</p>',0,'post-images/pelayanan_surat_desa_1791185676779.jpg','published',NULL,'2026-10-02 02:42:33','2026-10-05 02:42:33','2026-10-05 07:37:54',NULL,NULL),(11,1,15,NULL,'Menelusuri Sejarah dan Wisata Religi Makam Kiai Gede Sunan Cibalampu di Desa Cigagade','Exploring History and Spiritual Tourism of Kiai Gede Sunan Cibalampu in Cigagade','sejarah-wisata-religi-sunan-cibalampu-cigagade','spiritual-tourism-history-sunan-cibalampu-cigagade','Kisah sejarah lokal dan pesona ziarah makam Kiai Gede di kawasan Cibalampu yang menjadi bagian penting dari warisan budaya desa.','The local historical heritage and spiritual attraction of Kiai Gede tomb in Cibalampu, an integral part of village culture.','<p>Desa Cigagade menyimpan warisan sejarah yang mendalam, salah satunya adalah situs makam sesepuh Kiai Gede di kawasan perbukitan Sunan Cibalampu yang kerap dikunjungi masyarakat untuk berziarah dan merenungi sejarah penyebaran Islam di wilayah Limbangan Garut.</p>','<p>Cigagade Village preserves a profound cultural heritage, including the tomb of Kiai Gede on Mount Sunan Cibalampu, frequently visited by pilgrims and history enthusiasts.</p>',0,'post-images/wisata_religi_cigagade_1791185703480.jpg','published',NULL,'2026-10-04 02:42:33','2026-10-05 02:42:33','2026-10-05 07:37:54',NULL,NULL),(12,1,16,NULL,'Pola Hidup Bersih dan Sehat (PHBS): Kiat Menjaga Kesehatan Keluarga di Lingkungan Perdesaan','Clean and Healthy Lifestyle (PHBS): Tips for Maintaining Family Health in Rural Communities','pola-hidup-bersih-sehat-phbs-desa-cigagade','clean-healthy-lifestyle-phbs-cigagade-village','Edukasi kesehatan mengenai air bersih, jamban sehat, pengelolaan sampah rumah tangga, serta pencegahan DBD.','Health education on clean water, household sanitation, and community disease prevention.','<p>Pemerintah Desa Cigagade bekerjasama dengan tenaga kesehatan Puskesmas Balubur Limbangan terus mengedukasi warga mengenai pentingnya sanitasi lingkungan, konsumsi air bersih, dan pembuangan sampah yang tepat demi menjaga kesehatan bersama.</p>','<p>Health education regarding clean water, household sanitation, and vector-borne disease prevention conducted collaboratively with local clinics.</p>',1,'post-images/kerja_bakti_desa_1791185759696.jpg','published',NULL,'2026-09-28 02:42:33','2026-10-05 02:42:33','2026-10-28 07:25:09',NULL,NULL),(13,1,7,NULL,'Desa Cigagade Raih Apresiasi Tertib Administrasi dan Akuntabilitas Dana Desa Terbaik se-Kecamatan','Cigagade Village Receives Best Village Fund Accountability and Administration Award','prestasi-tertib-administrasi-dana-desa-cigagade','village-fund-accountability-award-cigagade','Pemerintah Kabupaten Garut melalui pihak Kecamatan Balubur Limbangan memberikan apresiasi atas kecepatan dan kepatuhan pelaporan keuangan Desa Cigagade.','Garut Regency Government through the subdistrict recognized Cigagade Village for prompt and accurate financial reporting.','<p>Prestasi membanggakan kembali diraih Pemerintah Desa Cigagade atas dedikasi dan komitmen dalam pengelolaan Anggaran Pendapatan dan Belanja Desa (APBDes) yang transparan, akuntabel, serta tepat waktu dalam pelaporan pertanggungjawaban.</p>','<p>Cigagade Village was honored for exemplary transparency and timeliness in village budget management and public accountability.</p>',0,'post-images/penghargaan_desa_1791185730644.jpg','published',NULL,'2026-09-22 02:42:33','2026-10-05 02:42:33','2026-10-05 07:37:54',NULL,NULL),(14,1,7,NULL,'Juara 2 Posyandu Percontohan dan Inovasi Penanganan Gizi Balita Tingkat Balubur Limbangan','Second Place for Model Posyandu and Child Nutrition Innovation in Balubur Limbangan','juara-posyandu-percontohan-cigagade','model-posyandu-runner-up-cigagade','Kerja keras para kader posyandu dan bidan desa dalam menurunkan angka stunting berhasil membawa penghargaan membanggakan.','Tireless efforts by community health cadres and village midwives in stunting prevention earned a prestigious accolade.','<p>Posyandu Mawar Desa Cigagade berhasil merebut Juara 2 dalam ajang apresiasi posyandu teladan tingkat Kecamatan Balubur Limbangan berkat inovasi program pendampingan ibu hamil dan pemberian makanan tambahan berbahan pangan lokal.</p>','<p>Cigagade Village healthcare center won second place in the subdistrict model posyandu evaluation thanks to innovative nutrition programs.</p>',0,'post-images/posyandu_pkk_desa_1791185623334.jpg','published',NULL,'2026-10-01 02:42:33','2026-10-05 02:42:33','2026-10-05 07:37:54',NULL,NULL),(15,1,8,NULL,'Jadwal Pelayanan Pembuatan KTP Elektronik, Kartu Keluarga, dan Akta Kelahiran di Kantor Desa Cigagade','Schedule for Electronic ID, Family Card, and Birth Certificate Services at Cigagade Village Office','jadwal-pelayanan-ktp-kk-desa-cigagade','id-card-family-certificate-services-cigagade','Masyarakat Desa Cigagade dapat memanfaatkan jadwal pelayanan administrasi kependudukan setiap hari kerja Senin hingga Jumat pukul 08.00 - 15.00 WIB.','Cigagade residents can access civil registry and identity documentation services on weekdays from 08:00 to 15:00 WIB.','<p>Diberitahukan kepada seluruh warga Desa Cigagade bahwa pelayanan administrasi kependudukan (perekaman KTP-el, pengurusan Kartu Keluarga, Akta Kelahiran, dan Surat Pindah) dibuka setiap hari kerja di Kantor Desa Cigagade. Mohon membawa dokumen persyaratan asli dan fotokopi lengkap.</p>','<p>All residents are notified that civil documentation services are available every weekday at the Village Office. Please bring all necessary original and copied documents.</p>',0,'post-images/pelayanan_surat_desa_1791185676779.jpg','published',NULL,'2026-09-15 02:42:33','2026-10-05 02:42:33','2026-10-05 07:37:54',NULL,NULL),(16,1,8,NULL,'Pemberitahuan Pelunasan Pajak Bumi dan Bangunan Perdesaan (PBB-P2) Desa Cigagade Tahun Anggaran Berjalan','Notification on Land and Building Tax (PBB-P2) Settlement for Cigagade Village','pemberitahuan-pelunasan-pbb-desa-cigagade','land-building-tax-settlement-cigagade','Kolektor desa siap melayani pembayaran PBB-P2 warga di tiap dusun atau langsung melalui loket Kantor Desa Cigagade.','Village tax officers are ready to assist residents with land and building tax payments in each hamlet or directly at the village counter.','<p>Pemerintah Desa Cigagade menghimbau kepada seluruh Wajib Pajak untuk melakukan pembayaran Pajak Bumi dan Bangunan (PBB-P2) sebelum tanggal jatuh tempo. Pembayaran dapat dilakukan melalui petugas kolektor dusun setempat atau loket pelayanan kantor desa.</p>','<p>Cigagade Village Government urges all taxpayers to settle land and building taxes before the due date through local hamlet collectors or the village service counter.</p>',0,'post-images/pajak_desa_cigagade_1791185821220.jpg','published',NULL,'2026-09-20 02:42:33','2026-10-05 02:42:33','2026-10-05 07:37:54',NULL,NULL),(17,1,8,NULL,'Jadwal Rutin Posyandu Balita dan Posbindu Lansia Bulan Ini di Seluruh Wilayah RW Desa Cigagade','Monthly Schedule for Toddler and Elderly Health Clinics Across Cigagade Village','jadwal-rutin-posyandu-posbindu-cigagade','monthly-health-clinic-schedule-cigagade','Simak jadwal penimbangan balita, imunisasi dasar, serta pemeriksaan tensi dan gula darah gratis bagi lansia.','Check the schedule for toddler weighing, mandatory vaccinations, and free health checkups for the elderly.','<p>Pemerintah Desa Cigagade bersama Bidan Desa dan Kader PKK mengumumkan jadwal kegiatan Posyandu Balita dan Posbindu Lansia serentak di Pos RW 01 sampai dengan RW 08. Seluruh masyarakat diimbau membawa buku KIA dan KMS balita.</p>','<p>Cigagade Village announces this month schedule for mother-and-child healthcare clinics across RW 01 through RW 08.</p>',0,'post-images/posyandu_pkk_desa_1791185623334.jpg','published',NULL,'2026-09-26 02:42:33','2026-10-05 02:42:33','2026-10-05 07:37:54',NULL,NULL),(18,3,4,1,'Gotong Royong Warga RW 01 Bersihkan Drainase dan Lingkungan Jelang Musim Hujan','Community Mutual Cooperation in RW 01 Cleans Drainage and Neighborhood Ahead of Rainy Season','gotong-royong-warga-rw-01-bersihkan-drainase-dan-lingkungan-jelang-musim-hujan','community-mutual-cooperation-in-rw-01-cleans-drainage-and-neighborhood-ahead-of-rainy-season','Antusiasme warga RW 01 Desa Cigagade dalam kegiatan kerja bakti massal membersihkan saluran air dan peremajaan pos ronda lingkungan.','Enthusiasm of RW 01 Cigagade residents in a community cleanup to clear drainage and renovate neighborhood security posts.','<p>Warga masyarakat di lingkungan <strong>Rukun Warga (RW) 01 Desa Cigagade</strong> melaksanakan kegiatan kerja bakti gotong royong terpadu pada akhir pekan ini. Kegiatan difokuskan pada pembersihan saluran air (drainase) lingkungan guna mengantisipasi genangan air saat curah hujan tinggi.</p><p>Ketua RW 01 menyampaikan apresiasi setinggi-tingginya kepada seluruh warga yang telah meluangkan waktu dan tenaga. Semangat kegotongroyongan warga Cigagade terus terjaga erat demi kenyamanan dan kebersihan lingkungan bersama.</p>','<p>Residents of <strong>Neighborhood Unit (RW) 01 of Cigagade Village</strong> held an integrated community cleanup this weekend. The activity focused on clearing drainage channels to prevent waterlogging during periods of high rainfall.</p><p>The head of RW 01 expressed utmost appreciation to all residents for their enthusiastic participation.</p>',145,NULL,'published',NULL,'2026-10-24 00:39:23','2026-10-26 00:39:23','2026-10-28 07:37:22',NULL,NULL),(19,4,4,2,'Layanan Posyandu Melati RW 02: Pemeriksaan Tumbuh Kembang Balita dan Lansia Rutin','Melati Integrated Health Post (Posyandu) RW 02: Routine Toddler and Elderly Health Checks','layanan-posyandu-melati-rw-02-pemeriksaan-tumbuh-kembang-balita-dan-lansia-rutin','melati-integrated-health-post-posyandu-rw-02-routine-toddler-and-elderly-health-checks','Pelayanan kesehatan berkala di Posyandu Melati RW 02 mencatatkan kehadiran 95% balita dan pemeriksaan tensi serta nutrisi bagi warga lansia.','Regular health services at Posyandu Melati RW 02 recorded 95% attendance for toddler growth tracking and health screening for seniors.','<p>Kader Posyandu Melati <strong>RW 02 Desa Cigagade</strong> kembali menggelar kegiatan pos pelayanan terpadu bulanan. Selain penimbangan balita dan pemberian vitamin A serta makanan tambahan (PMT), posyandu juga membuka posko cek tensi darah dan konsultasi gizi untuk lansia.</p><p>Kegiatan ini terselenggara berkat kolaborasi erat antara pengurus RW 02, Bidan Desa, dan Tim Penggerak PKK Desa Cigagade.</p>','<p>Health volunteers at Posyandu Melati in <strong>RW 02 Cigagade</strong> held monthly health service day providing growth monitoring, vitamins, and senior health consultations.</p>',106,NULL,'published',NULL,'2026-10-18 00:39:23','2026-10-26 00:39:23','2026-10-26 00:39:23',NULL,NULL),(20,5,3,3,'Swadaya Warga RW 03 Selesaikan Perbaikan Jalan Gang dan Penerangan Jalan Lingkungan','Self-Help Initiative by RW 03 Residents Completes Alley Paving and Solar Street Lights','swadaya-warga-rw-03-selesaikan-perbaikan-jalan-gang-dan-penerangan-jalan-lingkungan','self-help-initiative-by-rw-03-residents-completes-alley-paving-and-solar-street-lights','Dengan gotong royong dan sumbangsih sukarela warga, jalan gang penghubung RT di RW 03 kini telah diperkeras dan dilengkapi lampu hemat energi.','Through community solidarity and voluntary contributions, interconnecting alleys in RW 03 have been paved and fitted with energy-efficient street lamps.','<p>Pengurus <strong>RW 03 Desa Cigagade</strong> bersama jajaran Ketua RT dan tokoh pemuda sukses menuntaskan program pembenahan akses gang pemukiman. Program ini murni bersumber dari swadaya warga dan gotong royong tenaga secara bergiliran.</p><p>Kini gang pemukiman warga menjadi jauh lebih ramah dan aman bagi anak-anak maupun lansia yang beraktivitas pada malam hari.</p>','<p>The board of <strong>RW 03 Cigagade</strong> together with RT leaders and youth successfully finalized neighborhood alley improvements through local collective funding.</p>',70,NULL,'published',NULL,'2026-10-20 00:39:23','2026-10-26 00:39:23','2026-10-26 00:39:23',NULL,NULL),(21,7,1,5,'Revitalisasi Pos Ronda dan Penguatan Sistem Keamanan Lingkungan (Siskamling) di RW 05','Revitalization of Neighborhood Watch Post and Siskamling Security System in RW 05','revitalisasi-pos-ronda-dan-penguatan-sistem-keamanan-lingkungan-siskamling-di-rw-05','revitalization-of-neighborhood-watch-post-and-siskamling-security-system-in-rw-05','Pengurus RW 05 meresmikan renovasi pos ronda terpadu serta jadwal ronda malam baru demi menjaga ketenteraman dan ketertiban warga.','RW 05 board inaugurated the renovated security post and refreshed night patrol schedule to maintain neighborhood peace.','<p>Menjaga keamanan dan ketenteraman lingkungan adalah tanggung jawab bersama. Bertempat di pusat wilayah <strong>RW 05 Desa Cigagade</strong>, warga meresmikan selesainya renovasi pos ronda dan pembaruan jadwal ronda malam (siskamling).</p><p>Inisiatif ini disambut hangat oleh segenap warga sebagai wujud kepedulian bersama menjaga kampung tetap aman, damai, dan kondusif.</p>','<p>Residents of <strong>RW 05 Cigagade Village</strong> celebrated the reopening of their revitalized watch post and community night patrol roster.</p>',71,NULL,'published',NULL,'2026-10-16 00:39:23','2026-10-26 00:39:23','2026-10-26 00:39:23',NULL,NULL),(23,13,10,NULL,'Pemberian Makanan Tambahan (PMT) dan Pemantauan Tumbuh Kembang Balita oleh Kader PKK Cigagade','Supplementary Feeding and Child Growth Monitoring by Cigagade PKK Cadres','pemberian-makanan-tambahan-pmt-dan-pemantauan-tumbuh-kembang-balita-oleh-kader-pkk-cigagade','supplementary-feeding-and-child-growth-monitoring-by-cigagade-pkk-cadres','Kader TP-PKK Desa Cigagade menggelar program penimbangan rutin dan demo pembuatan menu gizi seimbang lokal guna mencegah stunting anak.','Cigagade Village PKK cadres held a routine weighing program and a balanced nutrition cooking demo to prevent child stunting.','<p>Kader <strong>Tim Penggerak Pemberdayaan dan Kesejahteraan Keluarga (TP-PKK) Desa Cigagade</strong> kembali melaksanakan kegiatan rutin posyandu dan pemantauan tumbuh kembang balita. Kegiatan ini dirangkaikan dengan penyuluhan gizi seimbang serta demo pembuatan Pemberian Makanan Tambahan (PMT) berbahan pangan lokal.</p><p>Ketua TP-PKK Desa Cigagade menyampaikan bahwa peran aktif kader posyandu di setiap dusun dan RW sangat krusial dalam mendeteksi sedini mungkin potensi gangguan pertumbuhan pada balita serta mempercepat penurunan angka stunting di Desa Cigagade.</p>','<p>Cadres of the <strong>Family Welfare Movement (TP-PKK) of Cigagade Village</strong> conducted routine integrated health post (Posyandu) sessions and child growth monitoring. The event was coupled with balanced nutrition education and cooking demonstrations of supplementary feeding made from local ingredients.</p>',54,NULL,'published',NULL,'2026-10-26 03:10:08','2026-10-28 03:10:08','2026-10-28 03:10:08',NULL,NULL),(24,13,10,NULL,'Gerakan Halaman Asri Teratur Indah dan Nyaman (HATINYA PKK) untuk Ketahanan Pangan Keluarga Cigagade','HATINYA PKK Movement for Family Food Security in Cigagade Village','gerakan-halaman-asri-teratur-indah-dan-nyaman-hatinya-pkk-untuk-ketahanan-pangan-keluarga-cigagade','hatinya-pkk-movement-for-family-food-security-in-cigagade-village','Inovasi pemanfaatan pekarangan rumah dengan tanaman sayuran, obat keluarga (toga), dan budidaya mandiri oleh kelompok Dasawisma PKK Cigagade.','Innovative utilization of home yards with vegetables and medicinal herbs by Cigagade PKK Dasawisma groups.','<p>Dalam rangka memperkuat ketahanan pangan keluarga di tingkat rumah tangga, <strong>TP-PKK Desa Cigagade</strong> menggalakkan kembali gerakan <em>Halaman Asri, Teratur, Indah dan Nyaman (HATINYA PKK)</em>. Para kader dan ibu-ibu dasawisma diajak memanfaatkan pekarangan rumah masing-masing dengan tanaman pangan seperti cabai, tomat, kangkung, serta tanaman obat keluarga (TOGA).</p><p>Program ini terbukti mampu menghemat pengeluaran dapur keluarga dan mendukung pemenuhan asupan sayur segar yang sehat dan bebas pestisida kimia.</p>','<p>In order to strengthen household food security, <strong>TP-PKK of Cigagade Village</strong> revitalized the home yard gardening program, encouraging residents to plant fresh vegetables and family medicinal herbs in their home gardens.</p>',45,NULL,'published',NULL,'2026-10-23 03:10:08','2026-10-28 03:10:08','2026-10-28 03:10:08',NULL,NULL);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `running_texts`
--

DROP TABLE IF EXISTS `running_texts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `running_texts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `badge` varchar(255) NOT NULL DEFAULT 'INFO',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `running_texts`
--

LOCK TABLES `running_texts` WRITE;
/*!40000 ALTER TABLE `running_texts` DISABLE KEYS */;
INSERT INTO `running_texts` VALUES (1,'Selamat Datang di Website Resmi Pemerintah Desa Cigagade, Kecamatan Balubur Limbangan, Kabupaten Garut',NULL,'INFO',1,1,'2026-10-05 09:29:40','2026-10-05 09:29:40'),(2,'Layanan Administrasi Surat Mandiri Warga Kini Dapat Diajukan Secara Online 24 Jam','#','INFO',1,2,'2026-10-05 09:29:41','2026-10-05 09:29:41'),(3,'Transparansi Data Pembangunan: Pantau Realisasi APBDes dan SDGs Desa Cigagade','/infografis','INFO',1,3,'2026-10-05 09:29:41','2026-10-05 09:29:41'),(4,'Kunjungi Destinasi Wisata Religi Sunan Cibalampu & Keasrian Saluran Irigasi Sungai Cipancar','/berita','INFO',1,4,'2026-10-05 09:29:41','2026-10-05 09:29:41'),(5,'Dukung Kebangkitan Ekonomi Warga: Jelajahi Produk Unggulan di Katalog UMKM Desa','/umkm','INFO',1,5,'2026-10-05 09:29:41','2026-10-05 09:29:41');
/*!40000 ALTER TABLE `running_texts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'about_title','Selamat Datang di Portal Resmi Desa Cigagade','2026-10-05 02:42:33','2026-10-05 02:42:33'),(2,'about_subtitle','PROFIL PEMERINTAHAN DESA','2026-10-05 02:42:33','2026-10-05 02:42:33'),(3,'about_description','Desa Cigagade adalah sebuah desa yang asri, agamis, dan berdaya saing di Kecamatan Balubur Limbangan, Kabupaten Garut, Provinsi Jawa Barat. Terletak di kawasan subur yang dilintasi aliran Sungai Cipancar, Desa Cigagade memiliki potensi pertanian pangan yang melimpah, kerajinan dan UMKM yang kreatif, serta sejarah budaya lokal yang kaya di kawasan Sunan Cibalampu. Kami berkomitmen memberikan pelayanan publik yang ramah, transparan, dan akuntabel untuk kesejahteraan seluruh warga.','2026-10-05 02:42:33','2026-10-05 02:42:33'),(4,'visi','Terwujudnya Desa Cigagade yang Maju, Mandiri, Agamis, Berkeadilan, dan Sejahtera Berbasis Potensi Pertanian, UMKM, dan Partisipasi Aktif Masyarakat.','2026-10-05 02:42:33','2026-10-05 02:42:33'),(5,'misi','1. Menyelenggarakan tata kelola pemerintahan desa yang bersih, transparan, profesional, dan berbasis pelayanan digital untuk masyarakat.\r\n2. Meningkatkan pembangunan infrastruktur perdesaan, jalan lingkungan, saluran irigasi Sungai Cipancar, dan sarana sanitasi yang merata.\r\n3. Mengembangkan potensi ekonomi kerakyatan, penguatan BUMDes Gagade Mandiri, dan pemberdayaan pelaku UMKM lokal.\r\n4. Mendorong produktivitas sektor pertanian pangan, perkebunan rakyat, dan ketahanan pangan desa.\r\n5. Meningkatkan kualitas sumber daya manusia, pendidikan keagamaan, serta layanan posyandu dan kesehatan ibu-anak.\r\n6. Menjaga kelestarian lingkungan hidup, tradisi gotong royong, dan nilai-nilai kearifan lokal budaya Sunda.','2026-10-05 02:42:33','2026-10-05 04:30:13'),(6,'video_url','https://www.youtube.com/watch?v=ScMzIvxBSi4','2026-10-05 02:42:33','2026-10-05 02:42:33'),(7,'stat_activities',NULL,'2026-10-05 02:42:33','2026-10-05 04:30:13'),(8,'stat_members',NULL,'2026-10-05 02:42:33','2026-10-05 04:30:13'),(9,'stat_programs',NULL,'2026-10-05 02:42:33','2026-10-05 04:30:13'),(10,'stat_partners',NULL,'2026-10-05 02:42:33','2026-10-05 04:30:13'),(12,'logo_path','logos/LOGO_GARUT.png','2026-10-05 04:30:13','2026-10-05 04:35:38'),(13,'about_image','settings/about.jpg','2026-10-05 08:06:14','2026-10-05 08:06:14');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat_requests`
--

DROP TABLE IF EXISTS `surat_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surat_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tracking_code` varchar(30) NOT NULL,
  `jenis_surat` varchar(20) NOT NULL,
  `nomor_surat` varchar(100) DEFAULT NULL,
  `status` enum('pending','diproses','selesai','ditolak') NOT NULL DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `nama_kades` varchar(100) NOT NULL DEFAULT 'DEVI FAHRUROJI, S.Pd.I.',
  `jabatan_kades` varchar(100) NOT NULL DEFAULT 'Kepala Desa Cigagade',
  `nama_lengkap` varchar(150) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `no_kk` varchar(20) DEFAULT NULL,
  `no_telepon` varchar(30) NOT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(20) NOT NULL DEFAULT 'Laki-laki',
  `warga_negara` varchar(50) NOT NULL DEFAULT 'Indonesia',
  `agama` varchar(30) NOT NULL DEFAULT 'Islam',
  `status_perkawinan` varchar(50) NOT NULL DEFAULT 'Belum Kawin',
  `pekerjaan` varchar(100) NOT NULL DEFAULT 'Buruh Harian Lepas',
  `alamat` varchar(255) NOT NULL DEFAULT 'KP. Cigagade',
  `rt` varchar(10) NOT NULL DEFAULT '001',
  `rw` varchar(10) NOT NULL DEFAULT '001',
  `desa` varchar(100) NOT NULL DEFAULT 'Cigagade',
  `kecamatan` varchar(100) NOT NULL DEFAULT 'Balubur Limbangan',
  `kabupaten` varchar(100) NOT NULL DEFAULT 'Garut',
  `keperluan` text DEFAULT NULL,
  `data_spesifik` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_spesifik`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `surat_requests_tracking_code_unique` (`tracking_code`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat_requests`
--

LOCK TABLES `surat_requests` WRITE;
/*!40000 ALTER TABLE `surat_requests` DISABLE KEYS */;
INSERT INTO `surat_requests` VALUES (1,'SRT-202610-001','sku','517/ 018 /2011-DS/X/2026','selesai',NULL,'2026-10-26','DEVI FAHRUROJI, S.Pd.I.','Kepala Desa Cigagade','ASEP KURNIAWAN GANTENG','3205011211890001','3205011211890001','081234567890','Garut','1989-11-12','Laki-laki','Indonesia','Islam','Kawin','Buruh Harian Lepas','KP. Ranca Paku','001','006','Cigagade','Balubur Limbangan','Garut','Persyaratan Credit BANK','{\"nama_usaha\":\"Usaha Kuliner (Bakso Tahu & Cuangki)\",\"alamat_usaha\":\"Kp. Krajan RT 14 RW 02, Desa Sukadami, Wanayasa, Purwakarta\"}','2026-10-28 02:02:39','2026-10-28 02:33:18'),(2,'SRT-202610-002','skbb','331/ 025 /2011-DS/X/2026','selesai',NULL,'2026-10-26','DEVI FAHRUROJI, S.Pd.I.','Kepala Desa Cigagade','RIDWAN NURDIN','3205011508920002',NULL,'082123456781','Garut','1992-08-15','Laki-laki','Indonesia','Islam','Kawin','Buruh Harian Lepas','KP. Ranca Paku','001','006','Cigagade','Balubur Limbangan','Garut','Kelengkapan Credit Bank','[]','2026-10-28 02:02:39','2026-10-28 02:02:39'),(3,'SRT-202610-003','skd','474.4/ 042 /DS-2011/III/2022','selesai',NULL,'2022-03-21','DEVI FAHRUROJI, S.Pd.I','Kepala Desa Cigagade','SITI NURJANAH','3205014505700003',NULL,'085234567892','Garut','1970-05-05','Perempuan','Indonesia','Islam','Kawin','Mengurus Rumah Tangga','Tonjong Kulon','002','002','Cigagade','Balubur Limbangan','Garut','Keterangan Domisili Tempat Tinggal','[]','2026-10-28 02:02:39','2026-10-28 02:02:39'),(4,'SRT-202610-004','sktm','460 / 011 /DS-2011/VII/2026','diproses',NULL,'2023-04-19','DEVI FAHRUROJI, S.Pd.I.','Kepala Desa Cigagade','NENG SALMA','3205016203040004',NULL,'087812345673','Garut','2004-03-22','Perempuan','Indonesia','Islam','Kawin','Pelajar/Mahasiswa','KP. Bantar Teureup','001','004','Cigagade','BL.Limbangan','Garut','Keringanan Biaya di PUSKESMAS','[]','2026-10-28 02:02:39','2026-10-28 02:02:39'),(5,'SRT-202610-005','skm','474.2/ 007 /2011-DS /VI/2026','selesai',NULL,'2026-02-20','DEVI FAHRUROJI, S.Pd.I','Kepala Desa Cigagade','JAKA','3205011111910005',NULL,'089612345674','Garut','1991-11-11','Laki-laki','Indonesia','Islam','Jejaka','Buruh Harian Lepas','KP. Rancasaat RT. 001 RW. 009 Desa Cigagade Kecamatan Bl. Limbangan Kabupaten Garut','001','009','Cigagade','Bl. Limbangan','Garut','Persyaratan Isbat Nikah','{\"suami_nama\":\"JAKA\",\"suami_bin\":\"TOSIN\",\"suami_jenis_kelamin\":\"Laki-aki\",\"suami_ttl\":\"Garut, 11 November 1991\",\"suami_agama\":\"Islam\",\"suami_status_perkawinan\":\"Jejaka\",\"suami_warga_negara\":\"Indonesia\",\"suami_pekerjaan\":\"Buruh Harian Lepas\",\"suami_alamat\":\"KP. Rancasaat RT. 001 RW. 009 Desa Cigagade Kecamatan Bl. Limbangan Kabupaten Garut\",\"istri_nama\":\"DINI SITI ROHANI\",\"istri_binti\":\"ELAN HAMBALI\",\"istri_jenis_kelamin\":\"Perempuan\",\"istri_ttl\":\"Garut, 01 Juli 1979\",\"istri_agama\":\"Islam\",\"istri_status_perkawinan\":\"Cerai Hidup\",\"istri_warga_negara\":\"Indonesia\",\"istri_pekerjaan\":\"Mengurus Rumah Tangga\",\"istri_alamat\":\"Rancapaku RT. 001 RW. 006 Desa Cigagade Kecamatan Bl. Limbangan Kabupaten Garut\",\"tanggal_pernikahan\":\"25 Oktober 2021\",\"kua_kecamatan\":\"KUA Bl. Limbangan\"}','2026-10-28 02:02:39','2026-10-28 02:02:39'),(6,'SRT-202610-006','skbm','400/ 088 /2011-DS/X/2026','diproses',NULL,'2026-10-20','DEVI FAHRUROJI, S.Pd.I.','Kepala Desa Cigagade','FAJAR ILHAM','3205012404020006',NULL,'083812345675','Garut','2002-04-24','Laki-laki','Indonesia','Islam','Belum Kawin','Pelajar/Mahasiswa','KP. Tengger','001','010','Cigagade','Balubur Limbangan','Garut','Persyaratan Melamar Pekerjaan','{\"pernyataan_rt\":\"01\",\"pernyataan_rw\":\"10\"}','2026-10-28 02:02:39','2026-10-28 02:38:38'),(7,'SRT-202610-007','skp','400/ 053 /2011-DS/VI/2026','selesai',NULL,'2026-06-15','DEVI FAHRUROJI, S.Pd.I.','Kepala Desa Cigagade','DEDE SUHENDAR','3205010906750007',NULL,'081312345676','Garut','1975-06-09','Laki-laki','Indonesia','Islam','Kawin','Buruh Harian Lepas','KP. Sukadana','001','001','Cigagade','Balubur Limbangan','Garut','Untuk Persyaratan Melanjutkan Pendidikan Ke perguruan Tinggi An. PUTRI NAYLA ALYA','{\"pernyataan_rt\":\"01\",\"pernyataan_rw\":\"01\",\"penghasilan_perbulan\":500000,\"penghasilan_terbilang\":\"Lima ratus ribu rupiah\"}','2026-10-28 02:02:39','2026-10-28 02:02:39');
/*!40000 ALTER TABLE `surat_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `umkms`
--

DROP TABLE IF EXISTS `umkms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `umkms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `seller_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'Makanan & Minuman',
  `price` decimal(12,0) NOT NULL,
  `unit` varchar(255) DEFAULT '/ bungkus',
  `description` text NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `views` bigint(20) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `umkms_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `umkms`
--

LOCK TABLES `umkms` WRITE;
/*!40000 ALTER TABLE `umkms` DISABLE KEYS */;
INSERT INTO `umkms` VALUES (1,'Kopi Robusta Lereng Cigagade','kopi-robusta-lereng-cigagade','Kang Dudung (Kelompok Tani Harapan Jaya)','081223344556','Makanan & Minuman',50000,'250gr','Kopi robusta pilihan dipetik merah dari kebun lereng perbukitan Desa Cigagade dengan ketinggian sejuk. Diproses secara natural dan dipanggang medium-dark, menghasilkan cita rasa aroma cokelat kacang yang mantap, tebal, dan rendah asam. Sangat cocok diseduh tubruk maupun filter.','Dusun Cibalampu RT 01/RW 03, Desa Cigagade','umkm/kopi-robusta.jpg',1,2,'2026-10-05 05:34:05','2026-10-19 05:43:33'),(2,'Keripik Singkong Pedas Gurih Cigagade','keripik-singkong-pedas-gurih-cigagade','Ibu Enok Rosidah','085798765432','Makanan & Minuman',18000,'bungkus','Camilan khas warga Cigagade dibuat dari singkong mentega segar hasil panen kebun lokal. Diiris tipis lalu digoreng garing renyah dengan baluran cabai rawit segar, bawang putih, dan aroma daun jeruk purut asli tanpa pengawet. Tersedia level pedas sedang dan ekstra pedas.','Dusun Cigagade Hilir RT 02/RW 01, Desa Cigagade','umkm/keripik-singkong.jpg',1,2,'2026-10-05 05:34:05','2026-10-28 07:26:56'),(3,'Gula Aren Batok Murni Cigagade','gula-aren-batok-murni-cigagade','Mang Ujang Saepudin','081394123456','Makanan & Minuman',32000,'kg','Gula aren asli disadap langsung dari pohon enau perbukitan Cigagade setiap pagi. Dimasak secara tradisional di atas tungku kayu bakar menghasilkan wangi karamel alami yang kuat dan rasa manis legit tidak enek. Sangat pas untuk pemanis kopi, teh, olahan kue basah, atau kolak.','Dusun Pasir Pari RT 03/RW 02, Desa Cigagade','umkm/gula-aren.jpg',1,0,'2026-10-05 05:34:05','2026-10-05 07:31:34'),(4,'Kerajinan Anyaman Bambu Tradisional','kerajinan-anyaman-bambu-tradisional','Pak Tatang (Sentra Anyaman Bambu)','082115678901','Kerajinan Tangan',65000,'set','Satu set wadah anyaman bambu handmade terdiri dari besek serbaguna, boboko tempat nasi, dan wadah saji ramah lingkungan. Dibuat dari bambu tali pilihan yang diolah secara teliti, dihaluskan, dan diawetkan secara alami sehingga bebas jamur dan tahan bertahun-tahun.','Dusun Cigagade Girang RT 04/RW 02, Desa Cigagade','umkm/anyaman-bambu.jpg',1,0,'2026-10-05 05:34:05','2026-10-05 08:06:14'),(5,'Beras Organik Terasering Cigagade','beras-organik-terasering-cigagade','Gapoktan Mekar Mukti Cigagade','087823456789','Pertanian & Perkebunan',78000,'5 kg','Beras pulen alami tanpa pestisida kimia yang ditanam di persawahan terasering subur Cigagade dengan sistem irigasi mata air pegunungan. Dipanen dan digiling langsung saat ada pesanan agar kesegaran dan aroma pulen alaminya tetap terjaga sempurna.','Kompleks Lumbung Pangan Dusun II, Desa Cigagade','umkm/beras-organik.jpg',1,0,'2026-10-05 05:34:05','2026-10-05 08:06:14');
/*!40000 ALTER TABLE `umkms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `rw` tinyint(3) unsigned DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin Desa Cigagade','admin@desacigagade.id','superadmin',NULL,'2026-10-05 02:42:32','$2y$12$DhdbS8AwaqLuS1aDYvz4CuFSS2urhoJ86eL1BO2tVutAfg/URI9s2',NULL,'2026-10-05 02:42:32','2026-10-28 02:28:57'),(2,'Fadzkal Luthfi (Admin IT Desa)','paskalluffy@gmail.com','superadmin',NULL,'2026-10-05 02:42:32','$2y$12$2jju0z0YSJE4xDhvd426nutF/lXwPRIlfQ5pBb.oT9cfJrfwNTCVC',NULL,'2026-10-05 02:42:32','2026-10-05 02:42:32'),(3,'Pengurus RW 01 Desa Cigagade','rw01@desacigagade.id','rw',1,'2026-10-26 00:39:19','$2y$12$WfTc1e3gyQkcgZgnaMZh3eXfn9kDS/j6AwnAG39Y6Wbc/TbHTo1QC',NULL,'2026-10-26 00:39:19','2026-10-26 00:39:19'),(4,'Pengurus RW 02 Desa Cigagade','rw02@desacigagade.id','rw',2,'2026-10-26 00:39:19','$2y$12$5H9NC40fdd9VEHkLs0byTOUDVF/bUyVtL0RKsPMKIadwjrlUsEiiC',NULL,'2026-10-26 00:39:19','2026-10-26 00:39:19'),(5,'Pengurus RW 03 Desa Cigagade','rw03@desacigagade.id','rw',3,'2026-10-26 00:39:19','$2y$12$DbSQris36pCSeAEuvwlRGOGWKrp7/KszOfCAOMBKY6kQzYbDz/BcO',NULL,'2026-10-26 00:39:19','2026-10-26 00:39:19'),(6,'Pengurus RW 04 Desa Cigagade','rw04@desacigagade.id','rw',4,'2026-10-26 00:39:20','$2y$12$GzMy6iSte0mjuMjGwZ/uKOZOEtE5PZxZ5D6Zz15Ir.8T.dOZQDQPC',NULL,'2026-10-26 00:39:20','2026-10-26 00:39:20'),(7,'Pengurus RW 05 Desa Cigagade','rw05@desacigagade.id','rw',5,'2026-10-26 00:39:20','$2y$12$rUnQ4Xhp5A5nmiLpeb36UeE539uatg9RqAYgwwGDwMZpUF9JqbC0u',NULL,'2026-10-26 00:39:20','2026-10-26 00:39:20'),(8,'Pengurus RW 06 Desa Cigagade','rw06@desacigagade.id','rw',6,'2026-10-26 00:39:21','$2y$12$ouZzZMGE1v0RWWQK1RDmTOJVUktfQykiDGfIrw4JIFq1nj2QhZ0pC',NULL,'2026-10-26 00:39:21','2026-10-26 00:39:21'),(9,'Pengurus RW 07 Desa Cigagade','rw07@desacigagade.id','rw',7,'2026-10-26 00:39:21','$2y$12$6Iuu2j5eT0LjT35DDZbUEueMq1pOjUv8WGE6qkUhVdX.cGL/lR6q.',NULL,'2026-10-26 00:39:21','2026-10-26 00:39:21'),(10,'Pengurus RW 08 Desa Cigagade','rw08@desacigagade.id','rw',8,'2026-10-26 00:39:22','$2y$12$zC48sdcOc6tMKI6Zt1BSNu6HlOLSXxIDDsneh0bjwDywCjGhabzzS',NULL,'2026-10-26 00:39:22','2026-10-26 00:39:22'),(11,'Pengurus RW 09 Desa Cigagade','rw09@desacigagade.id','rw',9,'2026-10-26 00:39:22','$2y$12$8lAcbDDWHGt50ksXbYul2eLittYWzMFrdZFrtA4yfIuDWlYveJhXy',NULL,'2026-10-26 00:39:22','2026-10-26 00:39:22'),(12,'Pengurus RW 10 Desa Cigagade','rw10@desacigagade.id','rw',10,'2026-10-26 00:39:23','$2y$12$BsMPkYyXJq2Uw5Cjp2I1Y..eLzSBoVGyCMX1ePBzXiZTiEXlL9h.a',NULL,'2026-10-26 00:39:23','2026-10-26 00:39:23'),(13,'Kader TP-PKK Desa Cigagade','pkk@desacigagade.id','pkk',NULL,'2026-10-28 03:10:08','$2y$12$pbfHPIiSDb865MNxjkP3mepoEB/2QiDXbqyNKlL/FOtGNh5wEytZu',NULL,'2026-10-28 03:10:08','2026-10-28 03:10:08');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `videos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `youtube_url` varchar(255) NOT NULL,
  `youtube_id` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` VALUES (1,'Profil Pemerintahan dan Potensi Alam Desa Cigagade Limbangan Garut',NULL,'https://www.youtube.com/watch?v=ScMzIvxBSi4',NULL,NULL,1,'2026-09-30 02:42:33','2026-10-05 02:42:33','2026-10-05 02:42:33'),(2,'Dokumentasi Semarak HUT RI dan Gotong Royong Warga Cigagade',NULL,'https://www.youtube.com/watch?v=ScMzIvxBSi4',NULL,NULL,0,'2026-09-23 02:42:33','2026-10-05 02:42:33','2026-10-05 02:42:33'),(3,'Mengenal Potensi Pertanian dan Aliran Sungai Cipancar Cigagade',NULL,'https://www.youtube.com/watch?v=ScMzIvxBSi4',NULL,NULL,0,'2026-09-10 02:42:33','2026-10-05 02:42:33','2026-10-05 02:42:33');
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitor_logs`
--

DROP TABLE IF EXISTS `visitor_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visitor_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) DEFAULT NULL,
  `ip_hash` varchar(64) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `visit_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visitor_logs_visit_date_ip_hash_index` (`visit_date`,`ip_hash`),
  KEY `visitor_logs_ip_hash_index` (`ip_hash`),
  KEY `visitor_logs_session_id_index` (`session_id`),
  KEY `visitor_logs_visit_date_index` (`visit_date`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitor_logs`
--

LOCK TABLES `visitor_logs` WRITE;
/*!40000 ALTER TABLE `visitor_logs` DISABLE KEYS */;
INSERT INTO `visitor_logs` VALUES (1,'127.0.0.1','3f3a45184d38b647abd77fed90f5b8bf078a1e8229dd32f9f330e8aafef42528','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','rG1xmLWYSUIniwwBjLF23dUpkhCewAxSrWzXN02P','http://localhost:8000','2026-10-05','2026-10-05 04:19:47','2026-10-05 04:19:47'),(2,'127.0.0.1','9f042781e4e3fba7701cc7611d45fe1b84df85400e157f3abba065841a4e33a1','Symfony','bSU66OjgmnRJ5YLLvHK0N3x63Ak4KWS1NIunqQeL','http://localhost','2026-10-05','2026-10-05 04:36:15','2026-10-05 04:36:15'),(3,'127.0.0.1','00e74cffd102dfdef8d2017eb6b90773896e15db6f0d0fa9b0b77f2730e52673','Unknown','UL7lFG1qWT4sSuwLfcHn3TIeri6EkLG666FfrRK8','http://127.0.0.1:8000','2026-10-05','2026-10-05 04:39:37','2026-10-05 04:39:37'),(4,'127.0.0.1','2c342628c0374f087f84bec6cb01dd696f87372896375c965038a5568c62ec2f','curl/8.21.0','tA0I67r1k6py1Zyr18DgmsprY8Jrfc1qZxnRuV1H','http://localhost:8000','2026-10-05','2026-10-05 05:36:09','2026-10-05 05:36:09'),(5,'127.0.0.1','e9c5282f1680f042222675eaab9bd1ef412e4428253c322c203a0a2f75b73a1f','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9168','TOeCkOsV1r3gjEN0siDNf4MzoHInkXADoqmgMGHE','http://127.0.0.1:8000','2026-10-06','2026-10-06 02:14:21','2026-10-06 02:14:21'),(6,'127.0.0.1','3ea0d0e5d64713f5792fa448cf09a7e1266c58e6a4085eac10b40cc2f2db460a','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0','1UXqzcQJTUy0bqXNjO7xhhkUoFuMdYgdwpzlQtCF','http://127.0.0.1:8000','2026-10-06','2026-10-06 02:15:51','2026-10-06 02:15:51'),(7,'127.0.0.1','22cbf9e8ff543c0ffc5f1927806922c0085509a85f745c7e75667833575e7440','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0','WGmFSCukIBKHcDvnT2XE1IWfMjsKEol3NHxxOHGy','http://127.0.0.1:8000','2026-10-19','2026-10-19 03:20:45','2026-10-19 03:20:45'),(8,'127.0.0.1','945a2f58c5b6fcd9923b2bdc798dc51302ecdfcede93a9652c799ce09f53e5b9','curl/8.21.0','OWlsE4WeYmSSvVOQIfdi0D88NEQu5DqsT2dIVASz','http://127.0.0.1:8000/sitemap.xml','2026-10-19','2026-10-19 03:40:05','2026-10-19 03:40:05'),(9,'127.0.0.1','6ec01cc9f192b910642cce29926251effc9f0643fd090575fd31084296eba7ec','Symfony','TxuAntfMubKomceKL6HGRLr93kD5Mlj6iBRqXjdz','http://localhost','2026-10-19','2026-10-19 03:51:18','2026-10-19 03:51:18'),(10,'127.0.0.1','1e6e1232dd1f7ca8bcda8c1c09bb1717145c349eabd16063c88c2d95a38a4fe5','Unknown','1KOV0Kwn88S1sewTIdz1vjn6fkyLBCbtXDPE0vCz','http://localhost:8000/infografis','2026-10-19','2026-10-19 04:25:51','2026-10-19 04:25:51'),(11,'127.0.0.1','3a4c0023a8b37656eef1174bdc6553acccd706cbe27389518da3b7621bff8ec2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/155.0.0.0 Safari/537.36','gFgmAUVylCYogrb9Wdy91ey8M4sINEph1FLKZC25','http://127.0.0.1:8000','2026-10-19','2026-10-19 05:40:31','2026-10-19 05:40:31'),(12,'127.0.0.1','d6478c2515ce49ee156f8977712d963cc9d5b4a33f57071812a28e46fa43034e','curl/8.21.0','X3f67qJZRJ5b5FrzCDdVEwCObgXpwRBAiqvrUB3B','http://localhost:8000','2026-10-25','2026-10-25 11:09:11','2026-10-25 11:09:11'),(13,'127.0.0.1','81f449194105935b51505173c5b9ea9facb611b691b17d2fea04d2fce5e439fd','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0','OPP8BLRqpAwFpMrNZDqv6vTK4vLEfRev8YHS1EdK','http://localhost:8000','2026-10-25','2026-10-25 11:09:41','2026-10-25 11:09:41'),(14,'127.0.0.1','55175897eb5109fe469e9f97ca082da060b258b6a0725e9634a410f4729d1916','curl/8.21.0','d6f1JlJctFY8QlwZUnKjyu9I1Lma2VHeZDAqkePT','http://127.0.0.1:8000/berita','2026-10-26','2026-10-26 00:57:29','2026-10-26 00:57:29'),(15,'127.0.0.1','7045a84b3da233d0ddda7889053c2362dc168d8d02db902d882a40a7c9356045','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36 Edg/156.0.0.0','ZPMVhzobDbZ7VbN7eJCWzPTgs9M9cBwg1QoARHql','http://127.0.0.1:8000','2026-10-26','2026-10-26 01:07:36','2026-10-26 01:07:36'),(16,'127.0.0.1','7487b86d753937f2f303b2f72c585a18be7b52f531a6d694dd7034d35603c625','Unknown','F981lVmFSNay3VwRHaNd7PmK77BPkKZePh9R2zBM','http://127.0.0.1:8000/login','2026-10-26','2026-10-26 01:13:53','2026-10-26 01:13:53'),(17,'127.0.0.1','e89f474136c1cafa3233da94d1cc75f01a6243e183e79289aac2216f73e93bb0','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9711','rZg63kZlFTM8Fl5cz50QVmTW370SgFd4zP2Rl0Dw','http://127.0.0.1:8000','2026-10-26','2026-10-26 03:08:09','2026-10-26 03:08:09'),(18,'127.0.0.1','72928e2321795cfa5f110574c21dd3adfd132896ba0e27eb5b261bddaef9c162','Symfony','r3N0aWfRpqM7lA9GjoqjACkoB35d1U1pnh3a3gzQ','http://localhost','2026-10-28','2026-10-28 02:19:55','2026-10-28 02:19:55'),(19,'127.0.0.1','a5d7fcd06f19f2c6d4aad3208fd670c20c275812929e40d4b4f7cd8ba0d356e5','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9711','iTFMPRB8jrZA870swtPM0Zfus9Jww19lBoYsN1SW','http://127.0.0.1:8000/layanan-surat','2026-10-28','2026-10-28 02:24:44','2026-10-28 02:24:44'),(20,'127.0.0.1','7503f37ea83a4081d84d874d2dbd451a1cba0c8421ef5ff826afee085db79fcb','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36 Edg/156.0.0.0','8Kpt97OanIBmQcljMe6QPPw4NAsBwS685huXjsRi','http://127.0.0.1:8000','2026-10-28','2026-10-28 02:25:32','2026-10-28 02:25:32'),(21,'127.0.0.1','b80f34e2dfb00fc9687f7005b4ddf35296714a1a8d367b210f8889688801c830','curl/8.21.0','rW9o7QLQKbOxyeoZAHqDf5IxAmKoHtHYupxXAWNr','http://127.0.0.1:8000','2026-10-28','2026-10-28 03:04:45','2026-10-28 03:04:45');
/*!40000 ALTER TABLE `visitor_logs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-01 11:31:23
