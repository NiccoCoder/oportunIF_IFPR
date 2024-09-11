FROM php:8.2-apache

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instale extensões PHP necessárias
RUN docker-php-ext-install mysqli

WORKDIR /var/www/html

# Copie os arquivos da aplicação para o diretório do Apache
COPY . .

# Instale as dependências do Composer
RUN composer install

# Defina variáveis de ambiente para o PHP
ENV DB_HOST=${DB_HOST}
ENV DB_USER=${DB_USER}
ENV DB_PASSWORD=${DB_PASSWORD}
ENV DB_NAME=${DB_NAME}

# Ajuste as permissões dos arquivos
RUN chown -R www-data:www-data /var/www/html

# Exponha a porta 80
EXPOSE 80
