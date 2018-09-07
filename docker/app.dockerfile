FROM php:7.2-fpm-stretch

RUN apt-get update && apt-get install -y libmcrypt-dev  \
    zlib1g-dev \
    mysql-client \
    libmemcached-dev \
    unzip \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install opcache mbstring pdo_mysql zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./ /var/www
WORKDIR /var/www

# build backend
RUN cp .env.example .env\
  && composer install \
  && php artisan key:generate \
  && chmod -R 777 ./ \
  && chmod -R 777 storage \
  && chmod -R 777 bootstrap/cache \
  && ls -la /var/www