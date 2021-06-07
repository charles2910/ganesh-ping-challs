FROM php:7.4-apache
LABEL maintainer="Ganesh - Segurança da Informação"

# sudo docker build --no-cache -t ganesh/chall-19:1.0 .
# sudo docker run -d -p 80:80 -p 443:443 --rm --name ganesh-chall19 ganesh/chall-19:1.0

# Enable Mod Rewrite & Enable Mod SSL
RUN a2enmod rewrite && a2enmod ssl && \
    mkdir /etc/apache2/certificate 
#apt update && apt install openssl && \

# Copying the challenges to container
COPY src  /var/www/html
COPY configurations/apache-config.conf    /etc/apache2/sites-enabled/000-default.conf
COPY configurations/certificate           /etc/apache2/certificate

RUN htpasswd -cb /var/www/html/.htpasswd ganesh 7331 && \
    mkdir /var/www/html/backups && \
    cp /var/www/html/.htpasswd /var/www/html/backups/bkp.htpasswd

# Expose Apache HTTP port
EXPOSE 80
EXPOSE 443