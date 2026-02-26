FROM richarvey/nginx-php-fpm:latest

# نسخ الملفات للمسار الافتراضي
COPY . /var/www/html

# إعدادات Laravel والبيئة
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# إضافة هذا السطر لإجبار Nginx على استخدام المنفذ 8080 بدلاً من 80 إذا لزم الأمر
ENV PORT 8080

# تثبيت المكتبات وتجهيز المجلدات
RUN cd /var/www/html && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# هذا السطر سيقوم بإنشاء مجلد السوكيت يدوياً لضمان عدم حدوث الخطأ
RUN mkdir -p /var/run/php && chown www-data:www-data /var/run/php

EXPOSE 8080
