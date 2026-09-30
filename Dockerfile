# syntax=docker/dockerfile:1.7

FROM php:8.4-cli-bookworm

# 1. Install dependency sistem, Node.js 20 (LTS), dan SQLite extension
RUN apt-get update && apt-get install -y \
        curl \
        unzip \
        git \
        libsqlite3-dev \
        gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 2. Copy dependency PHP & Node.js
COPY composer.json composer.lock ./
COPY package*.json ./

RUN --mount=type=cache,target=/root/.composer,sharing=locked \
    composer install \
    --no-scripts \
    --no-autoloader \
    --prefer-dist

RUN --mount=type=cache,target=/root/.npm \
    npm ci || npm install

# 3. Copy seluruh kode aplikasi
COPY . .

# 4. Build assets Vite & Autoload Composer
RUN --mount=type=cache,target=/root/.npm \
    npm run build
RUN composer dump-autoload --optimize

# 5. Setup environment & database
RUN cp .env.example .env \
    && php artisan key:generate \
    && touch database/database.sqlite \
    && php artisan migrate:fresh --force --seed

RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
