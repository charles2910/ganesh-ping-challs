create database cereal;

use cereal;

CREATE USER 'db_user'@'localhost' IDENTIFIED BY 'w3b_4_Th3_W!n';

create table users (
    id int(6) unsigned auto_increment PRIMARY KEY,
    username varchar(30) NOT NULL,
    password varchar(80) NOT NULL
);

GRANT SELECT, INSERT ON cereal.users TO 'db_user'@'localhost';

insert into users (id, username, password) values (1, "Marcelo Batata", "f6f008d5bf21abadc7d5dccc904a04090b574f420c72bd27b8c2c31afcfb8bd8"); -- tuberculooficial2020
insert into users (id, username, password) values (2, "flag", "Ganesh{pHp_!s_Fkn_bR@k3n}");
insert into users (id, username, password) values (3, "Ganesher Generico", "d7b875ee3d05dc5dfa4ca5066f17b4271f894fbe79b4faa64e71e9d7c7aa1966"); -- w3b_N3eds_Us
