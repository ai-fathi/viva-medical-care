FROM richarvey/nginx-php-fpm:latest
COPY . /var/www/app
ENV WEBROOT /var/www/app/public
ENV PHP_ERRORS_STDERR 1
RUN cd /var/www/app && composer install --no-dev
# إضافة صلاحيات المجلدات الضرورية
RUN chmod -R 777 /var/www/app/storage /var/www/app/bootstrap/cache