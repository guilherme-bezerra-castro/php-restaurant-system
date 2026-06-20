CREATE DATABASE IF NOT EXISTS db_gostinho_natural;
USE db_gostinho_natural;

CREATE TABLE carousel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NULL,
    imagem VARCHAR(255) NOT NULL,
    ordem INT NOT NULL DEFAULT 0,
    ativo TINYINT(1) DEFAULT 1
);

CREATE TABLE pratos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    ativo TINYINT(1) DEFAULT 1
);

CREATE TABLE pratos_precos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prato_id INT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (prato_id) REFERENCES pratos(id) ON DELETE CASCADE
);

CREATE TABLE faq (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pergunta VARCHAR(255) NOT NULL,
    resposta TEXT NOT NULL,
    ativo TINYINT(1) DEFAULT 1
);

CREATE TABLE footer_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('paginas','contato') NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    conteudo TEXT NOT NULL
);

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nivel_acesso ENUM('Admin') DEFAULT 'Admin'
) ENGINE=InnoDB;

-- Para criar um usuário admin, gere um hash bcrypt da senha desejada e insira abaixo:
-- INSERT INTO usuario (nome_usuario, senha, nivel_acesso)
-- VALUES ('seu_usuario', 'hash_bcrypt_da_senha', 'Admin');