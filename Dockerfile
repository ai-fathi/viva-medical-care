FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/app

ENV WEBROOT /var/www/app/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV SKIP_COMPOSER 1

RUN cd /var/www/app && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# هذا السطر يضمن تشغيل الترحيل عند انطلاق الحاوية
ENTRYPOINT ["sh", "-c", "php /var/www/app/artisan migrate --force && /start.sh"]