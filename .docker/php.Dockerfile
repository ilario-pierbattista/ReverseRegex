ARG BASE=php:7.4-cli-alpine
FROM $BASE

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
