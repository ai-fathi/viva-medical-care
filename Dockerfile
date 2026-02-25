FROM richarvey/nginx-php-fpm:latest
COPY . /var/www/app
ENV WEBROOT /var/www/app/public
ENV PHP_ERRORS_STDERR 1

# تنظيف وتثبيت وتجهيز الصلاحيات في خطوة واحدة
RUN cd /var/www/app && \
    composer install --no-dev && \
    php artisan config:clear && \
    php artisan cache:clear && \
    chmod -R 777 storage bootstrap/cache