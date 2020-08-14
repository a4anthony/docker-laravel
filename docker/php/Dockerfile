# PHP Version alpine image to install based on the PHP_VERSION environment variable
FROM php:7.4.6-fpm-alpine

# Application environment variable
ARG APP_ENV
ENV APP_ENV $APP_ENV

# Remote working directory environment variable
ARG REMOTE_WORKING_DIR
ENV REMOTE_WORKING_DIR $REMOTE_WORKING_DIR

RUN apk upgrade --update && apk add --no-cache \
  coreutils \
  freetype-dev \
  libjpeg-turbo-dev \
  libltdl \
  libmcrypt-dev \
  libpng-dev 

# Install Additional dependencies
RUN apk update && apk add --no-cache $PHPIZE_DEPS \
   build-base shadow nano curl gcc git bash \
   php7 \
   php7-fpm \
   php7-common \
   php7-pdo \
   php7-pdo_mysql \
   php7-mysqli \
   php7-mcrypt \
   php7-mbstring \
   php7-xml \
   php7-openssl \
   php7-json \
   php7-phar \
   php7-zip \
   php7-gd \
   php7-dom \
   php7-session \
   php7-zlib

#RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
#RUN npm cache clean --force
#RUN npm cache verify
#RUN npm install

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql
RUN apk add --no-cache freetype-dev
RUN docker-php-ext-configure gd --with-jpeg --with-freetype
RUN docker-php-ext-install gd

# install xdebug and enable it if the development environment is local
RUN if [ $APP_ENV = "local" ]; then \
   pecl install xdebug; \
   docker-php-ext-enable xdebug; \
fi;

# Install PHP Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Remove Cache
RUN rm -rf /var/cache/apk/*

# Add UID '1000' to www-data
RUN apk add shadow && usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN rm /usr/local/etc/php-fpm.d/www.conf
COPY www.conf /usr/local/etc/php-fpm.d/www.conf
RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf

RUN echo "phpinfo();"
# Copy existing application directory permissions
COPY --chown=www-data:www-data . $REMOTE_WORKING_DIR

# Change current user to www
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000

# Run php-fpm
CMD ["php-fpm", "--nodaemonize"]
