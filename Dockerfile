# Use the official PHP 7.4 Apache base image
FROM php:7.4-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the contents of the current directory to /var/www/html
COPY . .

# Enable mod_rewrite for Apache (if needed)
RUN a2enmod rewrite

# Install required system packages
RUN apt-get update && apt-get install -y libpq-dev libbz2-dev

# Install PHP extensions using pecl
RUN pecl install bz2 && docker-php-ext-enable bz2
RUN pecl install curl && docker-php-ext-enable curl
RUN pecl install gd && docker-php-ext-enable gd
RUN pecl install gettext && docker-php-ext-enable gettext
RUN pecl install mbstring && docker-php-ext-enable mbstring
RUN pecl install mysqli && docker-php-ext-enable mysqli
RUN pecl install pdo_mysql && docker-php-ext-enable pdo_mysql
RUN pecl install pdo_pgsql && docker-php-ext-enable pdo_pgsql
RUN pecl install pdo_sqlite && docker-php-ext-enable pdo_sqlite
RUN pecl install pgsql && docker-php-ext-enable pgsql
RUN pecl install shmop && docker-php-ext-enable shmop
RUN pecl install zip && docker-php-ext-enable zip

# Expose port 80 for Apache
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
