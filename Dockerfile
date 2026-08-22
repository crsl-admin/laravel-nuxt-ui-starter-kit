# syntax=docker/dockerfile:1

# --- Stage 1: build vendor + frontend assets ---------------------------------
# ponytail: PHP CLI + Node nello stesso stage perche' il plugin Vite di Wayfinder
# esegue `php artisan wayfinder:generate` durante `npm run build`.
FROM serversideup/php:8.4-cli AS build

USER root

COPY --from=node:22-bookworm-slim /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22-bookworm-slim /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -sf /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-autoloader --no-scripts

COPY package.json package-lock.json ./
RUN npm ci

COPY . .

RUN composer dump-autoload --optimize --no-dev \
    && npm run build \
    && rm -rf node_modules

# --- Stage 2: runtime (nginx + php-fpm, gestiti da s6) -----------------------
FROM serversideup/php:8.4-fpm-nginx AS production

USER root
RUN install-php-extensions pdo_pgsql pdo_mysql
USER www-data

# AUTORUN: migrate --force + storage:link + config/route/view/event cache all'avvio.
# MIGRATION_ISOLATION evita migrazioni concorrenti se scali a piu' repliche.
ENV AUTORUN_ENABLED=true \
    AUTORUN_LARAVEL_MIGRATION_ISOLATION=true \
    PHP_OPCACHE_ENABLE=1 \
    SSL_MODE=off

COPY --from=build --chown=www-data:www-data /app /var/www/html

EXPOSE 8080
