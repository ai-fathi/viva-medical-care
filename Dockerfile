FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/app

ENV WEBROOT /var/www/app/public
ENV PHP_ERRORS_STDERR 1

RUN cd /var/www/app && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

EXPOSE 8080
# هذا الأمر سيقوم بتنفيذ الهجرة ثم تشغيل السيرفر فوراً
CMD php artisan migrate --force && apache2-foreground