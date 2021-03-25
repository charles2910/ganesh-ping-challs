CREATE DATABASE IF NOT EXISTS db_chall_06;

USE db_chall_06;

CREATE TABLE IF NOT EXISTS usuarios (
    id    INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome  VARCHAR(120) NOT NULL,
    senha VARCHAR(120) NOT NULL,
    nivel_usuario INT(6) DEFAULT 0
);

INSERT INTO usuarios (nome, senha, nivel_usuario) VALUES ('admin','n@0_3h_p0sS1v3l_4d!viNhaR', 1);

CREATE USER IF NOT EXISTS 'user_chall_6'@'localhost' IDENTIFIED BY '7PPoabF7w08TquuC';

REVOKE ALL PRIVILEGES ON *.* FROM 'user_chall_6'@'localhost';

GRANT INSERT, SELECT ON db_chall_06.usuarios TO 'user_chall_6'@'localhost';