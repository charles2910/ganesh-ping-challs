FROM php:7.4-apache
LABEL maintainer="Ganesh - Segurança da Informação"

# sudo docker build -t ganesh/container-s2:1.0 .
# sudo docker run -d -p 1337:80 --rm --name ganesh-s2-instance ganesh/container-s2:1.0

# Copying default files to html root & Apache Configs & Enable Mod Rewrite
COPY default /default
RUN cp -r /default/src/*                 /var/www/html && \
    cp    /default/apache-config.conf    /etc/apache2/sites-enabled/000-default.conf && \
    a2enmod rewrite && \
    rm -r /default

# Copying the challenges to respective paths
COPY challenges/15_Flag_na_Cara/src       /var/www/html/06f4f65f10d7c04b

# Setting files to read-only (prevent flag rewrite)
RUN chmod 444 /var/www/html/06f4f65f10d7c04b/index.php
    
# Expose Apache HTTP port
EXPOSE 80