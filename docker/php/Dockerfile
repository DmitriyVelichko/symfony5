FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user=dmitry
ARG group=root
ARG uid=1000
ARG TIMEZONE="Europe/Moscow"

RUN useradd -u $uid -g $group -s /bin/sh $user

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install pdo pdo_mysql zip xsl gd intl opcache exif mbstring pcntl bcmath
RUN yes | pecl install xdebug-3.0.4 \
    && docker-php-ext-enable xdebug

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

WORKDIR /var/www/symfony-test/project
RUN echo "INSTALL COMPOSER" && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

ADD ./php.ini /usr/local/etc/php/custom.d/php.ini
USER $user