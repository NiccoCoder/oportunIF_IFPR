FROM php:8.2-apache

# Instalar extensões PHP necessárias
RUN docker-php-ext-install mysqli

# Copie os arquivos da aplicação para o diretório do Apache
COPY src/ /var/www/html/

ENV DB_HOST=DB_HOST
ENV DB_USER=DB_USER
ENV DB_PASSWORD=DB_PASSWORD
ENV DB_NAME=DB_NAME


# Ajuste as permissões dos arquivos
RUN chown -R www-data:www-data /var/www/html

# Exponha a porta 80
EXPOSE 80
