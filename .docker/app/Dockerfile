FROM php:7.4.10-fpm-alpine3.12

RUN ["apk", "add", "--no-cache", "openssl", "bash", "shadow", "mysql-client"]
RUN ["docker-php-ext-install", "pdo", "pdo_mysql"]

WORKDIR /var/www
RUN rm -rf /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN ln -s public html

RUN usermod -u 1000 www-data
USER www-data

EXPOSE 9000

ENTRYPOINT [ "php-fpm" ]