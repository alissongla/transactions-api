FROM php:8.3-fpm
LABEL authors="Alisson Campos"

ARG user=api
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip\
    libpq-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Install redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# Install rabbitmq
RUN apt-get update && apt-get install -y librabbitmq-dev \
    && pecl install amqp \
    && docker-php-ext-enable amqp

# Set working directory
WORKDIR /var/www

# install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

USER $user
