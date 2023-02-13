FROM php:8.1.15-zts-alpine3.17
LABEL maintainer="Nguyễn Văn Hiệp <nguyenhiepvan.bka@gmail.com>"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apk add git vim rsync openssh-client
RUN docker-php-ext-install opcache
RUN mkdir -p ~/.ssh

RUN git clone https://github.com/nguyenhiepvan/deployer.git
RUN cd deployer && composer install
