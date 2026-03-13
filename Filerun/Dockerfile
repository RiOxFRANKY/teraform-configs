FROM php:7.4-apache

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd zip mysqli pdo_mysql xml curl \
    && rm -rf /var/lib/apt/lists/*

# Set up Apache configurations
RUN a2enmod rewrite

# Copy FileRun files
COPY temp_filerun/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
