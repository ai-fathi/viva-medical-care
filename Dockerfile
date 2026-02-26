FROM richarvey/nginx-php-fpm:latest

# نسخ ملفات المشروع
COPY . /var/www/html

# إعدادات المسار والبيئة لـ Laravel
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# هذه الصورة تستخدم متغير خاص لتشغيل الأوامر عند الإقلاع
# سنستخدمه لتشغيل الميجرشن تلقائياً
ENV scripts_path /var/www/html/scripts
RUN mkdir -p /var/www/html/scripts
RUN echo "php /var/www/html/artisan migrate --force" > /var/www/html/scripts/after_deploy.sh
RUN chmod +x /var/www/html/scripts/after_deploy.sh

# تثبيت الملحقات وتصحيح الصلاحيات
RUN cd /var/www/html && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Render يستخدم المنفذ 10000 أو 8080، الصورة الأصلية تعمل على 80
EXPOSE 80
