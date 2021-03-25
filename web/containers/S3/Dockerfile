FROM php:7.4-apache
LABEL maintainer="Ganesh - Segurança da Informação"

# sudo docker build -t ganesh/container-s3:1.0 .
# sudo docker run -d -p 1337:80 --rm --name ganesh-s3-instance ganesh/container-s3:1.0

# Copying default files to html root & Apache Configs & Enable Mod Rewrite
COPY default /default
RUN cp -r /default/src/*                 /var/www/html && \
    cp    /default/apache-config.conf    /etc/apache2/sites-enabled/000-default.conf && \
    a2enmod rewrite && \
    rm -r /default

# Copying the challenges to respective paths
COPY challenges/98_Port_1337/src       /var/www/html/5e1a0b9bdd63da09

# Install Dependencies & Set files to read-only (prevent flag rewrite)
RUN apt update && apt -y install python2 python3 iputils-ping netcat && \
    chmod 444 /var/www/html/5e1a0b9bdd63da09/flag.txt  && \
    chmod 444 /var/www/html/5e1a0b9bdd63da09/index.php && \
    chmod 444 /var/www/html/5e1a0b9bdd63da09/index.txt
    
# Expose Apache HTTP port
EXPOSE 80