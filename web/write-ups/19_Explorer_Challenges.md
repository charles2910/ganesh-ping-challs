# Explorador Novato
**Flag:** `Ganesh{W3lc0m3_T0_th3_C4mp}`

A flag pode ser encontrada na página inicial (`index.html`) bastando dar uma busca no código fonte pelo seu início (`Ganesh{`).


# Explorador Explorador Não Encontrado
**Flag:** `Ganesh{D0nt_G3t_L0st_Al0n3}`

A flag pode ser encontrada ao inserir uma URL inválida no site e acessando a página 404.


# Manifesto do Explorador
**Flag:** `Ganesh{SUch_a_Pr0gr3ss1v3_M4n1f3sT}`

A flag pode ser encontrada no arquivo manifest.webmanifest localizado na página de Políticas de Privacidade.


# Explorador de Segredos
**Flag:** `Ganesh{JS_0bfusc4tion_1n_th3_W1ld}`

A flag pode ser encontrada em um arquivo javascript `s3cr3t.js` e apresenta um javascript obfuscado. Ao executar o conteúdo dentro de eval conseguimos obter o código javascript que possui o seguinte conteúdo:

```javascript
var flag = "Ganesh{JS_0bfusc4tion_1n_th3_W1ld}";
```


# Explorador Veterano
**Flag:** `Ganesh{H3r3_1s_My_CVE}`

Como a dica do desafio gira em torno de certificados, a flag pode ser obtida ao alternar o site de http:// para https:// e visualizando o certificado do site (que obviamente é indicado como inseguro por se tratar de um certificado auto-assinado).


# Aviso: Apenas Pessoal Autorizado
**Flag:** `Ganesh{Ins3cure_Acc3s_C0nf1gs}`

Neste desafio a flag se encontra na página `administrative.html` que se encontra protegida por uma autenticação HTTP básica e é necessário, portanto, conseguir a senha de alguma forma.

Navegando pelos arquivos podemos encontrar no arquivo `robots.txt` a existência de uma pasta chamada backups e, dentro dela, um arquivo chamado `bkp.htpasswd` que possui as configurações de acesso do website e o hash da senha.

```
ganesh:$apr1$Iga9B/qV$kk1UKDrKDXavirTeWcg0T.
```

Utilizando o utilitário John, the Ripper podemos copiar a hash da senha (`$apr1$Iga9B/qV$kk1UKDrKDXavirTeWcg0T.`) em um arquivo chamado `crack.txt` e solicitar que o john realize o bruteforce até encontrar uma senha candidata.

```bash
$ john --incremental:Digits  crack.txt
$ john --show crack.txt
```

E com isso conseguimos as credenciais para acessar a página restrita sendo elas: 

```
Login: ganesh
Senha: 7331
```
