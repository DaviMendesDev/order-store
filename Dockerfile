FROM php:8.0-apache
COPY . /var/www/html

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libpq-dev \
        nodejs \
        npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql \
    && a2enmod rewrite

RUN chown www-data:www-data -R /var/www/html/public/
RUN chown www-data:www-data -R /var/www/html/storage/
RUN chmod 777 -R /var/www/html/public/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#ENV NODE_VERSION=16.14.2
#RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
#ENV NVM_DIR=/root/.nvm
#RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
#RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
#RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
#ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"

RUN composer install

#USER node
RUN npm install
RUN npm run dev

CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]
