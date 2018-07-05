FROM php:7.1-fpm-jessie

RUN apt-get update && apt-get install -y libmcrypt-dev  \
    zlib1g-dev \
    mysql-client \
    libmemcached-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install opcache mbstring pdo_mysql zip mcrypt \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer