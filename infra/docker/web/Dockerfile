FROM php:7.3-apache

#setting for export
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin
ENV DEBCONF_NOWARNINGS yes
ENV APT_KEY_DONT_WARN_ON_DANGEROUS_USAGE=DontWarn

# ntpdate install
RUN DEBIAN_FRONTEND=noninteractive apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        ntpdate
RUN ntpdate -b ntp.nict.jp

#timezone change JST
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

#settings for Apache file permission. (for Mac)
RUN usermod -G staff daemon
RUN usermod -u 1000 daemon

#PHP + MySQL
RUN DEBIAN_FRONTEND=noninteractive apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
          apt-utils \
          zlib1g-dev \
          curl \
          gnupg cmake \
    && mkdir /tmp/libzip \
    && cd /tmp/libzip \
    && curl -sSLO https://libzip.org/download/libzip-1.4.0.tar.gz \
    && tar zxf libzip-1.4.0.tar.gz && cd libzip-1.4.0/ \
    && mkdir build \
    && cd build \
    && cmake ../ \
    && make > /dev/null \
    && make install

# make Apache2 SSL Directory
RUN mkdir -p /etc/apache2/ssl/

#  local store to container store
COPY ./etc/apache2/apache2.conf /etc/apache2/
COPY ./etc/php/php.ini /usr/local/etc/php/
COPY ./etc/apache2/conf.d/http.conf /etc/apache2/sites-enabled/000-default.conf
COPY ./etc/apache2/conf.d/ssl.conf /etc/apache2/sites-enabled/ssl.conf
COPY ./etc/apache2/ssl/server.* /etc/apache2/ssl/

#issue
#apache2: Could not reliab122ly determine the server's fully qualified domain name,
#using ***.***.*.*. Set the 'ServerName' directive globally to suppress this message
RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf
RUN a2enconf fqdn

RUN DEBIAN_FRONTEND=noninteractive apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y cron
RUN echo '* * * * * root cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1' >> /etc/crontab

RUN DEBIAN_FRONTEND=noninteractive apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        apt-utils \
        default-mysql-client \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install pdo_mysql gd

RUN DEBIAN_FRONTEND=noninteractive apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        unzip \
        zlib1g-dev \
        libzip-dev \
        libicu-dev \
    && docker-php-ext-install zip intl\
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN DEBIAN_FRONTEND=noninteractive apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        gnupg \
        libjpeg-dev \
        libfreetype6-dev \
        && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
        && docker-php-ext-install -j$(nproc) gd

#Composer download / install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# apache a2enmod rewrite for setting
RUN a2enmod rewrite

RUN a2enmod ssl

#current directory change
WORKDIR /var/www/html