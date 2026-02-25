FROM richarvey/nginx-php-fpm:latest
COPY . /var/www/app
ENV WEBROOT /var/www/app/public
ENV PHP_ERRORS_STDERR 1
RUN cd /var/www/app && composer install --no-dev