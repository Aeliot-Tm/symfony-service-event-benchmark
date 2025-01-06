ARG PHP_VERSION=8.2.7
ARG DEBIAN_RELEASE=bullseye

FROM php:${PHP_VERSION}-fpm-${DEBIAN_RELEASE}

ARG COMPOSER_ALLOW_SUPERUSER=1
ARG COMPOSER_NO_INTERACTION=1
ARG COMPOSER_VERSION=2.7.6
ARG DEBIAN_FRONTEND=noninteractive
ARG DOCKER_PHP_DEPS='libxml2-dev libzip-dev unzip'

RUN set -xe; \
    apt-get --allow-releaseinfo-change update && \
    apt-get install -y -qq ${DOCKER_PHP_DEPS} --no-install-suggests --no-install-recommends && \
    docker-php-ext-install -j$(nproc) xml && \
    docker-php-ext-install -j$(nproc) zip && \
    rm -rf /var/lib/apt/lists/* && \
    apt-get clean

# Install composer
RUN set -xe; \
    curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin --version=${COMPOSER_VERSION} > /dev/null 2>&1 && \
    chmod +x /usr/local/bin/composer

WORKDIR /app

#COPY composer.* ./
#
#RUN set -xe; \
#    composer install --no-autoloader --no-dev --no-interaction --no-progress --no-scripts --prefer-dist && \
#    composer clear-cache && \
#    rm -rf ./vendor/*/*/tests

COPY . ./

# RUN composer dump-autoload --optimize
