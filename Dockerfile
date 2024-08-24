FROM php:8.2-apache

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli

# Copy application files to Apache directory
COPY backend/ /var/www/html/
COPY frontend/ /var/www/html/

# Set environment variables for PHP
ENV DB_HOST=${DB_HOST}
ENV DB_USER=${DB_USER}
ENV DB_PASSWORD=${DB_PASSWORD}
ENV DB_NAME=${DB_NAME}

# Adjust file permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
