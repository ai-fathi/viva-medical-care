FROM php:8.3-cli

# تثبيت الأدوات + PostgreSQL extension
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# تثبيت الحزم
RUN composer install --no-dev --optimize-autoloader

# الصلاحيات
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD php artisan key:generate --force && \
    php artisan config:clear && \
    php artisan migrate --force || true && \
    php artisan serve --host=0.0.0.0 --port=10000
