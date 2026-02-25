FROM richarvey/nginx-php-fpm:latest

# نسخ ملفات المشروع إلى المجلد الافتراضي للصورة
COPY . /var/www/app

# إعدادات البيئة الضرورية للصورة
ENV WEBROOT /var/www/app/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV SKIP_COMPOSER 1

# تنفيذ عمليات التثبيت وضبط الصلاحيات أثناء البناء
RUN cd /var/www/app && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data /var/www/app/storage /var/www/app/bootstrap/cache && \
    chmod -R 775 /var/www/app/storage /var/www/app/bootstrap/cache

# السطر الأهم: تشغيل التهجير ثم تشغيل السيرفر باستخدام المسارات المطلقة
ENTRYPOINT ["sh", "-c", "php /var/www/app/artisan migrate --force && /start.sh"]