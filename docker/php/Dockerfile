FROM php:7.4-fpm

RUN apt-get update && apt-get install -y git unzip curl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Helsinki /etc/localtime
RUN "date"

# set up php
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/php.ini \
 && echo "display_startup_errors = On" >> /usr/local/etc/php.ini \
 && echo "display_errors = On" >> /usr/local/etc/php/php.ini \
 && echo "date.timezone=\"Europe/Helsinki\"" >> /usr/local/etc/php/php.ini

# install xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug \
 && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

VOLUME /www
WORKDIR /www

EXPOSE 80
