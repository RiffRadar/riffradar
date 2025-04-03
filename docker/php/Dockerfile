FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    vim \
    postgresql-client \
    libpq-dev \
    git \
    zip \
    unzip \
    dnsutils \
    libz-dev \
    libssl-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/backend

COPY ./backend /var/www/html/backend

RUN composer install

EXPOSE 9000

CMD ["php-fpm"]