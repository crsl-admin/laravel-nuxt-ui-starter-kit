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
# ponytail: niente AUTORUN_LARAVEL_MIGRATION_ISOLATION, con CACHE_STORE=database il
# lock cerca la tabella cache_locks che al primo deploy non esiste ancora. Riattivalo
# da Coolify solo se scali a piu' repliche con un cache store esterno (Redis).
ENV AUTORUN_ENABLED=true \
    PHP_OPCACHE_ENABLE=1 \
    SSL_MODE=off

COPY --from=build --chown=www-data:www-data /app /var/www/html

# Mountpoint del volume persistente per SQLite. Creato qui perche' Docker copia
# contenuto e permessi dell'immagine nel named volume alla prima inizializzazione.
# Il file va creato ora: l'AUTORUN di serversideup testa la connessione al DB
# *prima* di migrare, e su SQLite un file mancante = connessione fallita = boot ko.
RUN mkdir -p /var/www/html/storage/database \
    && touch /var/www/html/storage/database/database.sqlite

EXPOSE 8080
