FROM richarvey/nginx-php-fpm:latest
COPY . /var/www/app
ENV WEBROOT /var/www/app/public
ENV PHP_ERRORS_STDERR 1
RUN cd /var/www/app && \
    composer install --no-dev --optimize-autoloader && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache