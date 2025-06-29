-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: cleanlygo
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `idAdmin` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idAdmin`),
  UNIQUE KEY `idUser` (`idUser`),
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,4,'Oculis Iris');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `garansi`
--

DROP TABLE IF EXISTS `garansi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `garansi` (
  `idGaransi` int NOT NULL,
  `idPesanan` int NOT NULL,
  `deskripsiGaransi` varchar(255) DEFAULT NULL,
  `tanggalBerlaku` datetime DEFAULT NULL,
  `statusGaransi` enum('Aktif','TidakAktif','Kadaluwarsa') DEFAULT NULL,
  PRIMARY KEY (`idGaransi`),
  KEY `idPesanan` (`idPesanan`),
  CONSTRAINT `garansi_ibfk_1` FOREIGN KEY (`idPesanan`) REFERENCES `pesanan` (`idPesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `garansi`
--

LOCK TABLES `garansi` WRITE;
/*!40000 ALTER TABLE `garansi` DISABLE KEYS */;
/*!40000 ALTER TABLE `garansi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `layanan`
--

DROP TABLE IF EXISTS `layanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `layanan` (
  `idLayanan` int NOT NULL,
  `namaLayanan` varchar(255) DEFAULT NULL,
  `deskripsiLayanan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idLayanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layanan`
--

LOCK TABLES `layanan` WRITE;
/*!40000 ALTER TABLE `layanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `layanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pekerja`
--

DROP TABLE IF EXISTS `pekerja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pekerja` (
  `idPekerja` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `rolePekerja` enum('Pembersih','Pindahan') DEFAULT NULL,
  `statusPekerja` enum('Tersedia','TidakTersedia','Terjadwalkan') DEFAULT NULL,
  PRIMARY KEY (`idPekerja`),
  UNIQUE KEY `idUser` (`idUser`),
  CONSTRAINT `pekerja_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pekerja`
--

LOCK TABLES `pekerja` WRITE;
/*!40000 ALTER TABLE `pekerja` DISABLE KEYS */;
INSERT INTO `pekerja` VALUES (1,2,'Shin Numer','Pembersih','Tersedia');
/*!40000 ALTER TABLE `pekerja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pelanggan`
--

DROP TABLE IF EXISTS `pelanggan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pelanggan` (
  `idPelanggan` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `noHp` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idPelanggan`),
  UNIQUE KEY `idUser` (`idUser`),
  CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pelanggan`
--

LOCK TABLES `pelanggan` WRITE;
/*!40000 ALTER TABLE `pelanggan` DISABLE KEYS */;
INSERT INTO `pelanggan` VALUES (1,1,'Zangen Shiro','Zangen','Veldra, Narchcent','777777777'),(2,3,'Kuro Vensrech',NULL,NULL,NULL);
/*!40000 ALTER TABLE `pelanggan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran`
--

DROP TABLE IF EXISTS `pembayaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembayaran` (
  `idPembayaran` int NOT NULL,
  `idPesanan` int NOT NULL,
  `metodePembayaran` enum('Tunai','Transfer','Qris') DEFAULT NULL,
  `totalBayar` int DEFAULT NULL,
  `tanggalBayar` datetime DEFAULT NULL,
  PRIMARY KEY (`idPembayaran`),
  KEY `idPesanan` (`idPesanan`),
  CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`idPesanan`) REFERENCES `pesanan` (`idPesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran`
--

LOCK TABLES `pembayaran` WRITE;
/*!40000 ALTER TABLE `pembayaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembayaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengaduan`
--

DROP TABLE IF EXISTS `pengaduan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengaduan` (
  `idPengaduan` int NOT NULL,
  `idPesanan` int NOT NULL,
  `idPelanggan` int NOT NULL,
  `deskripsiPengaduan` varchar(255) DEFAULT NULL,
  `tanggalPengaduan` datetime DEFAULT NULL,
  `statusPengaduan` enum('BelumDiproses','SedangDiproses','Selesai') DEFAULT NULL,
  PRIMARY KEY (`idPengaduan`),
  KEY `idPelanggan` (`idPelanggan`),
  KEY `idPesanan` (`idPesanan`),
  CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`idPelanggan`) REFERENCES `pelanggan` (`idPelanggan`),
  CONSTRAINT `pengaduan_ibfk_2` FOREIGN KEY (`idPesanan`) REFERENCES `pesanan` (`idPesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaduan`
--

LOCK TABLES `pengaduan` WRITE;
/*!40000 ALTER TABLE `pengaduan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengaduan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pesanan`
--

DROP TABLE IF EXISTS `pesanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pesanan` (
  `idPesanan` int NOT NULL,
  `idPelanggan` int NOT NULL,
  `tipePesanan` varchar(100) DEFAULT NULL,
  `catatanPesanan` varchar(255) DEFAULT NULL,
  `statusPesanan` enum('BelumDibayar','Diproses','Terjadwal','Selesai','Ditolak') DEFAULT NULL,
  `tanggalPesanan` datetime DEFAULT NULL,
  `tanggalLayanan` datetime DEFAULT NULL,
  PRIMARY KEY (`idPesanan`),
  KEY `idPelanggan` (`idPelanggan`),
  CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`idPelanggan`) REFERENCES `pelanggan` (`idPelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pesanan`
--

LOCK TABLES `pesanan` WRITE;
/*!40000 ALTER TABLE `pesanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pesanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pesanan_layanan`
--

DROP TABLE IF EXISTS `pesanan_layanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pesanan_layanan` (
  `idPesanan` int NOT NULL,
  `idLayanan` int NOT NULL,
  PRIMARY KEY (`idPesanan`,`idLayanan`),
  KEY `idLayanan` (`idLayanan`),
  CONSTRAINT `pesanan_layanan_ibfk_1` FOREIGN KEY (`idPesanan`) REFERENCES `pesanan` (`idPesanan`),
  CONSTRAINT `pesanan_layanan_ibfk_2` FOREIGN KEY (`idLayanan`) REFERENCES `layanan` (`idLayanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pesanan_layanan`
--

LOCK TABLES `pesanan_layanan` WRITE;
/*!40000 ALTER TABLE `pesanan_layanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pesanan_layanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ulasan`
--

DROP TABLE IF EXISTS `ulasan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ulasan` (
  `idUlasan` int NOT NULL AUTO_INCREMENT,
  `idPesanan` int NOT NULL,
  `idPelanggan` int NOT NULL,
  `ratingUlasan` int DEFAULT NULL,
  `isiUlasan` varchar(255) DEFAULT NULL,
  `tanggalUlasan` datetime DEFAULT NULL,
  PRIMARY KEY (`idUlasan`),
  KEY `idPelanggan` (`idPelanggan`),
  KEY `idPesanan` (`idPesanan`),
  CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`idPelanggan`) REFERENCES `pelanggan` (`idPelanggan`),
  CONSTRAINT `ulasan_ibfk_2` FOREIGN KEY (`idPesanan`) REFERENCES `pesanan` (`idPesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ulasan`
--

LOCK TABLES `ulasan` WRITE;
/*!40000 ALTER TABLE `ulasan` DISABLE KEYS */;
/*!40000 ALTER TABLE `ulasan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `role` enum('admin','pelanggan','pekerja') NOT NULL DEFAULT 'pelanggan',
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-18 16:25:16
