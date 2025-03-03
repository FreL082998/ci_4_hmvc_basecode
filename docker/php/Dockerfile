FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG API_UID
ARG USER
ARG API_PATH
ARG API_PORT

# Set environment variables in the container
ENV API_PORT=$API_PORT

# Install system dependencies and enable necessary modules
RUN apt-get update \
    && apt-get install -y \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        build-essential \
        autoconf \
        libz-dev \
        libzip-dev \
        libssl-dev \
        libicu-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create a new system user to manage files
RUN useradd -G www-data,root -u $API_UID -d /home/$USER $USER
RUN mkdir -p /home/$USER/.composer && \
    chown -R $USER:$USER /home/$USER

# Set working directory
WORKDIR /var/www/$API_PATH

# Set ownership and group of $API_PATH to $USER
RUN chown -R $USER:$USER /var/www/$API_PATH

# Set permissions
RUN chown -R www-data:www-data /var/www/$API_PATH \
    && chmod -R 755 /var/www/$API_PATH

# Ensure necessary permissions for PHP-FPM
RUN chown -R $USER:$USER /var/log /var/run
RUN chown -R $USER:$USER /var/www/$API_PATH /var/log

# Switch to the non-root user
USER $USER

# Expose the specified port
EXPOSE $API_PORT

# Start PHP-FPM
CMD ["php-fpm"]
