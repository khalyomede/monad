FROM composer:2

RUN apk add --no-cache php8-pear php8-dev gcc musl-dev make && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug
