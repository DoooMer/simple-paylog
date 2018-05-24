FROM php:7.2-fpm

RUN apt-get update \
 && apt-get install -y --no-install-recommends git zlib1g-dev curl \
 && docker-php-ext-install zip pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
