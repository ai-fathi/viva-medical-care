FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD php artisan key:generate --force && \
    php artisan config:clear && \
    php artisan migrate --force || true && \
    php -S 0.0.0.0:10000 -t public
