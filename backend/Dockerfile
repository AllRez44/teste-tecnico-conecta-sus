FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    default-mysql-client

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions pdo_mysql bcmath xml gd pcov xdebug

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY entrypoint.sh /var/www/entrypoint.sh

RUN chmod +x /var/www/entrypoint.sh

RUN chown -R www-data:www-data /var/www

USER www-data

ENTRYPOINT [ "/var/www/entrypoint.sh" ]

EXPOSE 9000

CMD ["php-fpm"]
