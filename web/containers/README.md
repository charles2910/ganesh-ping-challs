# DOCKER CONTAINERS

Abaixo segue a configuração dos containers criados para os desafios do PInG, como executá-los e, por fim, a relação de quais desafios se encontram em quais containers. 

Os containers normais possuem uma indexação alfabética (A-Z) e possuem diversos challs sob um mesmo servidor.

Container especiais são indexados com (SX) e abrigam challs que necessitam de isolamento máximo devido ao risco de vazarem flags de challs vizinhos (Ex: command injections, path transversals, RCE).

## CONTAINER [A]

**Escopo:** Container básico servindo um servidor Apache com páginas PHP e HTML autossuficientes (não necessitam de banco de dados nem outra biblioteca/configuração adicional).

- php@7.4.latest
- Servidor apache@latest

## CONTAINER [B]

**Escopo:** Container com servidor Apache, PHP e servidor MySQL (MariaDB) habilitado.

- php@7.4.latest
- Servidor apache@latest
- mysql-server@latest 
- PHP Extensions: mysqli, pdo, pdo_mysql

## CONTAINER [C]

**Escopo:** Container básico similar ao container \[A\], porém feito para exibir os challs da categoria WEB na semana de CTF do ping.

- php@7.4.latest
- Servidor apache@latest

## CONTAINER [S1]

**Escopo:** servidor apache com chall de command injection.

- php@7.4.latest
- Servidor apache@latest

## CONTAINER [S2]

**Escopo:** servidor apache com chall de path transversal.

- php@7.4.latest
- Servidor apache@latest

## CONTAINER [S3]

**Escopo:** servidor apache com chall de command injection (categoria WEB na semana de CTF do ping).

- php@7.4.latest
- Servidor apache@latest
- python2 python3 iputils-ping netcat

## RELAÇÃO CHALL x CONTAINER

```
Container [A]
| -- 01_Introducao_a_Web_I              hashLocation: 1477d3783c2f8577
| -- 02_Introducao_a_Web_II             hashLocation: bf25909c80e4313a
| -- 03_0x0C00k1E==                     hashLocation: 67dc05537c7d53f1
| -- 04_Googlebot_Nao_Pegue             hashLocation: b67ae7a255eb7ffe
| -- 09_Malabarismo_PHP                 hashLocation: 190025debc492652
| -- 10_Convidado_Extra                 hashLocation: 9f97242726cbb8f9
| -- 11_Explorador_Novato               hashLocation: 8d71abc9d4944ad0
| -- 13_Metodos_Nao_Convencionais       hashLocation: 1290d5fdb7921ab3
| -- 16_Googlebot_Pegue                 hashLocation: c33fb80a057b1540

Container [B]
| -- 06_Site_do_Sobrinho                hashLocation: 2936e204bbc50cb8
| -- 12_Objetos_Magicos                 hashLocation: c9e298919d2c0c3a
| -- 14_Olho_no_Biscoito                hashLocation: 70f589c036d8464a
| -- 17_Rest_in_Peace                   hashLocation: c230e80e282f2176

Container [C]
| -- 99_The_Vault (picoCTF)             hashLocation: 5103198102690911
| -- 97_JWT_Scratchpad (picoCTF)        hashLocation: a37469330538541a

Container [S1]
| -- 05_Sopa_de_Letrinhas               hashLocation: 6ca27ec5acb62291

Container [S2]
| -- 15_Flag_na_Cara                    hashLocation: 06f4f65f10d7c04b

Container [S3]
| -- 98_Port_1337 (picoCTF)             hashLocation: 5e1a0b9bdd63da09

Nenhum Container Relacionado
| -- 07_Rock_You: desafio de bruteforce, precisa criar um NGINX para garantir que robustez.
| -- 08_Bolos_e_Tokens: feito em python, precisa adaptar para acesso remoto.
| -- 18_Jornada_do_Heroi: idem bruteforce (ideal servidor com cache ativado!)
```
