FROM php:8.5-fpm

# Installation des dépendances système (git et zip sont requis pour Composer, mariadb-client pour les outils SQL)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    mariadb-client \
    && docker-php-ext-install zip pdo pdo_mysql

# Installation de Composer depuis l'image officielle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html