# استخدم صورة PHP-FPM الرسمية مع Nginx
FROM php:8.2-fpm

# تثبيت الأدوات اللازمة و Nginx و PostgreSQL PDO
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    curl \
    nginx \
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

# إعداد Nginx للعمل مع Laravel
RUN rm /etc/nginx/sites-enabled/default
COPY ./nginx.conf /etc/nginx/sites-available/laravel.conf
RUN ln -s /etc/nginx/sites-available/laravel.conf /etc/nginx/sites-enabled/

# فتح البورت
EXPOSE 80

# تشغيل Laravel migrations + caching عند بدء الحاوية (runtime)
CMD ["sh", "-c", "php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php-fpm8.2 -F & nginx -g 'daemon off;'"]