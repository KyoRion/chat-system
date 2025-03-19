FROM php:8.2-fpm

LABEL maintainer="MiniApp"

ENV APP_PATH=/var/www/html
ENV TZ=Asia/Ho_Chi_Minh

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone


COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    ca-certificates \
    build-essential \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    nano \
    sudo \
    git \
    curl \
    libicu-dev \
    zlib1g-dev \
    libxml2 \
    libxml2-dev \
    libzip-dev \
    libreadline-dev \
    libonig-dev \
    potrace \
    imagemagick \
    libmagickwand-dev \
    supervisor \
    cron

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN install-php-extensions pdo_mysql mbstring zip exif pcntl bcmath intl gd imagick csv opcache sockets @composer

# Remove Cache
RUN rm -rf /var/cache/apk/*

# Cron
COPY cron /etc/cron.d/cron
RUN chmod 0644 /etc/cron.d/cron && crontab /etc/cron.d/cron && touch /var/log/cron.log
RUN cron

WORKDIR ${APP_PATH}

# Expose port 9000 and start php-fpm server
EXPOSE 9000
