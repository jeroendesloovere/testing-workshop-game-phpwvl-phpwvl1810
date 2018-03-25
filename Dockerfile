FROM php:5.6-cli

RUN apt-get update \
    && apt-get install -y curl zlib1g-dev \
    && docker-php-ext-install -j$(nproc) zip \
    && pecl install xdebug-2.5.5 \
    && docker-php-ext-enable xdebug

RUN useradd -s /bin/bash -d /home/phpunit -m phpunit

USER phpunit

VOLUME /home/phpunit

WORKDIR /home/phpunit
