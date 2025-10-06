#!/bin/sh
set -e

cd /var/www/html

echo "Ajustando permissões de diretório..."
chown -R sail:sail storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "Verificando a APP_KEY..."
if [ -z "$(grep -E '^APP_KEY=' .env | cut -d '=' -f2-)" ]; then
    echo "APP_KEY não encontrada. Gerando nova chave..."
    php artisan key:generate --ansi
else
    echo "APP_KEY já está definida."
fi

echo "Rodando as migrations do banco de dados..."
php artisan migrate --force

if [ "$RUN_SEEDERS" = "true" ]; then
    echo "Rodando os seeders..."
    php artisan db:seed --force
else
    echo "Pulando os seeders."
fi

if [ ! -L "public/storage" ]; then
    echo "Criando o link do storage..."
    php artisan storage:link
else
    echo "O link do storage já existe."
fi

if [ "$APP_ENV" = "production" ]; then
    echo "Otimizando a aplicação para produção..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "Iniciando o servidor PHP-FPM..."
exec "$@"