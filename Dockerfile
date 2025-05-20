FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip libpng-dev libonig-dev libxml2-dev git curl \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

# نصب Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html \
    # && composer install --no-interaction --prefer-dist --optimize-autoloader
    && chown -R www-data:www-data storage bootstrap/cache \
    # Install node and npm
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm run build

# بررسی نسخه نصب شده
# RUN node -v
# RUN npm -v
# RUN chmod -R 775 storage bootstrap/cache

# EXPOSE 8000