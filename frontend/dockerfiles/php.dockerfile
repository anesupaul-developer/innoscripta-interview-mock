FROM php:8-fpm-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# MacOS staff group's gid is 20, so is the dialout group in alpine linux. We're not using it, let's just remove it.
RUN delgroup dialout

RUN addgroup -g ${GID} --system laravel
RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel

RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

RUN apk --no-cache add linux-headers build-base rabbitmq-c-dev autoconf g++ make
RUN pecl install amqp
RUN docker-php-ext-enable amqp
RUN docker-php-ext-install pdo pdo_mysql sockets
RUN rm -rf /tmp/pear
RUN apk del autoconf g++ make;
    
USER laravel

EXPOSE 5173

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
