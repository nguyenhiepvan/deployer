FROM php:7.4.32-zts-alpine3.16
LABEL maintainer="Nguyễn Văn Hiệp <nguyenhiepvan.bka@gmail.com>"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apk add git
RUN docker-php-ext-install opcache

RUN git clone https://github.com/nguyenhiepvan/deployer.git
RUN cd deployer && composer install
