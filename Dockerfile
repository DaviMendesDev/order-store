FROM php:8.0-apache
COPY . /var/www/html

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql \
    && a2enmod rewrite

RUN chown www-data:www-data -R /var/www/html/public/
RUN chown www-data:www-data -R /var/www/html/storage/
RUN chmod 777 -R /var/www/html/public/

CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]
