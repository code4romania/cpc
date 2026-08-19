FROM code4romania/php:8.4 AS vendor

USER root

RUN set -ex; \
    install-php-extensions

USER www-data

COPY --chown=www-data:www-data . /var/www/html

RUN set -ex; \
    composer install \
    --optimize-autoloader \
    --no-interaction \
    --no-plugins \
    --no-dev \
    --prefer-dist

FROM node:22-alpine AS assets

WORKDIR /build

COPY \
    package.json \
    package-lock.json \
    vite.config.js \
    ./

RUN set -ex; \
    npm ci --no-audit --ignore-scripts

COPY --from=vendor /var/www/html /build

RUN set -ex; \
    npm run build

FROM vendor

ARG VERSION
ARG REVISION

RUN echo "$VERSION (${REVISION:0:7})" > /var/www/.version

COPY --from=assets --chown=www-data:www-data /build/public/build /var/www/html/public/build

ENV WORKER_ENABLED=true

ENV QUEUE_ENABLED=true

ENV PHP_PM_MAX_CHILDREN=64
