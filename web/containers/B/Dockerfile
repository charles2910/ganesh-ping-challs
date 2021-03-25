FROM php:7.4-apache
LABEL maintainer="Ganesh - Segurança da Informação"

# sudo docker build -t ganesh/container-b:1.0 .
# sudo docker run -d -p 1337:80 --rm --name ganesh-b-instance ganesh/container-b:1.0

# Copying default files to html root & Apache Configs & Enable Mod Rewrite
COPY default /default
RUN cp -r /default/src/*                 /var/www/html && \
    cp    /default/apache-config.conf    /etc/apache2/sites-enabled/000-default.conf && \
    a2enmod rewrite && \
    rm -r /default

# Copying the challenges to container
COPY challenges /challenges

# Moving the files inside the container and remove them
RUN cp -r /challenges/06_Site_do_Sobrinho/src          /var/www/html/2936e204bbc50cb8 && \
    cp -r /challenges/12_Objetos_Magicos/src           /var/www/html/c9e298919d2c0c3a && \
    cp -r /challenges/14_Olho_no_Biscoito/src          /var/www/html/70f589c036d8464a && \
    cp -r /challenges/17_Rest_in_Peace/src             /var/www/html/c230e80e282f2176 && \
    cp -r /challenges/06_Site_do_Sobrinho/scripts/setup.sql       /06_setup.sql && \
    cp -r /challenges/12_Objetos_Magicos/scripts/setup.sql        /12_setup.sql && \
    cp -r /challenges/14_Olho_no_Biscoito/scripts/setup.sql       /14_setup.sql && \
    cp -r /challenges/17_Rest_in_Peace/scripts/setup.sql          /20_setup.sql && \
    rm -r /challenges

# Define MySQL Enviroment Variables
ENV MYSQL_ROOT_PASSWORD G4n3shPassW0rDMu1t0Fort3M3sM0

# Installing MySQL Database
RUN apt update && \ 
    apt -y upgrade && \
    apt -y install default-mysql-server && \
    docker-php-ext-install mysqli pdo pdo_mysql && \ 
    docker-php-ext-enable  mysqli pdo pdo_mysql

# Expose Apache HTTP port
EXPOSE 80

# When Container Starts: 
# - Start MySQL Server 
# - Bind Mysql Socket Port
# - Repopulate the Database from setups
# - Start apache in foreground (container main proccess)
CMD /etc/init.d/mysql start && \
    ln -s /var/run/mysqld/mysqld.sock /tmp/mysql.sock && \
    mysql -u root < /06_setup.sql && \
    mysql -u root < /12_setup.sql && \
    mysql -u root < /14_setup.sql && \
    mysql -u root < /20_setup.sql && \
    rm /*_setup.sql && \
    apache2-foreground