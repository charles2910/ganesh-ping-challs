# COMO CRIAR IMAGENS E CONTAINERS

## 0º - Acessar a pasta container

Primeiro precisamos acessar a pasta do Dockerfile que queremos gerar uma imagem.

```bash
cd /path/to/dockerfile/folder/
```

## 1º - Buildando a imagem a partir do Dockerfile

Nesta etapa iremos gerar a imagem do container, toda vez que o Dockerfile for modificado é necessário que uma nova imagem se gerada. Aqui também definimos como iremos chamar nossa imagem podendo gerar até mesmo o versionamento das imagens.

```bash
# Não esquecer do ponto no final para indicar a pasta atual
sudo docker build -t ganesh/container-X:1.0 . 
```

Para garantir que a imagem foi criada, podemos listar todas as imagens existentes no sistema e gerencia-las com os seguintes comandos:

```bash
sudo docker image ls --all         # Lista todas as imagens
sudo docmer rmi <docker-image-id>  # Remove a imagem especificada
```

## 2º - Executando container com a imagem gerada

```bash
sudo docker run \
    -d \                       # Roda o container em background
    -p 8080:80 \               # Expõe <host-port>:<container-port> 
    --rm \                     # Remove o container quando ele parar de executar
    --name ganesh-X-instance \ # Nome do container
    ganesh/container-X:1.0     # Imagem de origem
```

Ou em uma única linha

```bash
sudo docker run -d -p 8080:80 --rm --name ganesh-X-instance ganesh/container-X:1.0
```

## 3º - Listando e Executando Containers

```bash
sudo docker container ls -a       # Exibe todos os containers 
sudo docker stop <container-id>   # Para o container de forma sútil
sudo docker kill <container-id>   # Para os casos que o docker stop não funcionam
sudo docker rm   <container-id>   # Remove o container definitivamente
```

## 4º - Acessando o terminal do container

Caso seja necessário verificar alguma configuração ou arquivo, é possível acessar o terminal do container utilizando o seguinte comando:

```bash
docker exec -it <container-id> bash
```
