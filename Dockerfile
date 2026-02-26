FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# إعدادات البيئة الأساسية
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# تعطيل التثبيت التلقائي المسبب للمشاكل وتفعيله يدوياً
ENV SKIP_COMPOSER 1

# تثبيت الاعتمادات وضبط الصلاحيات
RUN cd /var/www/html && \
    composer install --no-dev --optimize-autoloader --no-scripts && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# سكريبت ما بعد التثبيت لتشغيل الميجرشن
RUN mkdir -p /var/www/html/scripts && \
    echo "php /var/www/html/artisan migrate --force" > /var/www/html/scripts/after_deploy.sh && \
    chmod +x /var/www/html/scripts/after_deploy.sh

EXPOSE 80
