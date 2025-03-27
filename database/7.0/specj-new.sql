/*
 Navicat Premium Dump SQL

 Source Server         : miste_ry
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : specj-new

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 27/03/2025 20:39:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for branding
-- ----------------------------
DROP TABLE IF EXISTS `branding`;
CREATE TABLE `branding`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of branding
-- ----------------------------
INSERT INTO `branding` VALUES (1, 'asd');
INSERT INTO `branding` VALUES (2, 'asdf');
INSERT INTO `branding` VALUES (3, 'Robotics');
INSERT INTO `branding` VALUES (4, 'Study');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES (1, 'ad');
INSERT INTO `category` VALUES (2, 'asdg');

-- ----------------------------
-- Table structure for motorcycle_services
-- ----------------------------
DROP TABLE IF EXISTS `motorcycle_services`;
CREATE TABLE `motorcycle_services`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `service_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Motorcycle',
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp,
  `archive` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of motorcycle_services
-- ----------------------------
INSERT INTO `motorcycle_services` VALUES (1, 'Change Break', 'Motorcycle', 'brake-service', 2222.00, '2024-12-20 11:21:36', '0');
INSERT INTO `motorcycle_services` VALUES (2, 'Tire Change', 'Motorcycle', 'tire-change', 22.00, '2024-12-20 11:24:59', '0');
INSERT INTO `motorcycle_services` VALUES (3, 'change oil', 'Motorcycle', 'oil-change', 100.00, '2025-03-12 20:03:33', '0');

-- ----------------------------
-- Table structure for parts_registration
-- ----------------------------
DROP TABLE IF EXISTS `parts_registration`;
CREATE TABLE `parts_registration`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `parts_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `services_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `parts_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_expired` date NOT NULL,
  `category` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `manufacturer` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  `quantity_stock` int NOT NULL,
  `unit` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `condition` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `archive` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `reorder_point` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `received_date` datetime NULL DEFAULT NULL,
  `batch_number` int NULL DEFAULT NULL,
  `status` enum('available','depleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'available',
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of parts_registration
-- ----------------------------

-- ----------------------------
-- Table structure for parts_registrations
-- ----------------------------
DROP TABLE IF EXISTS `parts_registrations`;
CREATE TABLE `parts_registrations`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `parts_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `batch_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `manufacturer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `services_type` enum('Car','Motorcycle') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'images/default-placeholder.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `parts_name`(`parts_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of parts_registrations
-- ----------------------------
INSERT INTO `parts_registrations` VALUES (1, 'motordriver', 'MOT-6707', 'BATCH-250319-C6C', 'Robotics', 'asdg', 'Motorcycle', 'FOR ROBOTICS PURPOSES', 'uploads/IMG_67da60bb570ea6.94245475.webp', '2025-03-19 14:14:19');
INSERT INTO `parts_registrations` VALUES (2, 'nodemcu', 'NOD-6962', 'BATCH-250319-469', 'Robotics', 'asdg', 'Motorcycle', 'FOR ROBOTICS PURPOSES', 'uploads/IMG_67da615bf0fb29.30981146.webp', '2025-03-19 14:16:59');
INSERT INTO `parts_registrations` VALUES (3, 'calculator', 'CAL-7752', 'BATCH-250327-1C8', 'Study', 'asdg', 'Motorcycle', 'FOR ROBOTICS PURPOSES', 'uploads/IMG_67e54013d90666.53349641.jpg', '2025-03-27 20:09:55');

-- ----------------------------
-- Table structure for product_logs
-- ----------------------------
DROP TABLE IF EXISTS `product_logs`;
CREATE TABLE `product_logs`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `parts_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `parts_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quantity_stock` int NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `action` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_inserted` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_logs
-- ----------------------------
INSERT INTO `product_logs` VALUES (1, 'luffy', '1231222', 222, 'New', 'registration', '2024-12-20 10:27:03');
INSERT INTO `product_logs` VALUES (2, 'planets', '2', 22, 'Replacement', 'registration', '2024-12-20 10:35:59');
INSERT INTO `product_logs` VALUES (3, 'asd', 'asd', 2, 'New', 'registration', '2024-12-20 11:53:29');
INSERT INTO `product_logs` VALUES (4, 'Sparkplug', '109-2333-2024', 100, 'New', 'registration', '2025-01-10 20:27:05');
INSERT INTO `product_logs` VALUES (5, 'Motolite battery 12 volts', '93745', 6, 'New', 'registration', '2025-03-12 19:58:33');
INSERT INTO `product_logs` VALUES (6, 'sample', '123123', 123, 'New', 'registration', '2025-03-15 22:02:36');

-- ----------------------------
-- Table structure for product_transaction
-- ----------------------------
DROP TABLE IF EXISTS `product_transaction`;
CREATE TABLE `product_transaction`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NULL DEFAULT NULL,
  `product_id` int NULL DEFAULT NULL,
  `quantity` int NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `service_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_transaction
-- ----------------------------
INSERT INTO `product_transaction` VALUES (1, 16, 1, NULL, NULL, NULL);
INSERT INTO `product_transaction` VALUES (2, 17, 1, NULL, NULL, NULL);
INSERT INTO `product_transaction` VALUES (3, 17, 1, NULL, NULL, NULL);
INSERT INTO `product_transaction` VALUES (4, 17, 1, NULL, NULL, NULL);
INSERT INTO `product_transaction` VALUES (5, 18, 1, NULL, NULL, NULL);
INSERT INTO `product_transaction` VALUES (6, 18, 1, NULL, NULL, NULL);
INSERT INTO `product_transaction` VALUES (7, 19, 1, NULL, NULL, NULL);
INSERT INTO `product_transaction` VALUES (8, 20, 2, 3, NULL, NULL);
INSERT INTO `product_transaction` VALUES (9, 21, 4, 1, NULL, NULL);
INSERT INTO `product_transaction` VALUES (10, 21, 3, 1, 'Released', NULL);
INSERT INTO `product_transaction` VALUES (11, 21, 2, 10, 'Released', NULL);
INSERT INTO `product_transaction` VALUES (15, 24, 2, 1, NULL, NULL);
INSERT INTO `product_transaction` VALUES (16, 25, 3, 2, NULL, NULL);
INSERT INTO `product_transaction` VALUES (17, 26, 2, 10, NULL, NULL);
INSERT INTO `product_transaction` VALUES (18, 27, 5, 1, 'Released', NULL);
INSERT INTO `product_transaction` VALUES (19, 29, 2, 1, 'Released', NULL);
INSERT INTO `product_transaction` VALUES (20, 38, 6, 1, 'Released', NULL);
INSERT INTO `product_transaction` VALUES (21, 39, 6, 1, 'Scheduled', NULL);
INSERT INTO `product_transaction` VALUES (22, 40, 6, 2, 'Scheduled', NULL);

-- ----------------------------
-- Table structure for services_transaction
-- ----------------------------
DROP TABLE IF EXISTS `services_transaction`;
CREATE TABLE `services_transaction`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NULL DEFAULT NULL,
  `service_id` int NULL DEFAULT NULL,
  `set_schedule` date NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of services_transaction
-- ----------------------------
INSERT INTO `services_transaction` VALUES (1, 1, 1, NULL, NULL);
INSERT INTO `services_transaction` VALUES (2, 1, 2, NULL, NULL);
INSERT INTO `services_transaction` VALUES (3, 2, 1, NULL, NULL);
INSERT INTO `services_transaction` VALUES (4, 3, 1, NULL, NULL);
INSERT INTO `services_transaction` VALUES (5, 8, 1, NULL, NULL);
INSERT INTO `services_transaction` VALUES (6, 8, 2, NULL, NULL);
INSERT INTO `services_transaction` VALUES (7, 10, 1, NULL, NULL);
INSERT INTO `services_transaction` VALUES (8, 11, 1, '2024-12-26', 'Scheduled');
INSERT INTO `services_transaction` VALUES (9, 11, 1, '2024-12-26', 'Scheduled');
INSERT INTO `services_transaction` VALUES (10, 11, 1, '2024-12-26', 'Scheduled');
INSERT INTO `services_transaction` VALUES (11, 12, 1, NULL, NULL);
INSERT INTO `services_transaction` VALUES (12, 13, 1, NULL, NULL);
INSERT INTO `services_transaction` VALUES (13, 10, 1, NULL, NULL);
INSERT INTO `services_transaction` VALUES (14, 11, 2, '2024-12-27', 'Scheduled');
INSERT INTO `services_transaction` VALUES (15, 11, 1, '2024-12-26', 'Scheduled');
INSERT INTO `services_transaction` VALUES (16, 22, 1, NULL, NULL);
INSERT INTO `services_transaction` VALUES (17, 23, 1, '2025-01-02', NULL);
INSERT INTO `services_transaction` VALUES (18, 23, 2, '2025-01-02', NULL);
INSERT INTO `services_transaction` VALUES (19, 28, 1, '2025-02-07', 'Scheduled');
INSERT INTO `services_transaction` VALUES (20, 30, 2, '2025-03-15', 'Scheduled');
INSERT INTO `services_transaction` VALUES (21, 31, 2, '2025-03-08', 'Scheduled');
INSERT INTO `services_transaction` VALUES (22, 32, 2, NULL, 'Onprocess');
INSERT INTO `services_transaction` VALUES (23, 33, 2, '2025-03-29', 'Completed');
INSERT INTO `services_transaction` VALUES (24, 34, 2, '2025-03-08', 'Scheduled');
INSERT INTO `services_transaction` VALUES (25, 35, 2, '2025-03-09', 'Completed');
INSERT INTO `services_transaction` VALUES (26, 36, 2, '2025-03-12', 'Completed');
INSERT INTO `services_transaction` VALUES (27, 37, 3, '2025-03-13', 'Completed');
INSERT INTO `services_transaction` VALUES (28, 37, 1, '2025-03-13', 'Completed');

-- ----------------------------
-- Table structure for stocks
-- ----------------------------
DROP TABLE IF EXISTS `stocks`;
CREATE TABLE `stocks`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `parts_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `batch_group` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  `unit` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `condition` enum('new','used','refurbished','damaged','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stock` int NOT NULL,
  `reorder_point` int NOT NULL,
  `date_expired` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stocks
-- ----------------------------
INSERT INTO `stocks` VALUES (1, '0', 'asd', 'QOJ-1733801982874-382', 2222.00, 'PCS', 'new', 200, 123, '2025-03-11', '2025-03-19 15:17:30');
INSERT INTO `stocks` VALUES (2, '0', '11100-22223', '1', 100.00, 'PCS', 'new', 200, 2, '2025-03-19', '2025-03-19 15:33:28');
INSERT INTO `stocks` VALUES (3, 'BATCH-25031', 'asd', '3', 2222.00, 'PCS', 'new', 200, 123, '2025-03-11', '2025-03-19 15:34:32');
INSERT INTO `stocks` VALUES (4, 'BATCH-250319-C6C', '11100-22223sd', '1005', 22.00, 'PCS', 'new', 150, 123, '2025-03-20', '2025-03-19 15:35:31');
INSERT INTO `stocks` VALUES (5, 'BATCH-250319-C6C', '11100-22223', '1002', 100.00, 'Kilo', 'used', 200, 4, '2025-03-27', '2025-03-19 15:36:07');
INSERT INTO `stocks` VALUES (6, 'BATCH-250319-C6C', 'asd', '1003', 2222.00, 'PCS', 'new', 200, 123, '2025-03-11', '2025-03-19 15:39:32');
INSERT INTO `stocks` VALUES (7, 'BATCH-250319-C6C', 'asd', '1006', 2222.00, 'Pieces', 'expired', 200, 123, '2025-03-11', '2025-03-19 15:49:45');
INSERT INTO `stocks` VALUES (8, 'BATCH-250319-C6C', 'asd', '1001', 2222.00, 'Liters', 'new', 200, 123, '2025-03-11', '2025-03-19 15:59:23');
INSERT INTO `stocks` VALUES (9, 'BATCH-250319-C6C', 'asd', '1007', 2222.00, 'Kilograms', 'new', 200, 123, '2025-03-11', '2025-03-19 16:02:05');
INSERT INTO `stocks` VALUES (10, 'BATCH-250319-C6C', 'asd', '1008', 2222.00, 'Boxes', 'new', 200, 123, '2025-03-11', '2025-03-19 16:04:18');
INSERT INTO `stocks` VALUES (11, 'BATCH-250319-C6C', 'asd', '1008', 2222.00, 'Boxes', 'new', 200, 123, '2025-03-11', '2025-03-19 16:04:55');
INSERT INTO `stocks` VALUES (12, 'BATCH-250319-C6C', 'asd', '1008', 2222.00, 'Boxes', 'new', 200, 123, '2025-03-11', '2025-03-19 16:05:20');
INSERT INTO `stocks` VALUES (13, 'BATCH-250319-C6C', 'asd', '1009', 123123.00, 'Boxes', 'used', 150, 123, '2025-03-26', '2025-03-19 16:07:03');
INSERT INTO `stocks` VALUES (14, 'BATCH-250319-469', '11100-22223', '1001', 24.00, 'Pieces', 'new', 200, 5, '2025-03-19', '2025-03-19 20:05:49');
INSERT INTO `stocks` VALUES (15, 'BATCH-250327-1C8', '11112', '1001', 500.00, 'Pieces', 'expired', 500, 2, '2025-03-26', '2025-03-27 20:10:58');
INSERT INTO `stocks` VALUES (16, 'BATCH-250327-1C8', '11113', '1002', 450.00, 'Boxes', 'new', 250, 3, '2025-03-29', '2025-03-27 20:17:47');
INSERT INTO `stocks` VALUES (17, 'BATCH-250327-1C8', '233123123', '1003', 2222.00, 'Boxes', 'new', 233, 5, '2025-03-27', '2025-03-27 20:34:56');

-- ----------------------------
-- Table structure for transactions
-- ----------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total_amount` int NULL DEFAULT NULL,
  `type_transaction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `date_completed` datetime NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `transaction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transactions
-- ----------------------------
INSERT INTO `transactions` VALUES (1, 2, 'ray leigh mart', 'escalante', 2, 'Online', '2024-12-26 00:00:00', NULL, NULL, NULL);
INSERT INTO `transactions` VALUES (2, 2, 'ray leigh mart', 'escalante', 2, 'Online', '2024-12-26 00:00:00', NULL, NULL, NULL);
INSERT INTO `transactions` VALUES (3, 2, 'ray leigh mart', 'escalante', 2, 'Online', '2024-12-26 00:00:00', NULL, NULL, NULL);
INSERT INTO `transactions` VALUES (4, 2, 'ray leigh mart', 'escalante', 222, 'Online', '2024-12-26 00:00:00', NULL, NULL, NULL);
INSERT INTO `transactions` VALUES (5, 2, 'ray leigh mart', 'escalante', 1334, 'Online', '2024-12-26 00:00:00', NULL, NULL, NULL);
INSERT INTO `transactions` VALUES (6, 2, 'ray leigh mart', 'escalante', 4, 'Online', '2024-12-26 00:00:00', NULL, NULL, NULL);
INSERT INTO `transactions` VALUES (7, 2, 'ray leigh mart', 'escalante', 4446, 'Online', '2024-12-26 00:00:00', NULL, NULL, NULL);
INSERT INTO `transactions` VALUES (8, 2, 'ray leigh mart', 'escalante', 2, 'Online', '2024-12-26 00:00:00', NULL, NULL, 'product_transaction');
INSERT INTO `transactions` VALUES (9, 2, 'ray leigh mart', 'escalante', 222, 'Online', '2024-12-26 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (10, 2, 'ray leigh mart', 'escalante', 2222, 'Online', '2024-12-26 00:00:00', NULL, NULL, NULL);
INSERT INTO `transactions` VALUES (11, 2, 'ray leigh mart', 'escalante', 2244, 'Online', '2024-12-26 00:00:00', NULL, NULL, 'Services');
INSERT INTO `transactions` VALUES (12, 2, 'ray leigh mart', 'escalante', 222, 'Online', '2024-12-26 00:00:00', NULL, NULL, NULL);
INSERT INTO `transactions` VALUES (13, 2, 'ray leigh mart', 'escalante', 222, 'Online', '2024-12-26 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (14, 2, 'ray leigh mart', 'escalante', 4, 'Online', '2024-12-26 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (15, 2, 'ray leigh mart', 'escalante', 28886, 'Online', '2024-12-26 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (16, 2, 'ray leigh mart', 'escalante', 222, 'Online', '2024-12-26 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (17, 2, 'ray leigh mart', 'escalante', 4668, 'Online', '2024-12-26 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (18, 2, 'ray leigh mart', 'escalante', 4666, 'Online', '2024-12-26 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (19, 2, 'ray leigh mart', 'escalante', 2, 'Online', '2024-12-26 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (20, 2, 'ray leigh mart', 'escalante', 666, 'Online', '2024-12-26 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (21, 2, 'ray leigh mart', 'escalante', 2446, 'Online', '2024-12-26 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (22, 3, 'samp', 'sample', 2222, 'Online', '2024-12-26 00:00:00', NULL, NULL, 'Services');
INSERT INTO `transactions` VALUES (23, 5, 'sample1', 'sample1', 2244, 'Walkin', '2024-12-26 00:00:00', NULL, NULL, 'Services');
INSERT INTO `transactions` VALUES (24, NULL, NULL, NULL, 222, NULL, '2024-12-26 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (25, NULL, 'zorro', 'zorro', 4444, NULL, '2024-12-26 00:00:00', NULL, 'Completed', 'Product');
INSERT INTO `transactions` VALUES (26, NULL, 'Angel', 'sample', 2220, 'Walkin', '2024-12-26 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (27, NULL, 'Francis', 'Fortich', 250, 'Walkin', '2025-01-10 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (28, 2, 'ray leigh mart', 'escalante', 2222, 'Online', '2025-02-04 00:00:00', NULL, NULL, 'Services');
INSERT INTO `transactions` VALUES (29, 2, 'ray leigh mart', 'escalante', 222, 'Online', '2025-02-04 00:00:00', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (30, 2, 'ray leigh mart', 'escalante', 22, 'Online', '2025-03-04 00:00:00', NULL, NULL, 'Services');
INSERT INTO `transactions` VALUES (31, 2, 'ray leigh mart', 'escalante', 22, 'Online', '2025-03-06 00:00:00', NULL, NULL, 'Services');
INSERT INTO `transactions` VALUES (32, 2, 'ray leigh mart', 'escalante', 22, 'Online', '2025-03-06 00:00:00', NULL, 'Onprocess', 'Services');
INSERT INTO `transactions` VALUES (33, 2, 'ray leigh mart', 'escalante', 22, 'Online', '2025-03-06 11:17:17', '2025-03-12 03:16:01', 'Completed', 'Services');
INSERT INTO `transactions` VALUES (34, 6, 'asd', '123', 22, 'Walkin', '2025-03-08 10:47:07', NULL, NULL, 'Services');
INSERT INTO `transactions` VALUES (35, 7, 'Boa', 'Hannock', 22, 'Walkin', '2025-03-08 10:52:56', NULL, 'Completed', 'Services');
INSERT INTO `transactions` VALUES (36, 8, 'aya', 'harper', 22, 'Online', '2025-03-12 19:39:38', '2025-03-12 12:48:27', 'Completed', 'Services');
INSERT INTO `transactions` VALUES (37, 9, 'jing', 'oseta', 2322, 'Walkin', '2025-03-12 20:09:28', '2025-03-12 13:11:15', 'Completed', 'Services');
INSERT INTO `transactions` VALUES (38, NULL, 'dave', 'lopez', 2000, 'Walkin', '2025-03-12 20:14:25', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (39, NULL, 'paul', 'lopez', 2000, 'Walkin', '2025-03-12 20:17:13', NULL, NULL, 'Product');
INSERT INTO `transactions` VALUES (40, NULL, 'Angel', 'sample', 4000, 'Walkin', '2025-03-12 20:20:55', NULL, NULL, 'Product');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'user',
  `archive` tinyint(1) NULL DEFAULT 0,
  `confirm` tinyint(1) NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email` ASC) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'rayleigh mart', 'escalante', 'encoder@gmail.com', 'admin', 'admin', 'admin', 0, 0, '2024-12-18 16:53:19', NULL);
INSERT INTO `users` VALUES (2, 'ray leigh mart', 'escalante', 'admin@gmail.com', 'sample', 'sample', 'user', 0, 0, '2024-12-20 08:58:51', NULL);
INSERT INTO `users` VALUES (3, 'samp', 'sample', 'sample@gmail.com', '', '', 'user', 0, 0, '2024-12-26 15:57:31', NULL);
INSERT INTO `users` VALUES (5, 'samplesss', 'sampless', 'sample1@gmail.com', 'sampless', 'sample1', 'user', 0, 0, '2024-12-26 16:09:35', NULL);
INSERT INTO `users` VALUES (6, 'asd', '123', 'asd@gmail.com', 'asd@gmail.com', '', 'user', 0, 0, '2025-03-08 10:47:07', NULL);
INSERT INTO `users` VALUES (7, 'Boa', 'Hannock', 'boa@gmail.com', 'boa@gmail.com', '', 'user', 0, 0, '2025-03-08 10:52:56', NULL);
INSERT INTO `users` VALUES (8, 'aya', 'harper', 'aya@gmail.com', 'aya', 'aya123', 'user', 0, 0, '2025-03-12 19:36:15', NULL);
INSERT INTO `users` VALUES (9, 'jing', 'oseta', 'jing@gmail.com', 'jing@gmail.com', '', 'user', 0, 0, '2025-03-12 20:09:28', NULL);

SET FOREIGN_KEY_CHECKS = 1;
