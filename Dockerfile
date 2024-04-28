# Gunakan PHP sebagai dasar
FROM php:7.4-cli

# Tambahkan dependensi yang diperlukan
RUN apt-get update && apt-get install -y \
    curl \
    libcurl4-openssl-dev \
    && rm -rf /var/lib/apt/lists/*

# Salin skrip PHP ke dalam kontainer
COPY index.php /var/www/html/index.php

# Port yang perlu dibuka jika Anda ingin mengakses kontainer dari luar
EXPOSE 7860

# Perintah untuk menjalankan skrip PHP
CMD ["php", "-S", "0.0.0.0:7860", "-t", "/var/www/html"]
