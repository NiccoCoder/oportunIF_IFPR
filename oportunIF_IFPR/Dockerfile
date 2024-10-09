FROM php:8.2-apache

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instale extensões PHP necessárias
RUN docker-php-ext-install mysqli

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie os arquivos da aplicação para o diretório do Apache
COPY . .

# Instale as dependências do Composer
RUN composer install

# Ajuste as permissões dos arquivos
RUN chown -R www-data:www-data /var/www/html

# Exponha a porta 80
EXPOSE 80
