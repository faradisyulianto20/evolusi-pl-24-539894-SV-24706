# syntax=docker/dockerfile:1.7

# Versi dikunci (bukan `latest` / tag floating)
ARG PHP_VERSION=8.4.26
ARG COMPOSER_VERSION=2.8.12

# =============================================================================
# STAGE 0 — composer (hanya untuk mengambil binary composer)
# =============================================================================
FROM composer:${COMPOSER_VERSION} AS composer

# =============================================================================
# STAGE 1 — builder
# Boleh besar: Composer, Node.js, dev tooling, seluruh source, build aset.
# =============================================================================
FROM php:${PHP_VERSION}-cli-bookworm AS builder

RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        curl \
        gnupg \
        libsqlite3-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Dependency PHP (tanpa dev) & Node
COPY composer.json composer.lock ./
RUN --mount=type=cache,target=/root/.composer,sharing=locked \
    composer install \
        --no-dev \
        --no-scripts \
        --no-autoloader \
        --prefer-dist \
        --no-interaction \
        --no-progress

COPY package*.json ./
RUN --mount=type=cache,target=/root/.npm \
    npm ci

# Seluruh source aplikasi
COPY . .

# Build aset Vite + autoload PHP, lalu setup environment & database
RUN --mount=type=cache,target=/root/.npm \
    npm run build

RUN cp .env.example .env \
    && composer dump-autoload --optimize --no-dev \
    && touch database/database.sqlite \
    && php artisan key:generate \
    && php artisan migrate:fresh --force \
    && rm -rf node_modules

# =============================================================================
# STAGE 2 — runtime
# Hanya berisi yang dibutuhkan untuk melayani: PHP + ekstensi + vendor + aset.
# =============================================================================
FROM php:${PHP_VERSION}-cli-alpine AS runtime

RUN apk add --no-cache sqlite-libs curl \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS sqlite-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && apk del .build-deps

WORKDIR /var/www/html

COPY --from=builder /var/www/html /var/www/html

RUN addgroup -g 1000 -S appuser \
    && adduser -u 1000 -S appuser -G appuser \
    && chown -R appuser:appuser storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

USER appuser

EXPOSE 8000

HEALTHCHECK --interval=30s --timeout=5s --start-period=20s --retries=3 \
    CMD curl -fsS http://localhost:8000/up || exit 1

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
