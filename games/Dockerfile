FROM php:8.0-apache

WORKDIR /var/www/html
COPY index.php index.php
COPY . ./ 
EXPOSE 80
RUN apt-get update
RUN apt-get install libpq-dev -y
RUN docker-php-ext-install pgsql
RUN docker-php-ext-install pdo_pgsql