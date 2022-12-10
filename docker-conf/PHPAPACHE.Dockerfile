FROM php:7.4-apache

# Install Vim and Nano
RUN apt-get update
RUN apt-get install nano
RUN apt-get install vim -y

# For windows line endigs
RUN apt-get install dos2unix -y

RUN apt-get install libzip-dev -y
RUN apt-get install zip -y
RUN apt-get install default-mysql-client -y

# Install php extensions
RUN docker-php-ext-install zip
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install gettext


RUN apt-get install -y \
    libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
	&& docker-php-ext-enable imagick

# Install curl
RUN apt install -y curl

# Install git
RUN apt-get -y install git

# Add mod_rewrite module
RUN a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install node
ENV NODE_VERSION=14.5.0
RUN curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.34.0/install.sh | bash
ENV NVM_DIR=/root/.nvm
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"
RUN node --version
RUN npm --version

# Copy stuff into container
COPY public_html /var/www/html/
COPY ./docker-conf/httpd.conf /etc/apache2/sites-available/000-default.conf