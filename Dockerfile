FROM php:8.3-fpm-alpine

ARG user=sail
ARG uid=1000

WORKDIR /var/www/html

RUN apk update && apk add --no-cache \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    jpeg-dev \
    freetype-dev \
    libxml2-dev \
    postgresql-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_pgsql \
    zip \
    gd \
    exif \
    bcmath 

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN addgroup -g $uid -S $user
RUN adduser -u $uid -S $user -G $user

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

USER $user
COPY --chown=$user:$user . .


ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

EXPOSE 9000
CMD ["php-fpm"]