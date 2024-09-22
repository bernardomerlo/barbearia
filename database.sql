SET NAMES utf8mb4;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `barbearias`;

CREATE TABLE `barbearias` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nome` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `telefone` varchar(17) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `id_endereco` int NOT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

INSERT INTO
    `barbearias`
VALUES (
        1,
        'Barbearia A',
        '(27) 99513-5998',
        1
    );

INSERT INTO
    `barbearias`
VALUES (
        2,
        'Barbearia B',
        '(27) 90909-7142',
        2
    );

INSERT INTO
    `barbearias`
VALUES (
        3,
        'Barbearia C',
        '(27) 99310-9941',
        3
    );

DROP TABLE IF EXISTS `barbeiros`;

CREATE TABLE `barbeiros` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nome` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `senha` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `id_barbearia` int NOT NULL,
    `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `admin` tinyint(1) NOT NULL COMMENT '0 - Não é administrador\r\n1 - É administrador',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `fk_barbearia` (`id_barbearia` ASC) USING BTREE,
    CONSTRAINT `fk_barbearia` FOREIGN KEY (`id_barbearia`) REFERENCES `barbearias` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of barbeiros
-- ----------------------------
INSERT INTO
    `barbeiros`
VALUES (
        1,
        'admin',
        '$2y$10$OXZA3S5qMCak3pKwwHVD2OL0oOFT2PQ4VOqOZ/QYf29eI5YvAtPJa',
        1,
        'imgs/default_image_barbeiro.png',
        1
    );

-- ----------------------------
-- Table structure for cortes
-- ----------------------------
DROP TABLE IF EXISTS `cortes`;

CREATE TABLE `cortes` (
    `id` int NOT NULL AUTO_INCREMENT,
    `data_corte` date NOT NULL,
    `nome_cliente` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `telefone_cliente` varchar(17) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `id_barbeiro` int NOT NULL,
    `cliente` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `tipo_corte` int NULL DEFAULT NULL,
    `horario` time NOT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `fk_tipo_corte` (`tipo_corte` ASC) USING BTREE,
    INDEX `fk_barbeiro` (`id_barbeiro` ASC) USING BTREE,
    CONSTRAINT `fk_barbeiro` FOREIGN KEY (`id_barbeiro`) REFERENCES `barbeiros` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `fk_tipo_corte` FOREIGN KEY (`tipo_corte`) REFERENCES `tipos_cortes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

DROP TABLE IF EXISTS `enderecos`;

CREATE TABLE `enderecos` (
    `id` int NOT NULL AUTO_INCREMENT,
    `estado` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `cidade` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `bairro` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `rua` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `numero` int NOT NULL,
    `complemento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of enderecos
-- ----------------------------
INSERT INTO
    `enderecos`
VALUES (
        1,
        'ES',
        'Vitória',
        'Jardim da Penha',
        'Rua Tupinambás',
        342,
        'Sala 404'
    );

INSERT INTO
    `enderecos`
VALUES (
        2,
        'ES',
        'Vitória',
        'Monte Belo',
        'Rua Anselmo Serrate',
        199,
        NULL
    );

INSERT INTO
    `enderecos`
VALUES (
        3,
        'ES',
        'Vitória',
        'Enseada do Suá',
        'Av. Nossa Sra. dos Navegantes',
        955,
        NULL
    );

DROP TABLE IF EXISTS `horarios`;

CREATE TABLE `horarios` (
    `id` int NOT NULL AUTO_INCREMENT,
    `horario` time NOT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of horarios
-- ----------------------------
INSERT INTO `horarios` VALUES (1, '09:00:00');

INSERT INTO `horarios` VALUES (2, '09:30:00');

INSERT INTO `horarios` VALUES (3, '10:00:00');

INSERT INTO `horarios` VALUES (4, '10:30:00');

INSERT INTO `horarios` VALUES (5, '11:00:00');

INSERT INTO `horarios` VALUES (6, '11:30:00');

INSERT INTO `horarios` VALUES (7, '12:00:00');

INSERT INTO `horarios` VALUES (8, '12:30:00');

INSERT INTO `horarios` VALUES (9, '13:00:00');

INSERT INTO `horarios` VALUES (10, '13:30:00');

INSERT INTO `horarios` VALUES (11, '14:00:00');

INSERT INTO `horarios` VALUES (12, '14:30:00');

INSERT INTO `horarios` VALUES (13, '15:00:00');

INSERT INTO `horarios` VALUES (14, '15:30:00');

INSERT INTO `horarios` VALUES (15, '16:00:00');

INSERT INTO `horarios` VALUES (16, '16:30:00');

INSERT INTO `horarios` VALUES (17, '17:00:00');

INSERT INTO `horarios` VALUES (18, '17:30:00');

INSERT INTO `horarios` VALUES (19, '18:00:00');

INSERT INTO `horarios` VALUES (20, '18:30:00');

INSERT INTO `horarios` VALUES (21, '19:00:00');

-- ----------------------------
-- Table structure for tipos_cortes
-- ----------------------------
DROP TABLE IF EXISTS `tipos_cortes`;

CREATE TABLE `tipos_cortes` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nome` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipos_cortes
-- ----------------------------
INSERT INTO `tipos_cortes` VALUES (1, 'Pézinho');

INSERT INTO `tipos_cortes` VALUES (2, 'Sobrancelha');

INSERT INTO `tipos_cortes` VALUES (3, 'Corte com Máquina');

INSERT INTO `tipos_cortes` VALUES (4, 'Disfarçado');

INSERT INTO `tipos_cortes` VALUES (5, 'Barba');

INSERT INTO `tipos_cortes` VALUES (6, 'Bigode');

INSERT INTO
    `tipos_cortes`
VALUES (
        8,
        'Completo (Barba, Cabelo e Bigode)'
    );

INSERT INTO `tipos_cortes` VALUES (7, 'Pintar');

SET FOREIGN_KEY_CHECKS = 1;