FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/app

ENV WEBROOT /var/www/app/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1

RUN cd /var/www/app && \
    composer install --no-dev --optimize-autoloader && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# إضافة أمر التشغيل الذي يتضمن الـ migration قبل انطلاق السيرفر
CMD ["sh", "-c", "php artisan migrate --force && /start.sh"]