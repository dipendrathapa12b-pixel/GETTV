
# ==========================================
# 1. Build frontend assets
# ==========================================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json ./

RUN npm install

COPY . .

RUN npm run build


# ==========================================
# 2. Laravel + FrankenPHP production server
# ==========================================
FROM dunglas/frankenphp:1-php8.4-bookworm

# Install PHP extensions
RUN install-php-extensions \
    pdo_mysql \
    intl \
    zip \
    gd \
    opcache \
    mbstring \
    bcmath \
    exif \
    pcntl
# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy Laravel application
COPY . .

# Install production dependencies
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

# Copy compiled frontend assets
COPY --from=frontend /app/public/build ./public/build

# Prepare Laravel writable directories
RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Production settings
ENV APP_ENV=production
ENV APP_DEBUG=false

# Render provides PORT
EXPOSE 10000

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
