# استخدام الصورة الأصلية التي اخترتها
FROM richarvey/nginx-php-fpm:latest

# نسخ ملفات المشروع إلى الحاوية
COPY . /var/www/app

# إعداد المتغيرات البيئية اللازمة للصورة لتشغيل Laravel
# WEBROOT يحدد المجلد العام للمشروع لحل مشكلة ظهور الملفات بدلاً من الموقع
ENV WEBROOT /var/www/app/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# العمل داخل مجلد التطبيق
WORKDIR /var/www/app

# تنفيذ أوامر التثبيت وتعديل الصلاحيات
# تم دمج الأوامر لتقليل حجم الصورة النهائية
RUN composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# المنفذ الذي تستخدمه هذه الصورة افتراضياً
EXPOSE 8080

# ملاحظة: الصورة تقوم بتشغيل Nginx و PHP-FPM تلقائياً عند البدء
