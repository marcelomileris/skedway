# Use a imagem oficial do PHP-FPM 7.3
FROM php:7.3-fpm

# Instale pacotes necessários e extensões PHP
RUN apt-get update && \
    apt-get install -y libpdo-mysql php-pdo && \
    docker-php-ext-install pdo pdo_mysql

# Copie o código da aplicação para o diretório de trabalho
COPY . /www

# Defina o diretório de trabalho
WORKDIR /www