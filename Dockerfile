# استخدم صورة PHP-FPM الرسمية مع Nginx
FROM php:8.2-fpm

# تثبيت الأدوات اللازمة
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    curl \
    supervisor \
    && docker-php-ext-install pdo pdo_pgsql

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# نسخ ملفات المشروع
WORKDIR /var/www/app
COPY . .

# تثبيت dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# إعداد الصلاحيات
RUN chown -R www-data:www-data /var/www/app/storage /var/www/app/bootstrap/cache \
    && chmod -R 775 /var/www/app/storage /var/www/app/bootstrap/cache

# توليد مفتاح التطبيق
RUN php artisan key:generate

# تنفيذ المايجريشن caching
RUN php artisan migrate --force \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# فتح البورت
EXPOSE 80

# تشغيل Laravel + Nginx عند start
CMD ["sh", "-c", "/usr/sbin/php-fpm8.2 -F"]