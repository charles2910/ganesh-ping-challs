FROM php:7.4-apache
LABEL maintainer="Ganesh - Segurança da Informação"

# sudo docker build -t ganesh/container-s1:1.0 .
# sudo docker run -d -p 1337:80 --rm --name ganesh-s1-instance ganesh/container-s1:1.0

# Copying default files to html root & Apache Configs & Enable Mod Rewrite
COPY default /default
RUN cp -r /default/src/*                 /var/www/html && \
    cp    /default/apache-config.conf    /etc/apache2/sites-enabled/000-default.conf && \
    a2enmod rewrite && \
    rm -r /default

# Copying the challenges to respective paths
COPY challenges/05_Sopa_de_Letrinhas/src       /var/www/html/6ca27ec5acb62291

# Setting files to read-only (prevent flag rewrite)
RUN chmod 444 /var/www/html/6ca27ec5acb62291/flag_ef4507fe70049f6ca87.txt && \
    chmod 444 /var/www/html/6ca27ec5acb62291/list.txt && \
    chmod 444 /var/www/html/6ca27ec5acb62291/index.php
    
# Expose Apache HTTP port
EXPOSE 80