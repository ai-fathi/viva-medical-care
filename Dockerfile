FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# إعدادات ضرورية لـ Laravel وصورة Richarvey
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# لضمان عدم حدوث تعارض في الصلاحيات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# تشغيل الميجرشن تلقائياً عند الإقلاع
RUN echo "php /var/www/html/artisan migrate --force" > /var/www/html/scripts/after_deploy.sh
RUN chmod +x /var/www/html/scripts/after_deploy.sh

EXPOSE 80
