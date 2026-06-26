# PHP 8.3 version
FROM php:8.3-fpm-alpine

# Install Nginx, supervisor, and system tools
RUN apk add --no-cache nginx supervisor curl libpng-dev libxml2-dev zip unzip

# Install PHP extensions for MySQL and math operations
RUN docker-php-ext-install pdo_mysql bcmath

# Custom Nginx configuration
COPY .docker/nginx.conf /etc/nginx/nginx.conf

# Set working directory inside container
WORKDIR /var/www

COPY . .

# Copy Composer from the official image and install dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Give proper file permissions to Laravel's storage directories
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# Start both PHP-FPM and Nginx simultaneously
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]