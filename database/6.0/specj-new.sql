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

 Date: 15/03/2025 19:46:21
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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of branding
-- ----------------------------
INSERT INTO `branding` VALUES (1, 'asd');
INSERT INTO `branding` VALUES (2, 'asdf');

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
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of parts_registration
-- ----------------------------
INSERT INTO `parts_registration` VALUES (1, 'product', 'Motorcycle', '11100-22223', '2024-12-20', 'wheels-and-tires', 'scorpion-exhausts', 2.00, 2, 'Pcs', 'Replacement', 'uploads/BIR (2).jpg', '2024-12-20 10:21:33', '0', NULL);
INSERT INTO `parts_registration` VALUES (2, 'luffy', 'Motorcycle', '1231222', '2024-12-27', 'cooling-system', 'Rusi', 223.00, 31, 'Set', 'New', 'uploads/4cf92c2b45cacdae4697a8dd7ca38b73.jpg', '2024-12-20 10:27:03', '0', '31');
INSERT INTO `parts_registration` VALUES (3, 'planet', 'Motorcycle', '2', '0002-02-28', 'protective-gear', 'scorpion-exhausts', 2222.00, 20, 'Set', 'Replacement', 'uploads/Planet9_3840x2160.jpg', '2024-12-20 10:35:59', '1', '30');
INSERT INTO `parts_registration` VALUES (4, 'Block', 'Car', 'asd', '2024-12-05', 'wheels-and-tires', 'scorpion-exhausts', 2.00, 2002, 'Pcs', 'New', 'uploads/4cf92c2b45cacdae4697a8dd7ca38b73.jpg', '2024-12-20 11:53:29', '1', '20');
INSERT INTO `parts_registration` VALUES (5, 'Sparkplug', 'Motorcycle', '109-2333-2024', '2025-01-24', 'protective-gear', 'yoshimura', 250.00, 100, 'Pcs', 'New', 'uploads/4cf92c2b45cacdae4697a8dd7ca38b73.jpg', '2025-01-10 20:27:05', '0', '10');
INSERT INTO `parts_registration` VALUES (6, 'Motolite battery 12 volts', 'Motorcycle', '93745', '2027-02-12', 'maintenance-tools', 'ohlins', 2000.00, 6, 'Pcs', 'New', 'uploads/46B24LS-1.png', '2025-03-12 19:58:33', '0', '2');

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
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_logs
-- ----------------------------
INSERT INTO `product_logs` VALUES (1, 'luffy', '1231222', 222, 'New', 'registration', '2024-12-20 10:27:03');
INSERT INTO `product_logs` VALUES (2, 'planets', '2', 22, 'Replacement', 'registration', '2024-12-20 10:35:59');
INSERT INTO `product_logs` VALUES (3, 'asd', 'asd', 2, 'New', 'registration', '2024-12-20 11:53:29');
INSERT INTO `product_logs` VALUES (4, 'Sparkplug', '109-2333-2024', 100, 'New', 'registration', '2025-01-10 20:27:05');
INSERT INTO `product_logs` VALUES (5, 'Motolite battery 12 volts', '93745', 6, 'New', 'registration', '2025-03-12 19:58:33');

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
