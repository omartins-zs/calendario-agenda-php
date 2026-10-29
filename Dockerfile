FROM php:8.2-fpm-alpine

# Instala dependências de sistema e extensões necessárias
RUN apk add --no-cache \
    bash \
    curl \
    git \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    mysql-client \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        intl \
        zip \
        opcache

# Instala o Composer a partir da imagem oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Diretório de trabalho
WORKDIR /var/www/html

# Configurações de performance do PHP e PHP-FPM
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini
COPY docker/php/fpm-performance.conf /usr/local/etc/php-fpm.d/zz-docker.conf

# Script de bootstrap e permissões
COPY docker/scripts/start-app.sh /usr/local/bin/start-app.sh
RUN chmod +x /usr/local/bin/start-app.sh

# Copia os arquivos do projeto
COPY . /var/www/html

# Ajuste de permissões para o usuário www-data
RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000

CMD ["/usr/local/bin/start-app.sh"]
