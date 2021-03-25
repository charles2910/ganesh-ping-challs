# [GANESH] DESAFIOS DE WEB (PInG)

Repositório contendo código fonte dos desafios de Web utilizados no PInG (Processo de Ingresso do Ganesh).

## COMO EXECUTAR (Guia Simples)

Obs: para a execução dos scripts é necessário que a máquina possa executar scripts `bash` e possua `docker` instalado e funcionando corretamente (preferencialmente na última versão).

Execute primeiro o script para criar as imagens dos containers: 

```bash
$ # chmod +x prepare_images.sh
$ ./prepare_images.sh
```

Em seguida, após buildar as imagens pretendidas, execute o próximo script para iniciar as instâncias dos containers com o seguinte comando:

```bash
$ # chmod +x prepare_containers.sh
$ ./prepare_containers.sh
```

Após o fim da execução, os containrs estarão rodando nas portas padrões definidas no arquivo `prepare_containers.sh`.

## EXECUTANDO VIA DOCKER COMPOSE (Ideal para Produção)

Outra opção para inicializar os container se dá utilizando o Docker Compose. Sua principal vantagem é a de reiniciar automaticamente os containers caso algum erro ocorra. Os comandos para ativar e desativar os containers são os seguintes:

```bash
$ sudo docker-compose up -d     # Inicia os containers em background.
$ sudo docker-compose down      # Desliga e mata os containers ativos.
```

## INFORMAÇÕES DOS CONTAINERS

- Informações dos containers e distribuição dos desafios [neste link](./containers/README.md)
- Guia de como utilizar os comandos do Docker [neste link](./containers/HOWTOUSE.md)

## ORGANIZAÇÃO DOS ARQUIVOS

```
prepare_images.sh               Script para buildar as imagens do repositório
prepare_containers.sh           Script para iniciar containers do repositório
challenges/                     Pasta com todos os desafios funcionais
| -- ID_Chall_Name/             Exemplo de Pasta de Desafio (ID + Camel_Case_Name)
| -- | -- src/                  Pasta com os códigos que irão para a /var/www/html/hashLocation
| -- | -- scripts/setup.sql     Configuração da Base de Dados SQL (Se necessário)
| -- | -- README.md             Informações do chall (Nome, Dificildade, Descrição, Dependencias)
| -- | -- WRITEUP.md            Writeup mostrando resolução do desafio
containers/                     Pasta com todos os containers necessários
| -- _default/                  Arquivos comuns à todos (ou maioria) containers
| -- [A-Z]/                     Identificação alfabética do container
| -- | -- Dockerfile            Configurações do container
```