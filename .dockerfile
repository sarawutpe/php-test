# Use the official PHP 7.4 Apache base image
FROM php:7.4-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the contents of the current directory to /var/www/html
COPY . /var/www/html

# Enable mod_rewrite for Apache (if needed)
RUN a2enmod rewrite

# Install PHP extensions
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

# Additional recommended extensions
RUN apt-get install -y libzip-dev && \
    docker-php-ext-install zip

# Expose port 80 for Apache
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
