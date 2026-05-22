FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libsqlite3-dev \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd intl zip

# ✅ Increase PHP Upload Limits
RUN echo "upload_max_filesize = 50M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 50M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "file_uploads = On" >> /usr/local/etc/php/conf.d/uploads.ini

# Enable Apache modules and configure for Laravel
RUN a2enmod rewrite \
    && sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|<Directory /var/www/html>|<Directory /var/www/html/public>|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i '/<Directory \/var\/www\/html\/public>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . .
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# ✅ NUCLEAR PERMISSIONS FIX
RUN mkdir -p /var/www/html/storage/framework/{cache,sessions,views} \
    && mkdir -p /var/www/html/storage/app/public/projects/covers \
    && mkdir -p /var/www/html/storage/app/public/projects/gallery \
    && mkdir -p /var/www/html/storage/app/public/projects/pdfs \
    && mkdir -p /var/www/html/storage/app/public/livewire-tmp \
    && mkdir -p /var/www/html/bootstrap/cache \
    && mkdir -p /var/www/html/database \
    && touch /var/www/html/database/database.sqlite \
    && php artisan storage:link \
    && chmod -R 777 /var/www/html/storage \
    && chmod -R 777 /var/www/html/bootstrap/cache \
    && chmod -R 777 /var/www/html/database \
    && chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["sh", "-c", "php artisan migrate --force --seed && apache2-foreground"]