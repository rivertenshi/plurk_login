# Use official PHP image with Apache
FROM php:8.2-apache

# Install MySQLi extension for PHP
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite (optional if needed)
RUN a2enmod rewrite

# Copy your PHP code to the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Set permissions (optional)
RUN chown -R www-data:www-data /var/www/html/
