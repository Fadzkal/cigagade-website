# ============================================================
# Stage 1: Build Vite assets (Node)
# ============================================================
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts

COPY resources/ ./resources/
COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY public/ ./public/

RUN npm run build

# ============================================================
# Stage 2: PHP-FPM production runner
# ============================================================
FROM php:8.2-fpm-alpine AS production

LABEL maintainer="Desa Cigagade <desa.cigagade@garutkab.go.id>"
LABEL description="Portal Informasi & Pelayanan Desa Cigagade"

# System dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    mysql-client \
    curl \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files and install PHP deps (prod-only, no dev)
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --optimize-autoloader

# Copy application source
COPY . .

# Copy built Vite assets from node-builder stage
COPY --from=node-builder /app/public/build ./public/build

# Final composer optimizations with app code present (+ package discovery,
# karena composer install di atas pakai --no-scripts)
RUN composer dump-autoload --optimize --no-dev \
    && php artisan package:discover --ansi

# Nginx configuration
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# PHP-FPM pool (worker dibatasi — RAM server terbatas)
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/zz-app.conf

# Supervisor configuration
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# PHP OPcache configuration
COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN sed -i 's/\r$//' /entrypoint.sh && chmod +x /entrypoint.sh

# Fix storage & cache permissions
RUN mkdir -p storage/framework/sessions \
             storage/framework/views \
             storage/framework/cache \
             storage/app/public \
             storage/logs \
             bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
