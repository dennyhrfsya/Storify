/*
 Navicat Premium Data Transfer

 Source Server         : Server Local
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : db_laravel_storify

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 10/04/2026 17:02:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for aset
-- ----------------------------
DROP TABLE IF EXISTS `aset`;
CREATE TABLE `aset`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_seri` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pembelian` date NULL DEFAULT NULL,
  `tanggal_garansi` date NULL DEFAULT NULL,
  `kuantitas` int NOT NULL DEFAULT 0,
  `harga` decimal(10, 2) NOT NULL,
  `pt_pembeban` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_aset` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `departemen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `grade_barang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kondisi` enum('baik','rusak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` enum('tersedia','dipinjam','permanen') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_bukti_aset` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 65 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of aset
-- ----------------------------
INSERT INTO `aset` VALUES (1, 'BRG001', 'Laptop Dell', 'Laptop', 'Dell', 'SN12345', '2024-01-15', '2027-03-03', 1, 15000000.00, 'PT Global Sekuriti Indonesia', 'Aban', 'Pro Player', 'Rawa Belong', 'bekas', 'rusak', 'Masih baru', 'dipinjam', 'upload_bukti_aset/tuclhDZsSyYQZC0NWZAwVjFQeh469mbat5rbzcw0.pdf', '2026-03-07 02:05:03', '2026-04-07 12:35:57');
INSERT INTO `aset` VALUES (2, 'BRG002', 'Macbook Pro M3', 'Laptop', 'Apple', 'BH7H99S', '2026-03-08', '2027-03-10', 1, 15000000.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, 'Gudang', 'baru', 'baik', 'Oke', 'tersedia', 'upload_bukti_aset/DcwicFW3w8ritw26Kxu24eOIrNnqO2pOyme5khYG.jpg', '2026-03-07 18:37:13', '2026-04-07 09:23:05');
INSERT INTO `aset` VALUES (3, 'BRG003', 'Asus TUF Gaming', 'Laptop', 'Asus', 'SN12345', '2026-03-08', '2026-03-11', 1, 12500000.00, 'PT Sada Usaha Niaga', 'Mamat', 'MBG', 'Banten', 'bekas', 'baik', 'Oke', 'permanen', 'upload_bukti_aset/n9eQcyT97m7Nq9zTySg48AtCFkEIolSd2ugu6keQ.jpg', '2026-03-07 20:29:43', '2026-03-15 19:25:27');
INSERT INTO `aset` VALUES (6, 'BRG004', 'HP Victus 14', 'Laptop', 'HP', '7JHHWW782', '2026-03-16', '2028-03-01', 1, 13500000.00, 'PT Dapur Pulau Rasa', 'Abdoel bin smith', 'Industri', 'Amerika', 'baru', 'baik', 'Oke', 'dipinjam', 'upload_bukti_aset/rNyQisinsp4ljW8Z0Rb5A1MKFUmtvEyjkINNDrAT.png', '2026-03-15 17:30:39', '2026-03-28 10:38:45');
INSERT INTO `aset` VALUES (7, 'BRG005', 'Advan WorkPlus', 'Laptop', 'Advan', '23SDWWW2', '2026-03-17', '2028-03-01', 1, 7800000.00, 'PT Nawa Sena Utama', 'Tarno', 'Admin', 'Gedung KMZ', 'baru', 'baik', 'OKE', 'dipinjam', 'upload_bukti_aset/PSiS78Dzqxfrz4wqtheJysICoQe84LLRVCrIjy2u.png', '2026-03-16 18:43:14', '2026-03-16 18:44:09');
INSERT INTO `aset` VALUES (8, 'BRG006', 'Asus Vivobook 14s', 'Laptop', 'Asus', 'K900LOSD', '2026-03-17', '2027-03-01', 1, 15248000.00, 'PT Bumi Hardana Sakti', NULL, NULL, NULL, 'baru', 'baik', 'tes 123456', 'tersedia', 'upload_bukti_aset/yME86n3tocOUrcIpeV0gW7nRFoYCBJZdEO1IzOCG.png', '2026-03-17 11:00:36', '2026-03-24 09:35:33');
INSERT INTO `aset` VALUES (9, 'BRGCG-5780', 'Printer corporis', 'Printer', 'Logitech', 'SN-35K1I35SJI', '2008-04-26', '2026-08-25', 5, 7550134.00, 'PT Bumi Hardana Sakti', 'Jarot', 'Gudang', 'Gudang', 'bekas', 'rusak', 'Molestiae accusamus deserunt est doloremque eaque esse sit.', 'dipinjam', NULL, '2026-03-27 16:23:04', '2026-04-07 07:44:39');
INSERT INTO `aset` VALUES (10, 'BRGLR-5024', 'Monitor dolor', 'Monitor', 'Epson', 'SN-K8SK7KV36M', '1977-05-17', '2026-11-17', 16, 9151455.00, 'PT Mitrel Berkat Utama', 'Anto', 'Dinas Luar', 'Tangerang', 'bekas', 'rusak', 'Sed et dolorum voluptas et alias aut.', 'dipinjam', NULL, '2026-03-27 16:23:04', '2026-03-28 11:10:13');
INSERT INTO `aset` VALUES (11, 'BRGFH-4397', 'Server necessitatibus', 'Server', 'Asus', 'SN-YUV28HZ5KT', '2008-06-18', '2027-03-02', 2, 831153.00, 'PT Armindo Langgeng Sejahtera', 'AB', 'Developer', 'Bandung', 'baru', 'rusak', 'Sapiente omnis nisi aspernatur maxime.', 'permanen', NULL, '2026-03-27 16:23:04', '2026-03-28 11:08:17');
INSERT INTO `aset` VALUES (12, 'BRGRN-2826', 'Printer eum', 'Printer', 'Dell', 'SN-ZR2O78HFQE', '1987-10-09', '2026-06-16', 6, 8370286.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, 'Gudang', 'bekas', 'baik', 'Et odit explicabo vero quisquam unde quam.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-04-08 02:15:59');
INSERT INTO `aset` VALUES (13, 'BRGXE-5899', 'Server vel', 'Server', 'Logitech', 'SN-0QQKZ9999L', '2004-02-02', '2027-07-11', 1, 6094976.00, 'PT Mitrel Berkat Utama', 'Gogon', 'Pertanian', 'Karawang', 'baru', 'baik', 'Perferendis placeat quia assumenda amet quaerat sed asperiores voluptatem.', 'permanen', NULL, '2026-03-27 16:23:04', '2026-04-07 08:19:57');
INSERT INTO `aset` VALUES (14, 'BRGOT-2373', 'Server consequatur', 'Server', 'Logitech', 'SN-Y6XCVA3XR9', '1977-08-23', '2026-09-30', 15, 2651432.00, 'PT Bumi Hardana Sakti', NULL, NULL, 'Gudang', 'baru', 'rusak', 'Impedit non quasi culpa qui harum nihil et itaque.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-04-08 04:33:14');
INSERT INTO `aset` VALUES (15, 'BRGCS-5937', 'Laptop ea', 'Laptop', 'Logitech', 'SN-0A25VZ4611', '1996-05-06', '2027-05-13', 20, 2910247.00, 'PT Armindo Langgeng Sejahtera', 'Aban', 'Pro Player', 'Rawa Belong', 'bekas', 'rusak', 'Reiciendis et eum et qui.', 'dipinjam', NULL, '2026-03-27 16:23:04', '2026-04-08 08:27:58');
INSERT INTO `aset` VALUES (16, 'BRGHP-0846', 'Scanner voluptates', 'Scanner', 'Epson', 'SN-BX4586XTM2', '2015-10-16', '2027-01-14', 6, 7600007.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'bekas', 'baik', 'Ut pariatur voluptatem aperiam et et.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (17, 'BRGIV-7603', 'Printer at', 'Printer', 'Lenovo', 'SN-VQ01SWSVRM', '1983-10-31', '2027-06-18', 20, 4886908.00, 'PT Bumi Hardana Sakti', 'Puyol', 'Pertanian', 'Karawang', 'bekas', 'rusak', 'Pariatur distinctio et molestias in.', 'dipinjam', NULL, '2026-03-27 16:23:04', '2026-04-07 09:05:40');
INSERT INTO `aset` VALUES (19, 'BRGJI-8058', 'Scanner excepturi', 'Scanner', 'Logitech', 'SN-8L0UV637Z2', '1998-02-20', '2026-04-18', 19, 850090.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'bekas', 'baik', 'Qui nostrum quas asperiores.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (20, 'BRGAC-4867', 'Printer sed', 'Printer', 'Lenovo', 'SN-NSIH4HN1Y3', '1983-09-15', '2026-09-27', 1, 12467696.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'bekas', 'rusak', 'Illum ex unde harum quaerat animi.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (21, 'BRGVB-2092', 'Monitor optio', 'Monitor', 'Logitech', 'SN-94563QDNXJ', '1977-04-23', '2028-01-23', 5, 3430825.00, 'PT Bumi Hardana Sakti', NULL, NULL, NULL, 'bekas', 'rusak', 'Aut quisquam quisquam nisi exercitationem et possimus suscipit.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (22, 'BRGLU-7434', 'CCTV ea', 'CCTV', 'Lenovo', 'SN-4PGK7X0591', '2003-03-24', '2027-12-13', 1, 8683965.00, 'PT Armindo Langgeng Sejahtera', 'Toyo', 'Pro Player', 'Rawa Belong', 'baru', 'rusak', 'Assumenda ut in officia praesentium et rerum sunt corporis.', 'dipinjam', NULL, '2026-03-27 16:23:04', '2026-04-08 02:23:14');
INSERT INTO `aset` VALUES (23, 'BRGXD-3103', 'Printer autem', 'Printer', 'Epson', 'SN-51672RYOGD', '2010-09-23', '2027-01-27', 4, 2954001.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'bekas', 'baik', 'Blanditiis omnis aliquid eos.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (24, 'BRGVK-4699', 'Printer culpa', 'Printer', 'Epson', 'SN-V5P8W9LBK2', '2014-01-29', '2027-07-03', 2, 8212134.00, 'PT Mitrel Berkat Utama', 'Yayan', 'Admin', 'Kantor Pusat', 'baru', 'baik', 'Animi dolorum ut sit rerum molestias.', 'dipinjam', NULL, '2026-03-27 16:23:04', '2026-04-07 09:24:34');
INSERT INTO `aset` VALUES (25, 'BRGUE-3957', 'Laptop odit', 'Laptop', 'Asus', 'SN-J7D45L12X1', '1999-07-12', '2027-12-15', 3, 4992512.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'bekas', 'baik', 'Accusantium necessitatibus saepe nulla voluptas nemo et.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (26, 'BRGXU-4320', 'Printer iste', 'Printer', 'Hikvision', 'SN-GPD21ZP1GO', '2024-04-24', '2026-08-17', 3, 424071.00, 'PT Bumi Hardana Sakti', NULL, NULL, NULL, 'baru', 'rusak', 'Et voluptas delectus adipisci quis eum.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (27, 'BRGOT-8552', 'Server rerum', 'Server', 'Hikvision', 'SN-MLUQ7L8ZK2', '2000-04-11', '2026-11-09', 1, 11292402.00, 'PT Bumi Hardana Sakti', NULL, NULL, NULL, 'baru', 'baik', 'Sequi dolorem sed id voluptatem ut sint ullam consequatur.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (28, 'BRGAA-2190', 'Monitor voluptatem', 'Monitor', 'Asus', 'SN-Z61Q1K5Z76', '2015-09-07', '2027-04-11', 17, 5899361.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'bekas', 'rusak', 'Atque ut non eligendi modi.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (29, 'BRGCV-8056', 'Monitor accusantium', 'Monitor', 'Logitech', 'SN-9R0MU421P3', '1979-06-22', '2027-06-27', 20, 14375358.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'baru', 'rusak', 'Qui quam error repudiandae consequatur voluptatem et.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (30, 'BRGHH-0338', 'Laptop exercitationem', 'Laptop', 'Hikvision', 'SN-V2507AT2E8', '2025-03-02', '2026-04-01', 14, 7853609.00, 'PT Bumi Hardana Sakti', NULL, NULL, NULL, 'bekas', 'rusak', 'Exercitationem quasi quidem voluptas vitae et ipsa.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (31, 'BRGZN-6817', 'Laptop cumque', 'Laptop', 'Epson', 'SN-181G8BI37R', '2003-05-14', '2027-06-10', 9, 8915648.00, 'PT Bumi Hardana Sakti', NULL, NULL, NULL, 'bekas', 'rusak', 'Eos molestiae fuga nihil sed nobis expedita magnam.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (32, 'BRGSO-9941', 'Monitor aliquam', 'Monitor', 'HP', 'SN-F11720L5Y7', '2014-01-24', '2028-01-31', 18, 5690389.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'bekas', 'baik', 'Dignissimos sit aut est dolorem nemo dolorem.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (33, 'BRGHH-3784', 'Scanner repellendus', 'Scanner', 'Logitech', 'SN-7395R5S4DZ', '1972-07-05', '2026-07-03', 4, 1634020.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'bekas', 'rusak', 'Inventore vero ut rerum odit illum aliquid vitae.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (34, 'BRGYT-4598', 'Scanner officiis', 'Scanner', 'Asus', 'SN-80FESO095Z', '1984-06-11', '2028-01-12', 17, 1833588.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'bekas', 'baik', 'Veniam ullam voluptatem possimus aut reprehenderit explicabo repudiandae.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (35, 'BRGPP-0572', 'Server non', 'Server', 'Logitech', 'SN-K6768D74UR', '2019-08-26', '2027-12-14', 17, 11291378.00, 'PT Bumi Hardana Sakti', NULL, NULL, NULL, 'bekas', 'rusak', 'Consequatur et voluptates velit et reprehenderit.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (36, 'BRGGZ-1014', 'Server ut', 'Server', 'Hikvision', 'SN-0YZZL6I3Y2', '2021-04-22', '2028-02-28', 17, 12260598.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'baru', 'rusak', 'Repellendus aut id aperiam inventore iure minima quod.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (37, 'BRGCX-5496', 'Monitor ut', 'Monitor', 'Lenovo', 'SN-912J95YO47', '1979-04-04', '2027-03-16', 4, 14473405.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'bekas', 'baik', 'Praesentium et incidunt dicta occaecati necessitatibus sequi ad voluptatibus.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (38, 'BRGGQ-4407', 'Server repellendus', 'Server', 'Asus', 'SN-HSGD1UQ6W7', '1976-09-14', '2027-12-10', 1, 6337910.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'bekas', 'baik', 'Vel illo vero impedit et at magni accusamus.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (39, 'BRGDW-0722', 'Printer consequatur', 'Printer', 'Lenovo', 'SN-P3LZ37S8D8', '2018-01-02', '2026-11-01', 16, 313678.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'baru', 'baik', 'Et deleniti consequuntur enim cum quisquam architecto sit.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (40, 'BRGRO-7889', 'Server dicta', 'Server', 'Asus', 'SN-ZI1QF79R65', '1972-06-05', '2026-12-09', 5, 6723447.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'baru', 'rusak', 'Maxime non explicabo porro adipisci deleniti et aut voluptatem.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (41, 'BRGIP-4704', 'Printer totam', 'Printer', 'Epson', 'SN-9OTKA81RX6', '2025-10-21', '2028-02-29', 11, 10126469.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'baru', 'rusak', 'Ut aperiam quae laboriosam qui qui qui.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (42, 'BRGVN-2921', 'Monitor nostrum', 'Monitor', 'Asus', 'SN-82C313N65H', '2001-03-01', '2026-08-30', 18, 12117399.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'baru', 'baik', 'Deleniti eligendi magnam minus et.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (43, 'BRGHS-7202', 'Printer ut', 'Printer', 'Asus', 'SN-L25LY6C81D', '2004-06-01', '2027-12-24', 3, 1569534.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'bekas', 'rusak', 'Provident rerum modi voluptatum perferendis sit saepe aut dolores.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (44, 'BRGSG-3677', 'Laptop incidunt', 'Laptop', 'Logitech', 'SN-KU8UMVI043', '1980-09-19', '2026-07-09', 2, 6324844.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'baru', 'baik', 'Inventore dignissimos est qui dolorem deleniti.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (45, 'BRGCF-6499', 'Printer eligendi', 'Printer', 'Hikvision', 'SN-9TM9M2284J', '2008-10-19', '2027-05-28', 16, 11441893.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'bekas', 'rusak', 'Sint aut nostrum incidunt.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (46, 'BRGTS-0567', 'Monitor dolores', 'Monitor', 'Hikvision', 'SN-WGP48GF2Q2', '1972-02-26', '2026-06-23', 4, 4563930.00, 'PT Bumi Hardana Sakti', NULL, NULL, NULL, 'bekas', 'baik', 'Ducimus accusamus optio omnis rerum impedit quisquam.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (47, 'BRGAP-4112', 'Laptop impedit', 'Laptop', 'Hikvision', 'SN-EEY6BZ4WLN', '1986-06-13', '2026-11-17', 6, 225001.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'baru', 'rusak', 'Mollitia est qui voluptatem et reiciendis quo quae.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (48, 'BRGJB-6983', 'Scanner aut', 'Scanner', 'Logitech', 'SN-2Z637N5XF6', '1995-02-06', '2026-07-12', 10, 7159802.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'bekas', 'rusak', 'Consequatur repellat ex quod et corporis saepe reprehenderit voluptates.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (49, 'BRGMP-3120', 'CCTV neque', 'CCTV', 'Hikvision', 'SN-WIUW1A0W18', '2005-07-06', '2027-11-12', 1, 4299472.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'bekas', 'baik', 'Sint est quae architecto et.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (50, 'BRGHE-2784', 'Server iusto', 'Server', 'HP', 'SN-Z2TQ8K9W04', '1971-05-29', '2027-01-02', 3, 1508623.00, 'PT Bumi Hardana Sakti', NULL, NULL, NULL, 'baru', 'baik', 'Eaque magnam rem nesciunt quia nesciunt voluptas.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (51, 'BRGBG-9333', 'Server nostrum', 'Server', 'Asus', 'SN-VAL9Z18MX7', '2012-11-17', '2026-07-20', 10, 14922708.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'baru', 'rusak', 'Fuga dolores doloribus non qui quos placeat architecto repudiandae.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (52, 'BRGSJ-0428', 'Scanner dolor', 'Scanner', 'Asus', 'SN-79IG29V6E8', '1974-01-14', '2028-02-18', 8, 10795890.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'bekas', 'rusak', 'Tempore earum fuga culpa dolorem.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (53, 'BRGRN-5708', 'Laptop consequatur', 'Laptop', 'HP', 'SN-R61JM4MDAI', '1997-02-16', '2026-07-06', 13, 9472851.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'baru', 'rusak', 'Voluptas voluptas quas officia cum voluptatem dolor.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (54, 'BRGGB-5580', 'Printer nulla', 'Printer', 'Logitech', 'SN-JP2111W0V8', '2019-08-09', '2026-04-07', 3, 2262504.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'bekas', 'rusak', 'Quos non consequuntur occaecati dolor aspernatur delectus voluptates quidem.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (55, 'BRGRL-0038', 'CCTV dolores', 'CCTV', 'Dell', 'SN-JGJ1N2QPJH', '2020-08-24', '2026-08-30', 15, 5482759.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'baru', 'rusak', 'Quas consectetur neque nisi perspiciatis quas.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (56, 'BRGVF-9203', 'CCTV quas', 'CCTV', 'Hikvision', 'SN-636OG08BKN', '1974-03-03', '2028-01-06', 7, 11016643.00, 'PT Mitrel Berkat Utama', NULL, NULL, NULL, 'baru', 'rusak', 'Numquam error nulla necessitatibus rerum eum.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (57, 'BRGFI-9640', 'CCTV labore', 'CCTV', 'Epson', 'SN-68V90K5HE7', '1995-05-19', '2026-12-10', 13, 12286023.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'baru', 'baik', 'Ea esse laboriosam eum neque incidunt dolorem ut.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (58, 'BRGEZ-5079', 'Server qui', 'Server', 'HP', 'SN-ZYP3NP69W9', '1973-03-19', '2026-09-06', 6, 13504891.00, 'PT Armindo Langgeng Sejahtera', NULL, NULL, NULL, 'baru', 'baik', 'Dicta sunt quos earum laudantium explicabo distinctio.', 'tersedia', NULL, '2026-03-27 16:23:04', '2026-03-27 16:23:04');
INSERT INTO `aset` VALUES (61, 'BRG014', 'Acer Nitro', 'Laptop', 'Acer', 'BB11', '2026-03-29', '2026-03-31', 1, 15423000.00, 'PT Global Sekuriti Indonesia', 'Aban', 'Pro Player', 'Palembang', 'baru', 'rusak', 'Tes', 'dipinjam', 'upload_bukti_aset/20260407_BRG014.png', '2026-03-28 18:29:37', '2026-04-08 01:56:31');
INSERT INTO `aset` VALUES (64, 'BRG016', 'Lenovo LOQ', 'Laptop', 'Lenovo', 'IUOP231', '2026-04-08', '2027-04-01', 1, 12340000.00, 'PT Angin Ribut', NULL, NULL, 'Gudang', 'baru', 'baik', 'Tes', 'tersedia', 'upload_bukti_aset/20260408_BRG016.png', '2026-04-08 08:18:59', '2026-04-08 08:24:18');

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_locks_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2026_02_21_153240_add_role_to_table', 1);
INSERT INTO `migrations` VALUES (5, '2026_02_21_154837_add_two_factor_columns_to_users_table', 1);
INSERT INTO `migrations` VALUES (6, '2026_02_24_044718_create_aset_table', 1);
INSERT INTO `migrations` VALUES (7, '2026_03_03_040918_create_permissions_table', 1);
INSERT INTO `migrations` VALUES (8, '2026_03_05_055718_add_kuantitas_to_aset_table', 1);
INSERT INTO `migrations` VALUES (9, '2026_03_07_182931_create_stok_barang_table', 2);
INSERT INTO `migrations` VALUES (10, '2026_03_07_183039_create_transaksi_table', 2);
INSERT INTO `migrations` VALUES (11, '2026_03_12_090312_add_stok_histori_to_transaksi_table', 3);
INSERT INTO `migrations` VALUES (12, '2026_03_14_155458_create_peminjaman_table', 4);
INSERT INTO `migrations` VALUES (13, '2026_03_14_162713_create_peminjaman_table', 5);
INSERT INTO `migrations` VALUES (14, '2026_03_15_170258_add_departemen_to_aset_table', 6);
INSERT INTO `migrations` VALUES (15, '2026_03_15_170552_add_departemen_lokasi_to_peminjaman_table', 6);
INSERT INTO `migrations` VALUES (16, '2026_03_15_171056_add_departemen_to_aset_table', 7);
INSERT INTO `migrations` VALUES (17, '2026_03_15_171137_add_departemen_lokasi_to_peminjaman_table', 7);
INSERT INTO `migrations` VALUES (18, '2026_03_15_183319_create_pengembalian_table', 8);
INSERT INTO `migrations` VALUES (19, '2026_03_17_103731_add_grade_barang_to_aset_table', 9);
INSERT INTO `migrations` VALUES (20, '2026_03_27_163924_add_pt_user_to_peminjaman_table', 10);
INSERT INTO `migrations` VALUES (21, '2026_03_30_075051_add_bukti_transaksi_to_transaksi_table', 11);
INSERT INTO `migrations` VALUES (22, '2026_04_07_095438_add_soft_delete_to_aset_table', 12);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for peminjaman
-- ----------------------------
DROP TABLE IF EXISTS `peminjaman`;
CREATE TABLE `peminjaman`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_peminjaman` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_aset` bigint UNSIGNED NOT NULL,
  `user_aset` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pt_user` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `departemen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `foto_peminjaman` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan','permanen') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dipinjam',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `peminjaman_kode_peminjaman_unique`(`kode_peminjaman` ASC) USING BTREE,
  INDEX `peminjaman_id_aset_foreign`(`id_aset` ASC) USING BTREE,
  CONSTRAINT `peminjaman_id_aset_foreign` FOREIGN KEY (`id_aset`) REFERENCES `aset` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of peminjaman
-- ----------------------------
INSERT INTO `peminjaman` VALUES (3, 'PJ202603140001', 2, 'Yono Basri', 'PT Nawa Sena Utama', NULL, NULL, '2026-03-15', 'peminjaman/ZnWZMYKxBdhXLPFE2lwy8GJtypic9r00MeEBhHDU.png', 'dikembalikan', '2026-03-14 18:02:01', '2026-03-16 19:00:48');
INSERT INTO `peminjaman` VALUES (5, 'PJ202603150004', 6, 'Mank Edi', 'PT Nawa Sena Utama', 'Perkebunan', 'Kantor Pusat', '2026-03-16', 'peminjaman/P6VhrsC9hGCpKBoNiEsq26s9Tdav0j9V6bML8ZHX.png', 'dikembalikan', '2026-03-15 18:05:20', '2026-03-16 19:09:01');
INSERT INTO `peminjaman` VALUES (8, 'PJ202603150006', 3, 'Mamat', 'PT Nawa Sena Utama', 'MBG', 'Banten', '2026-03-16', 'peminjaman/USTHcUKTYhKSPBbMZSVcUOVTKws84aBPG4F1hQ4S.png', 'permanen', '2026-03-15 19:13:11', '2026-03-15 19:13:11');
INSERT INTO `peminjaman` VALUES (9, 'PJ202603160009', 1, 'Tarjo', 'PT Nawa Sena Utama', 'Developer', 'Rumah Dev', '2026-03-16', 'peminjaman/B2Vsh1KxY0rvS5jlDblO2PFN3LMMxUmbyM3ROFdY.png', 'dikembalikan', '2026-03-16 16:58:13', '2026-03-16 18:38:30');
INSERT INTO `peminjaman` VALUES (10, 'PJ202603160010', 7, 'Tarno', 'PT Nawa Sena Utama', 'Admin', 'Gedung KMZ', '2026-03-17', 'peminjaman/5jDRGtCSZ7XYqVBoUSAzcpXen74pAygTnJPf4pZZ.png', 'dipinjam', '2026-03-16 18:44:09', '2026-03-16 18:44:09');
INSERT INTO `peminjaman` VALUES (11, 'PJ202603270011', 1, 'Udin', 'PT Nawa Sena Utama', 'Pertamanan', 'Cibitung', '2026-03-27', 'peminjaman/gvOyjXlw7fbnKNUJuqUFeuytcgMyFWFHwegTbJ4t.png', 'dikembalikan', '2026-03-27 16:35:26', '2026-03-27 17:23:39');
INSERT INTO `peminjaman` VALUES (12, 'PJ202603270012', 2, 'Acong', 'PT Nawa Sena Utama', 'Admin', 'Bandung', '2026-03-28', 'peminjaman/J5B53ocQH1LkKYhywu5jJZBEIHH5JtcbPKlaZKNz.png', 'dikembalikan', '2026-03-27 17:20:50', '2026-04-07 09:23:05');
INSERT INTO `peminjaman` VALUES (13, 'PJ202603280013', 6, 'Abdoel bin smith', 'PT Singa Raja', 'Industri', 'Amerika', '2026-03-30', 'peminjaman/qxHB3927X2e989tfnlH6sk2aI2jl7vrtu1nBxxoz.pdf', 'dipinjam', '2026-03-28 10:38:45', '2026-03-28 10:38:45');
INSERT INTO `peminjaman` VALUES (14, 'PJ202603280014', 11, 'AB', 'PT Global Sekuriti Indonesia', 'Developer', 'Bandung', '2026-03-28', 'peminjaman/MmoZfx4D5NlgvcpJJVOnYA1KaLKfMf4qxgY3S0ed.png', 'permanen', '2026-03-28 11:08:17', '2026-03-28 11:08:17');
INSERT INTO `peminjaman` VALUES (15, 'PJ202603280015', 12, 'Bimo', 'PT Sinar Perdana Teknologi', 'Admin', 'Yogyakarta', '2026-03-24', 'peminjaman/hAfhy6hcze8F8XOAJXk95EjOUWZwm3p9nyKR9bVh.pdf', 'dikembalikan', '2026-03-28 11:09:33', '2026-04-07 09:13:37');
INSERT INTO `peminjaman` VALUES (16, 'PJ202603280016', 10, 'Anto', 'PT Mitrel Berkat Utama', 'Dinas Luar', 'Tangerang', '2026-03-28', 'peminjaman/hYIBgYQy4rvomFxYJ75jXqYN341ppT87dMv6jott.png', 'dipinjam', '2026-03-28 11:10:13', '2026-03-28 11:10:13');
INSERT INTO `peminjaman` VALUES (17, 'PJ202603280017', 61, 'Inem', 'PT Babon Kunciran', 'Admin', 'Jakarta Pusat', '2026-03-31', 'peminjaman/W9zaDh8bh8E6akYi1OyCt7273DluC9GKZXqME9gJ.jpg', 'dikembalikan', '2026-03-28 18:32:46', '2026-03-28 18:34:22');
INSERT INTO `peminjaman` VALUES (18, 'PJ202604070018', 9, 'Jarot', 'PT Bumi Hardana Sakti', 'Gudang', 'Gudang', '2026-04-07', 'peminjaman/7etlic7f0exkFyzUxSuger5lteRa9LSfLGLPRh66.png', 'dipinjam', '2026-04-07 07:44:39', '2026-04-07 07:44:39');
INSERT INTO `peminjaman` VALUES (19, 'PJ202604070019', 14, 'Jimmy', 'PT Cipta Arta Hadikara', 'Gudang', 'Gudang', '2026-04-08', 'peminjaman/sZYK3778manaQ4W3AxVm9qVJcnItg087bZCjDiou.pdf', 'dikembalikan', '2026-04-07 07:45:42', '2026-04-08 04:33:14');
INSERT INTO `peminjaman` VALUES (20, 'PJ202604070020', 13, 'Gogon', 'PT Mulia Indonesia Muda', 'Pertanian', 'Karawang', '2026-04-07', 'peminjaman/1775549997_PJ202604070020.jpg', 'permanen', '2026-04-07 08:19:57', '2026-04-07 08:19:57');
INSERT INTO `peminjaman` VALUES (21, 'PJ202604070021', 17, 'Puyol', 'PT Sinar Perdana Teknologi', 'Pertanian', 'Karawang', '2026-04-08', 'peminjaman/PJ_20260407_PJ202604070021.jpg', 'dipinjam', '2026-04-07 09:05:40', '2026-04-07 09:05:40');
INSERT INTO `peminjaman` VALUES (22, 'PJ202604070022', 24, 'Yayan', 'PT Kawan Usaha Sejahtera', 'Admin', 'Kantor Pusat', '2026-04-13', 'peminjaman/20260407_PJ202604070022.pdf', 'dipinjam', '2026-04-07 09:24:34', '2026-04-07 09:24:34');
INSERT INTO `peminjaman` VALUES (23, 'PJ202604070023', 61, 'Aan', 'PT Angin Ribut', 'Kehutanan', 'Palembang', '2026-04-08', 'peminjaman/20260407_PJ202604070023.pdf', 'dikembalikan', '2026-04-07 12:13:51', '2026-04-07 12:14:29');
INSERT INTO `peminjaman` VALUES (24, 'PJ202604070024', 1, 'Aban', 'PT Cipta Arta Hadikara', 'Pro Player', 'Rawa Belong', '2026-04-07', 'peminjaman/20260407_PJ202604070024.png', 'dipinjam', '2026-04-07 12:35:57', '2026-04-07 12:35:57');
INSERT INTO `peminjaman` VALUES (25, 'PJ202604070025', 61, 'Aban', 'PT Global Sekuriti Indonesia', 'Pro Player', 'Rawa Belong', '2026-04-07', NULL, 'dikembalikan', '2026-04-07 13:23:01', '2026-04-07 13:23:29');
INSERT INTO `peminjaman` VALUES (26, 'PJ202604080026', 61, 'Aban', 'PT Dapur Pulau Rasa', 'Pro Player', 'Palembang', '2026-04-08', NULL, 'dipinjam', '2026-04-08 01:56:31', '2026-04-08 01:56:31');
INSERT INTO `peminjaman` VALUES (27, 'PJ202604080027', 12, 'Toyo', 'PT Global Sekuriti Indonesia', 'Pro Player', 'Palembang', '2026-04-08', 'peminjaman/20260408_PJ202604080027.png', 'dikembalikan', '2026-04-08 01:57:45', '2026-04-08 02:15:59');
INSERT INTO `peminjaman` VALUES (28, 'PJ202604080028', 22, 'Toyo', 'PT Sinar Digital Teknologi', 'Pro Player', 'Rawa Belong', '2026-04-13', 'peminjaman/20260408_PJ202604080028.pdf', 'dipinjam', '2026-04-08 02:23:14', '2026-04-08 02:23:14');
INSERT INTO `peminjaman` VALUES (29, 'PJ202604080029', 64, 'Yanto', 'PT Dapur Pulau Rasa', 'Pro Player', 'Kantor Pusat', '2026-04-13', 'peminjaman/20260408_PJ202604080029.png', 'dikembalikan', '2026-04-08 08:21:36', '2026-04-08 08:24:18');
INSERT INTO `peminjaman` VALUES (30, 'PJ202604080030', 15, 'Aban', 'PT Bumi Hardana Sakti', 'Pro Player', 'Rawa Belong', '2026-04-08', NULL, 'dipinjam', '2026-04-08 08:27:58', '2026-04-08 08:27:58');

-- ----------------------------
-- Table structure for pengembalian
-- ----------------------------
DROP TABLE IF EXISTS `pengembalian`;
CREATE TABLE `pengembalian`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_peminjaman` bigint UNSIGNED NOT NULL,
  `kode_pengembalian` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `foto_pengembalian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kondisi_pengembalian` enum('baik','rusak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baik',
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `pengembalian_kode_pengembalian_unique`(`kode_pengembalian` ASC) USING BTREE,
  INDEX `pengembalian_id_peminjaman_foreign`(`id_peminjaman` ASC) USING BTREE,
  CONSTRAINT `pengembalian_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pengembalian
-- ----------------------------
INSERT INTO `pengembalian` VALUES (11, 9, 'KMB20260316001', '2026-03-17', 'pengembalian/dFLam2e0sdO3ywl9RrBt0iXF27OO2ErzlePLZc6q.pdf', 'baik', 'Kondisi normal', '2026-03-16 18:38:30', '2026-03-16 18:38:30');
INSERT INTO `pengembalian` VALUES (24, 3, 'KMB20260316002', '2026-03-17', 'pengembalian/Ur7LDjIxLSm2rTssFyVKH8Fbj2p7kQzpPrGAa1jI.png', 'baik', 'Normal ya', '2026-03-16 19:00:48', '2026-03-16 19:00:48');
INSERT INTO `pengembalian` VALUES (25, 5, 'KMB20260316003', '2026-03-21', 'pengembalian/sq9z8gPtlwtGQ4fOwpZgMOmnLpfqMkfFcxGJP9qO.png', 'baik', NULL, '2026-03-16 19:09:01', '2026-03-16 19:09:01');
INSERT INTO `pengembalian` VALUES (26, 11, 'KMB20260327001', '2026-03-31', 'pengembalian/BkKCTcY4HbCmdOUD6VFUDfdeqbdXzLhmLRioG7X6.png', 'rusak', 'Ada garis hitam di sisi bawah layar', '2026-03-27 17:23:39', '2026-03-27 17:23:39');
INSERT INTO `pengembalian` VALUES (27, 17, 'KMB20260328001', '2026-04-01', 'pengembalian/Ifu6X0A09FyOJglYJNPdV7DxrsDEcMQUdw9Qz4wZ.jpg', 'baik', 'Aman', '2026-03-28 18:34:22', '2026-03-28 18:34:22');
INSERT INTO `pengembalian` VALUES (28, 15, 'KMB20260407001', '2026-04-07', 'pengembalian/20260407_KMB20260407001.jpg', 'baik', 'Dengan charger, flashdisk, dan kabel data', '2026-04-07 09:13:37', '2026-04-07 09:13:37');
INSERT INTO `pengembalian` VALUES (29, 12, 'KMB20260407002', '2026-04-07', 'pengembalian/20260407_KMB20260407002.pdf', 'baik', NULL, '2026-04-07 09:23:05', '2026-04-07 09:23:05');
INSERT INTO `pengembalian` VALUES (30, 23, 'KMB20260407003', '2026-04-14', 'pengembalian/20260407_KMB20260407003.png', 'baik', 'Oke Aman', '2026-04-07 12:14:29', '2026-04-07 12:14:29');
INSERT INTO `pengembalian` VALUES (31, 25, 'KMB20260407004', '2026-04-09', 'pengembalian/20260407_KMB20260407004.png', 'rusak', NULL, '2026-04-07 13:23:29', '2026-04-07 13:23:29');
INSERT INTO `pengembalian` VALUES (32, 27, 'KMB20260408001', '2026-04-01', NULL, 'baik', 'A', '2026-04-08 02:15:59', '2026-04-08 02:15:59');
INSERT INTO `pengembalian` VALUES (33, 19, 'KMB20260408002', '2026-04-08', 'pengembalian/20260408_KMB20260408002.png', 'rusak', 'Rusak pada layar retak', '2026-04-08 04:33:14', '2026-04-08 04:33:14');
INSERT INTO `pengembalian` VALUES (34, 29, 'KMB20260408003', '2026-04-27', 'pengembalian/20260408_KMB20260408003.png', 'baik', 'Barang aman', '2026-04-08 08:24:18', '2026-04-08 08:24:18');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `all` tinyint(1) NOT NULL DEFAULT 0,
  `tambah` tinyint(1) NOT NULL DEFAULT 0,
  `ubah` tinyint(1) NOT NULL DEFAULT 0,
  `hapus` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'admin', 'User', 1, 1, 1, 1, '2026-03-24 15:36:29', '2026-03-24 15:36:29');
INSERT INTO `permissions` VALUES (2, 'admin', 'Inventori', 1, 1, 1, 1, '2026-03-24 15:36:29', '2026-03-24 15:36:29');
INSERT INTO `permissions` VALUES (3, 'admin', 'Peminjaman', 1, 1, 1, 1, '2026-03-24 15:36:29', '2026-03-24 15:36:29');
INSERT INTO `permissions` VALUES (4, 'admin', 'Pengembalian', 1, 1, 1, 1, '2026-03-24 15:36:29', '2026-03-28 10:56:14');
INSERT INTO `permissions` VALUES (5, 'admin', 'Report Peminjaman Pengembalian', 1, 1, 1, 1, '2026-03-24 15:36:29', '2026-03-27 06:38:02');
INSERT INTO `permissions` VALUES (6, 'admin', 'Stok', 1, 1, 1, 1, '2026-03-24 15:36:29', '2026-03-24 15:36:29');
INSERT INTO `permissions` VALUES (7, 'admin', 'Transaksi', 1, 1, 1, 1, '2026-03-24 15:36:29', '2026-03-24 15:36:29');
INSERT INTO `permissions` VALUES (8, 'admin', 'Report Transaksi', 1, 1, 1, 1, '2026-03-24 15:36:29', '2026-03-24 15:36:29');
INSERT INTO `permissions` VALUES (9, 'user', 'User', 0, 0, 0, 0, '2026-03-24 15:36:29', '2026-03-27 06:31:13');
INSERT INTO `permissions` VALUES (10, 'user', 'Inventori', 1, 0, 0, 0, '2026-03-24 15:36:29', '2026-04-08 08:14:13');
INSERT INTO `permissions` VALUES (11, 'user', 'Peminjaman', 1, 0, 0, 0, '2026-03-24 15:36:29', '2026-04-08 08:14:12');
INSERT INTO `permissions` VALUES (12, 'user', 'Pengembalian', 1, 0, 0, 0, '2026-03-24 15:36:29', '2026-04-08 08:14:11');
INSERT INTO `permissions` VALUES (13, 'user', 'Report Peminjaman Pengembalian', 1, 0, 0, 0, '2026-03-24 15:36:29', '2026-04-08 08:14:11');
INSERT INTO `permissions` VALUES (14, 'user', 'Stok', 1, 0, 0, 0, '2026-03-24 15:36:29', '2026-03-24 15:36:29');
INSERT INTO `permissions` VALUES (15, 'user', 'Transaksi', 1, 0, 0, 0, '2026-03-24 15:36:29', '2026-04-08 08:13:59');
INSERT INTO `permissions` VALUES (16, 'user', 'Report Transaksi', 1, 0, 0, 0, '2026-03-24 15:36:29', '2026-04-08 08:14:00');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('GGPLgW8YwoeurzvevHYzkryhLqDpl5vjmcmnH7HQ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiN1lSRWZCQTBMb1A2S0pPMGU0Sk55emJVZElQWEVWMVMwTHR6Qlp2ZSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjcwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvLndlbGwta25vd24vYXBwc3BlY2lmaWMvY29tLmNocm9tZS5kZXZ0b29scy5qc29uIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1775815315);

-- ----------------------------
-- Table structure for stok_barang
-- ----------------------------
DROP TABLE IF EXISTS `stok_barang`;
CREATE TABLE `stok_barang`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `pt_pembeban` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_satuan` decimal(15, 2) NOT NULL,
  `harga_total` decimal(15, 2) NOT NULL,
  `stok_saat_ini` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `stok_barang_kode_barang_unique`(`kode_barang` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of stok_barang
-- ----------------------------
INSERT INTO `stok_barang` VALUES (1, 'BRG-001', 'Flashdisk Lexar 64GB', '2026-06-20', 'PT Global Sekuriti Indonesia', 'Pcs', 250000.00, 2250000.00, 3, '2026-03-07 19:17:43', '2026-04-09 09:44:28');
INSERT INTO `stok_barang` VALUES (4, 'BRG-0002', 'Flashdisk Lexar 32GB', '2026-06-20', 'PT Kawan Usaha Sejahtera', 'Pcs', 100000.00, 1000000.00, 8, '2026-03-10 14:50:28', '2026-04-01 07:46:47');
INSERT INTO `stok_barang` VALUES (5, 'BRG-0005', 'Flashdisk Lexar 128GB', '2026-06-16', 'PT Kawan Usaha Sejahtera', 'Pcs', 250000.00, 1000000.00, 0, '2026-03-10 14:56:30', '2026-04-10 02:11:33');
INSERT INTO `stok_barang` VALUES (6, 'BRG-0006', 'Toner TN 451', '2026-03-06', 'PT Dwireka Cakra Buana', 'Box', 1200000.00, 4800000.00, 5, '2026-03-10 14:58:16', '2026-03-13 04:39:08');
INSERT INTO `stok_barang` VALUES (9, 'BRG-0009', 'Gelas', '2026-03-28', 'PT Dapur Pulau Rasa', 'Pieces', 5000.00, 50000.00, 5, '2026-03-28 16:26:08', '2026-04-10 10:01:52');
INSERT INTO `stok_barang` VALUES (10, 'BRG-0010', 'Toner A03', '2026-04-08', 'PT Nawa Sena Utama', 'Pieces', 800000.00, 3200000.00, 0, '2026-04-08 08:25:52', '2026-04-09 09:35:15');
INSERT INTO `stok_barang` VALUES (11, 'BRG-0011', 'Toner A04', '2026-04-09', 'PT Armindo Langgeng Sejahtera', 'Unit', 200000.00, 1000000.00, 1, '2026-04-09 09:48:43', '2026-04-10 02:12:18');

-- ----------------------------
-- Table structure for transaksi
-- ----------------------------
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok_barang_id` bigint UNSIGNED NOT NULL,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `departemen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `stok_awal` int NULL DEFAULT NULL,
  `stok_akhir` int NULL DEFAULT NULL,
  `status` enum('dipinjamkan','dibatalkan','diberikan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_transaksi` timestamp NOT NULL DEFAULT current_timestamp,
  `bukti_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `transaksi_kode_transaksi_unique`(`kode_transaksi` ASC) USING BTREE,
  INDEX `transaksi_stok_barang_id_foreign`(`stok_barang_id` ASC) USING BTREE,
  CONSTRAINT `transaksi_stok_barang_id_foreign` FOREIGN KEY (`stok_barang_id`) REFERENCES `stok_barang` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of transaksi
-- ----------------------------
INSERT INTO `transaksi` VALUES (9, 'TR202603130001', 5, 'Parjo', 'Keuangan', 1, 1, 0, 'diberikan', '2026-03-11 00:00:00', NULL, '2026-03-13 03:40:41', '2026-04-10 02:11:33');
INSERT INTO `transaksi` VALUES (11, 'TR202603130010', 1, 'Rudi', 'Kontraktor', 5, 10, 5, 'diberikan', '2026-03-13 00:00:00', NULL, '2026-03-13 04:29:05', '2026-03-13 04:29:52');
INSERT INTO `transaksi` VALUES (12, 'TR202603130012', 6, 'Parman', 'Admin', 1, 5, 5, 'dibatalkan', '2026-03-10 00:00:00', NULL, '2026-03-13 04:38:42', '2026-03-13 04:39:08');
INSERT INTO `transaksi` VALUES (13, 'TR202603140013', 5, 'Agung', 'Pertanian', 3, 4, 1, 'dipinjamkan', '2026-03-14 00:00:00', NULL, '2026-03-14 15:04:17', '2026-03-14 15:04:17');
INSERT INTO `transaksi` VALUES (14, 'TR202603300014', 4, 'Yanto', 'Keuangan', 2, 10, 8, 'dipinjamkan', '2026-03-30 00:00:00', 'bukti_transaksi/H0mp7PuumKYSSjrH6vXng0KBeGtHbrcgAOFk3cG4.png', '2026-03-30 09:07:29', '2026-04-01 07:46:48');
INSERT INTO `transaksi` VALUES (15, 'TR202603300015', 4, 'Badrul', 'Sekretaris', 2, 10, 8, 'dipinjamkan', '2026-03-30 00:00:00', 'bukti_transaksi/gZ0ClHkXEXH7EuYUp0ZCKNsDLF0Y80o6dH7vgBPj.pdf', '2026-03-30 09:12:33', '2026-03-30 10:08:07');
INSERT INTO `transaksi` VALUES (16, 'TR202604010016', 5, 'Hendro', 'Perkebunan', 1, 1, 0, 'dipinjamkan', '2026-04-01 00:00:00', 'bukti_transaksi/Q6dZUb02xMTK2V1Ec06lcwqep3znHdh7dndMubiI.png', '2026-04-01 09:18:39', '2026-04-01 09:19:09');
INSERT INTO `transaksi` VALUES (21, 'TR202604090017', 11, 'Budi', 'Pro Player', 3, 5, 2, 'dipinjamkan', '2026-04-09 00:00:00', NULL, '2026-04-09 09:49:17', '2026-04-09 09:49:17');
INSERT INTO `transaksi` VALUES (22, 'TR202604100022', 11, 'User A', 'Admin', 1, 2, 1, 'dipinjamkan', '2026-04-10 00:00:00', 'bukti_transaksi/20260410_TR202604100022.png', '2026-04-10 02:12:17', '2026-04-10 02:12:17');
INSERT INTO `transaksi` VALUES (32, 'TR202604100023', 9, 'Usman', 'Kecamatan Bikini Bottom', 5, 10, 5, 'dipinjamkan', '2026-04-10 00:00:00', NULL, '2026-04-10 09:28:58', '2026-04-10 09:42:07');
INSERT INTO `transaksi` VALUES (33, 'TR202604100033', 9, 'Udin', 'Kecamatan Bikini Bottom', 5, 5, 5, 'dibatalkan', '2026-04-10 00:00:00', 'bukti_transaksi/20260410_TR202604100033.pdf', '2026-04-10 09:42:26', '2026-04-10 10:01:52');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Tarjo', 'admin@gmail.com', NULL, '$2y$12$SYAGXR6dzn2zbq3KCjkI4O/ow4r.tHXkv0deWLIjDNy2voHdKcoyG', NULL, NULL, NULL, 'admin', 'Asg1C804e6My36hmn6YffSRG4RdhoHKAE5FWws5nogqNznlweHXmjQ1ia1Nq', '2026-03-07 02:05:03', '2026-03-07 02:05:03');
INSERT INTO `users` VALUES (33, 'Patricia Utami', 'sitompul.uchita@example.net', '2026-03-27 15:50:36', '$2y$12$m0Tn4cM4Qk1NAVf0vYq9W.wv4Qkrp.c/GShisziUElmvi.VMZvyri', NULL, NULL, NULL, 'user', 'WdMBgecwNS', '2026-03-27 15:50:36', '2026-03-27 15:50:36');
INSERT INTO `users` VALUES (34, 'Asirwanda Wahyudin', 'farah.hariyah@example.com', '2026-03-27 15:50:36', '$2y$12$m0Tn4cM4Qk1NAVf0vYq9W.wv4Qkrp.c/GShisziUElmvi.VMZvyri', NULL, NULL, NULL, 'user', 'jBi959gYFh', '2026-03-27 15:50:36', '2026-03-27 15:50:36');
INSERT INTO `users` VALUES (35, 'Safina Suartini', 'ibrani58@example.net', '2026-03-27 15:50:36', '$2y$12$m0Tn4cM4Qk1NAVf0vYq9W.wv4Qkrp.c/GShisziUElmvi.VMZvyri', NULL, NULL, NULL, 'user', 'z2JIwVvVqw', '2026-03-27 15:50:36', '2026-03-27 15:50:36');
INSERT INTO `users` VALUES (36, 'Tomi Langgeng Suryono M.Ak', 'bbudiman@example.org', '2026-03-27 15:50:36', '$2y$12$m0Tn4cM4Qk1NAVf0vYq9W.wv4Qkrp.c/GShisziUElmvi.VMZvyri', NULL, NULL, NULL, 'user', 'bjHDqHpBLp', '2026-03-27 15:50:36', '2026-03-27 15:50:36');
INSERT INTO `users` VALUES (37, 'Juli Purwanti', 'lamar.agustina@example.net', '2026-03-27 15:50:36', '$2y$12$m0Tn4cM4Qk1NAVf0vYq9W.wv4Qkrp.c/GShisziUElmvi.VMZvyri', NULL, NULL, NULL, 'user', 'OIUWUQHlC8', '2026-03-27 15:50:36', '2026-03-27 15:50:36');
INSERT INTO `users` VALUES (38, 'Perkasa Kuswoyo', 'cahyanto.hardiansyah@example.net', '2026-03-27 15:50:36', '$2y$12$m0Tn4cM4Qk1NAVf0vYq9W.wv4Qkrp.c/GShisziUElmvi.VMZvyri', NULL, NULL, NULL, 'user', 'JiMtz4ahuC', '2026-03-27 15:50:36', '2026-03-27 15:50:36');
INSERT INTO `users` VALUES (39, 'Tomi Sirait', 'almira40@example.net', '2026-03-27 15:50:36', '$2y$12$m0Tn4cM4Qk1NAVf0vYq9W.wv4Qkrp.c/GShisziUElmvi.VMZvyri', NULL, NULL, NULL, 'user', 'KKfaRbIBmz', '2026-03-27 15:50:36', '2026-03-27 15:50:36');
INSERT INTO `users` VALUES (40, 'Karja Wibisono S.IP', 'simbolon.hana@example.net', '2026-03-27 15:50:36', '$2y$12$m0Tn4cM4Qk1NAVf0vYq9W.wv4Qkrp.c/GShisziUElmvi.VMZvyri', NULL, NULL, NULL, 'user', '4Xyjs70aBj', '2026-03-27 15:50:36', '2026-03-27 15:50:36');
INSERT INTO `users` VALUES (41, 'Zalindra Prastuti', 'syahrini46@example.org', '2026-03-27 15:50:36', '$2y$12$m0Tn4cM4Qk1NAVf0vYq9W.wv4Qkrp.c/GShisziUElmvi.VMZvyri', NULL, NULL, NULL, 'user', 'pj7LjuNsHa', '2026-03-27 15:50:36', '2026-03-27 15:50:36');
INSERT INTO `users` VALUES (42, 'Nalar Hutagalung', 'marsito.irawan@example.net', '2026-03-27 15:50:36', '$2y$12$.BeP2ERzBdDzhZo5Ujz0FemBD4HyBwjmiCj0JEf3hITMZ1gE3j3am', NULL, NULL, NULL, 'user', 'BlgNUTRtsCCFnwPuoHPZIwSCEWfOc7anKxBaqR1VqSghMm5yF0S8lsfZoYrD', '2026-03-27 15:50:36', '2026-04-08 08:13:31');

SET FOREIGN_KEY_CHECKS = 1;
