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

 Date: 20/12/2024 16:58:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of motorcycle_services
-- ----------------------------
INSERT INTO `motorcycle_services` VALUES (1, 'asd', 'Motorcycle', 'brake-service', 2222.00, '2024-12-20 11:21:36');
INSERT INTO `motorcycle_services` VALUES (2, 'asds', 'Motorcycle', 'brake-service', 22.00, '2024-12-20 11:24:59');

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of parts_registration
-- ----------------------------
INSERT INTO `parts_registration` VALUES (1, 'product', 'Motorcycle', '11100-22223', '2024-12-20', 'wheels-and-tires', 'scorpion-exhausts', 2.00, 2, 'Pcs', 'Replacement', 'uploads/BIR (2).jpg', '2024-12-20 10:21:33', '0', NULL);
INSERT INTO `parts_registration` VALUES (2, 'luffy', 'Motorcycle', '1231222', '2024-12-27', 'cooling-system', 'Rusi', 222.00, 222, 'Set', 'New', 'uploads/4cf92c2b45cacdae4697a8dd7ca38b73.jpg', '2024-12-20 10:27:03', '0', NULL);
INSERT INTO `parts_registration` VALUES (3, 'planets', 'Motorcycle', '2', '0002-02-28', 'protective-gear', 'scorpion-exhausts', 2222.00, 22, 'Set', 'Replacement', 'uploads/Planet9_3840x2160.jpg', '2024-12-20 10:35:59', '0', NULL);
INSERT INTO `parts_registration` VALUES (4, 'asd', 'Car', 'asd', '2024-12-05', 'engine-components', 'scorpion-exhausts', 2.00, 2, 'Pcs', 'New', NULL, '2024-12-20 11:53:29', '0', '20');

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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_logs
-- ----------------------------
INSERT INTO `product_logs` VALUES (1, 'luffy', '1231222', 222, 'New', 'registration', '2024-12-20 10:27:03');
INSERT INTO `product_logs` VALUES (2, 'planets', '2', 22, 'Replacement', 'registration', '2024-12-20 10:35:59');
INSERT INTO `product_logs` VALUES (3, 'asd', 'asd', 2, 'New', 'registration', '2024-12-20 11:53:29');

-- ----------------------------
-- Table structure for services_transaction
-- ----------------------------
DROP TABLE IF EXISTS `services_transaction`;
CREATE TABLE `services_transaction`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NULL DEFAULT NULL,
  `service_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of services_transaction
-- ----------------------------
INSERT INTO `services_transaction` VALUES (1, 1, 1);
INSERT INTO `services_transaction` VALUES (2, 1, 2);
INSERT INTO `services_transaction` VALUES (3, 2, 1);
INSERT INTO `services_transaction` VALUES (4, 3, 1);
INSERT INTO `services_transaction` VALUES (5, 8, 1);
INSERT INTO `services_transaction` VALUES (6, 8, 2);
INSERT INTO `services_transaction` VALUES (7, 10, 1);
INSERT INTO `services_transaction` VALUES (8, 11, 1);
INSERT INTO `services_transaction` VALUES (9, 11, 1);
INSERT INTO `services_transaction` VALUES (10, 11, 1);
INSERT INTO `services_transaction` VALUES (11, 12, 1);
INSERT INTO `services_transaction` VALUES (12, 13, 1);

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
  `created_at` date NULL DEFAULT NULL,
  `set_date` date NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transactions
-- ----------------------------
INSERT INTO `transactions` VALUES (1, 2, 'ray leigh mart', 'escalante', 2244, NULL, '2024-12-20', NULL, NULL);
INSERT INTO `transactions` VALUES (2, 2, 'ray leigh mart', 'escalante', 2222, 'Online', '2024-12-20', NULL, NULL);
INSERT INTO `transactions` VALUES (3, 2, 'ray leigh mart', 'escalante', 2222, 'Online', '2024-12-20', NULL, NULL);
INSERT INTO `transactions` VALUES (4, 2, 'ray leigh mart', 'escalante', 0, 'Online', '2024-12-20', NULL, NULL);
INSERT INTO `transactions` VALUES (5, 2, 'ray leigh mart', 'escalante', 0, 'Online', '2024-12-20', NULL, NULL);
INSERT INTO `transactions` VALUES (6, 2, 'ray leigh mart', 'escalante', 0, 'Online', '2024-12-20', NULL, NULL);
INSERT INTO `transactions` VALUES (7, 2, 'ray leigh mart', 'escalante', 0, 'Online', '2024-12-20', NULL, NULL);
INSERT INTO `transactions` VALUES (8, 2, 'ray leigh mart', 'escalante', 2244, 'Online', '2024-12-20', NULL, NULL);
INSERT INTO `transactions` VALUES (9, 2, 'ray leigh mart', 'escalante', 0, 'Online', '2024-12-20', NULL, NULL);
INSERT INTO `transactions` VALUES (10, 2, 'ray leigh mart', 'escalante', 2222, 'Online', '2024-12-20', NULL, NULL);
INSERT INTO `transactions` VALUES (11, 2, 'ray leigh mart', 'escalante', 6666, 'Online', '2024-12-20', NULL, NULL);
INSERT INTO `transactions` VALUES (12, 2, 'ray leigh mart', 'escalante', 2222, 'Online', '2024-12-20', NULL, NULL);
INSERT INTO `transactions` VALUES (13, 2, 'ray leigh mart', 'escalante', 2222, 'Online', '2024-12-20', NULL, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'ray leigh mart', 'escalante', 'encoder@gmail.com', 'admin', 'admin', 'admin', 0, 0, '2024-12-18 16:53:19', NULL);
INSERT INTO `users` VALUES (2, 'ray leigh mart', 'escalante', 'admin@gmail.com', 'sample', 'sample', 'user', 0, 0, '2024-12-20 08:58:51', NULL);

SET FOREIGN_KEY_CHECKS = 1;
