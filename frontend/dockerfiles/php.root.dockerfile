FROM php:8-fpm-alpine

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN sed -i "s/user = www-data/user = root/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = root/g" /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

RUN apk --no-cache add linux-headers build-base rabbitmq-c-dev autoconf g++ make
RUN pecl install amqp
RUN docker-php-ext-enable amqp
RUN docker-php-ext-install pdo pdo_mysql sockets
RUN rm -rf /tmp/pear
RUN apk del autoconf g++ make;
    
USER root

EXPOSE 5173

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
