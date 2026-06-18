#!/bin/sh
set -e

cd /var/www

if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

if [ ! -f ".env" ] && [ -f ".env.example" ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
fi

if grep -q "APP_KEY=$" .env || ! grep -q "APP_KEY=" .env; then
    echo "Generating Laravel encryption key (APP_KEY)..."
    php artisan key:generate
fi

echo "Running migrations and seeders..."
php artisan migrate --seed --force

exec "$@"
