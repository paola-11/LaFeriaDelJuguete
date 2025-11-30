FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get update && apt-get install -y \
    wget \
    git \
    libxml2-dev \
    autoconf \
    build-essential \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Configurar Xdebug para cobertura
RUN echo "zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini

# Instalamos PHPUnit compatible con PHP 8.2 (v10.5)
RUN wget -q -O /usr/local/bin/phpunit https://phar.phpunit.de/phpunit-10.5.phar \
    && chmod +x /usr/local/bin/phpunit

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80