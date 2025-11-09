FROM php:8.2.10-apache

# Instal·lar dependències (afegint curl per Composer)
RUN apt-get update && apt-get install -y git zip unzip curl \
    && rm -rf /var/lib/apt/lists/*

# Instal·lar i configurar Xdebug (mantenint la configuració de l'app principal)
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
RUN { \
  echo "zend_extension=xdebug"; \
  echo "xdebug.mode=develop,debug"; \
  echo "xdebug.start_with_request=yes"; \
  echo "xdebug.discover_client_host=false"; \
  echo "xdebug.client_host=host.docker.internal"; \
  echo "xdebug.client_port=9003"; \
  echo "xdebug.log_level=0"; \
} > /usr/local/etc/php/conf.d/xdebug.ini

# Instal·lar Composer (necessari per al PHP Mailer)
RUN curl -sS https://getcomposer.org/installer \
       | php -- --install-dir=/usr/local/bin --filename=composer

# Habilitar mòdul rewrite d'Apache
RUN a2enmod rewrite

RUN git config --global --add safe.directory /var/www/html

# Directori de treball
WORKDIR /var/www/html

# Copiar i configurar entrypoint (del PHP Mailer)
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copiar el codi font PRIMER
COPY . /var/www/html/

# I LLavors canviar els permisos - ARA el directori existeix
RUN mkdir -p /var/www/html/Public/assets/avatar
RUN chown -R www-data:www-data /var/www/html/Public/assets/avatar/
RUN chmod -R 755 /var/www/html/Public/assets/avatar/

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]