# ==============================================
# Stage 1: Composer dependencies
# ==============================================
FROM php:8.4.5-fpm-alpine AS composer_builder

# Install system dependencies including openssl-dev for MongoDB
RUN apk add --no-cache git zip unzip icu-dev oniguruma-dev libpng-dev libjpeg-turbo-dev freetype-dev libzip-dev autoconf g++ make openssl-dev\
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring gd intl opcache zip

# Install PHP extensions (including mongodb with SSL support)
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

WORKDIR /app

# Copy composer files and install dependencies (no dev)
COPY . .
COPY database/ database/
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# ==============================================
# Stage 2: Node build (after composer)
# ==============================================
FROM node:20-alpine AS node_builder

WORKDIR /app

# Copy everything from composer stage first (so vendor exists)
COPY --from=composer_builder /app /app

# Copy package files and install node deps
COPY package*.json ./
RUN npm ci

# Copy remaining app source
COPY . .

# Build frontend assets
RUN npm run build

# ==============================================
# Stage 3: Final runtime image
# ==============================================
FROM php:8.4.5-fpm-alpine AS app

# Install runtime dependencies including openssl for MongoDB SSL
RUN apk add --no-cache bash curl icu-dev oniguruma-dev libpng-dev libjpeg-turbo-dev freetype-dev libzip-dev autoconf g++ make openssl openssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring gd intl opcache zip

# Install MongoDB extension with SSL support in final stage
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

WORKDIR /var/www/html

# Copy application code
COPY . .

# Copy composer dependencies (vendor)
COPY --from=composer_builder /app/vendor ./vendor

# Copy built frontend assets
COPY --from=node_builder /app/public/build ./public/build

# Set correct permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]