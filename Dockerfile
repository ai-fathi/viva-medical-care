FROM richarvey/nginx-php-fpm:latest

# نسخ ملفات المشروع بالكامل
COPY . /var/www/html

# إعدادات البيئة لـ Laravel
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# تثبيت الاعتمادات وتصحيح الصلاحيات في خطوة واحدة
RUN cd /var/www/html && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# إنشاء مجلد السكريبتات وبرمجة الميجرشن عند الإقلاع
RUN mkdir -p /var/www/html/scripts && \
    echo "php /var/www/html/artisan migrate --force" > /var/www/html/scripts/after_deploy.sh && \
    chmod +x /var/www/html/scripts/after_deploy.sh

EXPOSE 80
