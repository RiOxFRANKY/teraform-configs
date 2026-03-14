FROM php:5.6-apache

# Fix for old debian repositories
RUN printf "deb http://archive.debian.org/debian/ stretch main\ndeb http://archive.debian.org/debian-security stretch/updates main" > /etc/apt/sources.list && \
    echo "Acquire::Check-Valid-Until \"false\";" > /etc/apt/apt.conf.d/10no--check-valid-until

# Set up PHP configuration for research
RUN echo "register_globals = On" > /usr/local/etc/php/conf.d/globals.ini && \
    echo "allow_url_include = On" >> /usr/local/etc/php/conf.d/globals.ini && \
    echo "magic_quotes_gpc = Off" >> /usr/local/etc/php/conf.d/globals.ini

# Install dependencies if necessary
RUN apt-get update && apt-get install -y --force-yes \
    libpng-dev \
    libjpeg-dev \
    && rm -rf /var/lib/apt/lists/*

# Copy authentic PHPWebAdmin files
COPY extracted_hmail/PHPWebAdmin/ /var/www/html/
COPY hmail_config.php /var/www/html/config.php

# Create a sample file for LFI testing
RUN echo "Vulnerable File Content" > /var/www/html/test_lfi.txt

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
