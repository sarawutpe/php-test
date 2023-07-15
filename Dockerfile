# Use the official PHP 7.4 Apache base image
FROM php:7.4-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the contents of the current directory to /var/www/html
COPY . .

# Enable mod_rewrite for Apache (if needed)
RUN a2enmod rewrite

RUN apt-get update

# Install required system packages
RUN apt-get update && apt-get install -y \
    libbz2-dev \
    libcurl4-openssl-dev \
    libffi-dev \
    libgettextpo-dev \
    libgd-dev \
    libgmp-dev \
    libicu-dev \
    libimap-dev \
    libldap2-dev \
    libonig-dev \
    libpq-dev \
    libsqlite3-dev \
    libssl-dev \
    libxml2-dev \
    libzip-dev \
    zlib1g-dev

# Enable PHP extensions
RUN docker-php-ext-install bz2 curl fileinfo gd gettext gmp intl mbstring exif mysqli pdo_mysql pdo_pgsql pdo_sqlite pgsql shmop zip

# Uncomment the following line if you need the oci8 extension (Oracle Database)
# RUN docker-php-ext-install oci8

# Uncomment the following line if you need the odbc extension
# RUN docker-php-ext-install odbc
RUN apt-get update

# Configure phpMyAdmin to work with Apache
# RUN echo "Include /etc/phpmyadmin/apache.conf" >> /etc/apache2/apache2.conf

# Expose port 80 for Apache
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
