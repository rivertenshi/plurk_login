# Use official PHP Apache image with PHP 8.2 (or 8.1 if you prefer)
FROM php:8.2-apache

# Install PostgreSQL PDO extension and other dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite if needed
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy your PHP app into the container
COPY . /var/www/html

# Set proper permissions (optional but recommended)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 for web traffic
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]