#!/bin/sh
set -e

echo "🚀 Iniciando ambiente Calendário & Agenda PHP..."

# Garante que o autoloader existe
if [ ! -d "/var/www/html/vendor" ] && [ ! -d "/var/www/html/lib/composer/vendor" ]; then
    echo "📦 Instalando dependências do Composer..."
    composer install --no-interaction --prefer-dist --optimize-autoloader || true
fi

# Ajusta permissões básicas
chown -R www-data:www-data /var/www/html || true

echo "✅ Container pronto. Iniciando PHP-FPM..."
exec php-fpm -F

