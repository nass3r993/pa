FROM php:8.2-apache

# Install PHP extensions and dependencies
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache modules
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Configure Apache to allow .htaccess and directory listing for uploads
RUN echo '<Directory /var/www/html/uploads/profile_images/>' >> /etc/apache2/apache2.conf \
    && echo '    Options +Indexes' >> /etc/apache2/apache2.conf \
    && echo '    AllowOverride All' >> /etc/apache2/apache2.conf \
    && echo '</Directory>' >> /etc/apache2/apache2.conf

# Copy application files
COPY src/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html