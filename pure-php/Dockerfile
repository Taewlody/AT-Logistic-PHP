FROM php:8.0-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN a2enmod rewrite
RUN a2enmod ssl

RUN service apache2 restart

RUN apt-get update && apt-get upgrade -y