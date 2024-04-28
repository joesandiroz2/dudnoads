# Menggunakan base image PHP dengan Apache
FROM php:7.4-apache

# Menyalin wfile index.php ke direktori /var/www/html di dalam container
COPY index.php /var/www/html/

# Port yang akan diexpose
EXPOSE 7860

# Command yang akan dijalankan ketika container dijalankan
CMD ["apache2-foreground"]
