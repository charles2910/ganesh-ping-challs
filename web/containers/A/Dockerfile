FROM php:7.4-apache
LABEL maintainer="Ganesh - Segurança da Informação"

# sudo docker build -t ganesh/container-a:1.0 .
# sudo docker run -d -p 1337:80 --rm --name ganesh-a-instance ganesh/container-a:1.0

# Copying default files to html root & Apache Configs & Enable Mod Rewrite
COPY default /default
RUN cp -r /default/src/*              /var/www/html && \
    cp /default/apache-config.conf    /etc/apache2/sites-enabled/000-default.conf && \
    a2enmod rewrite && \
    rm -r /default
  
# Copying the challenges to container
COPY challenges /challenges

# Moving the files inside the container and remove them
RUN cp -r /challenges/01_Introducao_a_Web_I/src          /var/www/html/1477d3783c2f8577 && \
    cp -r /challenges/02_Introducao_a_Web_II/src         /var/www/html/bf25909c80e4313a && \
    cp -r /challenges/03_0x0C00k1E==/src                 /var/www/html/67dc05537c7d53f1 && \
    cp -r /challenges/04_Googlebot_Nao_Pegue/src         /var/www/html/b67ae7a255eb7ffe && \
    cp -r /challenges/09_Malabarismo_PHP/src             /var/www/html/190025debc492652 && \
    cp -r /challenges/10_Convidado_Extra/src             /var/www/html/9f97242726cbb8f9 && \
    cp -r /challenges/11_Explorador_Novato/src           /var/www/html/8d71abc9d4944ad0 && \
    cp -r /challenges/13_Metodos_Nao_Convencionais/src   /var/www/html/1290d5fdb7921ab3 && \
    cp -r /challenges/16_Googlebot_Pegue/src             /var/www/html/c33fb80a057b1540 && \
    rm -r /challenges

# Expose Apache HTTP port
EXPOSE 80