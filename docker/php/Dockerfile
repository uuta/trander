FROM composer:latest as build
WORKDIR /work
COPY . /work

FROM php:7.2-apache
COPY php.ini /usr/local/etc/php/
RUN apt update
RUN apt install -y git
RUN apt install -y vim
RUN apt install -y nodejs npm
RUN npm install -y -g n
RUN n stable
# RUN apt purge nodejs npm
RUN npm install npm@latest -g
RUN docker-php-ext-install bcmath pdo_mysql

# composer install
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
EXPOSE 8080
COPY --from=build /app /work
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN chmod 777 -R /work
RUN echo "Listen 8080" >> /etc/apache2/ports.conf
RUN chown -R www-data:www-data /work
RUN a2enmod rewrite

# FROM php:7.2-fpm-alpine
# LABEL maintainer "Yuta Aoki"

# ARG TZ
# ENV COMPOSER_ALLOW_SUPERUSER 1
# ENV COMPOSER_HOME /composer

# RUN set -eux && \
#   apk add --update-cache --no-cache --virtual=.build-dependencies tzdata && \
#   cp /usr/share/zoneinfo/${TZ} /etc/localtime && \
#   apk del .build-dependencies && \
#   docker-php-ext-install bcmath pdo_mysql && \
#   curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer && \
#   composer config -g repos.packagist composer https://packagist.jp && \
#   apk add --update nodejs nodejs-npm && \
#   npm install npm@latest -g && \
#   composer require laravel/socialite
