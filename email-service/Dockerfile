FROM php:8.0

RUN apt-get update && apt-get install -y \
    git \
    libc6-dev \
    libsasl2-dev \
    libsasl2-modules \
    libssl-dev \
    zlib1g-dev \
    libzip-dev \
    unzip

RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin --filename=composer

RUN git clone https://github.com/confluentinc/librdkafka.git \
        && cd librdkafka \
        && ./configure \
        && make \
        && make install \
        && pecl install rdkafka \
        && docker-php-ext-enable rdkafka
        
WORKDIR /app
COPY . .
RUN composer install


