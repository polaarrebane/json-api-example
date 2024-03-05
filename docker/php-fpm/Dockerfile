FROM php:8.3-fpm-alpine

RUN apk --no-cache update \
    && apk add --no-cache autoconf g++ make \
    postgresql-dev linux-headers \
    && apk add --no-cache postgresql-client

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql

ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app/public