/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.4.25-MariaDB : Database - naive_bayes
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`naive_bayes` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `naive_bayes`;

/*Table structure for table `dataset` */

DROP TABLE IF EXISTS `dataset`;

CREATE TABLE `dataset` (
  `data_id` int(11) NOT NULL AUTO_INCREMENT,
  `response` text NOT NULL,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `dataset` */

insert  into `dataset`(`data_id`,`response`,`label`) values 
(1,'barang tidak sesuai harapan??','Negatif'),
(2,'Kurang bagus ada lecet di bagian talinya','Negatif'),
(3,'Tidak sesuai pesanan merugikan konsumen. Saya juga tidak menerima komplain dari anda jika saya mengasih bintang satu.','Negatif'),
(4,'Baguss banget bahan nya juga bagus Rante nya bisa jadi pendek bisa jadi panjang pokoknya baguss banget GA nyesel beli di sini??','Positif'),
(5,'tidak sesuai yang di pesan apa yang di kirim apa','Negatif'),
(6,'Ini bagus banget serius sumpah. Warna nya lucu banget ini yang biru belum di buka. Modis dan gemay sekali. pengemasan cepat pengiriman cepat. Mantap sekali. Makasih','Positif'),
(7,'sangat bagus ini tas nya tu mini gituuu bagus bangett intinya suka banget deh????????❤️????????','Positif'),
(8,'Pengiriman cepat pakingnya bagus dan barangnya datang dengan kondisi baik ❤️','Positif'),
(9,'Tas nya bagus expetasinya besar ternyata kecil tali nya panjang bgttt','Netral'),
(10,'Ini tas nya lucu banget plis aaaa suka ????????????????i like it','Positif'),
(11,'Ukuran tas nya lumayan lebih kecil dr yg aku kira. Tapi so far bahan dan modelnya yang simple aku suka banget. Dan yg terpenting bahan nya bagus. Thankyou','positif');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
