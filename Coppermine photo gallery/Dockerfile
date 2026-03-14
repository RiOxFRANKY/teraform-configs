FROM php:5.6-apache

# Fix for old debian repositories
RUN printf "deb http://archive.debian.org/debian/ stretch main\ndeb http://archive.debian.org/debian-security stretch/updates main" > /etc/apt/sources.list && \
    echo "Acquire::Check-Valid-Until \"false\";" > /etc/apt/apt.conf.d/10no--check-valid-until

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y --force-yes \
    libpng-dev \
    libjpeg-dev \
    && docker-php-ext-configure gd --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd mysql mysqli \
    && echo "date.timezone = UTC" > /usr/local/etc/php/conf.d/timezone.ini \
    && echo "error_reporting = E_ALL & ~E_DEPRECATED & ~E_NOTICE" > /usr/local/etc/php/conf.d/error_reporting.ini \
    && rm -rf /var/lib/apt/lists/*

# Set up Apache configurations
RUN a2enmod rewrite

# Copy Coppermine files
COPY temp_coppermine/cpg1.4.11/ /var/www/html/
COPY coppermine_config.php /var/www/html/include/config.inc.php

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
