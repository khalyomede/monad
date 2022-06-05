FROM ubuntu:20.04

RUN apt-get update && \
    apt-get upgrade --yes && \
    apt-get install --yes software-properties-common && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    apt-get upgrade --yes && \
    apt-get install --yes \
    git \
    php8.0-cli \
    php8.0-xml \
    php8.0-dom \
    php8.0-tokenizer \
    php8.0-mbstring \
    php8.0-curl \
    php8.0-zip \
    php8.0-xdebug && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer && \
    apt-get clean && \
    apt-get autoremove
