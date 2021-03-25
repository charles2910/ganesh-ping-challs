FROM php:7.4-apache
LABEL maintainer="Ganesh - Segurança da Informação"

# sudo docker build -t ganesh/container-c:1.0 .
# sudo docker run -d -p 1337:80 --rm --name ganesh-c-instance ganesh/container-c:1.0

# Copying default files to html root & Apache Configs & Enable Mod Rewrite
COPY default /default
RUN cp -r /default/src/*              /var/www/html && \
    cp /default/apache-config.conf    /etc/apache2/sites-enabled/000-default.conf && \
    a2enmod rewrite && \
    rm -r /default
  
# Copying the challenges to container
COPY challenges /challenges

# Install Dependencies & Move challenges files & Remove them in the end
RUN cp -r /challenges/99_The_Vault/src          /var/www/html/5103198102690911 && \
    cp -r /challenges/97_JWT_Scratchpad/src     /var/www/html/a37469330538541a && \
    rm -r /challenges

# Expose Apache HTTP port
EXPOSE 80