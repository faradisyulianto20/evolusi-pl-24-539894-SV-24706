#!/bin/bash
set -e

echo "1. Running: php artisan down --retry=60"
echo "2. Running: git pull origin main"
echo "3. Running: composer install --no-dev --optimize-autoloader"
echo "4. Running: php artisan migrate --force"
echo "5. Running: php artisan config:cache"
echo "   Running: php artisan route:cache"
echo "   Running: php artisan view:cache"
echo "6. Running: php artisan queue:restart"
echo "7. Running: php artisan up"
