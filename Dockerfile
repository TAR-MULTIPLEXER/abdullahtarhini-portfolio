FROM php:8.2-apache

# Install system dependencies + PostgreSQL support
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd intl zip

# ✅ PHP Upload Limits
RUN echo "upload_max_filesize = 50M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 50M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "file_uploads = On" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini

# Apache Config
RUN a2enmod rewrite \
    && sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|<Directory /var/www/html>|<Directory /var/www/html/public>|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i '/<Directory \/var\/www\/html\/public>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . .
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# ✅ Create folders & fix permissions
RUN mkdir -p /var/www/html/storage/framework/{cache,sessions,views} \
    && mkdir -p /var/www/html/storage/app/public/projects/covers \
    && mkdir -p /var/www/html/storage/app/public/projects/gallery \
    && mkdir -p /var/www/html/bootstrap/cache \
    && rm -rf /var/www/html/public/storage \
    && php artisan storage:link \
    && chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/public/storage

EXPOSE 80

# ✅ Migrate DB (no seed, no SQLite)
CMD ["sh", "-c", "php artisan migrate --force && apache2-foreground"]