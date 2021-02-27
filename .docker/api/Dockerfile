FROM ubuntu:latest
MAINTAINER Tudose Valentin <tudose.valentin21@gmail.com>

# Install apache, PHP, and supplimentary programs. openssh-server, curl, and lynx-cur are for debugging the container.
RUN apt-get update && apt-get -y upgrade && apt-get -y install software-properties-common && add-apt-repository ppa:ondrej/php && apt-get update && DEBIAN_FRONTEND=noninteractive apt-get -y install \
    apache2 php7.4 php7.4-pgsql libapache2-mod-php7.4 php7.4-mbstring composer curl lynx-common lynx php7.4-xml php7.4-bcmath php7.4-curl

# Enable apache mods.
RUN a2enmod php7.4
RUN a2enmod rewrite

# Update the PHP.ini file, enable <? ?> tags and quieten logging.
RUN sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.4/apache2/php.ini
RUN sed -i "s/error_reporting = .*$/error_reporting = E_ERROR | E_WARNING | E_PARSE/" /etc/php/7.4/apache2/php.ini

# Manually set up the apache environment variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

# Expose apache.
EXPOSE 80

# Update the default apache site with the config we created.
ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf
ADD apache2.conf /etc/apache2/apache2.conf

#print access log and error log
RUN ln -sf /dev/stdout /var/log/apache2/access.log \
        && ln -sf /dev/stderr /var/log/apache2/error.log

# By default start up apache in the foreground, override with /bin/bash for interative.
CMD /usr/sbin/apache2ctl -D FOREGROUND
