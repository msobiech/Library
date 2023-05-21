FROM php:8.1-apache
LABEL authors="max"
RUN apt-get update
RUN docker-php-ext-install mysqli pdo pdo_mysql


