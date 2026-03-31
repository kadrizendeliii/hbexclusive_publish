FROM php:8.2-apache

WORKDIR /var/www/html

RUN docker-php-ext-install mysqli

COPY . /var/www/html/

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf
