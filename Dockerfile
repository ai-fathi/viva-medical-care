FROM richarvey/nginx-php-fpm:latest

# نستخدم المسار الافتراضي للصورة لضمان عمل السكربتات التلقائية
COPY . /var/www/html

# إعدادات Laravel الضرورية
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# تصحيح الصلاحيات للمجلد الافتراضي
RUN cd /var/www/html && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

EXPOSE 80
