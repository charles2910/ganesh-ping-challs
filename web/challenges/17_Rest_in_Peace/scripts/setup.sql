-- Criando o Banco de dados do Chall 20
CREATE DATABASE IF NOT EXISTS  db_chall_20;

-- Ativa o banco
USE db_chall_20;

-- Cria a tabela pro chall
CREATE TABLE IF NOT EXISTS stolendata (
    id     INT(7) UNSIGNED,
    field  VARCHAR(120) NOT NULL,
    val  VARCHAR(120) NOT NULL
);

-- Criando o novo usuário
CREATE USER IF NOT EXISTS 'user_chall_20'@'localhost' IDENTIFIED BY 'F6wVLZ=&J9pDDdXV';
-- Remove todas as permissões dadas por padrão ao usuário
REVOKE ALL PRIVILEGES ON *.* FROM 'user_chall_20'@'localhost';
-- Permite que este usuário possa apenas dar SELECT e INCLUDE na tabela
GRANT INSERT,SELECT ON db_chall_20.* TO 'user_chall_20'@'localhost';

-- Inserindo os dados e a flag
INSERT INTO stolendata (id, field, val) VALUES (54123, 'name',          'Johny');
INSERT INTO stolendata (id, field, val) VALUES (54123, 'lastname',      'Smith');   
INSERT INTO stolendata (id, field, val) VALUES (54123, 'card-number',   '1244124124124124');
INSERT INTO stolendata (id, field, val) VALUES (54123, 'card-cve',      '123');
INSERT INTO stolendata (id, field, val) VALUES (54123, 'card-date',     '02/24');

INSERT INTO stolendata (id, field, val) VALUES (33948, 'name',          'Sarah');
INSERT INTO stolendata (id, field, val) VALUES (33948, 'lastname',      'james Scott II');   
INSERT INTO stolendata (id, field, val) VALUES (33948, 'card-number',   '4024007142251593');
INSERT INTO stolendata (id, field, val) VALUES (33948, 'card-cve',      '446');
INSERT INTO stolendata (id, field, val) VALUES (33948, 'card-date',     '02/22');

INSERT INTO stolendata (id, field, val) VALUES (2676, 'name',          'Johny');
INSERT INTO stolendata (id, field, val) VALUES (2676, 'lastname',      'Smith');   
INSERT INTO stolendata (id, field, val) VALUES (2676, 'card-number',   '1244124124124124');
INSERT INTO stolendata (id, field, val) VALUES (2676, 'card-cve',      '123');
INSERT INTO stolendata (id, field, val) VALUES (2676, 'card-date',     '02/24');

INSERT INTO stolendata (id, field, val) VALUES (1, 'fL4G', 'Ganesh{W3B_w4S_Ch4ot1c_3v1L}');

INSERT INTO stolendata (id, field, val) VALUES (41379, 'name',          'X AE');
INSERT INTO stolendata (id, field, val) VALUES (41379, 'lastname',      'A-12');   
INSERT INTO stolendata (id, field, val) VALUES (41379, 'card-number',   '11251412411241');
INSERT INTO stolendata (id, field, val) VALUES (41379, 'card-cve',      '133');
INSERT INTO stolendata (id, field, val) VALUES (41379, 'card-date',     '02/44');

INSERT INTO stolendata (id, field, val) VALUES (46926, 'name',          'Luffy');
INSERT INTO stolendata (id, field, val) VALUES (46926, 'lastname',      'Mugiwara');   
INSERT INTO stolendata (id, field, val) VALUES (46926, 'card-number',   '6011050816846421');
INSERT INTO stolendata (id, field, val) VALUES (46926, 'card-cve',      '123');
INSERT INTO stolendata (id, field, val) VALUES (46926, 'card-date',     '02/24');

INSERT INTO stolendata (id, field, val) VALUES (35686, 'name',          'Samara');
INSERT INTO stolendata (id, field, val) VALUES (35686, 'lastname',      'Lines');   
INSERT INTO stolendata (id, field, val) VALUES (35686, 'card-number',   '4508027326322437');
INSERT INTO stolendata (id, field, val) VALUES (35686, 'card-cve',      '222');
INSERT INTO stolendata (id, field, val) VALUES (35686, 'card-date',     '01/24');

INSERT INTO stolendata (id, field, val) VALUES (26278, 'name',          'Tim');
INSERT INTO stolendata (id, field, val) VALUES (26278, 'lastname',      'Berners-Lee');   
INSERT INTO stolendata (id, field, val) VALUES (26278, 'card-number',   '6376420770308206');
INSERT INTO stolendata (id, field, val) VALUES (26278, 'card-cve',      '333');
INSERT INTO stolendata (id, field, val) VALUES (26278, 'card-date',     '02/21');