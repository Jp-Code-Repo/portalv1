#!/bin/sh

set -e

echo "Starting Portal Service..."

mkdir -p storage/logs bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache

chmod -R 775 storage bootstrap/cache

exec php-fpm