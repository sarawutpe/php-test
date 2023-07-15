# Use the official PHP 7.4 Apache base image
FROM php:7.4-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the contents of the current directory to /var/www/html
COPY src/ /var/www/html

# Enable mod_rewrite for Apache (if needed)
RUN a2enmod rewrite

# Install PHP extensions
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

# Install MySQL client
RUN apt-get update && \
    apt-get install -y default-mysql-client

# Install phpMyAdmin dependencies
RUN apt-get update && \
    apt-get install -y php-mbstring php-zip php-gd

# Download and extract phpMyAdmin
ENV PHPMYADMIN_VERSION=5.1.1
RUN curl -L -o phpmyadmin.tar.gz https://files.phpmyadmin.net/phpMyAdmin/${PHPMYADMIN_VERSION}/phpMyAdmin-${PHPMYADMIN_VERSION}-all-languages.tar.gz && \
    tar xzf phpmyadmin.tar.gz --strip-components=1 -C /var/www/html && \
    rm phpmyadmin.tar.gz

# Configure phpMyAdmin to work with Apache
RUN echo "Include /etc/phpmyadmin/apache.conf" >> /etc/apache2/apache2.conf

# Expose port 80 for Apache
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
