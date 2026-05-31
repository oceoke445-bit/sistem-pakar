#!/bin/bash
set -e

echo "==> Running migrations..."
php artisan migrate --force || true

echo "==> Seeding admin account..."
php artisan db:seed --force --class=AdminSeeder 2>/dev/null || true

echo "==> Caching config..."
php artisan config:cache || true
php artisan view:cache || true

echo "==> Starting FrankenPHP..."
exec /start-container.sh
