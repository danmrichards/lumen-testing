FROM php:7-fpm-alpine
RUN apk add --update nginx && rm -rf /var/cache/apk/*
RUN mkdir -p /tmp/nginx/client-body

ENV SERVICE_VERSION=base

ONBUILD ARG SERVICE_VERSION_ARG=0.0.0
ONBUILD ENV SERVICE_VERSION=${SERVICE_VERSION_ARG}

RUN docker-php-source extract \
    && apk add --no-cache libxml2-dev curl bash $PHPIZE_DEPS \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-install ctype iconv json mbstring opcache xml pdo_mysql \
    && docker-php-source delete

COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY nginx/default.conf /etc/nginx/conf.d/default.conf
COPY start-up /start-up

CMD ["ash", "/start-up"]

ADD service /service
RUN chown -R www-data. /service

WORKDIR /service
