#!/usr/bin/env sh
set -e

cd /var/www/html
export COMPOSER_ALLOW_SUPERUSER=1

# 1) Assegura Composer
if ! command -v composer >/dev/null 2>&1; then
  echo "Composer no disponible dins del contenidor."
  exit 1
fi

# 2) Si no hi ha composer.json, crea'n un mínim
if [ ! -f composer.json ]; then
  echo ">> Creant composer.json mínim…"
  cat > composer.json <<'JSON'
{
  "name": "local/test-app",
  "require": {}
}
JSON
fi

# 3) Instala dependències (idempotent)
if [ -f composer.lock ]; then
  echo ">> composer.lock detectat → composer install"
  composer install --no-interaction --prefer-dist
else
  if ! grep -q '"phpmailer/phpmailer"' composer.json; then
    echo ">> Afegint PHPMailer…"
    composer require phpmailer/phpmailer --no-interaction --prefer-dist
  else
    echo ">> composer.json ja inclou dependències → composer install"
    composer install --no-interaction --prefer-dist
  fi
fi

# 4) CORRECCIÓ: Assegurar permisos del directori avatar
echo ">> Configurant permisos per a /var/www/html/Public/assets/avatar/"
chown -R www-data:www-data /var/www/html/Public/assets/avatar/
chmod -R 755 /var/www/html/Public/assets/avatar/

# 5) Arrenca Apache en primer pla
exec apache2-foreground