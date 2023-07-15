# Use the official PHP 7.4 Apache base image
FROM php:7.4-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the contents of the current directory to /var/www/html
COPY . .

# Enable mod_rewrite for Apache (if needed)
RUN a2enmod rewrite

RUN apt-get update

# Install PHP extensions
RUN apt-get install -y libpq-dev && \
    docker-php-ext-install bz2 curl fileinfo gd2 pdo gettext mbstring exif mysqli pdo_mysql pdo_oci pdo_odbc pdo_pgsql pdo_sqlite pgsql shmop

# Expose port 80 for Apache
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
