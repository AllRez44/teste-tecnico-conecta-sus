FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git

RUN docker-php-ext-install pdo_mysql bcmath xml gd

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY entrypoint.sh /var/www/entrypoint.sh

RUN chmod +x /var/www/entrypoint.sh

RUN chown -R www-data:www-data /var/www

USER www-data

ENTRYPOINT [ "/var/www/entrypoint.sh" ]

EXPOSE 9000

CMD ["php-fpm"]
