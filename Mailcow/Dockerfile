FROM php:7.1-apache

# Fix for old debian repositories (Buster)
RUN printf "deb http://archive.debian.org/debian/ buster main\ndeb http://archive.debian.org/debian-security buster/updates main" > /etc/apt/sources.list && \
    echo "Acquire::Check-Valid-Until \"false\";" > /etc/apt/apt.conf.d/10no--check-valid-until

# Install dependencies and PHP extensions matching Mailcow's requirements
RUN apt-get update && apt-get install -y --force-yes \
    zlib1g-dev \
    libicu-dev \
    g++ \
    libidn11-dev \
    libxml2-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql xmlrpc \
    && pecl install redis-5.3.7 \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

# Set up Apache configurations
RUN a2enmod rewrite

# Copy Mailcow web files
COPY mailcow-dockerized/data/web/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
