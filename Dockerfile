FROM php:8.2

RUN apt-get update -yqq && \
    apt-get install -y -qq  --no-install-recommends git nodejs libzip-dev default-mysql-client zip unzip \
  zlib1g-dev libzip-dev npm

RUN docker-php-ext-install zip pdo_mysql bcmath

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && \
    php composer-setup.php install

CMD ["bash"]
