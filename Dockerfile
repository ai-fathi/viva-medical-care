FROM richarvey/nginx-php-fpm:latest

# نسخ ملفات المشروع للمسار الافتراضي للصورة لضمان عمل السكربتات الآلية
COPY . /var/www/html

# إعداد المتغيرات البيئية لضبط Laravel والـ Ports
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV PORT 8080

# العمل داخل المجلد الصحيح
WORKDIR /var/www/html

# تثبيت المكتبات وتجهيز المجلدات والصلاحيات
# قمنا بإضافة إنشاء مجلد السوكيت يدوياً لضمان وجوده عند بدء Nginx
RUN composer install --no-dev --optimize-autoloader && \
    mkdir -p /var/run/php && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/run/php && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080
