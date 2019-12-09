FROM php:7.2-apache

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        vim \
        wget \
        unzip \
        git \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

#COPY php.ini /usr/local/etc/php/php.ini
COPY ./vhost.conf /etc/apache2/sites-available/vhost.conf
COPY ./hosts /etc/hosts

RUN a2enmod rewrite

RUN service apache2 restart
WORKDIR /etc/apache2/sites-available/
RUN a2ensite vhost.conf
WORKDIR /var/www/html/
EXPOSE 80
EXPOSE 443