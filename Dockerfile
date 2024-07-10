FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Set working directory
WORKDIR /var/www/html

# Copy the composer.json and composer.lock files to the container
COPY composer.json composer.lock ./

# Install PHP dependencies (done during build to cache dependencies)
RUN composer install --no-interaction --optimize-autoloader

# Copy the rest of the application source code to the container
COPY . .

# Ensure the cache, logs, and other necessary directories exist
RUN mkdir -p var/cache var/log

# Expose port 9000
EXPOSE 9000

# Run the necessary commands on container start
CMD composer install --no-interaction --optimize-autoloader && \
    php bin/console doctrine:migrations:migrate --no-interaction && \
    php bin/console cache:clear --env=prod && \
    php bin/console cache:warmup --env=prod && \
    php-fpm
