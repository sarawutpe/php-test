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
    docker-php-ext-install pdo pdo_mysql

RUN apt-get update

# Install MariaDB client
RUN apt-get install -y mariadb-client

# Install phpMyAdmin
RUN apt-get update && \
    apt-get install -y wget && \
    wget https://files.phpmyadmin.net/phpMyAdmin/5.1.1/phpMyAdmin-5.1.1-all-languages.tar.gz && \
    tar xzf phpMyAdmin-5.1.1-all-languages.tar.gz && \
    rm phpMyAdmin-5.1.1-all-languages.tar.gz && \
    mv phpMyAdmin-5.1.1-all-languages /var/www/html/phpmyadmin

# Configure phpMyAdmin to work with Apache
# RUN echo "Include /etc/phpmyadmin/apache.conf" >> /etc/apache2/apache2.conf

# Expose port 80 for Apache
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
