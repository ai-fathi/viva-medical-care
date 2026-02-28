FROM php:8.3-cli

# تثبيت الأدوات المطلوبة
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    curl \
    && docker-php-ext-install pdo pdo_mysql zip

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# تثبيت الحزم
RUN composer install --no-dev --optimize-autoloader

# إعطاء الصلاحيات
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
