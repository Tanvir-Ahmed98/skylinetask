FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Set Apache DocumentRoot to Laravel public directory
RUN sed -ri -e 's!/var/www/html!/var/www/skylinetask/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/html!/var/www/skylinetask/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set working directory
WORKDIR /var/www/skylinetask

# Copy project files
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/skylinetask \
    && chmod -R 755 /var/www/skylinetask/storage

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 80
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
