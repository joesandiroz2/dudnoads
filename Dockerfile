# Gunakan PHP dengan Apache sebagai dasar
FROM php:7.4-apache

# Instal libcurl dan dependensinya
RUN apt-get update && apt-get install -y libcurl4-openssl-dev

# Aktifkan modul curl
RUN a2enmod rewrite
RUN docker-php-ext-install curl

# Salin skrip PHP ke dalam kontainer
COPY index.php /var/www/html/index.php

# Expose port 7860 untuk mengakses Apache
EXPOSE 7860

# Ubah port Apache untuk mendengarkan
RUN sed -i 's/Listen 80/Listen 7860/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Perintah untuk menjalankan Apache
CMD ["apache2-foreground"]
