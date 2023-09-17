FROM php:8.2-apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
ARG timezone

RUN apt-get update && apt-get install --no-install-recommends --no-install-suggests -y \
		git \
        unzip \
        libicu-dev \
        zlib1g-dev \
        libssl-dev \
        pkg-config \
        libpq-dev \
    	libzip-dev \
        libfreetype6-dev \
	  	libjpeg62-turbo-dev \
	  	libpng-dev \
		locales \
		zip \
		jpegoptim optipng pngquant gifsicle \
    	openssl \
    	libssl-dev\
      	libcurl4-openssl-dev\
    	libmcrypt-dev\
    	libssh2-1\
    	libssh2-1-dev\
    	libicu-dev\
    	libbz2-dev\
    	libpcre3\
    	libpcre3-dev\
    	nodejs \
    	npm \
    && rm -rf /var/lib/apt/lists/*

RUN set -xe \
    && docker-php-ext-configure \
        intl \
    && docker-php-ext-install \
        intl \
        opcache \
        pdo \
        zip \
    	-j "$(nproc)" gd \
        pdo_mysql \
    && pecl install \
        apcu \
        mongodb \
        redis \
    && docker-php-ext-enable \
        apcu \
        mongodb \
        redis

COPY php.ini /usr/local/etc/php/php.ini
RUN sed -i -e "s#TIMEZONE#$timezone#g" /usr/local/etc/php/php.ini

RUN npm install --global yarn
WORKDIR /var/www

# RUN yarn install && yarn add @popperjs/core datatables.net bootstrap
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER 1
# create composer cache directory
RUN mkdir -p /var/www/.composer && chown -R www-data /var/www/.composer
