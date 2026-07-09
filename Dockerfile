# === STAGE 1: Build Frontend Assets with Vite ===
FROM node:20-alpine AS frontend-builder
WORKDIR /app

# Copy package files and install frontend dependencies
COPY package*.json ./
RUN npm ci

# Copy the rest of your code and run the Vite build
COPY . .
RUN npm run build

# ==========================================================

# === STAGE 2: Production PHP & Nginx Image ===
FROM php:8.5-fpm-alpine

# Install system dependencies, build tools, and common PHP extension libraries
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    libzip-dev

# Install PHP extensions for MySQL and math operations
RUN docker-php-ext-install pdo_mysql bcmath mbstring xml zip

# Custom Nginx configuration
COPY .docker/nginx.conf /etc/nginx/nginx.conf

# Set working directory inside container
WORKDIR /var/www

# Copy all application files
COPY . .

# CRITICAL: Copy the compiled Vite assets from Stage 1 into your public directory
COPY --from=frontend-builder /app/public/build ./public/build

# Copy Composer from the official image and install dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Give proper file permissions to Laravel's storage and build directories
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public/build

EXPOSE 80

# Start both PHP-FPM and Nginx simultaneously
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]