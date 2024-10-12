FROM php:8.0



RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install -y \
        zlib1g-dev \
        libzip-dev \
        unzip

WORKDIR /app
COPY . .
RUN composer install


