-- Criar a tabela de endereços primeiro, pois ela é referenciada em barbearias
DROP TABLE
IF
	EXISTS enderecos;
CREATE TABLE enderecos (
	id INT NOT NULL AUTO_INCREMENT,
	estado VARCHAR ( 25 ) CHARACTER 
	SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	cidade VARCHAR ( 35 ) CHARACTER 
	SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	bairro VARCHAR ( 40 ) CHARACTER 
	SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	rua VARCHAR ( 100 ) CHARACTER 
	SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	numero INT NOT NULL,
	complemento VARCHAR ( 50 ) CHARACTER 
	SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
	PRIMARY KEY ( id ) USING BTREE 
) ENGINE = INNODB AUTO_INCREMENT = 4 CHARACTER 
SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;
INSERT INTO enderecos ( id, estado, cidade, bairro, rua, numero, complemento )
VALUES
	( 1, 'ES', 'Vitória', 'Jardim da Penha', 'Rua Tupinambás', 342, 'Sala 404' ),
	( 2, 'ES', 'Vitória', 'Monte Belo', 'Rua Anselmo Serrate', 199, NULL ),
	( 3, 'ES', 'Vitória', 'Enseada do Suá', 'Av. Nossa Sra. dos Navegantes', 955, NULL );-- Criar a tabela de barbearias
DROP TABLE
IF
	EXISTS barbearias;
CREATE TABLE barbearias (
	id INT NOT NULL AUTO_INCREMENT,
	nome VARCHAR ( 155 ) CHARACTER 
	SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	telefone VARCHAR ( 17 ) CHARACTER 
	SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	id_endereco INT NOT NULL,
	PRIMARY KEY ( id ) USING BTREE,
	CONSTRAINT fk_endereco FOREIGN KEY ( id_endereco ) REFERENCES enderecos ( id ) ON DELETE RESTRICT ON UPDATE CASCADE 
) ENGINE = INNODB AUTO_INCREMENT = 4 CHARACTER 
SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;-- Inserir dados na tabela barbearias
INSERT INTO barbearias ( id, nome, telefone, id_endereco )
VALUES
	( 1, 'Barbearia A', '(27) 99513-5998', 1 ),
	( 2, 'Barbearia B', '(27) 90909-7142', 2 ),
	( 3, 'Barbearia C', '(27) 99310-9941', 3 );-- Criar a tabela de barbeiros
DROP TABLE
IF
	EXISTS barbeiros;
CREATE TABLE barbeiros (
	id INT NOT NULL AUTO_INCREMENT,
	nome VARCHAR ( 155 ) CHARACTER 
	SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	senha VARCHAR ( 255 ) CHARACTER 
	SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	id_barbearia INT NOT NULL,
	foto VARCHAR ( 255 ) CHARACTER 
	SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	admin TINYINT ( 1 ) NOT NULL COMMENT '0 - Não é administrador\r\n1 - É administrador',
	PRIMARY KEY ( id ) USING BTREE,
	INDEX fk_barbearia ( id_barbearia ASC ) USING BTREE,
	CONSTRAINT fk_barbearia FOREIGN KEY ( id_barbearia ) REFERENCES barbearias ( id ) ON DELETE RESTRICT ON UPDATE CASCADE 
) ENGINE = INNODB AUTO_INCREMENT = 9 CHARACTER 
SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;-- Inserir dados na tabela barbeiros
INSERT INTO barbeiros ( id, nome, senha, id_barbearia, foto, admin )
VALUES
	( 1, 'admin', '$2y$10$OXZA3S5qMCak3pKwwHVD2OL0oOFT2PQ4VOqOZ/QYf29eI5YvAtPJa', 1, 'imgs/default_image_barbeiro.png', 1 );-- Criar a tabela de tipos de cortes antes da tabela cortes
DROP TABLE
IF
	EXISTS tipos_cortes;
CREATE TABLE tipos_cortes ( id INT NOT NULL AUTO_INCREMENT, nome VARCHAR ( 30 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, PRIMARY KEY ( id ) USING BTREE ) ENGINE = INNODB AUTO_INCREMENT = 8 CHARACTER 
SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;-- Inserir dados na tabela tipos_cortes
INSERT INTO tipos_cortes ( id, nome )
VALUES
	( 1, 'Pézinho' ),
	( 2, 'Sobrancelha' ),
	( 3, 'Corte com Máquina' ),
	( 4, 'Disfarçado' ),
	( 5, 'Barba' ),
	( 6, 'Bigode' ),
	( 7, 'Pintar' ),
	( 8, 'Completo (Barba, Cabelo e Bigode)' );-- Criar a tabela de cortes
DROP TABLE
IF
	EXISTS cortes;
CREATE TABLE cortes (
	id INT NOT NULL AUTO_INCREMENT,
	data_corte DATE NOT NULL,
	nome_cliente VARCHAR ( 155 ) CHARACTER 
	SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	telefone_cliente VARCHAR ( 17 ) CHARACTER 
	SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	id_barbeiro INT NOT NULL,
	cliente VARCHAR ( 45 ) CHARACTER 
	SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	tipo_corte INT NULL DEFAULT NULL,
	horario TIME NOT NULL,
	PRIMARY KEY ( id ) USING BTREE,
	INDEX fk_tipo_corte ( tipo_corte ASC ) USING BTREE,
	INDEX fk_barbeiro ( id_barbeiro ASC ) USING BTREE,
	CONSTRAINT fk_barbeiro FOREIGN KEY ( id_barbeiro ) REFERENCES barbeiros ( id ) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT fk_tipo_corte FOREIGN KEY ( tipo_corte ) REFERENCES tipos_cortes ( id ) ON DELETE 
	SET NULL ON UPDATE CASCADE 
	) ENGINE = INNODB AUTO_INCREMENT = 13 CHARACTER 
	SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;-- Criar a tabela de horários
DROP TABLE
IF
	EXISTS horarios;
CREATE TABLE horarios ( id INT NOT NULL AUTO_INCREMENT, horario TIME NOT NULL, PRIMARY KEY ( id ) USING BTREE ) ENGINE = INNODB AUTO_INCREMENT = 22 CHARACTER 
SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;-- Inserir dados na tabela horários
INSERT INTO horarios ( id, horario )
VALUES
	( 1, '09:00:00' ),
	( 2, '09:30:00' ),
	( 3, '10:00:00' ),
	( 4, '10:30:00' ),
	( 5, '11:00:00' ),
	( 6, '11:30:00' ),
	( 7, '12:00:00' ),
	( 8, '12:30:00' ),
	( 9, '13:00:00' ),
	( 10, '13:30:00' ),
	( 11, '14:00:00' ),
	( 12, '14:30:00' ),
	( 13, '15:00:00' ),
	( 14, '15:30:00' ),
	( 15, '16:00:00' ),
	( 16, '16:30:00' ),
	( 17, '17:00:00' ),
	( 18, '17:30:00' ),
	( 19, '18:00:00' ),
	( 20, '18:30:00' ),
	( 21, '19:00:00' );