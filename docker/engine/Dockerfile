FROM php:7.4-fpm

WORKDIR /home/docker

ARG PHP_APCU_VERSION=5.1.19

RUN useradd -u 1000 -d /home/dateanime -m dateanime \
    && apt update \
    && apt install -y \
        git \
        libicu-dev \
        libpq-dev \
        libxml2-dev \
        libonig-dev \
        zlib1g-dev \
        libpng-dev \
        unzip \
        libzip-dev \
        libjpeg-dev \
        libfreetype6-dev \
    && docker-php-source extract \
    && curl -L -o /tmp/apcu-$PHP_APCU_VERSION.tgz https://pecl.php.net/get/apcu-$PHP_APCU_VERSION.tgz \
    && tar xfz /tmp/apcu-$PHP_APCU_VERSION.tgz \
    && rm -r \
        /tmp/apcu-$PHP_APCU_VERSION.tgz \
    && mv apcu-$PHP_APCU_VERSION /usr/src/php/ext/apcu \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        apcu \
        calendar \
        intl \
        gd \
        mbstring \
        opcache \
        pdo_pgsql \
        xml \
        zip \
    && docker-php-source delete \
    && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

COPY ./docker/engine/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

COPY ./docker/engine/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY . /home/docker

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
