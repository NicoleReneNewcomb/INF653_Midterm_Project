# Use official PHP runtime with apache as the parent image
FROM php:8.2-apache

# Install requirec system packages and dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Set the working directory of container
WORKDIR /var/www/html

# Copy current directory contents into container working directory
COPY . /var/www/html

# Install any dependencies PHP application may need
# Example below if using Composer for dependency management
# RUN apt-get update && apt-get install -y \
#     git \
#     && curl -sS https://getcomposer.org/installer | php --
# -- install-dir=/usr/local/bin --filename=composer

# If needing specific PHP extensions, can install using here.
# Example below is for installing support for MySQL
# RUN docker-php-ext-install pdo_pgsql

# Add Postgres SQL support:
RUN docker-php-ext-install pdo_pgsql

# Copy custom Apache configuration
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache modules
RUN a2enmod rewrite

# Set Apache to bind to IP address 0.0.0.0
# RUN echo "Listen 0.0.0.0:80" >> /etc/apache2/apache2.conf

# Expose port 80 to allow incoming connections to the container
EXPOSE 80

# By default, Apache is started automatically. You can change
# or customize the startup command if necessary
# CMD ["apache2-foreground"]
