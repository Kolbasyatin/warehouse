ARG PHP_VERSION
ARG PHP_TYPE
FROM php:${PHP_VERSION}-${PHP_TYPE}

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions bcmath gd intl memcached opcache pcntl pdo_pgsql pgsql xdebug zip

# Add packages
RUN apt update && apt install -y --no-install-recommends acl git graphviz openssh-client wget sudo unzip

# Add User
ARG PUID1
ARG PGID
ARG USER=logicstore

RUN set -xe; \
    groupadd -g ${PGID} dev && \
    useradd -l -u ${PUID} -g dev -m ${USER} -G sudo && \
    usermod ${USER} -s /bin/bash

RUN echo "${USER} ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers
USER ${USER}

RUN wget https://get.symfony.com/cli/installer -O - | sudo bash && sudo mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN sudo mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

EXPOSE 9000

WORKDIR "/var/www/application"