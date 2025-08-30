#!/bin/sh

# Para o script se algo der errado
set -e

# Garante que estamos no diretório correto da aplicação
cd /var/www/html

# --- INSTALAÇÃO DE DEPENDÊNCIAS (APENAS SE NECESSÁRIO) ---
if [ ! -f "vendor/autoload.php" ]; then
    echo "Pasta vendor não encontrada. Rodando composer install..."
    composer install --no-interaction --no-progress --prefer-dist
else
    echo "Pasta vendor encontrada. Pulando composer install."
fi

echo "Garantindo que os diretórios de storage existem..."
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data

echo "Ajustando permissões de diretório..."
chmod -R 777 storage bootstrap/cache

echo "Limpando o cache de pacotes antigos do Laravel..."
rm -f bootstrap/cache/packages.php
rm -f bootstrap/cache/services.php

echo "Limpando e recriando os caches da aplicação..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "Verificando a APP_KEY..."
if [ -z "$(grep -E '^APP_KEY=' .env | cut -d '=' -f2-)" ]; then
    echo "APP_KEY não encontrada. Gerando nova chave..."
    php artisan key:generate --ansi
else
    echo "APP_KEY já está definida."
fi

echo "Rodando as migrations do banco de dados..."
php artisan migrate --force

echo "Iniciando o servidor PHP-FPM..."
exec "$@"