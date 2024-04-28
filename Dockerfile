# Gunakan PHP dengan Apache sebagai dasar
FROM php:7.4-apache

# Aktifkan modul curl
RUN a2enmod rewrite
RUN docker-php-ext-install curl

# Salin skrip PHP ke dalam kontainer
COPY index.php /var/www/html/index.php

# Expose port 7860 untuk mengakses Apache
EXPOSE 7860

# Perintah untuk menjalankan Apache
CMD ["apache2-foreground"]
