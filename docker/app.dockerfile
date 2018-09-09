FROM php:7.2-fpm-stretch

RUN apt-get update && apt-get install -y gnupg2 \
    libmcrypt-dev  \
    sudo  \
    zlib1g-dev \
    mysql-client \
    libmemcached-dev \
    unzip \
    && curl -sL https://deb.nodesource.com/setup_6.x | bash - \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install opcache mbstring pdo_mysql zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer global require phpunit/phpunit ^7.0 --no-progress --no-scripts --no-interaction \
    && apt-get install -y nodejs \
    build-essential \
    libpng-dev \
    && npm install -g pngquant-bin

COPY ./ /var/www
WORKDIR /var/www

# build backend
RUN cp .env.example .env \
  && composer install \
  && php artisan key:generate \
  && chmod -R 777 ./ \
  && chmod -c -R 777 storage \
  && chmod -R 777 bootstrap/cache \
  && npm install